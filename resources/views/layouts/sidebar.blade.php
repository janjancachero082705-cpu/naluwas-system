<aside id="sidebar" class="sidebar-container">
    {{-- Brand --}}
    <div class="brand">
        <div class="logo-upload-trigger" id="logoTrigger">
            @php
                $userImg = Auth::user()->profile_picture ?? Auth::user()->profile_photo_path ?? null;
                $churchLogo = \App\Models\ChurchSetting::current()->logo ?? 'images/church-logo.png';
            @endphp
            @if($userImg && file_exists(public_path('storage/' . $userImg)))
                <img src="{{ $assetPath('storage/' . $userImg) }}" alt="User Profile" class="logo-img" style="object-fit: cover; width: 100%; height: 100%;">
            @elseif(file_exists(public_path($churchLogo)))
                <img src="{{ $assetPath($churchLogo) }}" alt="Church Logo" class="logo-img" style="object-fit: cover; width: 100%; height: 100%; background: #fff; padding: 2px;">
            @else
                <div class="logo-icon-fallback"><i class="fas fa-church"></i></div>
            @endif
        </div>
        <div class="brand-text">
            <div class="brand-name">{{ $churchName ?? 'Church Management' }}</div>
            <div class="brand-sub">{{ $tagline ?? 'Church System' }}</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="nav-menu">
        @php
            $nav = [
                ['label' => 'Main', 'items' => [
                    ['Dashboard', 'dashboard', 'dashboard', 'fa-table-cells-large'],
                    ['Members', 'members.index', 'members.*', 'fa-users'],
                    ['Finance', 'finance.index', 'finance.*', 'fa-money-bill-wave'],
                    ['Inventory', 'inventory.index', 'inventory.*', 'fa-boxes-stacked'],
                ]],
                ['label' => 'Communication', 'items' => [
                    ['Messages', 'messages.index', 'messages.*', 'fa-envelope'],
                ]],
                ['label' => 'Reports', 'items' => [
                    ['Reports & Analytics', 'reports.analytics', 'reports.*', 'fa-chart-line'],
                ]],
            ];
        @endphp

        @foreach($nav as $group)
            @php $visible = array_values(array_filter($group['items'], fn($i) => Route::has($i[1]))); @endphp
            @if(count($visible))
            <div class="nav-section">
                @if($group['label'])
                    <div class="nav-section-title">{{ $group['label'] }}</div>
                @endif
                @foreach($visible as $item)
                    {{-- Only render a link when its route exists --}}
                    @if(Route::has($item[1]))
                        <a href="{{ route($item[1]) }}" class="nav-item {{ request()->routeIs($item[2]) ? 'active' : '' }}" @if(request()->routeIs($item[2])) aria-current="page" @endif>
                            <i class="fas {{ $item[3] }}"></i>
                            <span>{{ $item[0] }}</span>
                            @if($item[1] === 'messages.index' && ($unreadMsgCount ?? 0) > 0)
                                <span class="nav-badge">{{ $unreadMsgCount > 99 ? '99+' : $unreadMsgCount }}</span>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
            @endif
        @endforeach
    </nav>

    {{-- User Section --}}
    <div class="user-section">
        <button type="button" class="user-card" id="userCard" aria-haspopup="true" aria-expanded="false">
            <div class="admin-avatar-wrap">
                @if(Auth::user()->profile_picture)
                    <img src="{{ $assetPath('storage/' . Auth::user()->profile_picture) }}" class="admin-avatar-img" alt="Profile">
                @else
                    <div class="admin-avatar-initials" style="background: var(--primary);">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                @endif
                <span class="admin-status-dot"></span>
            </div>
            <div class="admin-info">
                <div class="admin-name">{{ Auth::user()->name }}</div>
                <div class="admin-role">{{ Auth::user()->church->name ?? 'My account' }}</div>
            </div>
            <i class="fas fa-chevron-up user-chevron" style="font-size: 0.7rem; color: var(--text-muted); transition: transform 0.2s;"></i>
        </button>

        {{-- Dropdown Panel --}}
        <div class="user-panel" id="userPanel">
            @if(Route::has('profile.edit'))
                <a href="{{ route('profile.edit') }}" class="panel-item">
                    <i class="fas fa-user"></i> My Profile
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="panel-item danger">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>
        <div class="sidebar-foot">{{ config('app.name', 'TINC Church System') }}</div>
    </div>
</aside>
