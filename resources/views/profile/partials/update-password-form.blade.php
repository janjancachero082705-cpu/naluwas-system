<section class="pf-card pf-danger">
    <div class="pf-card-head">
        <span class="pf-card-ico rose"><i class="fas fa-key"></i></span>
        <div><h3>{{ __('Update Password') }}</h3><p>{{ __('Use a long, random password to stay secure.') }}</p></div>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        @foreach ([
            ['update_password_current_password', 'current_password', 'Current Password', 'current-password'],
            ['update_password_password', 'password', 'New Password', 'new-password'],
            ['update_password_password_confirmation', 'password_confirmation', 'Confirm Password', 'new-password'],
        ] as [$id, $name, $label, $ac])
            <div class="pf-field">
                <label for="{{ $id }}">{{ __($label) }}</label>
                <div class="pf-input"><i class="fas fa-lock lead"></i>
                    <input id="{{ $id }}" name="{{ $name }}" type="password" autocomplete="{{ $ac }}">
                </div>
                @foreach($errors->updatePassword->get($name) as $m)<p class="pf-hint" style="color:#DC2626">{{ $m }}</p>@endforeach
            </div>
        @endforeach

        <button type="submit" class="pf-btn rose"><i class="fas fa-key"></i> {{ __('Update password') }}</button>
        @if (session('status') === 'password-updated')
            <p class="pf-hint" style="text-align:center;color:#16A34A">{{ __('Saved.') }}</p>
        @endif
    </form>
</section>
