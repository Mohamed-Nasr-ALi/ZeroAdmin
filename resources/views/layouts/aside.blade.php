
@section('aside')

    <aside class="main-menu">
        <ul>


            <li class="pt-5">
                <a href="{{route('home')}}" class="text-capitalize">
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                            Home
                        </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="{{route('agents.index')}}" class="text-capitalize">
                    <i class="fa fa-laptop fa-2x"></i>
                    <span class="nav-text">
                            agents
                        </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="{{route('types.index')}}" class="text-capitalize">
                    <i class="fa fa-list fa-2x"></i>
                    <span class="nav-text">
                           types
                        </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="{{route('friends.index')}}" class="text-capitalize">
                    <i class="fa fa-folder-open fa-2x"></i>
                    <span class="nav-text">
                            friends
                        </span>
                </a>

            </li>
            <li>
                <a href="{{route('wallets.index')}}" class="text-capitalize">
                    <i class="fa fa-bar-chart-o fa-2x"></i>
                    <span class="nav-text">
                           wallets
                        </span>
                </a>
            </li>
            <li>
                <a href="{{route('requests.index')}}" class="text-capitalize">
                    <i class="fa fa-font fa-2x"></i>
                    <span class="nav-text">
                           requests
                        </span>
                </a>
            </li>
            <li>
                <a href="#item-1" class="text-capitalize" style="line-height: 2.5;text-indent: 12px" data-toggle="collapse">
                    <i class="fas fa-calendar-alt" ></i><span class="d-inline-block" style="text-indent: 25px">transactions</span>
                </a>
                <div class="list-group collapse" id="item-1">
                    <a href="{{route('show_cc_history_transaction')}}" class="list-group-item text-capitalize text-dark" >
                        c-c history
                    </a>
                    <a href="{{route('show_cm_history_transaction')}}" class="list-group-item text-capitalize text-dark">
                        c-m history
                    </a>
                </div>
            </li>
            <li>
                <a href="{{route('countries.index')}}" class="text-capitalize">
                    <i class="fa fa-map-marker fa-2x"></i>
                    <span class="nav-text">
                            countries
                        </span>
                </a>
            </li>
            <li>
                <a href="{{route('send_money')}}" class="text-capitalize">
                    <i class="fa fa-money fa-2x"></i>
                    <span class="nav-text">
                            Add Money(Top Up)
                        </span>
                </a>
            </li>
            <li>
                <a class="text-capitalize" href="{{ route('logout_admin') }}"
                   onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                           {{ __('Logout') }}
                        </span>

                </a>

                <form id="logout-form" action="{{ route('logout_admin') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>

    </aside>

@endsection
