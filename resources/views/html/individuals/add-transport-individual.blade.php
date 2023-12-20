<?php
	use \App\Http\Controllers\CommonController;
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
<div class="wrapper"> @include('common.header')
 <div class="content-wrapperd">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="header-icon"> <i class="fa fa-users"></i> </div>
      <div class="header-title">
        <h1>Add Transport Individual</h1>
        <small>Transport Individual list</small> </div>
    </section>
    <!-- Main content -->
    {!! CommonController::display_message('message') !!}
    <section class="content">
      <div class="row">
        <!-- Form controls -->
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="{{ route('show-transport-individuals') }}"> <i class="fa fa-list"></i> Transport Individual List </a> </div>
            </div>
            <div class="panel-body">
              <form  role="form" name="indvEdit" id="indvEdit" method="post" onSubmit="return validateForm()" action="{{ url('store_transport_individual') }}">
                @csrf

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>GSTIN</label>
                        <input type="text" class="form-control" name="gstin" id="gstin" placeholder="Enter GST Number">
                        <input type="hidden" class="form-control" name="type" id="type" value="transport" >
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Name <span class="required">*</span> </label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                      </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Company Name <span class="required">*</span> </label>
                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter Company Name" required>
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Nick Name </label>
                        <input type="text" class="form-control" name="nick_name" id="nick_name" placeholder="Enter Nick Name">
                      </div>
                </div>

                <div class="col-sm-6">
                <div class="form-group">
                    <label>Email <span class="required">*</span> </label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                  </div>
                </div>
                <div class="col-sm-6">
                <div class="form-group">
                    <label>Mobile <span class="required">*</span> </label>
                    <input type="number" class="form-control" oninput="limitInputLength(this, 10)" name="phone" maxlength="10" id="phone" placeholder="Enter Mobile" required>
                  </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>PAN</label>
                        <input type="text" class="form-control" oninput="limitInputLength2(this, 10)" name="pan" id="pan" placeholder="Enter Pan">
                      </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>TAN Number</label>
                        <input type="text" class="form-control" name="tanno" oninput="limitInputLength3(this, 10)" id="tanno" placeholder="Enter Tan Number">
                      </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Adhaar <span class="required">*</span> </label>
                        <input type="number" class="form-control" oninput="limitInputLength4(this, 12)" required name="adhar" id="adhar" placeholder="Enter Adhaar Number">
                      </div>
                </div>
                <div class="col-sm-6">
                <div class="form-group">
                    <label>WhatsApp <span class="required">*</span> </label>
                    <input type="number" class="form-control" oninput="limitInputLength5(this, 10)" required maxlength="10" name="whatsapp" id="whatsapp" placeholder="Enter WhatsApp Number">
                  </div>
                </div>

                <div class="col-sm-6">
                <div class="form-group">
                    <label>Verified Remark</label>
                    <input type="text" class="form-control" name="verified_remark" id="verified_remark" placeholder="Enter Verified Remark By">
                  </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Is Verified </label>
                        <select class="form-control" name="is_verified" id="is_verified">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>
                </div>


                <div class="reset-button">
                  <button type="submit" id="submit" name="submit"  class="btn btn-success"> Save </button>
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
  @include('common.footer') </div>
@include('common.footerscript')
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script language="javascript" type="text/javascript">
$().ready(function() {
	$("#indvEdit").validate({
		rules: {
			name:
			{
				required: true
			},

			email:
			{
				required: true
			},
			phone:
			{
				required: true,
				min:10
			},

			adhar:
			{
				required: true,
				min:12
			},
			whatsapp:
			{
				required: true
			}
				},
		messages: {
			name:
			{
				required: "Please enter your name."
			},

			email:
			{
				required: "Please enter your email Id."
			},
			phone:
			{
				required: "Please enter your mobile number.",
				min:"Please enter your valid mobile number."
			},

			adhar:
			{
				required: "Please enter your Adhaar number.",
				min:"Please enter your valid Adhaar number."
			},
			whatsapp:
			{
				required: "Please enter your whatsapp number."
			}
		}
	});
});
</script>
<script>
function limitInputLength(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}

function limitInputLength2(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}

function limitInputLength3(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}
function limitInputLength4(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}

function limitInputLength5(inputElement, maxLength) {
  if (inputElement.value.length > maxLength) {
    inputElement.value = inputElement.value.slice(0, maxLength);
    inputElement.blur();
  }
}
</script>
</body>
</html>
