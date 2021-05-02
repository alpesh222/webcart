<nav class="navbar navbar-default navbar-cls-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a target="_blank" class="navbar-brand" href="{{url('/')}}">VISIT STORE</a>
    </div>

    <div class="navbar-right-container">
        @if(\App::isDownForMaintenance())
        <span class="text-success"><strong>Maintenance Mode: ON</strong></span>
        @endif
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="{{route('manage.settings.profile')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    {{Auth::user()->name}} <i class="fa fa-user"></i><span class="caret"></span>
                </a>
                <ul class="dropdown-menu custom_manage_top_drop">
                    <li><a href="{{route('manage.settings.profile')}}"><i class="fa fa-user"></i><b> {{ucfirst(Auth::user()->username)}}</b></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{route('manage.settings.profile')}}"><i class="fa fa-wrench"></i> Edit Profile </a></li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="#" onclick="logout();" class="text-danger"><i class="fa fa-sign-out"></i> Logout </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                        <script>
                            function logout() {
                                var logoutForm = $('#logout-form');
                                if (!logoutForm.hasClass('form-submitted')) {
                                    logoutForm.addClass('form-submitted');
                                    logoutForm.submit();
                                }
                            }
                        </script>
                    </li>
                </ul>
            </li>        
        </ul>
    </div>
</nav>