<?php
use App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
<style>
    .page1 {
        -moz-column-count: 4;
        -moz-column-gap: 20px; /* Adjust this value as needed */
        -webkit-column-count: 4;
        -webkit-column-gap: 20px; /* Adjust this value as needed */
        column-count: 4;
        column-gap: 20px; /* Adjust this value as needed */
        max-width: 100%; /* Ensure content stays within the available width */
    }

    .page1 ol {
        display: block; /* Ensure each list item takes up the full column width */
        margin-bottom: 10px;
    }
</style>
</head><body class="hold-transition sidebar-mini">
<!--preloader-->
<div id="preloader">
  <div id="status"></div>
</div>
<!-- Site wrapper -->
<div class="wrapper"> @include('common.header')
   <div class="content-wrapperd">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="header-icon"> <i class="fa fa-users"></i> </div>
      <div class="header-title">
        <h1>Add User Module Assignment</h1>
        <small>User Module Assignment List</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-usermoduleassignments') }}"> <i class="fa fa-list"></i> User Module Assignment List </a> </div>
            </div>
            <div class="panel-body">
              <form  role="form" name="domainEdit" id="domainEdit" method="post"
                                    action="{{ url('store_usermoduleassignment') }}">
                @csrf
                <div class="form-group col-sm-6" >
                  <label>User name   <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="user_id" id="user_id">
                    <option value="none" selected disabled hidden>Select an Option</option>

                                            @foreach ($dataI as $data)

                    <option value="{{ $data->id }}">{{ $data->name }}</option>

                                            @endforeach


                  </select>
                </div>
                <div class="form-group col-sm-12">
                  <label>Page</label>
                  <ul class="page1">
                    @foreach ($dataM as $data1)
                    <ol>
                      <label>
                      <input type="checkbox" name="page_name[]" id="page_name" value="{{ $data1->page_name }}" >
                      &nbsp;&nbsp;{{ $data1->heading }}</label>
                    </ol>
                    @endforeach
                  </ul>
                </div>
                <div class="reset-button col-sm-12">
                  <input type="submit" name="submit" value="Save" class="btn btn-success">
                  <a href="#" class="btn btn-warning">Reset</a> </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('common.footer') </div>
@include('common.footerscript')
</body>
</html>
