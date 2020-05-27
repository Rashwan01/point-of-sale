<!DOCTYPE html>
<html dir= "{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/dashboard/rtl/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->

  @if(app()->getLocale()=="ar")
  <!-- Theme style -->
  <link rel="stylesheet" href="/dashboard/rtl/dist/css/adminlte.min.css">
  <!-- Bootstrap 4 RTL -->
  <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
  <!-- Custom style for RTL -->
  <link rel="stylesheet" href="/dashboard/rtl/dist/css/custom.css">
@else
  <link rel="stylesheet" href="/dashboard/dist/css/adminlte.min.css">
  @endif

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </ul>



        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto-navbav">
          <!-- localization -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-globe-africa"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

              <ul class="list-unstyled">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="nav-item">
                  <a class="nav-link" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $properties['native'] }}
                  </a>
                </li>
                @endforeach
              </ul>


            </div>
          </li>


        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
          <img src="/dashboard/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
          <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="/dashboard/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">{{Auth()->user()->first_name.' '.Auth()->user()->last_name}}</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item has-treeview ">
            <a href="{{route('dashboard.')}}" class="nav-link @if(Request::segment(2) =='dashboards' && Request::segment(3) == '') active @endif">
             <i class="nav-icon fa fa-home" aria-hidden="true"></i>
             <p>
               @lang('site.home')
               
             </p>
           </a>
         </li>
         <!-- users -->
         @permission("read-users")
         <li class="nav-item">
          <a href="{{route('dashboard.user.index')}}" class="nav-link @if(Request::segment(2) =='dashboards' && Request::segment(3) == 'user') active @endif">
            <i class=" nav-icon fa fa-user" aria-hidden="true"></i>

            <p>
              @lang("site.users")
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
        @endpermission
        <!-- end Users -->
        <!-- categories -->
        @permission("read-categories")
        <li class="nav-item">
          <a href="{{route('dashboard.categories.index')}}" class="nav-link @if(Request::segment(2) =='dashboards' && Request::segment(3) == 'categories') active @endif">
            <i class="nav-icon fas fa-th"></i>
            <p>
              @lang("site.categories")
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
        @endpermission
        <!-- end categories -->

        <!-- products -->
        @permission("read-products")
        <li class="nav-item">
          <a href="{{route('dashboard.products.index')}}" class="nav-link @if(Request::segment(2) =='dashboards' && Request::segment(3) == 'products') active @endif">
            <i class="nav-icon fas fa-th"></i>
            <p>
              @lang("site.products")
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
        @endpermission
        <!-- end products -->

        <!-- Client -->
        @permission("read-clients")
        <li class="nav-item">
          <a href="{{route('dashboard.clients.index')}}" class="nav-link @if(Request::segment(2) =='dashboards' && Request::segment(3) == 'clients') active @endif">
            <i class="nav-icon fa fa-users" aria-hidden="true"></i>
            <p>
              @lang("site.clients")
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
        @endpermission
        <!-- end Client -->
        <!-- Client -->
        @permission("read-orders")
        <li class="nav-item">
          <a href="{{route('dashboard.orders.index')}}" class="nav-link @if(Request::segment(2) =='dashboards' && Request::segment(3) == 'orders') active @endif">
            <i class="nav-icon fa fa-shopping-cart" aria-hidden="true"></i>
            <p>
              @lang("site.orders")
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
        @endpermission
        <!-- end Client -->
        
        <li class="nav-item">
         <a class="nav-link" href="{{ route('logout') }}"
         onclick="event.preventDefault();
         document.getElementById('logout-form').submit();">
         @lang("site.logout")
       </a>

       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>



@yield("content")
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.0.0-rc.1
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/dashboard/rtl/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/dashboard/rtl/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="/dashboard/rtl/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/dashboard/rtl/dist/js/adminlte.js"></script>
<script src="/dashboard/rtl/dist/js/jquery.number.min.js"></script>
<script src="/dashboard/rtl/dist/js/custom.js"></script>
<script src="https://unpkg.com/turbolinks"></script>

</body>
</html>
