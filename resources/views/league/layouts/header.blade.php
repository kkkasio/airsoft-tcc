<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{Auth::user()->league->avatar ? '/storage/avatars/'.Auth::user()->league->avatar : 'https://baladasegura.rs.gov.br/themes/modelo-institucional/images/outros/GD_imgSemImagem.png'}})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->league->name}}</div>
                        <div class="mt-1 small text-muted">Liga</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href=" {{route('liga-me')}} " class="dropdown-item">Perfil</a>
                    <a href=" {{route('liga-password-form')}} " class="dropdown-item">Trocar Senha</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
        </div>
    </div>
</header>
