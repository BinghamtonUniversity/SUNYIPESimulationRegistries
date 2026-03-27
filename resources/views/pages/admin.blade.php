<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon"  type="image/png" href="/assets/icons/fontawesome/gray/32/medkit.png">
    <title>SUNY Share | {{$title}}</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link href="/assets/css/IPESimulationRegistries.css" rel="stylesheet">
    <link href="/assets/css/toastr.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>
    <link data-name="vs/editor/editor.main" rel="stylesheet" href="/assets/js/vendor/vs/editor/editor.main.css">
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin">
            <i class="fa fa-medkit fa-fw" aria-hidden="true"></i> Admin
          </a>
            <ul class="nav navbar-nav hidden-xs">
              <li aria-current="page"><span class="navbar-text"><h4 style="margin:0px;">{{$title}}</h4></span></li>
          </ul>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <button type="button"
                      class="dropdown-toggle identity-info navbar-btn btn btn-link"
                      data-toggle="dropdown"
                      aria-haspopup="true"
                      aria-expanded="false">
                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                <span class="caret" aria-hidden="true"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li role="none"><a href="/" role="menuitem"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Home</a></li>
                <li role="none"><a href="{{ url('/logout') }}" role="menuitem"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
              </ul>
              @can('viewAny','App\Activity')
                <li class="visible-xs-block @if($page=="activities") active @endif"><a href="/admin/activities"><i class="fa fa-stethoscope fa-fw"></i>&nbsp; Activities</a></li>
              @endcan
              @can('view', 'App\Type')
                <li class="visible-xs-block @if($page=="types") active @endif"><a href="/admin/types"><i class="fa fa-table fa-fw"></i>&nbsp; Types</a></li>
              @endcan
              @can('viewAny', 'App\User')
                <li class="visible-xs-block @if($page=="users") active @endif"><a href="/admin/users"><i class="fa fa-users fa-fw"></i>&nbsp; Users</a></li>
              @endcan
              @can('manage', 'App\Campus')
                <li class="visible-xs-block @if($page=="campuses") active @endif"><a href="/admin/campuses"><i class="fa fa-university fa-fw"></i>&nbsp;Institutions</a></li>
              @endcan
              @can('manage','App\SiteConfiguration')
                <li class="visible-xs-block @if($page=="site_configurations") active @endif"><a href="/admin/site_configurations"><i class="fa fa-cogs fa-fw"></i>&nbsp; Site Configuration</a></li>
              @endcan
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right visible-xs-block">
              <!-- Insert Links Here -->
          </ul>
        </div>
      </div>
    </nav>
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
          @can('viewAny','App\Activity')
            <li class="@if($page=="activities") active @endif"><a href="/admin/activities"><i class="fa fa-stethoscope fa-fw"></i>&nbsp; Activities</a></li>
          @endcan
          @can('view', 'App\Type')
            <li class="@if($page=="types") active @endif"><a href="/admin/types"><i class="fa fa-table fa-fw"></i>&nbsp;Types</a></li>
          @endcan
          @can('viewAny', 'App\User')
            <li class="@if($page=="users") active @endif"><a href="/admin/users"><i class="fa fa-users fa-fw"></i>&nbsp; Users</a></li>
          @endcan
          @can('manage', 'App\Campus')
            <li class="@if($page=="campuses") active @endif"><a href="/admin/campuses"><i class="fa fa-university fa-fw"></i>&nbsp;Institutions</a></li>
            @endcan
        @can('manage','App\SiteConfiguration')
            <li class="@if($page=="site_configurations") active @endif"><a href="/admin/site_configurations"><i class="fa fa-cogs fa-fw"></i>&nbsp; Site Configuration</a></li>
        @endcan
        <li>
          <button type="button"
                  class="btn btn-link"
                  style="padding:8px 20px;width:100%;text-align:left;color:inherit;"
                  onclick="localStorage.clear();location.reload(true);"
                  aria-label="Clear local cache and reload page">
            <i class="fa fa-code fa-fw" aria-hidden="true"></i>&nbsp; Clear Cache
          </button>
        </li>
      </ul>
    </div>
    <div class="container-fluid" id="main-container">
      <div class="row">
        <div class="col-sm-12 admin-main">
            <div id="content">
              <!--
                <nav aria-label="breadcrumb">
                    <?php $crumbs = explode('_',$page); ?>
                    <ol class="breadcrumb">
                        @if (isset($ids))
                            @foreach($crumbs as $index => $crumb)
                                <li class="breadcrumb-item"><a href="/<?php
                                    for($i=0;$i<=$index;$i++) {
                                        echo (isset($ids[$i-1])?('/'.$ids[$i-1]):'').'/'.$crumbs[$i];
                                    }
                                ?>">{{Str::snakeToTitle(Str::snake($crumb))}}</a></li>
                            @endforeach
                        @endif
                    </ol>
                </nav>
              -->
                @if(isset($help))
                    <div class="alert alert-info">{{$help}}</div>
                @endif
                <div id="adminDataGrid"></div>
                <style>
                div#adminDataGrid > div.well > div {
                    /* Make All Datagrid Stuff Scrollable Hack */
                    /* overflow: scroll !important; */
                }
                div#adminDataGrid > div.well > div.table-container > div > table {
                    width: 99.5%;
                }
                div#adminDataGrid > div.tab-content > div#data-types.tab-pane > div#study_data_types > div.well > div.table-container > div > table {
                    width: 99.5%;
                }
                div#adminDataGrid > div.tab-content > div#participants.tab-pane > div#study_participants > div.well > div.table-container > div > table {
                    width: 99.5%;
                }
                div#adminDataGrid > div.tab-content > div#users.tab-pane > div#study_users > div.well > div.table-container > div > table {
                    width: 99.5%;
                }
                </style>
            </div>
        </div>
      </div>
    </div>

<!-- Begin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Modal -->

    <script src='/assets/js/vendor/jquery.min.js'></script>
    <script src="/assets/js/vendor/bootstrap.min.js"></script>
    <script src="/assets/js/vendor/lodash.min.js"></script>
    <script>_.findWhere = _.find; _.where = _.filter;_.pluck = _.map;_.contains = _.includes;</script>
    <script src='/assets/js/vendor/hogan.min.js'></script>
    <script src='/assets/js/vendor/toastr.min.js'></script>
    <script src='/assets/js/vendor/gform_bootstrap.js'></script>
    <script src='/assets/js/vendor/GrapheneDataGrid.min.js'></script>
    <script src='/assets/js/vendor/moment.js'></script>
    <script src='/assets/js/vendor/bootstrap-datetimepicker.min.js'></script>
    <script src='/assets/js/vendor/sortable.js'></script>
    <script src='/assets/js/vendor/ractive.min.js'></script>
    <script src="/assets/js/_framework.js"></script>
    <script src="/assets/js/admin/admin.js"></script>
    <script>
        @if(isset($id)) window.id={!!json_encode($id)!!}; @endif
        @if(isset($type_id)) window.type_id={!!json_encode($type_id)!!}; @endif
        @if(isset($actions)) window.actions={!!json_encode($actions)!!}; @endif
        @if(isset($form_fields)) window.form_fields={!!json_encode($form_fields)!!}; @endif
        @if(isset($permissions))
            window.auth_user_perms = {!! json_encode($permissions) !!};
        @endif
    </script>
    <script src="/assets/js/admin/admin_{{$page}}.js"></script>
  </body>
</html>
