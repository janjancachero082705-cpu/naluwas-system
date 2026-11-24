<?php

namespace App\Http\Controllers;

use App\Models\MoneyTransaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    private const AMOUNT_RULE = 'regex:/^\d{1,8}(\.\d{1,2})?$/';
    private const SORTS       = ['newest', 'oldest', 'high', 'low'];
    private const PER_PAGE    = [15, 30, 50];

    public function index(Request $request)
    {
        $churchId = $this->churchId($request);
        [$filters, $filterErrors] = $this->parseFilters($request);

        $hasRange = !empty($filters['from']) || !empty($filters['to']);

        // ---- Fund cards ----
        $funds = [];
        foreach (MoneyTransaction::FUNDS as $key => $label) {
            $funds[$key] = [
                'label' => $label, 'balance' => 0.0,
                'collected' => 0.0, 'spent' => 0.0,
                'range_collected' => 0.0, 'range_spent' => 0.0,
            ];
        }

        $allTime = MoneyTransaction::forChurch($churchId)
            ->selectRaw('fund, type, SUM(amount) AS total')
            ->groupBy('fund', 'type')->get();

        foreach ($allTime as $row) {
            if (!isset($funds[$row->fund])) continue;
            $key = $row->type === MoneyTransaction::INCOME ? 'collected' : 'spent';
            $funds[$row->fund][$key] = (float) $row->total;
        }

        $ranged = MoneyTransaction::forChurch($churchId)
            ->tap(fn ($q) => $this->applyDateRange($q, $filters))
            ->selectRaw('fund, type, SUM(amount) AS total')
            ->groupBy('fund', 'type')->get();

        foreach ($ranged as $row) {
            if (!isset($funds[$row->fund])) continue;
            $key = $row->type === MoneyTransaction::INCOME ? 'range_collected' : 'range_spent';
            $funds[$row->fund][$key] = (float) $row->total;
        }

        foreach ($funds as $k => $f) {
            $funds[$k]['balance'] = round($f['collected'] - $f['spent'], 2);
        }
        $totalBalance = round(array_sum(array_column($funds, 'balance')), 2);

        // ---- Sunday collections (follows date range + fund filter) ----
        $weekly = MoneyTransaction::forChurch($churchId)
            ->where('type', MoneyTransaction::INCOME)
            ->tap(fn ($q) => $this->applyDateRange($q, $filters))
            ->when(!empty($filters['fund']), fn ($q) => $q->where('fund', $filters['fund']))
            ->where(fn ($q) => $q->whereNull('category')->orWhere('category', '!=', 'Donation'))
            ->selectRaw('date, fund, SUM(amount) AS total')
            ->groupBy('date', 'fund')
            ->orderByDesc('date')
            ->get()
            ->groupBy(fn ($r) => Carbon::parse($r->date)->toDateString())
            ->take($hasRange ? 60 : 12);

        // ---- Transactions table ----
        $filtered = MoneyTransaction::forChurch($churchId)
            ->tap(fn ($q) => $this->applyFilters($q, $filters));

        $totals = (clone $filtered)->selectRaw(
            "COALESCE(SUM(CASE WHEN type = 'income' THEN amount END), 0) AS collected,
             COALESCE(SUM(CASE WHEN type = 'expense' THEN amount END), 0) AS spent"
        )->first();

        $this->applySort($filtered, $filters['sort'] ?? 'newest');

        $transactions = $filtered
            ->paginate((int) ($filters['per_page'] ?? 15))
            ->withQueryString();

        $today      = Carbon::today();
        $lastSunday = $today->isSunday() ? $today : $today->copy()->previous(Carbon::SUNDAY);
        $lastMonth  = $today->copy()->subMonthNoOverflow();

        $presets = [
            ['label' => 'This week',    'from' => $today->copy()->startOfWeek(Carbon::SUNDAY)->toDateString(), 'to' => $today->copy()->endOfWeek(Carbon::SATURDAY)->toDateString()],
            ['label' => 'This month',   'from' => $today->copy()->startOfMonth()->toDateString(),              'to' => $today->copy()->endOfMonth()->toDateString()],
            ['label' => 'Last month',   'from' => $lastMonth->copy()->startOfMonth()->toDateString(),          'to' => $lastMonth->copy()->endOfMonth()->toDateString()],
            ['label' => 'Last 30 days', 'from' => $today->copy()->subDays(29)->toDateString(),                 'to' => $today->toDateString()],
            ['label' => 'This year',    'from' => $today->copy()->startOfYear()->toDateString(),               'to' => $today->copy()->endOfYear()->toDateString()],
        ];

        return view('inventory.index', [
            'funds'        => $funds,
            'totalBalance' => $totalBalance,
            'weekly'       => $weekly,
            'transactions' => $transactions,
            'totals'       => $totals,
            'filters'      => $filters,
            'filterErrors' => $filterErrors,
            'presets'      => $presets,
            'lastSunday'   => $lastSunday->toDateString(),
            'today'        => $today->toDateString(),
        ]);
    }

    public function storeCollection(Request $request)
    {
        $churchId = $this->churchId($request);

        $data = $request->validateWithBag('collection', [
            'date'                => ['required', 'date', 'before_or_equal:today'],
            'amounts.fellowship'  => ['nullable', 'numeric', 'min:0', self::AMOUNT_RULE, 'max:1000000'],
            'amounts.missions'    => ['nullable', 'numeric', 'min:0', self::AMOUNT_RULE, 'max:1000000'],
            'amounts.offering'    => ['nullable', 'numeric', 'min:0', self::AMOUNT_RULE, 'max:1000000'],
            'note'                => ['nullable', 'string', 'max:200'],
        ]);

        $amounts = collect(MoneyTransaction::FUNDS)
            ->mapWithKeys(fn ($label, $key) => [$key => (float) ($data['amounts'][$key] ?? 0)])
            ->filter(fn ($amount) => $amount > 0);

        if ($amounts->isEmpty()) {
            throw ValidationException::withMessages([
                'amounts' => 'Enter an amount for at least one fund.',
            ])->errorBag('collection');
        }

        DB::transaction(function () use ($amounts, $data, $churchId, $request) {
            foreach ($amounts as $fund => $amount) {
                $label = MoneyTransaction::FUNDS[$fund];

                MoneyTransaction::create([
                    'church_id'   => $churchId,
                    'type'        => MoneyTransaction::INCOME,
                    'fund'        => $fund,
                    'category'    => $label,
                    'description' => $data['note'] ?: "Sunday collection – {$label}",
                    'amount'      => $amount,
                    'date'        => $data['date'],
                    'created_by'  => $request->user()->id,
                ]);
            }
        });

        return redirect()->route('inventory.index')
            ->with('success', 'Collection for ' . Carbon::parse($data['date'])->format('M d, Y') . ' saved.');
    }

    public function storeDonation(Request $request)
    {
        $churchId = $this->churchId($request);

        $data = $request->validateWithBag('donation', [
            'fund'       => ['required', Rule::in(array_keys(MoneyTransaction::FUNDS))],
            'amount'     => ['required', 'numeric', 'gt:0', self::AMOUNT_RULE, 'max:1000000'],
            'date'       => ['required', 'date', 'before_or_equal:today'],
            'donor_name' => ['nullable', 'string', 'max:120'],
            'note'       => ['nullable', 'string', 'max:200'],
        ]);

        $label = MoneyTransaction::FUNDS[$data['fund']];
        $donor = trim((string) ($data['donor_name'] ?? '')) ?: 'Anonymous';

        MoneyTransaction::create([
            'church_id'   => $churchId,
            'type'        => MoneyTransaction::INCOME,
            'fund'        => $data['fund'],
            'category'    => 'Donation',
            'description' => ($data['note'] ?? null) ?: "Donation - {$label}",
            'amount'      => $data['amount'],
            'date'        => $data['date'],
            'donor_name'  => $donor,
            'created_by'  => $request->user()->id,
        ]);

        return redirect()->route('inventory.index')
            ->with('success', 'Donation from ' . $donor . ' recorded.');
    }
    public function storeDeduction(Request $request)
    {
        $churchId = $this->churchId($request);

        $data = $request->validateWithBag('deduction', [
            'fund'      => ['required', Rule::in(array_keys(MoneyTransaction::FUNDS))],
            'amount'    => ['required', 'numeric', 'gt:0', self::AMOUNT_RULE, 'max:1000000'],
            'date'      => ['required', 'date', 'before_or_equal:today'],
            'recipient' => ['required', 'string', 'max:120'],
            'purpose'   => ['required', 'string', 'min:3', 'max:500'],
        ]);

        DB::transaction(function () use ($data, $churchId, $request) {
            $balance = MoneyTransaction::fundBalance($churchId, $data['fund'], null, true);

            if ($this->cents($data['amount']) > $this->cents($balance)) {
                throw ValidationException::withMessages([
                    'amount' => sprintf(
                        'Not enough in %s. Available: ₱%s.',
                        MoneyTransaction::FUNDS[$data['fund']],
                        number_format($balance, 2)
                    ),
                ])->errorBag('deduction');
            }

            MoneyTransaction::create([
                'church_id'   => $churchId,
                'type'        => MoneyTransaction::EXPENSE,
                'fund'        => $data['fund'],
                'category'    => MoneyTransaction::FUNDS[$data['fund']],
                'description' => Str::limit($data['purpose'], 250, ''),
                'amount'      => $data['amount'],
                'date'        => $data['date'],
                'recipient'   => $data['recipient'],
                'purpose'     => $data['purpose'],
                'created_by'  => $request->user()->id,
            ]);
        });

        return redirect()->route('inventory.index')->with('success', 'Deduction recorded.');
    }

    public function edit(Request $request, MoneyTransaction $transaction)
    {
        $churchId = $this->churchId($request);
        $this->ensureOwned($transaction, $churchId);

        return view('inventory.edit', [
            'transaction' => $transaction,
            'balance'     => MoneyTransaction::fundBalance($churchId, $transaction->fund),
        ]);
    }

    public function update(Request $request, MoneyTransaction $transaction)
    {
        $churchId = $this->churchId($request);
        $this->ensureOwned($transaction, $churchId);

        $isCollection = $transaction->isCollection();

        $data = $request->validate([
            'date'      => ['required', 'date', 'before_or_equal:today'],
            'amount'    => ['required', 'numeric', 'gt:0', self::AMOUNT_RULE, 'max:1000000'],
            'note'      => [$isCollection ? 'nullable' : 'prohibited', 'string', 'max:200'],
            'recipient' => [$isCollection ? 'prohibited' : 'required', 'string', 'max:120'],
            'purpose'   => [$isCollection ? 'prohibited' : 'required', 'string', 'min:3', 'max:500'],
        ]);

        DB::transaction(function () use ($transaction, $data, $churchId, $isCollection) {
            $without = MoneyTransaction::fundBalance($churchId, $transaction->fund, $transaction->id, true);
            $after   = $isCollection ? $without + (float) $data['amount'] : $without - (float) $data['amount'];

            if ($this->cents($after) < 0) {
                throw ValidationException::withMessages([
                    'amount' => 'This change would leave the ' . $transaction->fundLabel() . ' fund below ₱0.00.',
                ]);
            }

            if ($isCollection) {
                $transaction->update([
                    'date'        => $data['date'],
                    'amount'      => $data['amount'],
                    'description' => $data['note'] ?: "Sunday collection – {$transaction->fundLabel()}",
                ]);
            } else {
                $transaction->update([
                    'date'        => $data['date'],
                    'amount'      => $data['amount'],
                    'recipient'   => $data['recipient'],
                    'purpose'     => $data['purpose'],
                    'description' => Str::limit($data['purpose'], 250, ''),
                ]);
            }
        });

        return redirect()->route('inventory.index')->with('success', 'Transaction updated.');
    }

    public function destroy(Request $request, MoneyTransaction $transaction)
    {
        $churchId = $this->churchId($request);
        $this->ensureOwned($transaction, $churchId);

        $blocked = false;

        DB::transaction(function () use ($transaction, $churchId, &$blocked) {
            $without = MoneyTransaction::fundBalance($churchId, $transaction->fund, $transaction->id, true);

            if ($transaction->isCollection() && $this->cents($without) < 0) {
                $blocked = true;
                return;
            }
            $transaction->delete();
        });

        if ($blocked) {
            return back()->withErrors([
                'general' => 'This collection can’t be deleted because part of it was already deducted from the ' . $transaction->fundLabel() . ' fund.',
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Transaction deleted.');
    }

    public function export(Request $request)
    {
        $churchId = $this->churchId($request);
        [$filters, $errors] = $this->parseFilters($request);

        if ($errors->any()) {
            return redirect()->route('inventory.index')->withErrors(['general' => $errors->first()]);
        }

        $query = MoneyTransaction::forChurch($churchId)
            ->tap(fn ($q) => $this->applyFilters($q, $filters));
        $this->applySort($query, 'oldest');

        $filename = 'fund-report-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Date', 'Fund', 'Type', 'Taken by', 'Description / Purpose', 'Amount']);

            foreach ($query->cursor() as $t) {
                $isCollection = $t->isCollection();
                fputcsv($out, [
                    $t->date->format('Y-m-d'),
                    $this->csvSafe($t->fundLabel()),
                    $isCollection ? 'Collection' : 'Deduction',
                    $this->csvSafe($isCollection ? '' : $t->recipient),
                    $this->csvSafe($isCollection ? $t->description : ($t->purpose ?: $t->description)),
                    ($isCollection ? '' : '-') . number_format((float) $t->amount, 2, '.', ''),
                ]);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /* ================= HELPERS ================= */

    private function churchId(Request $request): int
    {
        $id = $request->user()?->church_id;
        abort_unless($id, 403, 'Your account is not linked to a church.');
        return (int) $id;
    }

    private function ensureOwned(MoneyTransaction $transaction, int $churchId): void
    {
        abort_unless((int) $transaction->church_id === $churchId, 404);
    }

    /**
     * Returns [filters, errors]. Bad filters never redirect: the page just
     * loads unfiltered and shows the message.
     */
    private function parseFilters(Request $request): array
    {
        $rules = [
            'from'     => ['nullable', 'date'],
            'to'       => array_values(array_filter([
                'nullable', 'date',
                $request->filled('from') ? 'after_or_equal:from' : null,
            ])),
            'fund'     => ['nullable', Rule::in(array_keys(MoneyTransaction::FUNDS))],
            'type'     => ['nullable', Rule::in([MoneyTransaction::INCOME, MoneyTransaction::EXPENSE, 'donation'])],
            'q'        => ['nullable', 'string', 'max:100'],
            'sort'     => ['nullable', Rule::in(self::SORTS)],
            'per_page' => ['nullable', Rule::in(self::PER_PAGE)],
        ];

        $validator = Validator::make($request->query(), $rules, [
            'to.after_or_equal' => 'The "To" date must be on or after the "From" date.',
        ]);

        if ($validator->fails()) {
            return [[], $validator->errors()];
        }

        $clean = array_filter($validator->validated(), fn ($v) => $v !== null && $v !== '');
        return [$clean, new MessageBag()];
    }

    private function applyDateRange(Builder $query, array $filters): Builder
    {
        if (!empty($filters['from'])) $query->whereDate('date', '>=', $filters['from']);
        if (!empty($filters['to']))   $query->whereDate('date', '<=', $filters['to']);
        return $query;
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        $this->applyDateRange($query, $filters);

        if (!empty($filters['fund'])) $query->where('fund', $filters['fund']);
        if (($filters['type'] ?? null) === 'donation') { $query->where('type', MoneyTransaction::INCOME)->where('category', 'Donation'); } elseif (!empty($filters['type'])) { $query->where('type', $filters['type']); }

        if (!empty($filters['q'])) {
            $like = '%' . addcslashes($filters['q'], '%_\\') . '%';
            $query->where(function (Builder $q) use ($like) {
                $q->where('description', 'like', $like)
                  ->orWhere('recipient', 'like', $like)
                  ->orWhere('purpose', 'like', $like);
            });
        }
        return $query;
    }

    private function applySort(Builder $query, string $sort): Builder
    {
        return match ($sort) {
            'oldest' => $query->orderBy('date')->orderBy('id'),
            'high'   => $query->orderByDesc('amount')->orderByDesc('id'),
            'low'    => $query->orderBy('amount')->orderByDesc('id'),
            default  => $query->orderByDesc('date')->orderByDesc('id'),
        };
    }

    private function cents($value): int
    {
        return (int) round(((float) $value) * 100);
    }

    private function csvSafe(?string $value): string
    {
        $value = (string) $value;
        return preg_match('/^[=+\-@\t\r]/', $value) ? "'" . $value : $value;
    }
}