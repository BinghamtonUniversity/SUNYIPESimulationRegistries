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
    <title>OpenSim | {{$title}}</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link href="/assets/css/IPESimulationRegistries.css" rel="stylesheet">
    <link href="/assets/css/toastr.min.css" rel="stylesheet">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Mono' rel='stylesheet'>
    <link data-name="vs/editor/editor.main" rel="stylesheet" href="/assets/js/vendor/vs/editor/editor.main.css">
  </head>
  <body>
  <style>
    .navbar-inverse a:hover, .navbar-inverse a:active {
      color:#ddd !important;
    }
  </style>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin" style="background: #004c93;width:200px;">
            <h4 style="color:#fff;margin:0px;"><i class="fa fa-medkit fa-fw"></i> OpenSim Admin</h4>
          </a>
            <ul class="nav navbar-nav  hidden-xs">
                <li><a href="#"><h4 style="margin:0">{{$title}}</h4></a></li>
            </ul>
          <ul class="nav navbar-nav navbar-right hidden-xs">
          </li>
            <li><a href="#"><h4 style="margin:0"></h4></a></li>
          </ul>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle identity-info" data-toggle="dropdown" role="button">
{{--                <img class="gravatar" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?d=mm" />--}}
                  {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/"><i class="fa fa-arrow-left"></i> Home</a></li>
                <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
              </ul>
              <li class="visible-xs-block @if($page=="users") active @endif"><a href="/admin/users"><i class="fa fa-users fa-fw"></i>&nbsp; Users</a></li>
              <li class="visible-xs-block @if($page=="activities") active @endif"><a href="/admin/activities"><i class="fa fa-stethoscope fa-fw"></i>&nbsp; Activities</a></li>
              <li class="visible-xs-block @if($page=="types") active @endif"><a href="/admin/types"><i class="fa fa-table fa-fw"></i>&nbsp; Types</a></li>
              <li class="visible-xs-block @if($page=="campuses") active @endif"><a href="/admin/campuses"><i class="fa fa-university fa-fw"></i>&nbsp;Institutions</a></li>
              <li class="visible-xs-block @if($page=="site_configurations") active @endif"><a href="/admin/site_configurations"><i class="fa fa-cogs fa-fw"></i>&nbsp; Site Configuration</a></li>
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
        <li class="@if($page=="users") active @endif"><a href="/admin/users"><i class="fa fa-users fa-fw"></i>&nbsp; Users</a></li>
        <li class="@if($page=="activities") active @endif"><a href="/admin/activities"><i class="fa fa-stethoscope fa-fw"></i>&nbsp; Activities</a></li>
        <li class="@if($page=="types") active @endif"><a href="/admin/types"><i class="fa fa-table fa-fw"></i>&nbsp;Types</a></li>
        <li class="@if($page=="campuses") active @endif"><a href="/admin/campuses"><i class="fa fa-university fa-fw"></i>&nbsp;Institutions</a></li>
        <li class="@if($page=="site_configurations") active @endif"><a href="/admin/site_configurations"><i class="fa fa-cogs fa-fw"></i>&nbsp; Site Configuration</a></li>
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
    <script src="/assets/js/admin/_framework.js"></script>
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
