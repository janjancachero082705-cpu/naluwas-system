@extends('layouts.app')

@section('header', 'Members')
@section('subheader', trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? '')) . ' · #' . str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT))

@push('styles')
    @include('members._styles')
@endpush

@section('content')
@php
    $selectedRoles = old('roles', $memberRoles ?? []);
    $choirRoles    = ['Singer', 'Guitarist', 'Bassist', 'Drummer'];
@endphp

<div class="panel m-narrow mx-auto">

    <div class="panel-head flex-wrap">
        <div class="m-avatar">
            {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
        </div>
        <span data-i18n="edit_member_information">{{ __("Edit Member Information") }}</span>

        <div class="ms-auto d-flex align-items-center gap-2">
            <span class="m-pill">
                <i class="fas fa-clock"></i>
                <span data-i18n="last_updated">{{ __("Last updated:") }}</span>
                {{ $member->updated_at ? \Carbon\Carbon::parse($member->updated_at)->diffForHumans() : __("Never") }}
            </span>
            <a href="{{ route('members.show', $member->id) }}" class="btn-ghost">
                <i class="fas fa-eye"></i>
                <span data-i18n="view_profile">{{ __("View Profile") }}</span>
            </a>
        </div>
    </div>

    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="panel-body">

            {{-- PERSONAL INFORMATION --}}
            <section class="m-section">
                <h3 class="m-section-title">
                    <i class="fas fa-user-circle"></i>
                    <span data-i18n="personal_information">{{ __("Personal Information") }}</span>
                </h3>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">
                            <span data-i18n="first_name">{{ __("First Name") }}</span> <span class="req">*</span>
                        </label>
                        <input type="text" id="first_name" name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name', $member->first_name) }}"
                               placeholder="{{ __('Enter first name') }}" required>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label">
                            <span data-i18n="last_name">{{ __("Last Name") }}</span> <span class="req">*</span>
                        </label>
                        <input type="text" id="last_name" name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name', $member->last_name) }}"
                               placeholder="{{ __('Enter last name') }}" required>
                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="birthday" class="form-label" data-i18n="birthday">{{ __("Birthday") }}</label>
                        <input type="date" id="birthday" name="birthday"
                               class="form-control @error('birthday') is-invalid @enderror"
                               value="{{ old('birthday', $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('Y-m-d') : '') }}">
                        @error('birthday') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="gender" class="form-label" data-i18n="gender">{{ __("Gender") }}</label>
                        <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">{{ __("Select Gender") }}</option>
                            <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>{{ __("Male") }}</option>
                            <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>{{ __("Female") }}</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label" data-i18n="phone_number">{{ __("Phone Number") }}</label>
                        <input type="text" id="phone" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $member->phone) }}"
                               placeholder="{{ __('Enter phone number') }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label" data-i18n="email_address">{{ __("Email Address") }}</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $member->email) }}"
                               placeholder="{{ __('Enter email address') }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label" data-i18n="address">{{ __("Address") }}</label>
                        <input type="text" id="address" name="address"
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address', $member->address) }}"
                               placeholder="{{ __('Enter address') }}">
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </section>

            {{-- ROLES --}}
            <section class="m-section">
                <h3 class="m-section-title">
                    <i class="fas fa-tags"></i>
                    <span data-i18n="roles_responsibilities">{{ __("Roles & Responsibilities") }}</span>
                </h3>

                <div class="row g-2">
                    @foreach($roles as $role)
                        <div class="col-sm-6 col-lg-4">
                            <label class="m-role">
                                <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $role->id }}"
                                       {{ in_array($role->id, $selectedRoles) ? 'checked' : '' }}>
                                <i class="fas {{ $role->icon ?? 'fa-tag' }}"></i>
                                <span>{{ $role->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('roles') <div class="text-danger mt-2" style="font-size:.8rem;">{{ $message }}</div> @enderror
            </section>

            {{-- CHOIR --}}
            <section class="m-section">
                <h3 class="m-section-title">
                    <i class="fas fa-music"></i>
                    <span data-i18n="choir_information">{{ __("Choir Information") }}</span>
                    <span class="text-muted fw-normal" style="font-size:.72rem;">(<span data-i18n="optional">{{ __("Optional") }}</span>)</span>
                </h3>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="choir_group_id" class="form-label" data-i18n="choir_group">{{ __("Choir Group") }}</label>
                        <select id="choir_group_id" name="choir_group_id"
                                class="form-select @error('choir_group_id') is-invalid @enderror">
                            <option value="">{{ __("No Choir Group") }}</option>
                            @foreach($choirGroups ?? [] as $group)
                                <option value="{{ $group->id }}"
                                    {{ old('choir_group_id', $member->choir_group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('choir_group_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="choir_role" class="form-label" data-i18n="choir_role">{{ __("Choir Role") }}</label>
                        <select id="choir_role" name="choir_role"
                                class="form-select @error('choir_role') is-invalid @enderror">
                            <option value="">{{ __("No Choir Role") }}</option>
                            @foreach($choirRoles as $choirRole)
                                <option value="{{ $choirRole }}"
                                    {{ old('choir_role', $member->choir_role) == $choirRole ? 'selected' : '' }}>
                                    {{ __($choirRole) }}
                                </option>
                            @endforeach
                        </select>
                        @error('choir_role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </section>

            <div class="m-foot">
                <a href="{{ route('members.index') }}" class="btn-ghost">
                    <i class="fas fa-times"></i>
                    <span data-i18n="cancel">{{ __("Cancel") }}</span>
                </a>
                <button type="submit" class="btn-cyan">
                    <i class="fas fa-check"></i>
                    <span data-i18n="update_member">{{ __("Update Member") }}</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Scroll to the first invalid field
        const invalid = document.querySelector('.is-invalid');
        if (invalid) {
            invalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            invalid.focus();
        }

        // Unsaved-changes guard
        const form = document.querySelector('.panel form');
        if (!form) return;

        let changed = false;
        form.querySelectorAll('input, select, textarea').forEach(function (el) {
            el.addEventListener('change', function () { changed = true; });
        });
        form.addEventListener('submit', function () { changed = false; });

        window.addEventListener('beforeunload', function (e) {
            if (!changed) return;
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        });
    });

    window.addEventListener('localeChanged', function () {
        if (typeof window.applyTranslations === 'function') window.applyTranslations();
    });
</script>
@endpush