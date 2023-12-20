<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper"> <?php /*?>@include('common.header')<?php */?>
 <div class="content-wrapperd">
   
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-bd lobidrag">
           
            <div class="panel-body">
              <div class="table-responsive">
			  
			  
			   <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                <!--  <thead>
                    <tr class="info">
                      <th colspan="2">B.NO= </th>
                      <th colspan="2"> LOOM NO= </th>
                      <th colspan="2">B/G DATE </th>
                      <th colspan="2">B/GATER </th>
                    </tr>
                  </thead>-->
			  
			  
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
				  <tr class="info">
                      <th colspan="2">B.NO= </th>
                      <th colspan="2"> LOOM NO= </th>
                      <th colspan="2">B/G DATE </th>
                      <th colspan="2">B/GATER </th>
                    </tr>
				   <tr>
                    <td style="text-align: center; vertical-align: middle;" width="4%"><b>S.NO</b></td>
                    <td style="text-align: center; vertical-align: middle;" width="10%"><b>DATE</b> </td>
                    <td style="text-align: center; vertical-align: middle;" width="7%"><b>DROFF</b></td>
                    <td style="text-align: center; vertical-align: middle;" width="8%"><b>MTR</b></td>
                    <td style="text-align: center; vertical-align: middle;"><b>PCS NO</b> </td>
                    <td style="text-align: center; vertical-align: middle;" width="7%"><b>SHIFT</b> </td>
                    <td style="text-align: center; vertical-align: middle;" width="9%"><b>SIGN</b></td>
                    <td style="text-align: center; vertical-align: middle;"><b>REMARK</b> </td>
                   
                  </tr>
                   
                  </thead>
                  <tbody>
                  <?php for($i = 1; $i<=24; $i++){?>
                  <tr>
                    <td><?php echo $i;?> </td>
                    <td>&nbsp;&nbsp; </td>
                    <td>&nbsp; </td>
                    <td>&nbsp;&nbsp;&nbsp; </td>
                    <td>&nbsp; </td>
                    <td>&nbsp; </td>
                    <td>&nbsp; </td>
                    <td>&nbsp;&nbsp;&nbsp; </td>
                   
                  </tr>
                 <?php }?>
                 
                  </tbody>
					</table>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  
  </div>
 
   </div>
@include('common.formfooterscript')

</body>
<style>
.table-striped>tbody>tr:nth-of-type(odd){background-color:#ffffff;}
</style>
</html>