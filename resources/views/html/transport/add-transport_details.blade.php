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
<div class="wrapper">
 @include('common.header')
   <div class="content-wrapperd">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-users"></i>
               </div>
               <div class="header-title">
                  <h1>Add Transport Details</h1>
                  <small>Transport Details</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- Form controls -->
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonlist">
                              <a class="btn btn-add " href="{{ route('show-transport_details') }}">
                              <i class="fa fa-list"></i>  Transport Details </a>
                           </div>
                        </div>
                        <div class="panel-body">


			<form class="col-sm-6" role="form" name="indvEdit" id="indvEdit" method="post" onSubmit="return validateForm()" action="{{ url('store_transport_details') }}">
				@csrf

							<div class="form-group">
							 <label>Individual type</label>
							 <select class="form-control" name="type" id="type"  >
								<option value="customers">Customers</option>
								<option value="master">Master</option>
								<option value="agents">Agents</option>
								<option value="labourer">Labourer</option>
								<option value="vendors">Vendors</option>
								<option value="transport">Transport</option>
							 </select>
                              </div>

							   <div class="form-group">
                                 <label>GSTIN</label>
                                 <input type="text" class="form-control" name="gstin" id="gstin" placeholder="Enter GST Number">
                              </div>

                             <div class="form-group">
                                 <label> Name </label>
                                 <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                              </div>

                              <div class="form-group">
                                 <label> Company Name </label>
                                 <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter Company Name" required>
                              </div>

                              <div class="form-group">
                                 <label> Nick Name </label>
                                 <input type="text" class="form-control" name="nick_name" id="nick_name" placeholder="Enter Nick Name" required>
                              </div>

                              <div class="form-group">
                                 <label>Email</label>
                                 <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                              </div>
                              <div class="form-group">
                                 <label>Mobile</label>
                                 <input type="number" class="form-control" name="phone" maxlength="10" id="phone" placeholder="Enter Mobile" required>
                              </div>

                              <div class="form-group">
                                 <label>PAN</label>
                                 <input type="text" class="form-control" name="pan" id="pan" placeholder="Enter Pan" required>
                              </div>
                              <div class="form-group">
                                 <label>TAN Number</label>
                                 <input type="text" class="form-control" name="tanno" id="tanno" placeholder="Enter Tan Number" required>
                              </div>
                              <div class="form-group">
                                 <label>Adhaar</label>
                                 <input type="number" class="form-control" maxlength="12" name="adhar" id="adhar" placeholder="Enter Adhaar Number" required>
                              </div>
                              <div class="form-group">
                                 <label>WhatsApp</label>
                                 <input type="number" class="form-control" maxlength="10" name="whatsapp" id="whatsapp" placeholder="Enter WhatsApp Number" required>
                              </div>
                              <div class="form-group">
                                 <label>Verified Remark</label>
                                 <input type="text" class="form-control" name="verified_remark" id="verified_remark" placeholder="Enter Verified Remark By" required>
                              </div>

                              <div class="form-group">
                                 <label>Is Verified </label>
                                 <select class="form-control" name="is_verified" id="is_verified">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>

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
  @include('common.footer')
  </div>
@include('common.footerscript')

<script type="text/javascript">
function validateForm()
{
  var type = $("#type").val();
  if (type === "customers" || type === "vendors") {
    if($('#gstin').val()=='')
    {
        alert("GSTIN must be filled out");
        return false;
    }
  }

  $('button[type=submit]').prop('disabled', true);
    return true;
}

</script>


<script type="text/javascript">

</script>


</body>
</html>
