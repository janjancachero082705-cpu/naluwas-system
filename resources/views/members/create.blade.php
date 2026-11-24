@extends('layouts.app')

@section('header', 'Members')
@section('subheader', __('Add a new member to your church family'))

@push('styles')
    @include('members._styles')
@endpush

@section('content')
<div class="panel m-narrow mx-auto">

    <div class="panel-head">
        <i class="fas fa-user-plus"></i>
        <span data-i18n="add_new_member">{{ __("Add New Member") }}</span>
        <span class="ms-auto text-muted fw-normal" style="font-size:.75rem;" data-i18n="fill_required_fields">
            {{ __("Fields marked with * are required") }}
        </span>
    </div>

    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <div class="panel-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label for="first_name" class="form-label">
                        <span data-i18n="first_name">{{ __("First Name") }}</span> <span class="req">*</span>
                    </label>
                    <input type="text" id="first_name" name="first_name"
                           class="form-control @error('first_name') is-invalid @enderror"
                           placeholder="{{ __('Enter first name') }}" value="{{ old('first_name') }}" required>
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="last_name" class="form-label">
                        <span data-i18n="last_name">{{ __("Last Name") }}</span> <span class="req">*</span>
                    </label>
                    <input type="text" id="last_name" name="last_name"
                           class="form-control @error('last_name') is-invalid @enderror"
                           placeholder="{{ __('Enter last name') }}" value="{{ old('last_name') }}" required>
                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label" data-i18n="gender">{{ __("Gender") }}</label>
                    <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">{{ __("Select Gender") }}</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __("Male") }}</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __("Female") }}</option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="birthday" class="form-label" data-i18n="birthday">{{ __("Birthday") }}</label>
                    <input type="date" id="birthday" name="birthday"
                           class="form-control @error('birthday') is-invalid @enderror" value="{{ old('birthday') }}">
                    @error('birthday') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">
                        <span data-i18n="phone">{{ __("Phone") }}</span>
                        <span class="fw-normal">(<span data-i18n="optional">{{ __("Optional") }}</span>)</span>
                    </label>
                    <input type="text" id="phone" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           placeholder="{{ __('Enter phone number') }}" value="{{ old('phone') }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <span data-i18n="email">{{ __("Email") }}</span>
                        <span class="fw-normal">(<span data-i18n="optional">{{ __("Optional") }}</span>)</span>
                    </label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="{{ __('Enter email address') }}" value="{{ old('email') }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label for="address" class="form-label" data-i18n="address">{{ __("Address") }}</label>
                    <input type="text" id="address" name="address"
                           class="form-control @error('address') is-invalid @enderror"
                           placeholder="{{ __('Complete address of the member') }}" value="{{ old('address') }}">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Roles --}}
                <div class="col-12">
                    <label class="form-label mb-1" data-i18n="roles_ministries">{{ __("Roles / Ministries") }}</label>
                    <p class="text-muted mb-2" style="font-size:.75rem;" data-i18n="select_roles_hint">
                        {{ __("Select one or more roles for this member") }}
                    </p>

                    @if(isset($roles) && $roles->count() > 0)
                        <div class="row g-2">
                            @foreach($roles as $role)
                                <div class="col-sm-6 col-lg-4">
                                    <label class="m-role">
                                        <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $role->id }}"
                                               {{ is_array(old('roles')) && in_array($role->id, old('roles')) ? 'checked' : '' }}>
                                        <i class="fas {{ $role->icon ?? 'fa-tag' }}"></i>
                                        <span>{{ $role->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="m-empty py-3">
                            <p class="mb-0" data-i18n="no_roles_available">{{ __("No roles available. Please contact administrator.") }}</p>
                        </div>
                    @endif

                    @error('roles') <div class="text-danger mt-2" style="font-size:.8rem;">{{ $message }}</div> @enderror
                </div>

            </div>

            <div class="m-foot">
                <a href="{{ route('members.index') }}" class="btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    <span data-i18n="cancel">{{ __("Cancel") }}</span>
                </a>
                <button type="submit" class="btn-cyan">
                    <i class="fas fa-check"></i>
                    <span data-i18n="save_member">{{ __("Save Member") }}</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    window.addEventListener('localeChanged', function () {
        if (typeof window.applyTranslations === 'function') window.applyTranslations();
    });
</script>
@endpush