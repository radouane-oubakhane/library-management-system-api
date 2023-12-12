<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand">FST Library</a>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{'/'}}">Home</a>
            </li>

            @if (Auth::check())
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @endif
    </div>
</nav>

