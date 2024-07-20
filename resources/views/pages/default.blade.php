<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.darkly.min.css" media="(prefers-color-scheme: dark)" />
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" media="(prefers-color-scheme: light)" />
    <link href="/assets/css/SUNYIPESimulationRegistries.css" rel="stylesheet">
    <link href="/assets/css/toastr.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="margin-top:119px;">

    <!-- New Stuff -->
    <nav class="navbar navbar-fixed-top navbar-default" style=" background-color:#004c93;">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" style="width:100%;">
            <a class="navbar-brand pull-left" href="/" style="color: white; background: #004c93;">
                IPE/Simulation Registries
            </a>
          <div class="hidden-xs pull-right center-block">
                <a class="btn btn-xs btn-primary" href="{{route('admin')}}">Admin</a>
                <a class="btn btn-xs btn-primary" href="{{route('manage_page')}}">Manage Account</a>
          </div>
        </div>
      </div>
    </nav>
    <!-- End New Stuff -->

    <nav class="navbar navbar-fixed-top navbar-default" role="navigation" style="margin-top:60px;border:0px;">
      <div class="container-fluid" style="background-color:#004c93;">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse"  id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav" >
              <li><a href="/" style="color: white">Home</a></li>
              <li><a href="/search" style="color: white">Search</a></li>
              <li><a href="/activities" style="color: white">Activities</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid" style="background-color:white">
{{--        <div class="row" style="text-align:center;">--}}
{{--            <strong>@yield('title')</strong>--}}
{{--        </div>--}}
        <div class="row">
            <div class="col-sm-12">
                <strong>@yield('description')</strong>
            </div>
        </div>
        <div>
            @yield('content')
        </div>
        <nav class="footer navbar-fixed-bottom"  style="background-color: #89949B; color: #CCD6DF;text-align: center;">
            {!! config('templates.footer') !!}
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
    <script type="text/javascript">
    var root_url = "{{url('/')}}";
    </script>
    <script type="text/javascript" src="{{url('/assets/js/admin.js')}}"></script>
    <script>
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
