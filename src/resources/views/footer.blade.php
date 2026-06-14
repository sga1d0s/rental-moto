
<nav class="bottom-nav">
    <a href="{{ route('home') }}" class="bottom-nav__item {{ Route::is('home') ? 'bottom-nav__item--active' : '' }}">
        <i class="bi bi-house bottom-nav__icon"></i>
        <span class="bottom-nav__label">Inicio</span>
    </a>
    <a href="{{ route('motos.index') }}" class="bottom-nav__item {{ Route::is('motos.*') ? 'bottom-nav__item--active' : '' }}">
        <i class="bi bi-scooter bottom-nav__icon"></i>
        <span class="bottom-nav__label">Listado</span>
    </a>
    <a href="{{ route('reservas.index') }}" class="bottom-nav__item {{ Route::is('reservas.*') ? 'bottom-nav__item--active' : '' }}">
        <i class="bi bi-calendar-check bottom-nav__icon"></i>
        <span class="bottom-nav__label">Reservas</span>
    </a>
</nav>
