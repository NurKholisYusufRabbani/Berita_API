<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">Global News</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/home/health') }}">Health</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/home/movies') }}">Movies</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/home/food') }}">Food</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/home/fashion') }}">Fashion</a></li>
            </ul>
        </div>
    </div>
</nav>
