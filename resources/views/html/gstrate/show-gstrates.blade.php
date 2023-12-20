<?php
use App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
</head>
<body class="hold-transition sidebar-mini">
<!--preloader-->
<div id="preloader">
  <div id="status"></div>
</div>
<!-- Site wrapper -->
<div class="wrapper">
@include('common.header')
  <div class="content-wrapperd">
<!-- Content Header (Page header) -->
<!-- Main content -->

<section class="content">
<div class="row">
  <div class="col-sm-12">
  {!! CommonController::display_message('message') !!}
    <div class="panel panel-bd lobidrag">
      <div class="panel-heading">
        <div class="btn-group" id="buttonexport">
          <h4> Gst Rate</h4>
          </a> </div>
      </div>
      <div class="panel-body">
        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
       <!-- <div class="row" style="margin-bottom:5px">
          <form action="{{ route('show-unittypes') }}" method="GET" role="search">
            @csrf
            <div class="col-sm-4 col-xs-12">
              <input type="text" class="form-control" name="search" placeholder="Search..."
                                        value="{{ request()->query('search') }}" />
            </div>
            <div class="col-sm-2 col-xs-12">
              <button class="btn btn-add">Search</button>
            </div>
          </form>
          <div class="col-sm-2 col-xs-12">
            <button class="btn btn-exp btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
            <ul class="dropdown-menu exp-drop" role="menu">
              <li class="divider"></li>
              <li> <a href="javascript:void(0);" onClick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});"> <img src="assets/dist/img/xls.png" width="24" alt="logo"> XLS</a> </li>
            </ul>
          </div>
          <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-unittype"> <i class="fa fa-plus"></i> Add
            Unit Type </a> </div>
        </div>-->

        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
        <div class="table-responsive">
          <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
            <thead>
              <tr class="info">
                <th> GST Rate </th>
                <th>Status </th>
              </tr>
            </thead>
            <tbody>

            @foreach ($dataP as $data)
            <tr id="Mid{{ $data->gst_rate_id }}">
              <td> {{ $data->gst_rate }} % </td>


              <td class="center">
                @if($data->status == 1)
                <a href="ajax_script/deactivateGstRate/{{ $data->gst_rate_id }}" title="Click to Inactivate"  class="btn btn-success btn-xs"> Active  @endif</a>
                 @if($data->status == 0)
                <a href="ajax_script/activateGstRate/{{ $data->gst_rate_id }}" title="Click to Activate"  class="btn btn-danger btn-xs"> Inactive  @endif</a>
                </td>
            </tr>
            @endforeach
            <tr class="center text-center">
              <td class="center" colspan="5"><div class="pagination">{{ $dataP->links() }}</div></td>
            </tr>
            </tbody>

          </table>
        </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.content-wrapper -->
  @include('common.footer') </div>
@include('common.formfooterscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript">
var siteUrl = "{{url('/')}}";
        function deactivateGstRate(gst_rate_id) {
            if (confirm("Do you realy want to deactivate this GST Rate?")) {
                jQuery.ajax({
                    type: "GET",
                    url: siteUrl + '/' +"ajax_script/deactivateGstRate",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "FId": gst_rate_id,
                    },

                    cache: false,
                    success: function(msg) {
                       // $("#Mid" + gst_rate_id).hide();
                    }
                });

            }

        }

        function activateGstRate(gst_rate_id) {

            if (confirm("Do you realy want to activate this GST Rate?")) {
                jQuery.ajax({
                    type: "GET",
                    url: siteUrl + '/' +"ajax_script/activateGstRate",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "FId": gst_rate_id,
                    },

                    cache: false,
                    success: function(msg) {
alert(msg);
                       // $("#Mid" + gst_rate_id).hide();
                    }
                });

            }

        }

    </script>
</body>
</html>
