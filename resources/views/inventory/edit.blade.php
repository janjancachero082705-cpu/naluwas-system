@extends('layouts.app')

@section('title', __('Edit transaction'))
@section('header', __('Edit transaction'))
@section('subheader', __('Fund and type are locked so balances stay accurate'))

@section('content')
@php
    $isIn = $transaction->isCollection();
    $peso = fn ($n) => '₱' . number_format((float) $n, 2);
@endphp

<style>
    .edit-wrap { max-width: 720px; margin: 0 auto; }
    .fund-fellowship { --fc: #0BA5C0; }
    .fund-missions   { --fc: #3157D5; }
    .fund-offering   { --fc: #7C5CF0; }
    [data-theme="dark"] .fund-fellowship { --fc: #22D3EE; }
    [data-theme="dark"] .fund-missions   { --fc: #7C9BFF; }
    [data-theme="dark"] .fund-offering   { --fc: #A78BFA; }
    .fund-pill { display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; border-radius: 999px; font-size: .72rem; font-weight: 700; color: var(--fc); background: color-mix(in srgb, var(--fc) 14%, transparent); }
    .fund-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--fc); }
    .type-tag { font-size: .7rem; font-weight: 700; padding: 3px 9px; border-radius: 4px; }
    .type-tag.in  { background: rgba(34,197,94,.12); color: #16A34A; }
    .type-tag.out { background: rgba(239,68,68,.10); color: #DC2626; }
    .form-label { font-size: .72rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--text-muted); }
    .money-input { display: flex; }
    .money-input span { display: grid; place-items: center; padding: 0 14px; border: 1px solid var(--border-color); border-right: 0; border-radius: var(--radius) 0 0 var(--radius); background: var(--bg-hover); font-weight: 700; color: var(--text-muted); }
    .money-input .form-control { border-radius: 0 var(--radius) var(--radius) 0; }
    .locked { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; padding: 14px 18px; background: var(--bg-hover); border-radius: var(--radius); margin-bottom: 20px; }
    .locked .meta { margin-left: auto; font-size: .78rem; color: var(--text-muted); font-weight: 600; }
</style>

<div class="edit-wrap">
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $msg)<div>{{ $msg }}</div>@endforeach
        </div>
    @endif

    <div class="panel">
        <div class="panel-head">
            <i class="fas fa-pen"></i> {{ __('Transaction') }} #{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
            <span class="ms-auto" style="font-size:.75rem; color: var(--text-muted); font-weight:600;">
                {{ __('Updated') }} {{ $transaction->updated_at?->diffForHumans() }}
            </span>
        </div>

        <form method="POST" action="{{ route('inventory.update', $transaction) }}" class="panel-body" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="locked">
                <span class="fund-pill fund-{{ $transaction->fund }}"><span class="fund-dot"></span>{{ $transaction->fundLabel() }}</span>
                <span class="type-tag {{ $isIn ? 'in' : 'out' }}">{{ $isIn ? __('Collection') : __('Deduction') }}</span>
                <span class="meta">{{ __('Fund balance now') }}: <strong>{{ $peso($balance) }}</strong></span>
            </div>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="form-label" for="e_date">{{ __('Date') }}</label>
                    <input type="date" id="e_date" name="date" class="form-control @error('date') is-invalid @enderror" required
                           max="{{ now()->toDateString() }}" value="{{ old('date', $transaction->date->format('Y-m-d')) }}">
                    @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-sm-6">
                    <label class="form-label" for="e_amount">{{ __('Amount') }}</label>
                    <div class="money-input">
                        <span>₱</span>
                        <input type="number" id="e_amount" name="amount" class="form-control @error('amount') is-invalid @enderror"
                               step="0.01" min="0.01" max="99999999.99" inputmode="decimal" required
                               value="{{ old('amount', $transaction->amount) }}">
                    </div>
                    @error('amount')<div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>@enderror
                </div>

                @if($isIn)
                    <div class="col-12">
                        <label class="form-label" for="e_note">{{ __('Note') }}</label>
                        <input type="text" id="e_note" name="note" class="form-control @error('note') is-invalid @enderror" maxlength="200"
                               value="{{ old('note', $transaction->description) }}">
                        @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                @else
                    <div class="col-12">
                        <label class="form-label" for="e_recipient">{{ __('Taken by') }}</label>
                        <input type="text" id="e_recipient" name="recipient" class="form-control @error('recipient') is-invalid @enderror"
                               maxlength="120" required value="{{ old('recipient', $transaction->recipient) }}">
                        @error('recipient')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="e_purpose">{{ __('Purpose') }}</label>
                        <textarea id="e_purpose" name="purpose" rows="3" minlength="3" maxlength="500" required
                                  class="form-control @error('purpose') is-invalid @enderror">{{ old('purpose', $transaction->purpose ?: $transaction->description) }}</textarea>
                        @error('purpose')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                @endif
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-between mt-4 pt-3" style="border-top:1px solid var(--border-color);">
                <a href="{{ route('inventory.index') }}" class="btn-ghost"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
                <button type="submit" class="btn-cyan"><i class="fas fa-check"></i> {{ __('Save changes') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection