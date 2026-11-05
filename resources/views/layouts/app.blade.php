<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Generador de Tickets Navideños' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=20261104-6">
    <script src="{{ asset('js/date-toggle.js') }}?v=20261104-1" defer></script>
    <script src="{{ asset('js/design-save.js') }}?v=20261104-1" defer></script>
</head>
<body class="app-shell">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-mark">▰</div>
            <div><strong>PORTÁTILES<br>PERÚ</strong><small>Tecnología a tu alcance</small></div>
        </div>
        <nav class="main-nav" aria-label="Navegación principal">
            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span>⌂</span> Dashboard</a>
            <a class="{{ request()->routeIs('template.design') ? 'active' : '' }}" href="{{ route('template.design') }}"><span>◉</span> Diseño de Plantilla</a>
            <a class="{{ request()->routeIs('tickets.create') ? 'active' : '' }}" href="{{ route('tickets.create') }}"><span>▣</span> Generar Tickets</a>
            <a class="{{ request()->routeIs('tickets.history') ? 'active' : '' }}" href="{{ route('tickets.history') }}"><span>◷</span> Historial</a>
            <a class="{{ request()->routeIs('downloads.*') ? 'active' : '' }}" href="{{ route('downloads.index') }}"><span>⇩</span> Descargas</a>
            @can('manage-users')
                <a class="{{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><span>♟</span> Usuarios</a>
            @endcan
            <a class="{{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.edit') }}"><span>⚙</span> Configuración</a>
        </nav>
        <div class="sidebar-footer">
            <div class="christmas-badge">✦<br><span>Feliz<br>Navidad</span></div>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="logout"><span>↪</span> Cerrar Sesión</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <button class="menu-toggle" type="button" aria-label="Abrir menú">☰</button>
            <div class="topbar-title"><span class="tree">🎄</span><div><h1>{{ $heading ?? 'Generador de Tickets Navideños' }} <b>– Portátiles Perú</b></h1><small>Panel de administración</small></div></div>
            <div class="profile"><span class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><div><strong>{{ auth()->user()->name }}</strong><small>{{ ucfirst(auth()->user()->role) }}</small></div><span class="chevron">⌄</span></div>
        </header>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
