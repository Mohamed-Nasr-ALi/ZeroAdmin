<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm z-depth-1-half">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link btn peach-gradient" href="{{route('agents.index')}}">Agents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn purple-gradient" href="{{route('wallets.index')}}">Wallets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn blue-gradient" href="{{route('send_money')}}">Add Money</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn aqua-gradient" href="{{route('requests.index')}}">Requests</a>
                </li>
                <li class="nav-item dropdown">
                    <button id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" class="btn btn-danger px-3"><i class="fa fa-power-off" style="width: 0 !important;;height: 0!important;" aria-hidden="true"></i></button>

{{--                    <a id="navbarDropdown" class="nav-link text-danger" href="#" role="button"--}}
{{--                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}

{{--                    </a>--}}

                    <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarDropdown">
                        <a style="height: 33px" class="dropdown-item" href="{{ route('logout_admin') }}"
                           onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout_admin') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
