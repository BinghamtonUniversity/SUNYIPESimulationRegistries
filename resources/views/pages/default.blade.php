<!DOCTYPE html>
<html lang="en">
<head>
    <title>SUNY Share | @yield('title')</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link href="/assets/css/IPESimulationRegistries.css" rel="stylesheet">
    <link href="/assets/css/toastr.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/css/filepond.css" rel="stylesheet" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon"  type="image/png" href="/assets/icons/fontawesome/gray/32/medkit.png">
</head>

<body style="background-color:#eee;padding-top:50px;">
<style>
  /* ── Navbar base ─────────────────────────────────────────── */
  .navbar-default a:hover {
    color: #18bc9c !important; /* theme's own hover colour on dark bg */
  }
  /* Hamburger toggle: match the SUNY Share brand blue for visual
     consistency and sufficient contrast on the dark navbar (WCAG 1.4.3) */
  .navbar-default .navbar-toggle {
    background-color: #004c93;
    border-color: #004c93;
    border-radius: 4px;
  }
  .navbar-default .navbar-toggle:hover,
  .navbar-default .navbar-toggle:focus {
    background-color: #003a72;
    border-color: #003a72;
    outline: 2px solid #fff;
    outline-offset: 2px;
  }

  /* ── Keyboard focus ring inside dropdowns ────────────────── */
  .dropdown-menu > li > a:focus {
    outline: 2px solid #fff;
    outline-offset: -2px;
    background-color: #337ab7;
    color: #fff;
  }

  /* ── Mobile / zoomed (<768 px or any small viewport) ─────── */
  @media (max-width: 767px) {

    /* Make the expanded collapse panel scrollable                */
    .navbar-collapse.in,
    .navbar-collapse.collapsing {
      max-height: calc(100vh - 50px);
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch;
      padding-bottom: 10px;
    }

    /* Un-float right-side nav so it stacks naturally           */
    .navbar-right {
      float: none !important;
      margin: 0 !important;
      border-top: 1px solid #e7e7e7;
    }

    /* Inline dropdown: show submenu items directly in the list */
    .navbar-right .dropdown-menu {
      position: static !important;
      float: none;
      width: 100%;
      background-color: transparent;
      border: 0;
      box-shadow: none;
      padding: 0;
    }

    .navbar-right .dropdown-menu > li > a {
      padding: 8px 15px 8px 30px;
      color: #555;
    }

    .navbar-right .dropdown-menu > li > a:hover,
    .navbar-right .dropdown-menu > li > a:focus {
      background-color: #f5f5f5;
      color: #333;
    }

    /* Keep the user toggle arrow pointing down, not right      */
    .navbar-right .dropdown-toggle .caret {
      border-top-color: #777;
    }
  }
</style>
<nav class="navbar navbar-fixed-top navbar-default" role="navigation" aria-label="Main navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button"
              class="navbar-toggle collapsed"
              data-toggle="collapse"
              data-target="#main-nav-collapse"
              aria-expanded="false"
              aria-controls="main-nav-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar" aria-hidden="true"></span>
        <span class="icon-bar" aria-hidden="true"></span>
        <span class="icon-bar" aria-hidden="true"></span>
      </button>
      <a class="navbar-brand" href="{{route('home')}}" style="background: #004c93;">
        <i class="fa fa-medkit fa-fw" aria-hidden="true"></i> SUNY Share
      </a>
    </div>

    <div class="collapse navbar-collapse" id="main-nav-collapse">
      <ul class="nav navbar-nav">
        <li @if(request()->routeIs('home')) class="active" @endif>
          <a href="{{route('home')}}" @if(request()->routeIs('home')) aria-current="page" @endif>
            <i class="fa fa-home fa-fw" aria-hidden="true"></i> Home
          </a>
        </li>
        <li @if(request()->routeIs('browse')) class="active" @endif>
          <a href="{{route('browse')}}" @if(request()->routeIs('browse')) aria-current="page" @endif>
            <i class="fa fa-search fa-fw" aria-hidden="true"></i> Browse Activities
          </a>
        </li>
        <li @if(request()->routeIs('glossary')) class="active" @endif>
          <a href="{{route('glossary')}}" @if(request()->routeIs('glossary')) aria-current="page" @endif>
            <i class="fa fa-file fa-fw" aria-hidden="true"></i> Glossary
          </a>
        </li>
        <li @if(request()->routeIs('manage')) class="active" @endif>
          <a href="{{route('manage')}}" @if(request()->routeIs('manage')) aria-current="page" @endif>
            <i class="fa fa-cog fa-fw" aria-hidden="true"></i> Manage My Activities
          </a>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        @guest
          <li>
            <a href="{{route('login')}}">
              <i class="fa fa-sign-in fa-fw" aria-hidden="true"></i> Login
            </a>
          </li>
        @endguest
        @auth
        <li class="dropdown">
          <button type="button"
                  id="user-menu-toggle"
                  class="dropdown-toggle navbar-btn btn btn-link"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                  aria-controls="user-dropdown-menu"
                  style="color:#ffffff;background-color:transparent;box-shadow:none;padding:15px;text-decoration:none;">
            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
            <span class="caret" aria-hidden="true"></span>
          </button>
          <ul class="dropdown-menu"
              id="user-dropdown-menu"
              role="menu"
              aria-labelledby="user-menu-toggle">
            @can('admin', App\Models\User::class)
              <li role="none">
                <a href="/admin" role="menuitem">
                  <i class="fa fa-cog fa-fw" aria-hidden="true"></i> Admin
                </a>
              </li>
            @endcan
            <li role="none">
              <a href="{{route('logout')}}" role="menuitem">
                <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> Logout
              </a>
            </li>
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
            <main>
            @yield('content')
            </main>
        </div>
      </div>
      <footer role="contentinfo" style="background-color:#004c93;color:#CCD6DF;text-align:center;padding:12px 15px;margin-top:30px;">
        {!! $site_config['footer'] ?? '' !!}
      </footer>
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
    <script src="/assets/js/vendor/filepond.js"></script>
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

    <script>
    $(document).ready(function () {

        // Sync aria-expanded on the user dropdown toggle
        $('#user-menu-toggle').closest('.dropdown')
            .on('show.bs.dropdown', function () {
                $('#user-menu-toggle').attr('aria-expanded', 'true');
            })
            .on('shown.bs.dropdown', function () {
                // Move focus to first menu item when dropdown opens
                $('#user-dropdown-menu [role="menuitem"]').first().focus();
            })
            .on('hide.bs.dropdown', function () {
                $('#user-menu-toggle').attr('aria-expanded', 'false');
            })
            .on('hidden.bs.dropdown', function () {
                // Return focus to toggle when dropdown closes
                $('#user-menu-toggle').focus();
            });

        // Sync aria-expanded on the mobile navbar toggle
        $('[data-toggle="collapse"][data-target="#main-nav-collapse"]').on('click', function () {
            var isExpanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', isExpanded ? 'false' : 'true');
        });

        // Keyboard navigation inside dropdown menus
        $(document).on('keydown', '#user-dropdown-menu [role="menuitem"]', function (e) {
            var $items = $('#user-dropdown-menu [role="menuitem"]');
            var index  = $items.index(this);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                $items.eq((index + 1) % $items.length).focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                $items.eq((index - 1 + $items.length) % $items.length).focus();
            } else if (e.key === 'Escape') {
                e.preventDefault();
                $('#user-menu-toggle').dropdown('toggle');
            } else if (e.key === 'Tab') {
                // Close dropdown when tabbing out of the last item
                if (!e.shiftKey && index === $items.length - 1) {
                    $('#user-menu-toggle').dropdown('toggle');
                } else if (e.shiftKey && index === 0) {
                    e.preventDefault();
                    $('#user-menu-toggle').dropdown('toggle');
                }
            }
        });

        // Open dropdown and focus first item on Enter/Space/ArrowDown from toggle
        $(document).on('keydown', '#user-menu-toggle', function (e) {
            if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if ($(this).closest('.dropdown').hasClass('open')) {
                    $('#user-dropdown-menu [role="menuitem"]').first().focus();
                } else {
                    $(this).dropdown('toggle');
                }
            } else if (e.key === 'Escape') {
                if ($(this).closest('.dropdown').hasClass('open')) {
                    $(this).dropdown('toggle');
                }
            }
        });
    });
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
