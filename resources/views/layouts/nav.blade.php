
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
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Felhaszn??l?? kezel??  </a>
                        <ul class="dropdown-menu">
                            @can('Felhaszn??l??k')<li><a class="dropdown-item" href="{{ route('admin.users.index') }}"> Felhaszn??l??k </a></li>@endcan
                            @can('Felhaszn??l??k jogosults??ga')<li><a class="dropdown-item" href="{{ route('admin.roles.index') }}"> Felhaszn??l??k jogosults??gai </a></li>@endcan
                            @can('Orvosok')<li><a class="dropdown-item" href="{{ route('admin.doctor.index') }}"> Orvosok </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Telephely kezel??  </a>
                        <ul class="dropdown-menu">
                            @can('Rendel??k')<li><a class="dropdown-item" href="{{ route('admin.teams.index') }}"> Rendel??k </a></li>@endcan
                            @can('Munka??llom??sok')<li><a class="dropdown-item" href="{{ route('admin.chair.index') }}"> Munka??llom??sok </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  Term??k kezel??  </a>
                        <ul class="dropdown-menu">
                            @can('Eszk??z??k')<li><a class="dropdown-item" href="{{ route('admin.assets.index') }}"> Term??kek </a></li>@endcan
                            <li><a class="dropdown-item" href="{{ route('admin.category.index') }}"> Kateg??ri??k </a></li>
                            @can('Mennyis??gi egys??gek')<li><a class="dropdown-item" href="{{ route('admin.unit.index') }}"> Mennyis??gi egys??gek </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  K??szlet kezel??  </a>
                        <ul class="dropdown-menu">
                            @can('Besz??ll??t??k')<li><a class="dropdown-item" href="{{ route('admin.importer.index') }}"> Besz??ll??t??k </a></li>@endcan
                            @can('Bev??telez??s')<li><a class="dropdown-item" href="{{ route('admin.stocks.index') }}"> K??szlet </a></li>@endcan
                            @can('Tranzakci??k')<li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}"> Tranzakci??k </a></li>@endcan
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="nav_button_{{ session('company')->id }}" data-bs-toggle="dropdown">  K??szletmozg??s kezel??  </a>
                        <ul class="dropdown-menu">
                            @can('Bev??telez??s')<li><a class="dropdown-item" href="{{ route('admin.stock.in') }}"> Bev??telez??s </a></li>@endcan
                            @can('Felhaszn??l??s')<li><a class="dropdown-item" href="{{ route('admin.stock.out') }}"> Felhaszn??l??s </a></li>@endcan
                            @can('Rakt??rak k??z??tti k??szletmozg??s')<li><a class="dropdown-item" href="{{ route('admin.stock.between') }}"> Rakt??rak k??z??tti k??szletozg??s </a></li>@endcan
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#" id="nav_button_{{ session('company')->id }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>Kijelentkez??s
                        </a>
                    </li>
                </ul>

            </div> <!-- navbar-collapse.// -->
        </div> <!-- container-fluid.// -->
    </nav>
