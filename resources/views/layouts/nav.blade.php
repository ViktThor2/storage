
<script type="text/javascript">
    window.addEventListener("resize", function() {
        "use strict"; window.location.reload();
    });

    document.addEventListener("DOMContentLoaded", function(){

        // make it as accordion for smaller screens
        if (window.innerWidth < 992) {

            // close all inner dropdowns when parent is closed
            document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
                everydropdown.addEventListener('hidden.bs.dropdown', function () {
                    // after dropdown is hidden, then find all submenus
                    this.querySelectorAll('.submenu').forEach(function(everysubmenu){
                        // hide every submenu as well
                        everysubmenu.style.display = 'none';
                    });
                })
            });

            document.querySelectorAll('.dropdown-menu a').forEach(function(element){
                element.addEventListener('click', function (e) {

                    let nextEl = this.nextElementSibling;
                    if(nextEl && nextEl.classList.contains('submenu')) {
                        // prevent opening link if link needs to open dropdown
                        e.preventDefault();

                        if(nextEl.style.display == 'block'){
                            nextEl.style.display = 'none';
                        } else {
                            nextEl.style.display = 'block';
                        }

                    }
                });
            })
        }
        // end if innerWidth

    });
    // DOMContentLoaded  end
</script>

    <!-- ============= COMPONENT ============== -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <img src="{{ asset('img/'.session('company')->id .'.png') }}" height="60" id="nav-img">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">


                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Felhasználó kezelő  </a>
                        <ul class="dropdown-menu">
                            @can('Felhasználók')<li><a class="dropdown-item" href="{{ route('admin.users.index') }}"> Felhasználók </a></li>@endcan
                            @can('Felhasználók jogosultsága')<li><a class="dropdown-item" href="{{ route('admin.roles.index') }}"> Felhasználók jogosultságai </a></li>@endcan
                            @can('Orvosok')<li><a class="dropdown-item" href="{{ route('admin.doctor.index') }}"> Orvosok </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Telephely kezelő  </a>
                        <ul class="dropdown-menu">
                            @can('Rendelők')<li><a class="dropdown-item" href="{{ route('admin.teams.index') }}"> Rendelők </a></li>@endcan
                            @can('Munkaállomások')<li><a class="dropdown-item" href="{{ route('admin.chair.index') }}"> Munkaállomások </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Termék kezelő  </a>
                        <ul class="dropdown-menu">
                            @can('Eszközök')<li><a class="dropdown-item" href="{{ route('admin.assets.index') }}"> Termékek </a></li>@endcan
                            <li><a class="dropdown-item" href="{{ route('admin.category.index') }}"> Kategóriák </a></li>
                            @can('Mennyiségi egységek')<li><a class="dropdown-item" href="{{ route('admin.unit.index') }}"> Mennyiségi egységek </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Készlet kezelő  </a>
                        <ul class="dropdown-menu">
                            @can('Beszállítók')<li><a class="dropdown-item" href="{{ route('admin.importer.index') }}"> Beszállítók </a></li>@endcan
                            @can('Bevételezés')<li><a class="dropdown-item" href="{{ route('admin.stocks.index') }}"> Készlet </a></li>@endcan
                            @can('Tranzakciók')<li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}"> Tranzakciók </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Készletmozgás kezelő  </a>
                        <ul class="dropdown-menu">
                            @can('Bevételezés')<li><a class="dropdown-item" href="{{ route('admin.stock.in') }}"> Bevételezés </a></li>@endcan
                            @can('Felhasználás')<li><a class="dropdown-item" href="{{ route('admin.stock.out') }}"> Felhasználás </a></li>@endcan
                            @can('Raktárak közötti készletmozgás')<li><a class="dropdown-item" href="{{ route('admin.stock.between') }}"> Raktárak közötti készletozgás </a></li>@endcan
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#" id="nav_button_{{ session('company')->id }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>Kijelentkezés
                        </a>
                    </li>
                </ul>

            </div> <!-- navbar-collapse.// -->
        </div> <!-- container-fluid.// -->
    </nav>
