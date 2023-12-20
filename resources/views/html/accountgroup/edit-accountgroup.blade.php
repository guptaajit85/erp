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
		{!! CommonController::display_message('message') !!}
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="header-title">
                    <h1>Update Account Group</h1>
                    <small>Account Group list</small>
                </div>
            </section>
            <!-- Main content -->
            {!! CommonController::display_message('message') !!}

            <section class="content">
                <div class="row">
                    <!-- Form controls -->
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonlist">
                                    <a class="btn btn-add " href="{{ route('show-accountgroups') }}">
                                        <i class="fa fa-list"></i> Account Group List </a>
                                </div>
                            </div>
                            <div class="panel-body">

                                <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post"
                                    action="{{ url('/update_accountgroup') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label> Name   <span style="color:#ff0000;">*</span></label>
                                        <input type="text" class="form-control" name="accountgroup_name"
                                            value="{{ htmlentities($data->accountgroup_name) }}" id="accountgroup_name"
                                            placeholder="Enter Account Group Name" required>
                                        <input type="hidden" class="form-control" name="id" id="id"
                                            value="{{ htmlentities($data->id) }}">
                                    </div>
                                    <div class="form-group">
                                        <label> ParentId   <span style="color:#ff0000;">*</span></label>
                                        <input type="text" class="form-control" name="parent_id"
                                            value="{{ htmlentities($data->parent_id) }}" id="parent_id"
                                            placeholder="Enter ParentId" required>
                                    </div>
                                    <div class="reset-button">

                                        <input type="submit" name="submit" value="Save" class="btn btn-success">
                                        <a href="#" class="btn btn-warning">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('common.footer')
    </div>
    @include('common.footerscript')


    <script type="text/javascript" src="{{ asset('js/jquery.validate.js')}}"></script>

    <script language="javascript" type="text/javascript">
        $().ready(function() {
            $("#domainEdit").validate({
                rules: {
                    accountgroup_name: {
                        required: true,
                        letterswithbasicpunc: true,
                        minlength: 3,
                        maxlength: 100

                    },
                    parent_id: {
                        required: true,
                        digits: true,
                        minlength: 1,
                        maxlength: 4

                    }
                },
                messages: {
                    accountgroup_name: {
                        required: "<span style='color: red;'>Please enter a name</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only alphabet characters are allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
                    parent_id: {
                        required: "<span style='color: red;'>Please enter an Id</span>",
                        digits: "<span style='color: red;'>Only Numbers are allowed</span>",
                        minlength: "<span style='color: red;'>Minimum  One Numbers are allowed</span>",
                        maxlength: "<span style='color: red;'>Maximum  Four Numbers are allowed</span>"

                    }
                }
            });


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed</span>");
       });
    </script>
</body>

</html>
