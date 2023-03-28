<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{asset(Storage::disk('public')->url('profile/'.Auth::user()->image))}}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
            <div class="email">{{Auth::user()->email}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="{{Auth::user()->role->id == 1 ? route('admin.profile.settings') : route('author.profile.settings')}}">
                            <i class="material-icons">person</i>Profile
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            @if(Request::is('admin*'))
                <li class="{{Request::is('admin/dashboard') ? 'active' : ''}}">
                    <a href="{{route('admin.dashboard')}}">
                        <i class="material-icons">dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{Request::is('admin/tag*') ? 'active' : ''}}">
                    <a href="{{route('admin.tag')}}">
                        <i class="material-icons">label</i>
                        <span>Tag</span>
                    </a>
                </li>
                <li class="{{Request::is('admin/category*') ? 'active' : ''}}">
                    <a href="{{route('admin.category')}}">
                        <i class="material-icons">category</i>
                        <span>Category</span>
                    </a>
                </li>
                <li class="{{Request::is('admin/post*') ? 'active' : ''}}">
                    <a href="{{route('admin.post')}}">
                        <i class="material-icons">book</i>
                        <span>Post</span>
                    </a>
                </li>
                <li class="{{Request::is('admin/pending/post') ? 'active' : ''}}">
                    <a href="{{route('admin.post.pending')}}">
                        <i class="material-icons">help_center</i>
                        <span>Pending Post</span>
                    </a>
                </li>
                <li class="{{Request::is('admin/subscribers') ? 'active' : ''}}">
                    <a href="{{route('admin.subscriber')}}">
                        <i class="material-icons">subscriptions</i>
                        <span>Subscribers</span>
                    </a>
                </li>
                <li class="{{Request::is('admin/favourite-post') ? 'active' : ''}}">
                    <a href="{{route('admin.favorite.post')}}">
                        <i class="material-icons">favorite</i>
                        <span>favorite Post</span>
                    </a>
                </li>
                <li class="{{Request::is('admin/comment') ? 'active' : ''}}">
                    <a href="{{route('admin.comment')}}">
                        <i class="material-icons">comment</i>
                        <span>Comments</span>
                    </a>
                </li>

                <li class="header">LABELS</li>

                <li class="{{Request::is('admin/profile/settings') ? 'active' : ''}}">
                    <a href="{{route('admin.profile.settings')}}">
                        <i class="material-icons">settings</i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

             @endif

            @if(Request::is('author*'))
                <li class="{{Request::is('author/dashboard') ? 'active' : ''}}">
                    <a href="{{route('author.dashboard')}}">
                        <i class="material-icons">dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{Request::is('author/post*') ? 'active' : ''}}">
                    <a href="{{route('author.post')}}">
                        <i class="material-icons">book</i>
                        <span>Post</span>
                    </a>
                </li>

                <li class="{{Request::is('author/favourite-post') ? 'active' : ''}}">
                    <a href="{{route('author.favorite.post')}}">
                        <i class="material-icons">favorite</i>
                        <span>favorite Post</span>
                    </a>
                </li>
                <li class="{{Request::is('author/comment') ? 'active' : ''}}">
                    <a href="{{route('author.comment')}}">
                        <i class="material-icons">comment</i>
                        <span>Comments</span>
                    </a>
                </li>
                <li class="header">LABELS</li>

                <li class="{{Request::is('author/profile/settings') ? 'active' : ''}}">
                    <a href="{{route('author.profile.settings')}}">
                        <i class="material-icons">settings</i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            @endif

        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>
