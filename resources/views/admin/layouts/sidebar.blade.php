<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{route('dashboard.view')}}">
                        <img src="{{asset('assets/img/logo/aaip-logo.png')}}" style="width: auto" alt="logo">
                    </a>
                </div>
                {{-- <div class="nav-item theme-text">
                    <a href="./index.html" class="nav-link"> CORK </a>
                </div> --}}
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>
        <div class="profile-info">
            <div class="user-info">
                <div class="profile-img">
                    <img src="{{asset($user['avatar_url'] ? $user['avatar_url'] : 'assets/img/user.png')}}" alt="avatar">
                </div>
                <div class="profile-content">
                    <h6>{{$user['fullname']}}</h6>
                    <p>{{$user['role']['name']}}</p>
                </div>
            </div>
        </div>

        {{-- <div class="shadow-bottom"></div> --}}
        <ul class="list-unstyled menu-categories menu-sidebar" id="accordionExample"></ul>

    </nav>

</div>
