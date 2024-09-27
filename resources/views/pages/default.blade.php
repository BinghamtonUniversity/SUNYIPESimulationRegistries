<!DOCTYPE html>
<html>
<head>
    <title>OpenSim | @yield('title')</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link href="/assets/css/IPESimulationRegistries.css" rel="stylesheet">
    <link href="/assets/css/toastr.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon"  type="image/png" href="/assets/icons/fontawesome/gray/32/medkit.png">
</head>

<body style="background-color:#eee;">
<style>
  .navbar-inverse a:hover {
    color:#ddd !important;
  }
</style>
<nav class="navbar navbar-fixed-top navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{route('home')}}" style="background: #004c93;"><i class="fa fa-medkit fa-fw"></i> OpenSim Registry</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li @if(request()->routeIs('home')) class="active" @endif><a href="{{route('home')}}"><i class="fa fa-home fa-fw"></i> Home <span class="sr-only">(current)</span></a></li>
        <li @if(request()->routeIs('search')) class="active" @endif><a href="{{route('search')}}"><i class="fa fa-search fa-fw"></i> Search</a></li>
        @auth<li @if(request()->routeIs('manage')) class="active" @endif><a href="{{route('manage')}}"><i class="fa fa-cog fa-fw"></i> Manage My Activities</a></li>@endauth
      </ul>
      <!--
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      -->
      <ul class="nav navbar-nav navbar-right">
        @guest<li><a href="{{route('login')}}"><i class="fa fa-sign-in fa-fw"></i> Login</a></li>@endguest
        @auth
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/admin"><i class="fa fa-cog fa-fw"></i> Admin</a></li>
            <li><a href="{{route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
          </ul>
        </li>
        @endauth
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          @yield('description')
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          @yield('content')
        </div>
      </div>
      <nav class="footer navbar-fixed-bottom" style="background-color:#004c93;color:#CCD6DF;text-align:center;">
        <span>OpenSim Registry | &copy; 2024 Binghamton University</span>
      </nav>
    </div>

    <script src="{{url('/assets/js/vendor/jquery.min.js')}}"></script>
    <script src="{{url('/assets/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/js/vendor/lodash.min.js')}}"></script>
    <script>_.findWhere = _.find; _.where = _.filter;_.pluck = _.map;_.contains = _.includes;</script>
    <script src="{{url('/assets/js/vendor/hogan.min.js')}}"></script>
    <script src="{{url('/assets/js/vendor/toastr.min.js')}}"></script>
    <script src="{{url('/assets/js/vendor/gform_bootstrap.min.js')}}"></script>
    <script src="{{url('/assets/js/vendor/GrapheneDataGrid.min.js')}}"></script>
    <script src="{{url('/assets/js/vendor/moment.js')}}"></script>
    <script src="{{url('/assets/js/vendor/bootstrap-datetimepicker.min.js')}}"></script>
    <script src='/assets/js/vendor/ractive.min.js'></script>
    <script src="/assets/js/_framework.js"></script>
    <script type="text/javascript">
    var root_url = "{{url('/')}}";
    </script>
    <script>
      @if (isset($data))
      window.data = <?php echo json_encode($data); ?>;
      @endif
      @yield('scripts')
    </script>

    <!-- Begin Google Analytics -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-1861349-1', 'auto');
    ga('send', 'pageview');
    </script>
<!-- End Google Analytics -->
</body>
</html>
