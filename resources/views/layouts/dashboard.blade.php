<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <img src={{url("/assets/images/allucar-logo.png")}} alt="AlluCar" class="pt-2 pb-2">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    @if (auth()->check())
                        {{ session()->get('success') }}
                        <a href={{ route('login.destroy') }} class="btn btn-primary">Sair</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>