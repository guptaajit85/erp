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

    <section class="content">
      <div class="row">
        <div class="col-sm-12">
		{!! CommonController::display_message('message') !!}
          <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
              <div class="btn-group" id="buttonexport">
                <h4> Manage Yarn for <span style="text-decoration:underline;"> {{ $data->item_name }}</span></h4>
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <form method="post" action="{{ route('add_manage_yarn')}}" class="form-horizontal" autocomplete="off">
                    @csrf
                <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                   <thead>
					<tr class="info">
						<th>Process</th>
						<th>Yarn</th>
						<th>Reed/Peak</th>
						<th>Quantity</th>
						<th>Action</th>
					</tr> 
                    @foreach($dataIYR as $row)
                        <tr id="Mid{{ $row->iyr_id }}">
                            <td>@if($row->process_id == 1) EPI  @else PPI @endif</td>
                            <td>{{ $row->getyarn->item_name }}</td>
                            <td>@if($row->process_id == 1) Peak  @else Reed @endif : {{ $row->reed_peak }}</td>
                            <td>{{ $row->yarn_quantity }} {{ $row->unit }}</td>
                            <td><button type="button" class="btn btn-danger btn-xs" onclick="deleteYarn({{ $row->iyr_id }})">Delete</button></td>
                        </tr>
                    @endforeach
                  </thead>
                  <tbody>
                    <div class="row">
                    <div class="col-md-12">

                        <fieldset>
                        <table class="table table-bordered" id="myTable">
                        <tbody>

                            <tr>
                           <h4>  Add Yarn</h4>
                            </tr>
                            <tr>
                            <input type="hidden" id="item_id" name="item_id" value="<?=$data->item_id;?>">
                            <th><span id="ReqProduct">Process</span> </th>
                            <th><span id="ReqProduct">Yarn</span> </th>
                            <th><span id="ReqProduct">Reed/Peak</span> </th>

                            <th>Quantity</th>
                            <th> Unit</th>
                            <th> Action</th>
                            </tr>

                            <?php  // echo '<pre>'; print_r($reedPkAr); ?>

                            <tr>
                                <td class=""><select onchange="change_process(1)" class="form-control processid_1" name="process_id[]" required>


                                    <option value=""> Select Process</option>
                                        <?php foreach($reedPkAr as $key => $valArr) { // echo '<pre>'; print_r($valArr);    ?>
                                    <option value="<?=$key+1;?>"><?=$valArr;?> </option>

                                    <?php } ?>
                                    </select>
                                </td>

                            <td><select  class="form-control" name="yarn_id[]" required>
                                <option value=""> Select Item</option>
                                <?php foreach($dataI as $rowArr) { ?>
                                <option value="<?=$rowArr->item_id;?>"><?=$rowArr->item_name;?></option>
                                <?php } ?>
                                </select>
                            </td>
                            <td><span id="readpk-1"></span>
                                <input type="number"  min="1" class="small-input" id="read_peak_1" name="reed_peak[]" required>
                                </td>

                            <td>
                            <input type="number" min="1" class="form-control" id="yarn_quantity[]" name="yarn_quantity[]" required>
                            </td>
                            <td>Kg</td>
                            <td><button type="button" class="btn btn-success btn-xs" onClick="addRow()">Add Row</button></td>
                            </tr>
                        </tbody>
                        </table>
                        <div class="svbtn"><input class="btn btn-success" type="submit" name="Save" value="Save"></div>
                        </fieldset>
                    </div>
                    </div>

                    </tbody>

                </table>

                </form>
              </div>
            </div>
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
<style>
.svbtn {
	padding:0 50px 16px 0;
	float:right;
}
</style>
<script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript">

	function addRow()
	{


        var table = document.getElementById("myTable");
		var newRow = table.insertRow(table.rows.length);
        var cnt = table.rows.length;
		var cell1 = newRow.insertCell(0);
		var cell2 = newRow.insertCell(1);
		var cell3 = newRow.insertCell(2);
		var cell4 = newRow.insertCell(3);
		var cell5 = newRow.insertCell(4);
		var cell6 = newRow.insertCell(5);

        cell1.innerHTML = '<select  class="form-control processid_'+cnt+'" onchange="change_process('+cnt+')" name="process_id[]" required><option value=""> Select Process</option><?php foreach($reedPkAr as $key => $rowVal) { ?><option value="<?=$key+1;?>"> <?=$rowVal;?> </option><?php } ?></select> ';
		cell2.innerHTML = '<select  class="form-control" name="yarn_id[]" required><option value=""> Select Item</option><?php foreach($dataI as $rowArr) { ?><option value="<?=$rowArr->item_id;?>"> <?=$rowArr->item_name;?> </option><?php } ?></select>';
		cell3.innerHTML = '<span id="readpk-'+cnt+'"></span><input type="number" class="small-input" name="reed_peak[]" required>';

		cell4.innerHTML = '<input type="number" min="1" class="form-control" id="yarn_quantity[]" name="yarn_quantity[]" required value="">';

		cell5.innerHTML = 'Kg';

		cell6.innerHTML = '<button type="button" class="btn btn-danger btn-xs" onclick="deleteRow(this)">Delete</button>';

	}

	function deleteRow(button) {
		var row = button.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}

    var siteUrl = "{{url('/')}}";
	function deleteYarn(id)
	{
		if(confirm("Do you realy want to delete this record?"))
		{
			jQuery.ajax({
				type: "GET",
				url: siteUrl + '/' +"ajax_script/deleteYarn",
				data: {
					"_token": "{{ csrf_token() }}",
					"FId":id,
				},

				cache: false,
				success: function(msg)
				{
					$("#Mid"+id).hide();
				}
			});

		}

	}
    function change_process(pid){
        var pidval = $('.processid_'+pid).val();
        if(pidval == 1){
            $('#readpk-'+pid).html('EPI ');

       } else {
        $('#readpk-'+pid).html('PPI ');
       }
    }

</script>




</body>
</html>
