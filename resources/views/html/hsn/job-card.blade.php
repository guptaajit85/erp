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
			  

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12" style="font-size:22px;margin-bottom:15px;"><b>AJY TECH INDIA PVT LTD.</b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<b style="background-color:lavenderblush;">JOB CARD</b>
		</div>
		<!--<div class="col-sm-6" style="background-color:lavenderblush;font-size:22px;margin-bottom:10px;">-->
		</div>
	</div>
</div>
			  
			  
			  
			  
			   <table style="border-collapse:separate; margin-bottom:4px;" class="table table-bordered table-striped table-hover">
                 <tbody>
				<tr>
                    <th>DATE:</th>
                    <th>LOT No. </th>
                  </tr>
				  <tr>
                    <th>Design No.</th>
                    <th>TAKA: </th>
                  </tr>
				  <tr>
                    <th>Ch. No.</th>
                    <th>Grey Mtr. </th>
                  </tr>
				  <tr>
                    <th>Quality :</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp; </td>
                  </tr>
				   </tbody>
			  </table>
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="info">
                      <th>TAKA.NO </th>
                      <th> GREY MTR. </th>
                      <th>FINISH MTR. </th>
                      <th>COLOUR</th>
                      <th>REMARK</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php for($i = 1; $i<=20; $i++){?>
                  <tr>
                    <td><?php echo $i;?> </td>
                    <td>&nbsp;&nbsp; </td>
                    <td>&nbsp; </td>
                    <td>&nbsp;&nbsp;&nbsp; </td>
                    <td>&nbsp;&nbsp;&nbsp; </td>
                   
                  </tr>
                 <?php }?>
                 
                  </tbody>
					
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