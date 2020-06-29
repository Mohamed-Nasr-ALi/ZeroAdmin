<div id="app">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2" style="padding: 0 !important;">
                @yield('aside')
            </div>
            <div class="col-sm-10 container-fluid vh-100" style="padding: 0 !important;">
                @include('layouts.navbar')
                @include('layouts.content')
            </div>
        </div>
    </div>
</div>


