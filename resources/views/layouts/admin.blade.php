<!DOCTYPE html>
<html>

@include('layouts.style')

<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">

    <header id="nav_{{ session('company')->id }}">

        @include('layouts.nav')

    </header>

    <div class="app-body" style="margin-top: 0">


        <main class="main" style="margin-left:0 ">

            <div style="padding-top: 20px" class="container-fluid mb-5">

                @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                                <li>{{ session('error') }}</li>
                        </ul>
                    </div>
                @endif

                @yield('content')

            </div>

        </main>

        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    </div>

        @include('layouts.footer')

@include('layouts.scripts')
</body>

</html>
