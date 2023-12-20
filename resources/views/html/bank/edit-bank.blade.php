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
            <section class="content-header">
                <div class="header-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="header-title">
                    <h1>Update Bank</h1>
                    <small>Bank list</small>
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
                                    <a class="btn btn-add " href="{{ route('show-banks') }}">
                                        <i class="fa fa-list"></i> Bank List </a>
                                </div>
                            </div>
                            <div class="panel-body">

                                <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post"
                                    action="{{ url('/update_bank') }}" enctype="multipart/form-data">

                                    @csrf

                                    <div class="form-group">
                                        <label> Bank Name <span style="color:red;"">*</span></label>
                                        <input type="text" class="form-control" name="bank_name" id="bank_name"
                                            value="{{ htmlentities($data->bank_name) }}" placeholder="Enter Bank Name"
                                            required>
                                        <input type="hidden" class="form-control" name="id" id="id"
                                            value="{{ htmlentities($data->id) }}">
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
            $("#productEdit").validate({
                rules: {
                    bank_name: {
                        required: true,
                        letterswithbasicpunc: true,
                        minlength: 3,
                        maxlength: 100

                    }
                },
                messages: {
                    bank_name: {
                        required: "<span style='color: red;'>Please enter a Name</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only Alphabet  are Allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    }
                }
            });


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet  are allowed</span>");
       });
    </script>
</body>

</html>
