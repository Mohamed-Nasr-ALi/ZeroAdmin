
    <section class="main">
        <div class="absolute" style="right: 32.5%;bottom: 75%">
            <h1 style="font-size: 50px;font-weight: bold;">Welcome To ZeroCache</h1>
        </div>

        <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Sign in</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{route('login_admin')}}">
                        @csrf
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <input name="email" type="email" id="defaultForm-email" class="form-control validate">
                                <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label>
                            </div>

                            <div class="md-form mb-4">
                                <i class="fas fa-lock prefix grey-text"></i>
                                <input name="password" type="password" id="defaultForm-pass" class="form-control validate">
                                <label data-error="wrong" data-success="right" for="defaultForm-pass">Your password</label>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="btn btn-default">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a style="right: 48%" class="shadow text-white absolute btn-round contact-btn" data-toggle="modal" data-target="#modalLoginForm">Login </a>
        </div>
        <div class="absolute cloud_left">
            <ul class="inline-list">
                <li class="cloud"></li>
                <li class="cloud"></li>
                <li class="cloud"></li>
            </ul>
        </div>

        <div class="absolute cloud_right">
            <ul class="inline-list">
                <li class="cloud"></li>
                <li class="cloud"></li>
                <li class="cloud"></li>
            </ul>
        </div>

        <span class="absolute sun"></span>


        <div class="absolute landscape left_m">

				<span class="grass gl">
					<span class="land_tree leftt-gras">
						<ul class="inline-list">
						  <li class="t_grass"></li>
						  <li class="t_grass"></li>
						  <li class="t_grass"></li>
						</ul>
					</span>
				</span>

            <span class="absolute tree1"></span>
            <span class="absolute tree2"></span>
        </div>

        <div class="absolute landscape max_right">

				<span class="grass">
					<span class="land_tree">
						<ul class="inline-list">
						  <li class="t_grass"></li>
						  <li class="t_grass"></li>
						  <li class="t_grass"></li>
						</ul>
					</span>
				</span>

            <div class="mountain">
                <div class="r-mountain"></div>
                <ul class="snow inline-list">
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>

        </div>

        <div class="absolute boat">
            <ul class="no-bullet">
                <ul class="no-bullet fume">
                    <li class="fume4"></li>
                    <li class="fume3"></li>
                    <li class="fume2"></li>
                    <li class="fume1"></li>
                </ul>
                <li class="smokestack"></li>
                <li class="white-body">
                    <ul class="windows inline-list">
                        <li class="circle"></li>
                        <li class="circle"></li>
                        <li class="circle"></li>
                    </ul>
                </li>
                <li class="boat-body"></li>
            </ul>
        </div>

        <div class="absolute dark-back"></div>

        <div class="absolute plane">
            <ul class="no-bullet">
                <li class="plane-body">
                    <ul class="windows inline-list">
                        <li class="circle"></li>
                        <li class="circle"></li>
                        <li class="circle"></li>
                        <li class="circle"></li>
                        <li class="circle"></li>
                    </ul>
                </li>

                <li class="wing1"></li>
                <li class="wing1 flipwing"></li>
                <li class="absolute teal"></li>
            </ul>
        </div>

        <div class="absolute sea">
            <span class="wave1"></span>
            <span class="wave2"></span>
            <span class="wave3"></span>
            <span class="wave4"></span>
        </div>

    </section>

