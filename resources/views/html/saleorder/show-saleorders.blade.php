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

      <section class="content">
        <div class="row">
          <div class="col-sm-12">
            {!! CommonController::display_message('message') !!}
            <div class="panel panel-bd lobidrag">
              <div class="panel-heading">
                <div class="btn-group" id="buttonexport"> <a href="javascript:void(0);">
                    <h4>Sale Order List</h4>
                  </a> </div>
              </div>
              <div class="panel-body">
                <div class="row" style="margin-bottom:5px">

                  <form action="{{ route('show-saleorders') }}" method="GET" role="search">
                    @csrf
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="qsearch" id="qsearch" value="<?= $qsearch; ?>" placeholder="Search by Customer Name.. ">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="qnamesearch" id="qnamesearch" value="<?= $qnamesearch; ?>" placeholder="Search by Item Name. ">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="ordNumSearch" id="ordNumSearch" value="<?= $ordNumSearch; ?>" placeholder="Search by Sale Order Number.. ">
                    </div>
                    <div class="col-sm-1 col-xs-12">
                      <select class="form-control" name="priority" id="priority">
                        <option value="">Priority</option>
                        <?php foreach ($priorityArr as $pArr) { ?>
                          <option value="<?= $pArr ?>" <?php if ($pArr == $priority) { ?> selected <?php } ?>> <?= $pArr ?> </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="date" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?= $fromDate; ?>">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="date" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?= $toDate; ?>">
                    </div>
                    <div class="col-sm-1 col-xs-12">
                      <select class="form-control" name="sale_order_type" id="sale_order_type">
                        <option value="">All</option>
                        <option value="1" @if($sale_order_type=="1") selected @endif>Customer</option>
                        <option value="2" @if($sale_order_type=="2") selected @endif>Self</option>
                      </select>
                    </div>
                    <div class="col-sm-1 col-xs-12">
                      <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                    </div>
                  </form>

                  <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-exp btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                    <ul class="dropdown-menu exp-drop" role="menu">
                      <li class="divider"></li>
                      <li><a href="javascript:void(0);" onClick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});"><img src="assets/dist/img/xls.png" width="24" alt="logo"> XLS</a></li>
                    </ul>
                  </div>
                  <div class="col-sm-2 col-xs-12"><a class="btn btn-add" href="add-saleorder"> <i class="fa fa-plus"></i> Add Sale Order</a> </div>
                </div>
                <div class="table-responsive">
                  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="info">
                        <th>Sale <br /> Order Num. </th>
                        <th>Customer <br />Name </th>
                        <th>Order</th>
                        <th>Order Item Details </th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($dataP as $data)
                      <?php
                      //  echo "<pre>"; print_r($data); 

                      ?>
                      <tr id="Mid{{ $data->sale_order_id }}">
                        <td> {{ $data->sale_order_number }} </td>
                        <td> @if(isset($data['Individual']->name)) {{ $data['Individual']->name }} @endif</td>
                        <td>
                          Priority : <strong>{{ $data->order_priority }} </strong>
                          </br>
                          Lot Num. <strong>{{ $data->sale_order_id }} </strong>
                          </br>
                          <?= date('M jS, Y', strtotime($data->sale_order_date)); ?>
                          <br>
                        </td>
                        <td>
                          <table class="table table-bordered table-striped table-hover">
                            <tr>
                              <th>Item Name</th>
                              <th>Internal Name</th>
                              <th>Priority</th>
                              <th>Dyeing Color</th>
                              <th>Coated PVC</th>
                              <th>Extra Job</th>
                              <th>Print Job</th>
                              <th>Exp. Del. Date</th>
                              <th>Pcs</th>
                              <th>Cut</th>
                              <th>Meter</th>
                              <th>Work Order No.</th>
                            </tr>
                            <?php
                            foreach ($data['SaleOrderItem'] as $row) {
                              $saleOrdItemId = $row->sale_order_item_id;

                              $woId = CommonController::getWorkOrderIdForSaleOrder($saleOrdItemId);
                              $internalName = CommonController::getItemInternalName($row->item_id);
                              //  echo "<pre>"; print_r($woId); // exit;
                            ?>
                              <tr>
                                <td> <?= $row->name; ?> </td>
                                <td> <?= $internalName; ?> </td>
                                <td> <?= $row->order_item_priority; ?> </td>
                                <td> <?= $row->dyeing_color; ?> </td>
                                <td> <?= $row->coated_pvc; ?> </td>
                                <td> <?= $row->print_job; ?> </td>
                                <td> <?= $row->extra_job; ?> </td>
                                <td> <?= date('M jS, Y', strtotime($row->expect_delivery_date)); ?></td>
                                <td> <?= round($row->pcs); ?> </td>
                                <td> <?= round($row->cut); ?> </td>
                                <td> <?= round($row->meter); ?></td>
                                <td> <?= $woId; ?> </td>
                              </tr>
                            <?php } ?>
                          </table>
                        </td>
                        <td>

                          <p> <a href="print-saleorder/{{ base64_encode($data->sale_order_id) }}" class="tooltip-info"> <label class="label bg-green"><i class="fa fa-print" aria-hidden="true"></i></label> </a> </p>

                          <p> <a href="show-saleorder-workorder-details/{{ base64_encode($data->sale_order_id) }}" class="btn btn-success">Details</a> </p>

                          <p> <a href="javascript:void(0);" onClick="deleteSaleOrder({{ $data->sale_order_id }})" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a></p>

                          <?php /* if(!empty($totBal)) { ?>
						<a href="start-workorder/{{ base64_encode($data->sale_order_id) }}" class="btn btn-xs btn-success">Create Work Order</a> 
					<p>	  <?=$totBal; ?> item is pending to create the work order. </p>
					<?php } else if(empty($totBal)) { ?>
						<p> <?=$totBal; ?> All items have been sent to create the work order.</p>
					<?php } */ ?>
                        </td>
                      </tr>
                      @endforeach
                      <tr class="center text-center">
                        <td class="center" colspan="6">
                          <div class="pagination">{{ $dataP->links('vendor.pagination.bootstrap-4')}} </div>
                        </td>
                      </tr>
                    </tbody>

                  </table>
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
    @include('common.footer')
  </div>
  @include('common.formfooterscript')
  <script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>

  <script>
    $(function() {
      $("#from_date, #to_date").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        autoclose: true,
      });
    });
  </script>

  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function deleteSaleOrder(id) {
      if (confirm("Do you realy want to delete this record?")) {
        jQuery.ajax({
          type: "GET",
          url: siteUrl + '/' + "ajax_script/deleteSaleOrder",
          data: {
            "_token": "{{ csrf_token() }}",
            "FId": id,
          },

          cache: false,
          success: function(msg) {
            $("#Mid" + id).hide();
          }
        });

      }

    }
  </script>
</body>

</html>