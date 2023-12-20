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
                <div class="btn-group" id="buttonexport"> <a href="add-warehouse">
                    <h4>Purchase Request Send By Warehouse List</h4>
                  </a> </div>
              </div>
              <div class="panel-body">
                <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                <div class="row" style="margin-bottom:5px">
                  <form action="{{ route('show-work-purchase-requirement') }}" method="GET" role="search">
                    @csrf
                    <div class="col-sm-3 col-xs-12">
                      <input type="text" class="form-control" name="qnamesearch" id="qnamesearch" value="{{ $qnamesearch }}" placeholder="Search by Item Name">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <select class="form-control" name="item_type" id="item_type">
                        <option value="">Please Select Item</option>
                        <?php foreach ($dataIT as $row) { ?>
                          <option value="<?= $row->item_type_id; ?>"><?= $row->item_type_name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="qworkordersearch" id="qworkordersearch" value="{{ $qworkordersearch }}" placeholder="Search by Work Order Number">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="number" class="form-control" name="qsalesearch" id="qsalesearch" value="{{ $qsalesearch }}" placeholder="Search by Sale Order Number">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="qworkrequestsearch" id="qworkrequestsearch" value="{{ $qworkrequestsearch }}" placeholder="Search by Work Request Send By">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                    </div>
                  </form>
                </div>

                <div class="table-responsive">
                  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="info">
                        <th>Item Name</th>
                        <th>Internal Name</th>
                        <th>Item Type</th>
                        <th>Wrok Order Id</th>
                        <th>Sale Order Id</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Purchase Remark</th>
                        <th>Work Request Send By</th>
                        <th>Status </th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($dataWPR as $data)
                      <?php
                      //	echo "<pre>"; print_r($data); // exit;
                      $process_accepted_by = $data->process_accepted_by;
                      $isProAccByWarehouse = $data->is_pro_acc_by_manager;
                      $processAcceptedBy   = CommonController::getEmpName($process_accepted_by);
                      $internalName = CommonController::getItemInternalName($data->item_id);
                      $resW = CommonController::getWorkOrderItemDetails($data->work_order_id);

                      ?>
                      <tr id="Mid{{ $data->id }}">
                        <td> {{ CommonController::getItemName($data->item_id) }} </td>
                        <td> {{ CommonController::getItemInternalName($data->item_id) }} </td>
                        <td> {{ CommonController::getItemType($data->item_type_id) }} </td>
                        <td> {{ CommonController::getWorkOrderProcessId($data->work_order_id) }} </td>
                        <td> {{ $resW->sale_order_id }} </td>
                        <td> {{ $data->quantity }} </td>
                        <td> {{ CommonController::getUnitTypeName($data->unit_type_id) }} </td>
                        <td> {{ $data->pur_remark }} </td>
                        <td> {{ CommonController::getEmpName($data->purchase_req_send_by) }} </td>
                        <div id="response-message{{ $data->id }}" class="btn btn-success" style="display: none;"></div>
                        <td class="center" id="Waccepted{{ $data->id }}">
                          <?php if (empty($isProAccByWarehouse)) { ?>
                            <a href="javascript:void(0);" onClick="AcceptWarehouseItemReq({{ $data->id }})" class="btn btn-success btn-xs">Accept</a>
                            <a href="javascript:void(0);" onClick="DenyWarehouseItemReq({{ $data->id }})" class="btn btn-danger btn-xs">Deny</a>
                          <?php } else if ($isProAccByWarehouse == 'Yes') { ?>
                            <a href="javascript:void(0);" class="btn btn-success btn-xs">Accepted</a>
                            <p> Accepted By <?= $processAcceptedBy; ?> </p>
                          <?php } else if ($isProAccByWarehouse == 'No') { ?>
                            <a href="javascript:void(0);" class="btn btn-success btn-xs">Denied</a>
                            <p> Denied By <?= $processAcceptedBy; ?> </p>
                          <?php } ?>
                        </td>
                      </tr>
                      @endforeach
                      <tr class="center text-center">
                        <td class="center" colspan="10">
                          <div class="pagination">{{ $dataWPR->links() }}</div>
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

    @include('common.footer')
  </div>
  @include('common.formfooterscript')
  <script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>

  <script type="text/javascript">
    var siteUrl = "{{ url('/') }}";

    function AcceptWarehouseItemReq(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/ajax_script/AcceptWarehouseItemReq',
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(msg) {
          $("#response-message" + Id).text(msg.message).fadeIn('slow');
          $('#Waccepted' + Id).html('<a href="javascript:void(0);" class="successClass">Accepted</a><p>Accepted By ' + msg.processAcceptedBy + '</p>');
        }
      });
    }
  </script>

  <script type="text/javascript">
    var siteUrl = "{{ url('/') }}";

    function DenyWarehouseItemReq(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/ajax_script/DenyWarehouseItemReq',
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(msg) {
          $("#response-message" + Id).text(msg.message).fadeIn('slow');
          $('#Waccepted' + Id).html('<a href="javascript:void(0);" class="successClass">Accepted</a><p>Accepted By ' + msg.processAcceptedBy + '</p>');
        }
      });
    }
  </script>


</body>

</html>