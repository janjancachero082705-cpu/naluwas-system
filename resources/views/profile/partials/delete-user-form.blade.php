<section class="pf-card pf-danger" x-data="{ open: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
    <div class="pf-card-head">
        <span class="pf-card-ico rose"><i class="fas fa-triangle-exclamation"></i></span>
        <div><h3>{{ __('Delete Account') }}</h3><p>{{ __('This permanently removes your account and its data. Download anything you want to keep first.') }}</p></div>
    </div>

    <button type="button" class="pf-btn rose" x-on:click="open = true"><i class="fas fa-trash"></i> {{ __('Delete account') }}</button>

    <div x-show="open" x-cloak style="position:fixed;inset:0;z-index:2000;display:grid;place-items:center;background:rgba(15,13,26,.55);padding:1rem" x-on:keydown.escape.window="open = false">
        <form method="post" action="{{ route('profile.destroy') }}" class="pf-card" style="max-width:460px;width:100%" x-on:click.outside="open = false">
            @csrf
            @method('delete')
            <div class="pf-card-head">
                <span class="pf-card-ico rose"><i class="fas fa-trash"></i></span>
                <div><h3>{{ __('Delete your account?') }}</h3><p>{{ __('Enter your password to confirm. This cannot be undone.') }}</p></div>
            </div>
            <div class="pf-field">
                <div class="pf-input"><i class="fas fa-lock lead"></i>
                    <input id="password" name="password" type="password" placeholder="{{ __('Password') }}">
                </div>
                @foreach($errors->userDeletion->get('password') as $m)<p class="pf-hint" style="color:#DC2626">{{ $m }}</p>@endforeach
            </div>
            <div style="display:flex;gap:.6rem;justify-content:flex-end">
                <button type="button" class="pf-btn ghost" x-on:click="open = false">{{ __('Cancel') }}</button>
                <button type="submit" class="pf-btn rose" style="width:auto">{{ __('Delete account') }}</button>
            </div>
        </form>
    </div>
</section>
