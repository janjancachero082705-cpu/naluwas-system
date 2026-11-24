<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    private function churchId()
    {
        return session('current_church_id', auth()->user()->church_id);
    }

    public function index(Request $request)
    {
        $churchId = $this->churchId();
        $query = Member::where('church_id', $churchId);

        $isDeceasedFilter = $request->query('filter') === 'deceased';
        $query->where('is_deceased', $isDeceasedFilter);

        if ($request->role && $request->role != 'all') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(10);

        $deceasedMembers = Member::where('church_id', $churchId)
            ->where('is_deceased', true)
            ->orderBy('date_deceased', 'desc')
            ->paginate(10);

        $currentFilter = $request->role ?? 'all';
        $allRoles = Role::all();

        $totalMembers = Member::where('church_id', $churchId)->where('is_deceased', false)->count();
        $birthdaysThisMonth = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->whereMonth('birthday', now()->month)
            ->count();
        $deceasedCount = Member::where('church_id', $churchId)->where('is_deceased', true)->count();
        $activeMinistries = Role::count();

        return view('members.index', compact(
            'members',
            'deceasedMembers',
            'currentFilter',
            'allRoles',
            'totalMembers',
            'birthdaysThisMonth',
            'activeMinistries',
            'deceasedCount',
            'isDeceasedFilter'
        ));
    }

    public function create()
    {
        $roles = Role::all();

        if ($roles->isEmpty()) {
            $this->createDefaultRoles();
            $roles = Role::all();
        }

        return view('members.create', compact('roles'));
    }

    private function createDefaultRoles()
    {
        $defaultRoles = [
            ['name' => 'Training Pastor', 'slug' => 'training_pastor', 'icon' => 'fa-church', 'color' => 'danger'],
            ['name' => 'Palagkanta', 'slug' => 'palagkanta', 'icon' => 'fa-microphone-alt', 'color' => 'primary'],
            ['name' => 'Instruments', 'slug' => 'instruments', 'icon' => 'fa-guitar', 'color' => 'info'],
            ['name' => 'Youth Leader', 'slug' => 'youth_leader', 'icon' => 'fa-users', 'color' => 'warning'],
            ['name' => 'AGAK Mentor', 'slug' => 'agak_mentor', 'icon' => 'fa-chalkboard-teacher', 'color' => 'secondary'],
            ['name' => 'Palagbulig (Lalaki)', 'slug' => 'palagbulig_lalaki', 'icon' => 'fa-male', 'color' => 'success'],
            ['name' => 'Palagbulig (Babae)', 'slug' => 'palagbulig_babae', 'icon' => 'fa-female', 'color' => 'success'],
            ['name' => 'Gahawid sa Offering', 'slug' => 'offering', 'icon' => 'fa-hand-holding-usd', 'color' => 'dark'],
            ['name' => 'Gahawid sa Computer', 'slug' => 'computer', 'icon' => 'fa-laptop', 'color' => 'info'],
            ['name' => 'Palagdasig', 'slug' => 'palagdasig', 'icon' => 'fa-heart', 'color' => 'danger'],
        ];

        foreach ($defaultRoles as $role) {
            Role::create($role);
        }
    }

    private function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'gender' => 'nullable|string|in:male,female',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ];
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->rules());

            $member = new Member();
            $member->first_name = $validated['first_name'];
            $member->last_name = $validated['last_name'];
            $member->birthday = $validated['birthday'] ?? null;
            $member->address = $validated['address'] ?? null;
            $member->phone = $validated['phone'] ?? null;
            $member->email = $validated['email'] ?? null;
            $member->gender = $validated['gender'] ?? null;
            $member->church_id = $this->churchId();
            $member->is_deceased = false;
            $member->date_deceased = null;
            $member->save();

            if (!empty($validated['roles'])) {
                $member->roles()->attach($validated['roles']);
            }

            return redirect()->route('members.index')
                ->with('success', 'Member added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('members.create')
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Store Error: ' . $e->getMessage());

            return redirect()->route('members.create')
                ->with('error', 'Error adding member: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $member = Member::where('id', $id)
            ->where('church_id', $this->churchId())
            ->firstOrFail();

        $roles = Role::all();
        $memberRoles = $member->roles->pluck('id')->toArray();

        return view('members.edit', compact('member', 'roles', 'memberRoles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $member = Member::where('id', $id)
                ->where('church_id', $this->churchId())
                ->firstOrFail();

            $validated = $request->validate($this->rules());

            $member->first_name = $validated['first_name'];
            $member->last_name = $validated['last_name'];
            $member->birthday = $validated['birthday'] ?? null;
            $member->address = $validated['address'] ?? null;
            $member->phone = $validated['phone'] ?? null;
            $member->email = $validated['email'] ?? null;
            $member->gender = $validated['gender'] ?? null;
            $member->save();

            if (isset($validated['roles'])) {
                $member->roles()->sync($validated['roles']);
            } else {
                $member->roles()->detach();
            }

            return redirect()->route('members.show', $id)
                ->with('success', 'Member updated successfully!');

        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());

            return redirect()->route('members.edit', $id)
                ->with('error', 'Error updating member: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $member = Member::where('id', $id)
            ->where('church_id', $this->churchId())
            ->firstOrFail();

        $member->roles()->detach();
        $member->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Member deleted successfully!']);
        }

        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully!');
    }

    public function show($id)
    {
        try {
            $churchId = $this->churchId();

            $member = Member::where('id', $id)
                ->where('church_id', $churchId)
                ->with('roles')
                ->firstOrFail();

            $attendanceCount = 0; // temporary, tangtangon sa view
            $contributionCount = 0;
            $recentActivities = collect();

            $transactionModel = $this->getTransactionModel();

            if ($transactionModel) {
                try {
                    $contributionCount = $transactionModel::where('member_id', $id)
                        ->where('church_id', $churchId)
                        ->where('type', 'income')
                        ->count();

                    $recentActivities = $transactionModel::where('member_id', $id)
                        ->where('church_id', $churchId)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get()
                        ->map(function ($item) {
                            return (object) [
                                'description' => $item->description ?? 'Contribution of PHP ' . number_format($item->amount ?? 0, 2),
                                'created_at' => $item->created_at ?? now(),
                                'type' => 'contribution',
                            ];
                        });
                } catch (\Exception $e) {
                    Log::warning('Transaction data error: ' . $e->getMessage());
                    $recentActivities = collect();
                    $contributionCount = 0;
                }
            }

            return view('members.show', compact(
                'member',
                'attendanceCount',
                'contributionCount',
                'recentActivities'
            ));

        } catch (\Exception $e) {
            Log::error('Error in MemberController@show: ' . $e->getMessage());

            return redirect()->route('members.index')
                ->with('error', 'Unable to load member profile. Please try again.');
        }
    }

    private function getTransactionModel()
    {
        foreach (['App\Models\MoneyTransaction', 'App\Models\Transaction', 'App\Models\Finance'] as $m) {
            if (class_exists($m)) {
                return $m;
            }
        }
        return null;
    }

    public function markAsDeceased(Request $request, $id)
    {
        return $this->setDeceased($request, $id, true);
    }

    public function restoreFromDeceased(Request $request, $id)
    {
        return $this->setDeceased($request, $id, false);
    }

    private function setDeceased(Request $request, $id, bool $deceased)
    {
        try {
            $member = Member::where('id', $id)
                ->where('church_id', $this->churchId())
                ->firstOrFail();

            $dateDeceased = null;
            if ($deceased) {
                if ($request->has('date_deceased')) {
                    $request->validate(['date_deceased' => 'required|date|before_or_equal:today']);
                    $dateDeceased = $request->date_deceased;
                } else {
                    $dateDeceased = now()->toDateString();
                }
            }

            $member->update(['is_deceased' => $deceased, 'date_deceased' => $dateDeceased]);

            $name = "{$member->first_name} {$member->last_name}";
            $message = $deceased
                ? "{$name} has been marked as deceased."
                : "{$name} has been restored to active members.";

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'message' => $message]);
            }

            return redirect()->route('members.show', $id)->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Deceased status error: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }

            return redirect()->route('members.show', $id)->with('error', 'Error: ' . $e->getMessage());
        }
    }
}