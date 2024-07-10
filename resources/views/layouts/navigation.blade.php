<nav class="navbar sticky-top navbar-expand-sm bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Termékek</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('productlist')}}">Lista</a></li>
            <li><a class="dropdown-item" href="{{route('products')}}">Új termék</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('attribute.set')}}">{{ __('Attribútumok') }}</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('category')}}">{{ __('Kategóriák') }}</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Feed
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('feed')}}">Lista</a></li>
            <li><a class="dropdown-item" href="#">UNAS-ból</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Import
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('import.index')}}">FEED-ből</a></li>
            <li><a class="dropdown-item" href="#">UNAS-ból</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Export
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('export.allproducts')}}">Teljes export UNAS-ba</a></li>
            <li><a class="dropdown-item" href="{{route('export.allproductswithcategories')}}">Termékek uj kategóriákkal export UNAS-ba</a></li>
          </ul>

        </li>
      </ul>
    
    </div>
    <div>
      
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Menu
        </button>
        <ul class="dropdown-menu">
          <li><span class="dropdown-item">{{ Auth::user()->name }}</span></li>
          <li><a class="dropdown-item" href="{{route('profile.edit')}}">Profil</a></li>
          <form method="POST" action="{{ route('logout') }}">
                    @csrf
          <li><a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                        this.closest('form').submit();">Kilép</a></li>
          </form>
        </ul>
      </div>
    </div>
  </div>
</nav>

