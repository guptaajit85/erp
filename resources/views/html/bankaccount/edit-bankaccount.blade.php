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
                    <h1>Update Bank Account</h1>
                    <small>Bank Account list</small>
                </div>
            </section>
            <!-- Main content -->

            <section class="content">
                <div class="row">
                    <!-- Form controls -->
                    <div class="col-sm-12">
					{!! CommonController::display_message('message') !!}
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonlist">
                                    <a class="btn btn-add " href="{{ route('show-bankaccounts') }}">
                                        <i class="fa fa-list"></i> Bank Account List </a>
                                </div>
                            </div>
                            <div class="panel-body">

                                <form class="col-sm-6" role="form" name="domainEdit" id="domainEdit" method="post"
                                    action="{{ url('/update_bankaccount') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label> Account Number <span style="color:#ff0000;">*</span></label>
                                        <input type="text" class="form-control" name="account_number"
                                            value="{{ htmlentities($data->account_number) }}" id="account_number"
                                            placeholder="Enter account number" required>
                                        <input type="hidden" class="form-control" name="id" id="id"
                                            value="{{ htmlentities($data->id) }}">
                                    </div>
                                    <div class="form-group">
                                        <label> Account Name <span style="color:#ff0000;">*</span> </label>
                                        <input type="text" class="form-control" name="account_name"
                                            value="{{ htmlentities($data->account_name) }}" id="account_name"
                                            placeholder="Enter Account Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label> Ifsc Code <span style="color:#ff0000;">*</span> </label>
                                        <input type="text" class="form-control" name="ifsc_code"
                                            value="{{ htmlentities($data->ifsc_code) }}" id="ifsc_code"
                                            placeholder="Enter Ifsc Code" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Bank Name <span style="color:#ff0000;">*</span></label>
                                        <select class="form-control" name="bank_id" id="bank_id">
                                            <option value="none" selected disabled hidden>Select an Option</option>
                                            @foreach ($dataI as $data1)
                                                <option value="{{ $data1->id }}"@if($data1->id==$data->bank_id) selected="selected" @endif>{{ $data1->bank_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label> Bank Branch <span style="color:#ff0000;">*</span> </label>
                                        <input type="text" class="form-control" name="bank_branch"
                                            value="{{ htmlentities($data->bank_branch) }}" id="bank_branch"
                                            placeholder="Enter Bank Branch" required>
                                    </div>
                                    <div class="form-group">
                                        <label> Bank Address <span style="color:#ff0000;">*</span> </label>
                                        <input type="text" class="form-control" name="bank_address"
                                            value="{{ htmlentities($data->bank_address) }}" id="bank_address"
                                            placeholder="Enter Bank Address" required>
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
                    account_name: {
                        required: true,
                        letterswithbasicpunc: true,
                        minlength: 3,
                        maxlength: 100

                    },
                    account_number: {
                        required: true,
                        digits: true,
                        minlength: 8,
                        maxlength: 16

                    },
                    ifsc_code: {
                        required: true,
                        alphanumeric: true,
                        minlength: 10,
                        maxlength: 10
                    }
                },
                messages: {
                    account_name: {
                        required: "<span style='color: red;'>Please enter a Name</span>",
                        letterswithbasicpunc: "<span style='color: red;'>Only alphabet characters are allowed</span>",
                        minlength: "<span style='color: red;'>Please enter a Name of Minimum Three letters</span>",
                        maxlength: "<span style='color: red;'>Please enter a Name of Minimum Hundred letters</span>"

                    },
                    account_number: {
                        required: "<span style='color: red;'>Please enter an Account Number</span>",
                        digits: "<span style='color: red;'>Only Numbers are allowed</span>",
                        minlength: "<span style='color: red;'>Minimum  Eight Numbers are allowed</span>",
                        maxlength: "<span style='color: red;'>Maximum  Sixteen Numbers are allowed</span>"
                    },

                    ifsc_code: {
                    required: "<span style='color: red;'>Please enter an IFSC code</span>",
                    alphanumeric: "<span style='color: red;'>Only alphanumeric characters are allowed</span>",
                    minlength: "<span style='color: red;'>IFSC code should have exactly 10 characters</span>",
                    maxlength: "<span style='color: red;'>IFSC code should have exactly 10 characters</span>"
                    }
            }
            });


            jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
                return this.optional(element) || /^[A-Za-z\s]*$/i.test(value);
            }, "<span style='color: red;'>Only alphabet characters are allowed</span>");

            jQuery.validator.addMethod("alphanumeric", function(value, element) {
                console.log("Validating alphanumeric:", value); // Check if this message appears in the console
                return this.optional(element) || /^[A-Za-z0-9]*$/i.test(value);
            }, "<span style='color: red;'>Only alphanumeric characters are allowed</span>");
       });
    </script>
</body>

</html>
