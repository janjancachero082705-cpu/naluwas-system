@extends('layouts.app')

@section('header', 'Members')
@section('subheader', __('Manage your church members and roles'))

@push('styles')
    @include('members._styles')
@endpush

@section('content')
@php
    $genders  = ['male' => ['fa-mars', 'Male'], 'female' => ['fa-venus', 'Female']];
    $roleList = collect($allRoles ?? [])->unique('name')->values();

    $stats = [
        ['fa-users',        'active_members_label',  __('Active Members'),        $totalMembers ?? 0],
        ['fa-cake-candles', 'birthdays_this_month',  __('Birthdays This Month'),  $birthdaysThisMonth ?? 0],
        ['fa-cross',        'deceased_label',        __('Deceased'),              $deceasedCount ?? 0],
    ];
@endphp

{{-- ACTIONS --}}
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('members.create') }}" class="btn-cyan">
        <i class="fas fa-user-plus"></i>
        <span data-i18n="add_member">{{ __("Add Member") }}</span>
    </a>
</div>

{{-- STATS --}}
<div class="row g-3 mb-4">
    @foreach($stats as [$icon, $key, $label, $value])
        <div class="col-6 col-xl-3">
            <div class="stat-card h-100">
                <div class="stat-icon"><i class="fas {{ $icon }}"></i></div>
                <div>
                    <div class="stat-label" data-i18n="{{ $key }}">{{ $label }}</div>
                    <div class="stat-value">{{ number_format($value) }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- MEMBERS PANEL --}}
<div class="panel">

    <div class="panel-head flex-wrap">
        <nav class="m-tabs">
            <a href="{{ route('members.index') }}" class="btn m-tab {{ !$isDeceasedFilter ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i>
                <span data-i18n="active">{{ __("Active") }}</span>
                <span class="m-count">{{ number_format($totalMembers ?? 0) }}</span>
            </a>
            <a href="{{ route('members.index', ['filter' => 'deceased']) }}" class="btn m-tab {{ $isDeceasedFilter ? 'active' : '' }}">
                <i class="fas fa-cross"></i>
                <span data-i18n="deceased">{{ __("Deceased") }}</span>
                <span class="m-count">{{ number_format($deceasedCount ?? 0) }}</span>
            </a>
        </nav>

        <div class="d-flex flex-wrap gap-2 ms-auto">

            <select id="roleFilter" class="form-select form-select-sm w-auto"
                    onchange="window.location.href=this.value" aria-label="{{ __('Filter by Ministry') }}">
                <option value="{{ route('members.index', ['role' => 'all']) }}"
                    {{ ($currentFilter ?? 'all') == 'all' ? 'selected' : '' }}>
                    {{ __("All Members") }}
                </option>
                @foreach($roleList as $role)
                    <option value="{{ route('members.index', ['role' => $role->slug ?? $role]) }}"
                        {{ ($currentFilter ?? '') == ($role->slug ?? $role) ? 'selected' : '' }}>
                        {{ $role->name ?? ucfirst($role) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ============ ACTIVE MEMBERS ============ --}}
    <section class="m-section {{ $isDeceasedFilter ? 'd-none' : '' }}">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:56px;">#</th>
                        <th data-i18n="member">{{ __("Member") }}</th>
                        <th data-i18n="gender">{{ __("Gender") }}</th>
                        <th data-i18n="roles">{{ __("Roles") }}</th>
                        <th class="d-none d-lg-table-cell" data-i18n="birthday">{{ __("Birthday") }}</th>
                        <th class="d-none d-lg-table-cell" data-i18n="age">{{ __("Age") }}</th>
                        <th class="text-end" data-i18n="actions">{{ __("Actions") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $member)
                        @php
                            $fullName = trim($member->first_name . ' ' . $member->last_name);
                            $birthday = $member->birthday ? \Carbon\Carbon::parse($member->birthday) : null;
                            $age      = $birthday?->age;

                            $birthdayThisWeek = false;
                            if ($birthday) {
                                $today = \Carbon\Carbon::today();
                                $next  = \Carbon\Carbon::create($today->year, $birthday->month, $birthday->day);
                                $days  = $today->diffInDays($next, false);
                                $birthdayThisWeek = $days >= 0 && $days <= 7;
                            }

                            $memberRoles = collect($member->roles ?? [])->unique('name')->values();
                            $g = $genders[$member->gender ?? ''] ?? null;
                        @endphp
                        <tr data-row data-member-name="{{ $fullName }}" data-member-phone="{{ $member->phone }}">
                            <td class="text-muted">{{ $members->firstItem() + $index }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="m-avatar">
                                        {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <div class="fw-semibold">
                                            {{ $fullName }}
                                            @if($birthdayThisWeek)
                                                <i class="fas fa-cake-candles ms-1" style="color:var(--primary);font-size:.75rem;" title="{{ __('Birthday this week') }}"></i>
                                            @endif
                                        </div>
                                        @if($member->phone)
                                            <div class="text-muted" style="font-size:.75rem;"><i class="fas fa-phone me-1"></i>{{ $member->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($g)
                                    <span class="m-pill {{ $member->gender }}"><i class="fas {{ $g[0] }}"></i> {{ __($g[1]) }}</span>
                                @else
                                    <span class="text-muted">&mdash;</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($memberRoles as $role)
                                        <span class="m-pill"><i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}</span>
                                    @empty
                                        <span class="m-pill"><i class="fas fa-user"></i> <span data-i18n="regular">{{ __("Regular") }}</span></span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="d-none d-lg-table-cell">{!! $birthday ? $birthday->format('M d') : '<span class="text-muted">&mdash;</span>' !!}</td>
                            <td class="d-none d-lg-table-cell">{!! $age ?: '<span class="text-muted">&mdash;</span>' !!}</td>

                            <td>
                                <div class="m-actions justify-content-end">
                                    <a href="{{ route('members.show', $member->id) }}" class="btn m-act" title="{{ __('View Profile') }}"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('members.edit', $member->id) }}" class="btn m-act" title="{{ __('Edit Member') }}"><i class="fas fa-pen"></i></a>
                                    @if(!$member->is_deceased)
                                        <button type="button" class="btn m-act" title="{{ __('Mark as Deceased') }}"
                                                data-action="deceased" data-id="{{ $member->id }}" data-name="{{ $fullName }}">
                                            <i class="fas fa-cross"></i>
                                        </button>
                                    @endif
                                    <button type="button" class="btn m-act danger" title="{{ __('Delete Member') }}"
                                            data-action="delete" data-id="{{ $member->id }}" data-name="{{ $fullName }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="m-empty">
                                    <i class="fas fa-users"></i>
                                    <h5 data-i18n="no_active_members">{{ __("No Active Members Yet") }}</h5>
                                    <p data-i18n="no_active_members_desc">{{ __("Get started by adding your first church member to the system.") }}</p>
                                    <a href="{{ route('members.create') }}" class="btn-cyan">
                                        <i class="fas fa-plus"></i>
                                        <span data-i18n="add_first_member">{{ __("Add Your First Member") }}</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="panel-body d-flex flex-wrap justify-content-between align-items-center gap-3" style="border-top:1px solid var(--border-color);">
                <div class="text-muted" style="font-size:.8rem;">
                    <span data-i18n="showing">{{ __("Showing") }}</span>
                    <strong>{{ $members->firstItem() }}</strong>
                    <span data-i18n="to">{{ __("to") }}</span>
                    <strong>{{ $members->lastItem() }}</strong>
                    <span data-i18n="of">{{ __("of") }}</span>
                    <strong>{{ $members->total() }}</strong>
                    <span data-i18n="active_members">{{ __("active members") }}</span>
                </div>
                {{ $members->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>

    {{-- ============ DECEASED MEMBERS ============ --}}
    <section class="m-section {{ !$isDeceasedFilter ? 'd-none' : '' }}">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:56px;">#</th>
                        <th data-i18n="member">{{ __("Member") }}</th>
                        <th data-i18n="gender">{{ __("Gender") }}</th>
                        <th data-i18n="roles">{{ __("Roles") }}</th>
                        <th class="d-none d-lg-table-cell" data-i18n="birthday">{{ __("Birthday") }}</th>
                        <th class="d-none d-lg-table-cell" data-i18n="age">{{ __("Age") }}</th>
                        <th class="text-end" data-i18n="actions">{{ __("Actions") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deceasedMembers as $index => $member)
                        @php
                            $fullName = trim($member->first_name . ' ' . $member->last_name);
                            $birthday = $member->birthday ? \Carbon\Carbon::parse($member->birthday) : null;
                            $died     = $member->date_deceased ? \Carbon\Carbon::parse($member->date_deceased) : null;
                            $ageAtDeath = ($birthday && $died) ? $birthday->diffInYears($died) : null;

                            $memberRoles = collect($member->roles ?? [])->unique('name')->values();
                            $g = $genders[$member->gender ?? ''] ?? null;
                        @endphp
                        <tr data-row data-member-name="{{ $fullName }}" data-member-phone="{{ $member->phone }}">
                            <td class="text-muted">{{ $deceasedMembers->firstItem() + $index }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="m-avatar danger"><i class="fas fa-cross"></i></div>
                                    <div style="min-width:0;">
                                        <div class="fw-semibold">{{ $fullName }}</div>
                                        @if($died)
                                            <div class="text-muted" style="font-size:.75rem;"><i class="fas fa-cross me-1"></i>{{ $died->format('M d, Y') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($g)
                                    <span class="m-pill {{ $member->gender }}"><i class="fas {{ $g[0] }}"></i> {{ __($g[1]) }}</span>
                                @else
                                    <span class="text-muted">&mdash;</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($memberRoles as $role)
                                        <span class="m-pill"><i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}</span>
                                    @empty
                                        <span class="m-pill"><i class="fas fa-user"></i> <span data-i18n="regular">{{ __("Regular") }}</span></span>
                                    @endforelse
                                    <span class="m-pill danger"><i class="fas fa-cross"></i> <span data-i18n="deceased">{{ __("Deceased") }}</span></span>
                                </div>
                            </td>

                            <td class="d-none d-lg-table-cell">{!! $birthday ? $birthday->format('M d') : '<span class="text-muted">&mdash;</span>' !!}</td>
                            <td class="d-none d-lg-table-cell">{!! $ageAtDeath ?: '<span class="text-muted">&mdash;</span>' !!}</td>

                            <td>
                                <div class="m-actions justify-content-end">
                                    <button type="button" class="btn m-act success" title="{{ __('Restore to Active') }}"
                                            data-action="restore" data-id="{{ $member->id }}" data-name="{{ $fullName }}">
                                        <i class="fas fa-rotate-left"></i>
                                    </button>
                                    <button type="button" class="btn m-act danger" title="{{ __('Delete Permanently') }}"
                                            data-action="purge" data-id="{{ $member->id }}" data-name="{{ $fullName }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <form id="delete-deceased-form-{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="m-empty">
                                    <i class="fas fa-cross"></i>
                                    <h5 data-i18n="no_deceased_members">{{ __("No Deceased Members") }}</h5>
                                    <p class="mb-0" data-i18n="no_deceased_members_desc">{{ __("Click the cross button on any active member to move them here.") }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($deceasedMembers->hasPages())
            <div class="panel-body d-flex flex-wrap justify-content-between align-items-center gap-3" style="border-top:1px solid var(--border-color);">
                <div class="text-muted" style="font-size:.8rem;">
                    <span data-i18n="showing">{{ __("Showing") }}</span>
                    <strong>{{ $deceasedMembers->firstItem() }}</strong>
                    <span data-i18n="to">{{ __("to") }}</span>
                    <strong>{{ $deceasedMembers->lastItem() }}</strong>
                    <span data-i18n="of">{{ __("of") }}</span>
                    <strong>{{ $deceasedMembers->total() }}</strong>
                    <span data-i18n="deceased_members">{{ __("deceased members") }}</span>
                </div>
                {{ $deceasedMembers->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
    @include('members._scripts')
@endpush