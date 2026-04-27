<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}"><img class="img-logo" src="{{ asset('images/logo.jpg') }}" alt="My library"></a>
    <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                My Library
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('book.index') }}">Book's List</a></li>
                <li><hr class="dropdown-divider"></li>
                {{-- <li><a class="dropdown-item" href="{{ route('author.index') }}">Author's List</a></li> --}}
                <li><a class="dropdown-item" href="">Author's List</a></li>
                </ul>
            </li>
          
        </ul>
        <div>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{auth()->user()?->name ?? 'Guest'}}
                        </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
 
                                <button type="submit" class="" href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                        </ul>
                    </li>        
                @endauth
                @guest
                            
                <li class="nav-item float-right">
                        <a class="nav-link" aria-current="page" href="{{ route('login') }}">Login</a>
                    </li>
                @endguest
            </ul>
        </div>
                       
    </div>
    </div>
</nav>