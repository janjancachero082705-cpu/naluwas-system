<section class="pf-card">
    <div class="pf-card-head">
        <span class="pf-card-ico"><i class="fas fa-id-card"></i></span>
        <div><h3>{{ __('Profile Information') }}</h3><p>{{ __("Update your account's profile information and email address.") }}</p></div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="pf-field">
            <label for="name">{{ __('Name') }}</label>
            <div class="pf-input"><i class="fas fa-user lead"></i>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            </div>
            @foreach($errors->get('name') as $m)<p class="pf-hint" style="color:#DC2626">{{ $m }}</p>@endforeach
        </div>

        <div class="pf-field">
            <label for="email">{{ __('Email') }}</label>
            <div class="pf-input"><i class="fas fa-envelope lead"></i>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            </div>
            @foreach($errors->get('email') as $m)<p class="pf-hint" style="color:#DC2626">{{ $m }}</p>@endforeach

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="pf-hint">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" style="background:none;border:0;padding:0;color:var(--primary);font-weight:700;cursor:pointer">{{ __('Re-send the verification email.') }}</button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="pf-hint" style="color:#16A34A">{{ __('A new verification link has been sent to your email address.') }}</p>
                @endif
            @endif
        </div>

        <button type="submit" class="pf-btn"><i class="fas fa-floppy-disk"></i> {{ __('Save changes') }}</button>
        @if (session('status') === 'profile-updated')
            <p class="pf-hint" style="text-align:center;color:#16A34A">{{ __('Saved.') }}</p>
        @endif
    </form>
</section>
