<?php
use App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
<style>
        .page1 {
            -moz-column-count: 4;
            -moz-column-gap: 20px;
            -webkit-column-count: 4;
            -webkit-column-gap: 20px; /
            column-count: 4;
            column-gap: 20px;
            max-width: 100%;
        }

        .page1 li {
            display: block;
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
        <h1>Update User Module Assignment</h1>
        <small>User Module Assignment list</small> </div>
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
              <form role="form" name="domainEdit" id="domainEdit" method="post" action="{{ url('/update_usermoduleassignment') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-sm-6">
                  <label>User Name   <span style="color:#ff0000;">*</span></label>
                  <select name="user_id" id="user_id">
                    <option value="none" selected disabled hidden>Select an Option</option>

            @foreach ($dataU as $data1)

                    <option value="{{ $data1->id }}" @if($data1->id == $user_id) selected="selected" @endif>{{ $data1->name }}</option>


            @endforeach

                  </select>
                  <input type="hidden" name="id" id="id"
               value="{{ htmlentities($user_id) }}">
                </div>
                <div class="form-group col-sm-12">
                  <label>Pages</label>
                  <ul class="page1">
                    @foreach ($dataM as $row)
                    <li>
                      <label>
                      <input type="checkbox" name="page_name[]" value="{{ $row->page_name }}" <?php echo in_array($row->page_name,$userModArr) ? 'checked' : ''; ?> >
                      &nbsp;  {{ $row->heading }}
                      <?php // echo ""; print_r($data); exit;	?>
                      </label>
                    </li>
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
