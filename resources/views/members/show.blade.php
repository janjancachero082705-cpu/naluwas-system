@extends('layouts.app')

@section('header', 'Members')
@section('subheader', trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? '')) . ' · #' . str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT))

@push('styles')
    @include('members._styles')
@endpush

@section('content')
@php
    $fullName = trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? ''));
    $birthday = $member->birthday ? \Carbon\Carbon::parse($member->birthday) : null;
    $genders  = ['male' => ['fa-mars', 'Male', 'male'], 'female' => ['fa-venus', 'Female', 'female']];
    $g        = $genders[$member->gender ?? ''] ?? ['fa-circle', 'Not specified', ''];
@endphp

{{-- ACTIONS --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('members.edit', $member->id) }}" class="btn-cyan">
        <i class="fas fa-edit"></i>
        <span data-i18n="edit_profile">{{ __("Edit Profile") }}</span>
    </a>
    <a href="{{ route('members.index') }}" class="btn-ghost">
        <i class="fas fa-arrow-left"></i>
        <span data-i18n="back_to_members">{{ __("Back to Members") }}</span>
    </a>
    @if($member->is_deceased)
        <button type="button" class="btn-ghost" data-action="restore" data-id="{{ $member->id }}" data-name="{{ $fullName }}">
            <i class="fas fa-undo-alt"></i>
            <span data-i18n="restore_to_active">{{ __("Restore to Active") }}</span>
        </button>
    @endif
</div>

<div class="row g-3">

    {{-- LEFT: identity --}}
    <div class="col-lg-4 col-xl-3">
        <div class="panel h-100">
            <div class="panel-body text-center">
                <div class="m-avatar lg mx-auto mb-3 {{ $member->is_deceased ? 'danger' : '' }}">
                    {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
                </div>

                <h2 class="mb-1" style="font-size:1.15rem;font-weight:700;">{{ $fullName }}</h2>
                <p class="text-muted mb-3" style="font-size:.78rem;">
                    <span data-i18n="id_label">{{ __("ID:") }}</span> {{ str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @if($member->is_deceased)
                        <span class="m-pill danger"><i class="fas fa-cross"></i> <span data-i18n="deceased">{{ __("Deceased") }}</span></span>
                    @else
                        <span class="m-pill success"><i class="fas fa-circle"></i> <span data-i18n="active">{{ __("Active") }}</span></span>
                    @endif

                    <span class="m-pill {{ $g[2] }}">
                        <i class="fas {{ $g[0] }}"></i> {{ __($g[1]) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: details --}}
    <div class="col-lg-8 col-xl-9">
        <div class="panel h-100">
            <div class="panel-head">
                <i class="fas fa-user-circle"></i>
                <span data-i18n="personal_information">{{ __("Personal Information") }}</span>
                <span class="m-pill ms-auto" title="{{ __('Member since') }}">
                    <i class="fas fa-clock"></i>
                    {{ \Carbon\Carbon::parse($member->created_at ?? now())->format('M d, Y') }}
                </span>
            </div>

            <div class="panel-body">

                <div class="m-info">
                    <div class="m-info-icon"><i class="fas fa-birthday-cake"></i></div>
                    <div>
                        <p class="m-info-label" data-i18n="birthday_label">{{ __("Birthday") }}</p>
                        <p class="m-info-value">
                            @if($birthday)
                                {{ $birthday->format('F d, Y') }}
                                <span class="text-muted fw-normal" style="font-size:.75rem;">({{ $birthday->age }} {{ __("years old") }})</span>
                            @else
                                <span class="text-muted fw-normal">N/A</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="m-info">
                    <div class="m-info-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <p class="m-info-label" data-i18n="phone_label">{{ __("Phone Number") }}</p>
                        <p class="m-info-value">{{ $member->phone ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="m-info">
                    <div class="m-info-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <p class="m-info-label" data-i18n="email_label">{{ __("Email Address") }}</p>
                        <p class="m-info-value">{{ $member->email ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="m-info">
                    <div class="m-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <p class="m-info-label" data-i18n="address_label">{{ __("Address") }}</p>
                        <p class="m-info-value">{{ $member->address ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="m-info">
                    <div class="m-info-icon"><i class="fas fa-tags"></i></div>
                    <div>
                        <p class="m-info-label" data-i18n="roles_label">{{ __("Roles & Responsibilities") }}</p>
                        <div class="m-info-value">
                            @if($member->roles->count() > 0)
                                <div class="d-flex flex-wrap gap-1 mt-1">
                                    @foreach($member->roles as $role)
                                        <span class="m-pill"><i class="fas fa-shield-alt"></i> {{ $role->name }}</span>
                                    @endforeach
                                    @if($member->is_choir)
                                        <span class="m-pill choir"><i class="fas fa-music"></i> <span data-i18n="choir_label">{{ __("Choir") }}</span></span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted fw-normal" style="font-size:.82rem;">
                                    <span data-i18n="no_roles_assigned">{{ __("No roles assigned") }}</span>
                                    &middot;
                                    <a href="{{ route('members.edit', $member->id) }}" class="fw-semibold">
                                        <i class="fas fa-plus" style="font-size:.6rem;"></i>
                                        <span data-i18n="add_label">{{ __("Add") }}</span>
                                    </a>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    @include('members._scripts')
@endpush