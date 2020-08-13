  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Customer System</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Customer System</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">


          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <span class="hidden-xs">{{auth('web')->user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="/123.png" class="img-circle" alt="User Image">
                <p>
                  {{auth('web')->user()->name}}
                  <small>最後登入:{{date('Y-m-d H:i',strtotime(auth('web')->user()->updated_at))}}</small>
                </p>
              </li>

              </li>
              <!-- Menu Footer-->
              <li class="user-footer">

                <!--<div class="pull-left">
                  <a href="/admin/user/{{auth('web')->user()->id}}/edit" class="btn btn-default btn-flat">編輯</a>
                </div>-->

                <div class="pull-right">
                    <a  href="{{ route('logout') }}"
                        class="btn btn-default btn-flat"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        登出
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>