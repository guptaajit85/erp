<?php

use \App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  @include('common.head')
  <style>
    .MultiCheckBox {
      border: 1px solid #e2e2e2;
      padding: 5px;
      border-radius: 4px;
      cursor: pointer;
    }

    .MultiCheckBox .k-icon {
      font-size: 15px;
      float: right;
      font-weight: bolder;
      margin-top: -7px;
      height: 10px;
      width: 14px;
      color: #787878;
    }

    .MultiCheckBoxDetail {
      display: none;
      position: absolute;
      border: 1px solid #e2e2e2;
      overflow-y: hidden;
    }

    .MultiCheckBoxDetailBody {
      overflow-y: scroll;
    }

    .MultiCheckBoxDetail .cont {
      clear: both;
      overflow: hidden;
      padding: 2px;
    }

    .MultiCheckBoxDetail .cont:hover {
      background-color: #cfcfcf;
    }

    .MultiCheckBoxDetailBody>div>div {
      float: left;
    }

    .MultiCheckBoxDetail>div>div:nth-child(1) {}

    .MultiCheckBoxDetailHeader {
      overflow: hidden;
      position: relative;
      height: 28px;
      background-color: #3d3d3d;
    }

    .MultiCheckBoxDetailHeader>input {
      position: absolute;
      top: 4px;
      left: 3px;
    }

    .MultiCheckBoxDetailHeader>div {
      position: absolute;
      top: 5px;
      left: 24px;
      color: #fff;
    }
  </style>
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
          <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
            <div class="panel panel-bd lobidrag">
              <div class="panel-heading">
                <div class="btn-group" id="buttonexport"><a href="javascript:void(0);">
                    <h4>Work Order List</h4>
                  </a></div>
              </div>
              <div class="panel-body">
                <div class="row" style="margin-bottom:5px">
                  <form action="{{ route('show-workorders') }}" method="GET" role="search" autocomplete="off">
                    @csrf
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="cus_search" id="cus_search" value="{{ $cusSearch }}" autofocus="autofocus" placeholder="Search by Customer Name. ">
                      <input type="hidden" id="individual_id" name="individual_id" value="{{-- $individualId --}}">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="item_search" id="item_search" value="{{ $itemSearch }}" placeholder="Search by Item Name.">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="ordNumSearch" id="ordNumSearch" value="{{ $ordNumSearch }}" placeholder="Search by Sale Order Number.">
                      <!-- <input type="hidden" id="qsaleOrderId" name="qsaleOrderId" value="{{-- $qsaleOrderId --}}"> -->
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <select class="form-control" name="priority" id="priority">
                        <option value="">Select Priority</option>
                        @foreach($priorityArr as $pArr)
                        <option value="{{ $pArr }}" {{ $pArr == $priority ? 'selected' : '' }}> {{ $pArr }} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <select class="form-control" name="search_process_id[]" id="search_process_id">
                        <option value="0">Select Process Type</option>
                        {{--@foreach($processI as $process)--}}
                        <!-- <option value="{{-- $process->id --}}" {{--@if(in_array($process->id,$search_process_id )) checked @endif--}} > {{-- $process->process_name --}} </option>  -->
                        {{--@endforeach--}}
                        <?php
                        foreach($processI as $process)
                        {
                          ?>
                         <option value="<?php echo $process->id; ?>" <?php echo in_array($process->id,$search_process_id) ? 'selected' : 'null';?>><?=$process->process_name;?></option>
                         <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="from_date" id="from_date" placeholder="From Date" style="margin-left: 18px;" value="<?= $fromDate; ?>">
                    </div>
                    <div class="col-sm-2 col-xs-12">
                      <input type="text" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?= $toDate; ?>">
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
                        <th>Work Order No.</th>
                        <th>Sale Order No.</th>
                        <th>Item</th>
                        <th>Internal Item</th>
                        <th>Customer Name</th>
                        <th>Process Type</th>
                        <th>Priority</th>
                        <th>Cut</th>
                        <th>Pcs</th>
                        <th>Meter</th>
                        <th>Requirement</th>
                        <th>Status</th>
                        <th>Print</th>
                        <th>Action</th>
                        <!--- <th>Status</th> ---->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($dataWI as $data) {
                        //   echo "<pre>"; print_r($data); // exit;
                        $WOItem = $data['WorkOrderItem'];
                        $Id   = $data->work_order_id;

                        $proTypeId       = $data->process_type_id;
                        $quantity       = $data->quantity;
                        $masterIndId     = $data->master_ind_id;
                        $machineId       = $data->machine_id;
                        $outputQuantity   = $data->output_quantity;
                        $outputProcess     = $data->output_process;
                        $endProcessEmpId   = $data->machine_id;
                        $inspWorkStatusProcess     = $data->insp_status;
                        $WorkStatusProcess       = $data->work_status;
                        $isWarehouseAccepted     = $data->is_warehouse_accepted;
                        $work_req_send_by       = $data->work_req_send_by;
                        $WorkRequireReqAccepted   = $data->is_work_require_request_accepted;

                        $IsGatePassGenrated         = $data->is_gatepass_genrated_by_warehouse;
                        $isItemReceivedFromWarehouse     = $data->is_item_received_from_warehouse;
                        $GatePassGenratedBy         = $data['GatepassGenratedByWarehouseUser'] ? $data['GatepassGenratedByWarehouseUser']->name : 'N/A';
                        $ReqSendBy               = $data['WorkReqSend'] ? $data['WorkReqSend']->name : 'N/A';
                        $internalName             = $data['Item']->internal_item_name;
                        $processName             = $data['ProcessType']->process_name;

                      ?>

                        <tr id="Mid{{ $Id }}">
                          <td>
                            <?= $data->process_type; ?><?= $data->process_sl_no; ?> <?= $Id; ?><br>
                            <?php
                            $created = date("d-m-Y", strtotime($data->created));
                            echo $created;
                            ?>
                          </td>
                          <td>
                            @foreach($WOItem as $rowArr)
                            @php
                            $dataSO = CommonController::getSaleOrd($rowArr->sale_order_id);
                            @endphp
                            <p>{{ $dataSO ? $dataSO->sale_order_number : 'No Sale Order Found' }}</p>
                            @endforeach
                          </td>
                          <td> {{ $data->item_name }} </td>
                          <td> {{ $internalName }} </td>
                          <td> {{ $data->customer_name }}
                            <?php foreach ($WOItem as $valArr) {  ?>
                              <p> {{ CommonController::getEmpName($valArr->customer_id) }} </p>
                            <?php } ?>
                          </td>
                          <td> <?= $processName; ?></td>
                          <td>
                            <?php foreach ($WOItem as $rowArr) { ?>
                              <p> {{ $rowArr->order_item_priority }} </p>
                            <?php } ?>
                          </td>
                          <td><?= $data->cut; ?> </td>
                          <td><?= $data->pcs; ?> </td>
                          <td><?= $data->meter; ?> </td>
                          <td>
                            <?php if (!empty($work_req_send_by) && $WorkRequireReqAccepted == 'Null') { ?>
                              <p>Work Requisition Send In Warehouse By <?= $ReqSendBy ?></p>
                            <?php } elseif ($WorkRequireReqAccepted == 'Yes') { ?>
                              <p class=""> Work Request Accepted By Warehouse</p>
                              <?php if ($IsGatePassGenrated == 'Yes') { ?>
                                <p class="">Gatepass genrated In Warehouse By <?= $GatePassGenratedBy; ?> </p>
                                <br />
                                <?php if ($isItemReceivedFromWarehouse == 'No') { ?>
                                  <form method="post" action="{{ route('accept_item_for_work') }}" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="work_order_Id" id="work_order_Id" value="<?= $Id; ?>">
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-success pull-left">Accept</button>
                                    </div>
                                  </form>
                                <?php } ?>
                              <?php } ?>

                            <?php } elseif ($WorkRequireReqAccepted == 'No') { ?>
                              <p>Work Request Denied By Warehouse </p>
                              <p><a href="start-requisition-process/<?= base64_encode($Id) ?>" class="btn btn-success btn-xs">Request</a></p>
                            <?php } else { ?>
                              <p><a href="start-requisition-process/<?= base64_encode($Id) ?>" class="btn btn-success btn-xs">Request</a></p>
                            <?php } ?>
                          </td>
                          <td>{{ $inspWorkStatusProcess }}</td>
                          <td class="center">
                            <?php if ($isWarehouseAccepted == 'Yes' && $WorkRequireReqAccepted == 'Yes' && $proTypeId > 1) { ?>
                              <a target="_blank" href="{{ route('print-workorder-gatepass', base64_encode($Id)) }}" class="btn btn-success btn-xs">Print Gatepass</a>
                            <?php } ?>
                            <?php $i = 1;
                            foreach ($data['GatePass'] as $gateVal) {
                              $GPId = $gateVal->id;  ?>
                              <a target="_blank" href="{{ route('print-workorder-gatepass', base64_encode($GPId)) }}" class="btn btn-success btn-xs">Print Gatepass <?= $i; ?></a>
                            <?php $i++;
                            } ?>
                          </td>

                          <td class="center">
                            <?php if ($WorkRequireReqAccepted == 'Yes') { ?>



                              <?php if ($proTypeId >= 4) { ?>


                                <?php if (empty($masterIndId) || empty($machineId)) { ?>
                                  <?php if ($IsGatePassGenrated == 'Yes' && $isItemReceivedFromWarehouse == 'Yes') { ?>
                                    <a href="javascript:void(0);" onClick="StartProcess({{ $Id }})" class="btn btn-success btn-xs">Start Process</a>
                                  <?php } ?>
                                <?php } else if ($inspWorkStatusProcess == 'Complete') { ?>
                                  <span class="label-custom label label-default">Item Send To Warehouse</span>
                                <?php } else if ($inspWorkStatusProcess == 'Pending') { ?>
                                  <a href="javascript:void(0);" onClick="CoatingInspProcess({{ $Id }})" class="btn btn-success btn-xs">Inspect & Send to Warehouse</a>
                                <?php } ?>


                                <?php if ($WorkStatusProcess == 'Pending' && $inspWorkStatusProcess == 'Complete') { ?>
                                  <form method="post" action="{{ route('create_work_order_for_packaging') }}" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="work_order_Id" id="work_order_Id" value="<?= $Id; ?>">
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-success pull-left">Create Packaging</button>
                                    </div>
                                  </form>
                                <?php } ?>



                              <?php } elseif ($proTypeId >= 3) { ?>

                                <?php if (empty($masterIndId) || empty($machineId)) { ?>
                                  <?php if ($IsGatePassGenrated == 'Yes' && $isItemReceivedFromWarehouse == 'Yes') { ?>
                                    <a href="javascript:void(0);" onClick="StartProcess({{ $Id }})" class="btn btn-success btn-xs">Start Process</a>
                                  <?php } ?>
                                <?php } else if ($inspWorkStatusProcess == 'Complete') { ?>
                                  <span class="label-custom label label-default">Item Send To Warehouse</span>
                                <?php } else if ($inspWorkStatusProcess == 'Pending') { ?>

                                  <a href="javascript:void(0);" onClick="DyeingInspProcess({{ $Id }})" class="btn btn-success btn-xs">Inspect & Send to Warehouse</a>
                                <?php } ?>
                                <?php if ($WorkStatusProcess == 'Pending' && $inspWorkStatusProcess == 'Complete') { ?>
                                  <form method="post" action="{{ route('create_work_order_for_coating') }}" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="work_order_Id" id="work_order_Id" value="<?= $Id; ?>">
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-success pull-left">Create Coating Process</button>
                                    </div>
                                  </form>
                                <?php } ?>

                              <?php } elseif ($proTypeId == 2) { ?>

                                <?php if (empty($masterIndId) || empty($machineId)) { ?>
                                  <?php if ($IsGatePassGenrated == 'Yes' && $isItemReceivedFromWarehouse == 'Yes') { ?>
                                    <a href="javascript:void(0);" onClick="StartProcess({{ $Id }})" class="btn btn-success btn-xs">Start Process</a>
                                  <?php } ?>
                                <?php } else if ($inspWorkStatusProcess == 'Complete') { ?>
                                  <span class="label-custom label label-default">Item Send To Warehouse</span>
                                <?php } else if ($inspWorkStatusProcess == 'Pending') { ?>
                                  <a href="javascript:void(0);" onClick="WeavingInspProcess({{ $Id }})" class="btn btn-success btn-xs">Inspect & Send to Warehouse</a>
                                <?php } ?>
                                <?php if ($WorkStatusProcess == 'Pending' && $inspWorkStatusProcess == 'Complete') { ?>
                                  <form method="post" action="{{ route('create_work_order_for_dying') }}" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="work_order_Id" id="work_order_Id" value="<?= $Id; ?>">
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-success pull-left">Create Dying Process</button>
                                    </div>
                                  </form>
                                <?php } ?>

                              <?php } else { ?>


                                <?php if (empty($masterIndId) || empty($machineId)) { ?>

                                  <?php if ($IsGatePassGenrated == 'Yes' && $isItemReceivedFromWarehouse == 'Yes') { ?>
                                    <a href="javascript:void(0);" onClick="StartProcess({{ $Id }})" class="btn btn-success btn-xs">Start Process</a>
                                  <?php } ?>

                                <?php } else if ($inspWorkStatusProcess == 'Complete') { ?>
                                  <span class="label-custom label label-default">Item Send To Warehouse</span>
                                <?php } else if ($inspWorkStatusProcess == 'Pending') { ?>
                                  <a href="javascript:void(0);" onClick="InspectionProcess({{ $Id }})" class="btn btn-success btn-xs">Inspect & Send to Warehouse</a>
                                <?php } ?>
                                <?php if ($WorkStatusProcess == 'Pending' && $inspWorkStatusProcess == 'Complete') { ?>
                                  <form method="post" action="{{ route('create_work_order_for_weaving') }}" class="form-horizontal">
                                    @csrf
                                    <input type="hidden" name="work_order_Id" id="work_order_Id" value="<?= $Id; ?>">
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-success pull-left">Create Weaving Process</button>
                                    </div>
                                  </form>
                                <?php } ?>

                              <?php } ?>

                            <?php } ?>

                            <a target="_blank" href="workorder-details/{{ base64_encode($Id) }}" title="View Work Order Details" class="tooltip-info">
                              <label class="label bg-green"><i class="fa fa-eye" aria-hidden="true"></i></label>
                            </a>
                          </td>



                        </tr>
                      <?php } ?>
                      <tr class="center text-center">
                        <td class="center" colspan="13">
                          <div class="pagination"> {{ $dataWI->links('vendor.pagination.bootstrap-4') }}</div>
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

    <!-------------------Model Start-------------------->

    <div class="modal fade" id="RequisitionPop" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('add_work_requisition')}}" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="modal-header modal-header-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3><i class="fa fa-plus m-r-5"></i> Start Requisition Process </h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <fieldset>
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th>Required Item Name</th>
                          <td> <span id="ItemNameReq"></span></td>

                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered" id="myTabled">

                      <tbody>
                        <tr>
                          <input type="hidden" id="itemIdReq" name="itemIdReq">
                          <input type="hidden" id="work_order_id_req" name="work_order_id_req">
                          <th><span id="ReqProduct---"></span> Item </th>
                          <th>Quantity</th>
                          <th>Unit</th>
                        </tr>

                        <tr>
                          <td>
                            <select class="form-control" name="req_item_id[]">
                              <option value=""> Select Item</option>
                              <?php foreach ($dataI as $rowArr) { ?>
                                <option value="<?= $rowArr->item_id; ?>"><?= $rowArr->item_name; ?></option>
                              <?php } ?>
                            </select>
                          </td>
                          <td>
                            <input type="number" min="1" class="form-control" id="quantity[]" name="quantity[]" required>
                            <button type="button" class="btn btn-success btn-xs" onClick="addRow()">Add Row</button>
                          </td>
                          <td>Kg</td>
                        </tr>
                      </tbody>
                    </table>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Send Requisition </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="CoatingInspProcessPop" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('update_coating_inspec_process')}}" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="modal-header modal-header-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3><i class="fa fa-plus m-r-5"></i>Inspection Process</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <fieldset>
                    <table class="table table-bordered">
                      <tr>
                        <th>Item Name</th>
                        <td> <span id="coating_ItemName"></span></td>
                      </tr>
                    </table>

                    <span id="coating_workRequirement"></span>
                    <table class="table table-bordered" id="myTable">
                      <tr>
                        <input type="hidden" id="coating_ins_item_id" name="ins_item_id">
                        <input type="hidden" id="coating_ins_work_order_id" name="ins_work_order_id">
                        <th>Completed <span id="coating_InsoutputNext"></span> (Quantity)</th>
                        <th>Output <span id="coating_outputNext"></span> Size (<span id="coating_outputUnitType"></span>)</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>
                          <input type="number" min="1" id="output_quan_size" class="form-control" name="output_quan_size[]" required>
                        </td>
                      </tr>
                    </table>

                    <table class="table table-bordered">

                      <tr>
                        <td><strong>Comment</strong> </td>
                        <td><textarea class="form-control" id="inspec_comment" required name="inspec_comment"></textarea></td>
                      </tr>
                      <tr>
                        <td><strong> <span id="coating_processtext"> </span></strong> </td>
                        <td><select name="insp_work_status_process" required id="insp_work_status_process" class="form-control">
                            <option value=""> Select Inspection Process Status</option>
                            <option value="No">Not Complete</option>
                            <option value="Yes">Completed</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Work Status</strong> </td>
                        <td><select name="work_status" required id="work_status" onChange='selectWorkStatus(this.value)' class="form-control">
                            <option value=""> Select Work Status</option>
                            <option value="Completed"> Completed</option>
                            <option value="Defective"> Defective</option>
                          </select>
                        </td>
                      </tr>

                      <tr id="WorkStatusProcess" style="display:none;">
                        <td><strong>Process</strong></td>
                        <td>
                          <div class="i-check">
                            <input tabindex="7" type="radio" id="minimal-radio-1" value="reprocess" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-1">Re-Processing</label>
                          </div>
                          <div class="i-check">
                            <input tabindex="8" type="radio" id="minimal-radio-2" value="stock" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-2">Send To Warehouse</label>
                          </div>
                        </td>
                      </tr>
                      <tr id="WorkStatusProcessReason" style="display:none;">
                        <td><strong>Defect Type Reason</strong></td>
                        <td><select name="fabric_fault_id" id="fabric_fault_id" class="form-control">
                            <option value=""> Select Reason</option>
                            <?php foreach ($dataF as $rowF) { ?>
                              <option value="<?= $rowF->id; ?>"> <?= $rowF->reason; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Warehouse</strong></td>
                        <td><select name="insp_work_warehouseId" id="coating_insp_work_warehouseId" required class="form-control">
                            <option> Select Warehouse</option>
                            <?php foreach ($dataW as $row) { ?>
                              <option value="<?= $row->id; ?>"> <?= $row->warehouse_name; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>

                    </table>
                  </fieldset>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Update Inspection Process</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="DyeingInspProcessPop" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('update_dyeing_inspec_process')}}" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="modal-header modal-header-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3><i class="fa fa-plus m-r-5"></i>Inspection Process</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <fieldset>
                    <table class="table table-bordered">
                      <tr>
                        <th>Item Name</th>
                        <td> <span id="dyeing_ItemName"></span></td>
                      </tr>
                    </table>

                    <span id="dyeing_workRequirement"></span>
                    <table class="table table-bordered" id="myTable">
                      <tr>
                        <input type="hidden" id="dyeing_ins_item_id" name="ins_item_id">
                        <input type="hidden" id="dyeing_ins_work_order_id" name="ins_work_order_id">
                        <th>Completed <span id="dyeing_InsoutputNext"></span> (Quantity)</th>
                        <th>Output <span id="dyeing_outputNext"></span> Size (<span id="dyeing_outputUnitType"></span>)</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>
                          <input type="number" min="1" id="output_quan_size" class="form-control" name="output_quan_size[]" required>
                        </td>
                      </tr>
                    </table>

                    <table class="table table-bordered">

                      <tr>
                        <td><strong>Comment</strong> </td>
                        <td><textarea class="form-control" id="inspec_comment" required name="inspec_comment"></textarea></td>
                      </tr>
                      <tr>
                        <td><strong> <span id="dyeing_processtext"> </span></strong> </td>
                        <td><select name="insp_work_status_process" required id="insp_work_status_process" class="form-control">
                            <option value=""> Select Inspection Process Status</option>
                            <option value="No">Not Complete</option>
                            <option value="Yes">Completed</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Work Status</strong> </td>
                        <td><select name="work_status" required id="work_status" onChange='selectWorkStatus(this.value)' class="form-control">
                            <option value=""> Select Work Status</option>
                            <option value="Completed"> Completed</option>
                            <option value="Defective"> Defective</option>
                          </select>
                        </td>
                      </tr>

                      <tr id="WorkStatusProcess" style="display:none;">
                        <td><strong>Process</strong></td>
                        <td>
                          <div class="i-check">
                            <input tabindex="7" type="radio" id="minimal-radio-1" value="reprocess" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-1">Re-Processing</label>
                          </div>
                          <div class="i-check">
                            <input tabindex="8" type="radio" id="minimal-radio-2" value="stock" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-2">Send To Warehouse</label>
                          </div>
                        </td>
                      </tr>
                      <tr id="WorkStatusProcessReason" style="display:none;">
                        <td><strong>Defect Type Reason</strong></td>
                        <td><select name="fabric_fault_id" id="fabric_fault_id" class="form-control">
                            <option value=""> Select Reason</option>
                            <?php foreach ($dataF as $rowF) { ?>
                              <option value="<?= $rowF->id; ?>"> <?= $rowF->reason; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Warehouse</strong></td>
                        <td><select name="insp_work_warehouseId" id="dyeing_insp_work_warehouseId" required class="form-control">
                            <option> Select Warehouse</option>
                            <?php foreach ($dataW as $row) { ?>
                              <option value="<?= $row->id; ?>"> <?= $row->warehouse_name; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>

                    </table>
                  </fieldset>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Update Inspection Process</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="WeavingInspProcessPop" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('update_weaving_inspec_process')}}" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="modal-header modal-header-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3><i class="fa fa-plus m-r-5"></i>Inspection Process</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <fieldset>
                    <table class="table table-bordered">
                      <tr>
                        <th>Item Name</th>
                        <td> <span id="weav_ItemName"></span></td>
                      </tr>
                    </table>

                    <span id="weav_workRequirement"></span>
                    <table class="table table-bordered" id="myTable">
                      <tr>
                        <input type="hidden" id="weav_ins_item_id" name="ins_item_id">
                        <input type="hidden" id="weav_ins_work_order_id" name="ins_work_order_id">
                        <th>Completed <span id="weav_InsoutputNext"></span> (Quantity)</th>
                        <th>Output <span id="weav_outputNext"></span> Size (<span id="weav_outputUnitType"></span>)</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>
                          <input type="number" min="1" id="output_quan_size" class="form-control" name="output_quan_size[]" required>
                        </td>
                      </tr>
                    </table>

                    <table class="table table-bordered">

                      <tr>
                        <td><strong>Comment</strong> </td>
                        <td><textarea class="form-control" id="inspec_comment" required name="inspec_comment"></textarea></td>
                      </tr>
                      <tr>
                        <td><strong> <span id="weav_processtext"> </span></strong> </td>
                        <td><select name="insp_work_status_process" required id="insp_work_status_process" class="form-control">
                            <option value=""> Select Inspection Process Status</option>
                            <option value="No">Not Complete</option>
                            <option value="Yes">Completed</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Work Status</strong> </td>
                        <td><select name="work_status" required id="work_status" onChange='selectWorkStatus(this.value)' class="form-control">
                            <option value=""> Select Work Status</option>
                            <option value="Completed"> Completed</option>
                            <option value="Defective"> Defective</option>
                          </select>
                        </td>
                      </tr>

                      <tr id="WorkStatusProcess" style="display:none;">
                        <td><strong>Process</strong></td>
                        <td>
                          <div class="i-check">
                            <input tabindex="7" type="radio" id="minimal-radio-1" value="reprocess" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-1">Re-Processing</label>
                          </div>
                          <div class="i-check">
                            <input tabindex="8" type="radio" id="minimal-radio-2" value="stock" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-2">Send To Warehouse</label>
                          </div>
                        </td>
                      </tr>
                      <tr id="WorkStatusProcessReason" style="display:none;">
                        <td><strong>Defect Type Reason</strong></td>
                        <td><select name="fabric_fault_id" id="fabric_fault_id" class="form-control">
                            <option value=""> Select Reason</option>
                            <?php foreach ($dataF as $rowF) { ?>
                              <option value="<?= $rowF->id; ?>"> <?= $rowF->reason; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Warehouse</strong></td>
                        <td><select name="insp_work_warehouseId" id="insp_work_warehouseId" required class="form-control">
                            <option> Select Warehouse</option>
                            <?php foreach ($dataW as $row) { ?>
                              <option value="<?= $row->id; ?>"> <?= $row->warehouse_name; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Update Inspection Process</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="InspectionProcessPop" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('update_inspec_process')}}" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="modal-header modal-header-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3><i class="fa fa-plus m-r-5"></i>Inspection Process</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <fieldset>
                    <table class="table table-bordered">
                      <tr>
                        <th>Item Name</th>
                        <td><span id="ItemName"></span></td>
                      </tr>
                    </table>

                    <span id="workRequirement"></span>
                    <table class="table table-bordered" id="myTable">
                      <tr>
                        <input type="hidden" id="ins_item_id" name="ins_item_id">
                        <input type="hidden" id="ins_work_order_id" name="ins_work_order_id">
                        <th>Completed <span id="InsoutputNext"></span> (Quantity)</th>
                        <th>Output <span id="outputNext"></span> Size (<span id="outputUnitType"></span>)</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>
                          <input type="number" min="1" id="output_quan_size" class="form-control" name="output_quan_size[]" required>
                        </td>
                      </tr>
                    </table>

                    <table class="table table-bordered">
                      <tr>
                        <td><strong>Comment</strong> </td>
                        <td><textarea class="form-control" id="inspec_comment" required name="inspec_comment"></textarea></td>
                      </tr>
                      <tr>
                        <td><strong> <span id="processtext"> </span></strong> </td>
                        <td><select name="insp_work_status_process" required id="insp_work_status_process" class="form-control">
                            <option value=""> Select Inspection Process Status</option>
                            <option value="No">Not Complete</option>
                            <option value="Yes">Completed</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Work Status</strong> </td>
                        <td><select name="work_status" required id="work_status" onChange='selectWorkStatus(this.value)' class="form-control">
                            <option value=""> Select Work Status</option>
                            <option value="Completed"> Completed</option>
                            <option value="Defective"> Defective</option>
                          </select>
                        </td>
                      </tr>

                      <tr id="WorkStatusProcess" style="display:none;">
                        <td><strong>Process</strong></td>
                        <td>
                          <div class="i-check">
                            <input tabindex="7" type="radio" id="minimal-radio-1" value="reprocess" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-1">Re-Processing</label>
                          </div>
                          <div class="i-check">
                            <input tabindex="8" type="radio" id="minimal-radio-2" value="stock" onClick="gatePass(this.value)" name="work_status_process">
                            <label for="minimal-radio-2">Send To Warehouse</label>
                          </div>
                          <!------<div class="i-check"> <span id="ItemGatePass"></span> </div>  ------->
                        </td>
                      </tr>
                      <tr id="WorkStatusProcessReason" style="display:none;">
                        <td><strong>Defect Type Reason</strong></td>
                        <td><select name="fabric_fault_id" id="fabric_fault_id" class="form-control">
                            <option value=""> Select Reason</option>
                            <?php foreach ($dataF as $rowF) { ?>
                              <option value="<?= $rowF->id; ?>"> <?= $rowF->reason; ?> </option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Warehouse</strong></td>
                        <td><select name="insp_work_warehouse_id" id="insp_work_warehouse_id" required class="form-control">

                          </select>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="EndProcessPop" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('update_endprocess')}}" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="modal-header modal-header-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3><i class="fa fa-plus m-r-5"></i> End Process</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <fieldset>
                    <table class="table table-bordered ">
                      <tr>
                        <th>Item Name</th>
                        <td><span id="ItemNameE"></span></td>
                      </tr>
                      <tr>
                        <input type="hidden" id="end_item_id" name="end_item_id" value="">
                        <input type="hidden" id="end_work_order_id" name="end_work_order_id" value="">

                        <th>Output <span id="outputNext"></span></th>
                        <td><input type="number" min="1" id="output_quantity" name="output_quantity" required> <span id="outputUnit"></span></td>


                      </tr>

                      <tr>
                        <th>Output <span id="outputNext"></span> Size</th>
                        <td><input type="number" min="1" id="output_quantity" name="output_quantity" required> Meter</td>
                      </tr>


                      <tr>
                        <td><strong>Process Type</strong> </td>
                        <td><span id="processName"> </span>
                          <input type="hidden" name="output_process" id="output_process">
                        </td>
                      </tr>
                    </table>
                    <tr>
                      <td>
                        <label>End Process Remarks <span class="required">*</span></label>
                        <input type="text" name="process_ended_remarks" id="process_ended_remarks" required class="form-control">
                      </td>
                    </tr>

                  </fieldset>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="StartProcessPop" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="{{ route('update_startprocess')}}" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="modal-header modal-header-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3><i class="fa fa-plus m-r-5"></i> Start <span id="processNameId"></span> Process </h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <fieldset>
                    <span id="RequestedItems"></span>
                    <table class="table table-bordered ">
                      <tr>
                        <th>Item Name</th>
                        <td><span id="ItemNameS"></span> </td>
                      </tr>
                      <tr>
                        <input type="hidden" id="itemId" name="itemId">
                        <input type="hidden" id="work_order_id" name="work_order_id">

                      </tr>
                      <tr>
                        <td><strong>Master</strong> </td>
                        <td><select id="masterId" class="form-control" name="masterId">
                            <?php foreach ($dataMas as $row) { ?>
                              <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Machine </strong></td>
                        <td>
                          <select id="machineId" class="form-control" name="machineId">
                          </select>
                        </td>
                      </tr>

                    </table>
                    <tr>
                      <td>
                        <label>Process Remarks <span class="required">*</span></label>
                        <input type="text" name="process_started_remarks" id="process_started_remarks" required class="form-control">
                      </td>
                    </tr>

                  </fieldset>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Start Process</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-------------------Model End-------------------->

    @include('common.footer')
  </div>
  @include('common.formfooterscript')
  <script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#search_process_id").CreateMultiCheckBox({
        width: '230px',
        //defaultText: 'Select Below',
        height: '250px'
      });
    });

    $(document).ready(function() {
      $(document).on("click", ".MultiCheckBox", function() {
        var detail = $(this).next();
        detail.show();
      });

      $(document).on("click", ".MultiCheckBoxDetailHeader input", function(e) {
        e.stopPropagation();
        var hc = $(this).prop("checked");
        $(this).closest(".MultiCheckBoxDetail").find(".MultiCheckBoxDetailBody input").prop("checked", hc);
        $(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();
      });

      $(document).on("click", ".MultiCheckBoxDetailHeader", function(e) {
        var inp = $(this).find("input");
        var chk = inp.prop("checked");
        inp.prop("checked", !chk);
        $(this).closest(".MultiCheckBoxDetail").find(".MultiCheckBoxDetailBody input").prop("checked", !chk);
        $(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();
      });

      $(document).on("click", ".MultiCheckBoxDetail .cont input", function(e) {
        e.stopPropagation();
        $(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();

        var val = ($(".MultiCheckBoxDetailBody input:checked").length == $(".MultiCheckBoxDetailBody input").length)
        $(".MultiCheckBoxDetailHeader input").prop("checked", val);
      });

      $(document).on("click", ".MultiCheckBoxDetail .cont", function(e) {
        var inp = $(this).find("input");
        var chk = inp.prop("checked");
        inp.prop("checked", !chk);

        var multiCheckBoxDetail = $(this).closest(".MultiCheckBoxDetail");
        var multiCheckBoxDetailBody = $(this).closest(".MultiCheckBoxDetailBody");
        multiCheckBoxDetail.next().UpdateSelect();

        var val = ($(".MultiCheckBoxDetailBody input:checked").length == $(".MultiCheckBoxDetailBody input").length)
        $(".MultiCheckBoxDetailHeader input").prop("checked", val);
      });

      $(document).mouseup(function(e) {
        var container = $(".MultiCheckBoxDetail");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
          container.hide();
        }
      });
    });

    var defaultMultiCheckBoxOption = {
      width: '220px',
      defaultText: 'Select Below',
      height: '200px'
    };

    jQuery.fn.extend({
      CreateMultiCheckBox: function(options) {

        var localOption = {};
        localOption.width = (options != null && options.width != null && options.width != undefined) ? options.width : defaultMultiCheckBoxOption.width;
        localOption.defaultText = (options != null && options.defaultText != null && options.defaultText != undefined) ? options.defaultText : defaultMultiCheckBoxOption.defaultText;
        localOption.height = (options != null && options.height != null && options.height != undefined) ? options.height : defaultMultiCheckBoxOption.height;

        this.hide();
        this.attr("multiple", "multiple");
        var divSel = $("<div class='MultiCheckBox'>" + localOption.defaultText + "<span class='k-icon k-i-arrow-60-down'><svg aria-hidden='true' focusable='false' data-prefix='fas' data-icon='sort-down' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512' class='svg-inline--fa fa-sort-down fa-w-10 fa-2x'><path fill='currentColor' d='M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z' class=''></path></svg></span></div>").insertBefore(this);
        divSel.css({
          "width": localOption.width
        });

        var detail = $("<div class='MultiCheckBoxDetail'><div class='MultiCheckBoxDetailHeader'><input type='checkbox' class='mulinput' value='-1982' /><div>Select All</div></div><div class='MultiCheckBoxDetailBody'></div></div>").insertAfter(divSel);
        detail.css({
          "width": parseInt(options.width) + 10,
          "max-height": localOption.height
        });
        var multiCheckBoxDetailBody = detail.find(".MultiCheckBoxDetailBody");

        this.find("option").each(function() {
          var val = $(this).attr("value");

          if (val == undefined)
            val = '';

          multiCheckBoxDetailBody.append("<div class='cont'><div><input type='checkbox' class='mulinput' value='" + val + "' /></div><div>" + $(this).text() + "</div></div>");
        });

        multiCheckBoxDetailBody.css("max-height", (parseInt($(".MultiCheckBoxDetail").css("max-height")) - 28) + "px");
      },
      UpdateSelect: function() {
        var arr = [];

        this.prev().find(".mulinput:checked").each(function() {
          arr.push($(this).val());
        });

        this.val(arr);
      },
    });
    $(function() {
      $("#from_date, #to_date").datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        autoclose: true,
      });
    });

    var siteUrl = "{{url('/')}}";
    $("#cus_search").autocomplete({
        minLength: 0,
        source: siteUrl + '/' + "list_customer",
        focus: function(event, ui) {
          //console.log(ui);
          $("#cus_search").val(ui.item.name);
          return false;
        },
        select: function(event, ui) {
          $("#cus_search").val(ui.item.name);
          $("#individual_id").val(ui.item.id);
          return false;
        }
      })
      .autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>")
          .append("<div>" + item.name + "</div>")
          .appendTo(ul);
      };
  </script>

  <script type="text/javascript">
    // $(document).ready(function() {
    //   var siteUrl = "{{url('/')}}";
    //   $("#qsearch").autocomplete({
    //     minLength: 0,
    //     source: siteUrl + '/list_customer',
    //     focus: function(event, ui) {
    //       $("#qsearch").val(ui.item.name);
    //       return false;
    //     },
    //     select: function(event, ui) {
    //       $("#individual_id").val(ui.item.id);
    //       return false;
    //     }
    //   }).autocomplete("instance")._renderItem = function(ul, item) {
    //     return $("<li>")
    //       .append("<div>" + item.name + "<br> GSTIN - " + item.gstin + "</div>")
    //       .appendTo(ul);
    //   };
    // });
    $("#item_search").autocomplete({
        minLength: 0,
        source: siteUrl + '/' + "fabric_list_item",
        focus: function(event, ui) {
          if (ui.item.part_number != '') {
            $("#item_search").val(ui.item.item_name);
            //$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code );
          } else {
            $("#product_name").val(ui.item.item_name);
          }
          return false;
        },
        select: function(event, ui) {
          if (ui.item.part_number != '') {
            $("#product_name").val(ui.item.item_name);
            //$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code);
          } else {
            $("#product_name").val(ui.item.item_name);
          }
          return false;          
        }
      })
      .autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>")
          //.append( "<div>" + item.item_name + " </div>" )
          .append("<div>" + item.item_name + " </div>")
          .appendTo(ul);
      };
      //console.log($("#ordNumSearch").val());
      $("#ordNumSearch").autocomplete({
        minLength: 0,
        source: siteUrl + '/' + "find_saleOrderNumer",
        focus: function(event, ui) {
          //var ordNumSearch=$("#ordNumSearch").val();
          $( "#ordNumSearch" ).val( ui.item.sale_order_number);
		      return false;
        },
        select: function(event, ui) {
          $("#ordNumSearch").val(ui.item.sale_order_number);
          //$("#qsaleOrderId").val(ui.item.sale_order_id);
          return false;          
        }
      })
      .autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>")
          //.append( "<div>" + item.item_name + " </div>" )
          .append("<div>" + item.sale_order_number + " </div>")
          .appendTo(ul);
      };
  </script>

  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function CoatingInspProcess(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkOrderDetails",
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(response) {
          response = JSON.parse(response);
          console.log(response);

          //alert(response.workRequirement);
          $("#coating_ins_item_id").val(response.itemId);
          $("#coating_ins_work_order_id").val(response.workOrdId);
          $("#coating_ItemName").html(response.ItemName);
          $("#coating_InsoutputNext").html(response.outputNextPro);
          $("#coating_InsoutputUnit").html(response.outputUnit);
          $("#coating_processtext").html(response.processtext);
          $("#coating_outputUnitType").html(response.outputUnitType);
          $("#coating_workRequirement").html(response.workRequirement);
          $("#coating_insp_work_warehouseId").html(response.warehouses);

        }
      });

      $('#CoatingInspProcessPop').modal({
        backdrop: 'static',
        keyboard: false
      });
    }
  </script>

  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function DyeingInspProcess(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkOrderDetails",
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(response) {
          response = JSON.parse(response);
          console.log(response);

          //alert(response.workRequirement);
          $("#dyeing_ins_item_id").val(response.itemId);
          $("#dyeing_ins_work_order_id").val(response.workOrdId);
          $("#dyeing_ItemName").html(response.ItemName);
          $("#dyeing_InsoutputNext").html(response.outputNextPro);
          $("#dyeing_InsoutputUnit").html(response.outputUnit);
          $("#dyeing_processtext").html(response.processtext);
          $("#dyeing_outputUnitType").html(response.outputUnitType);
          $("#dyeing_workRequirement").html(response.workRequirement);
          $("#dyeing_insp_work_warehouseId").html(response.warehouses);

        }
      });

      $('#DyeingInspProcessPop').modal({
        backdrop: 'static',
        keyboard: false
      });
    }
  </script>

  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function WeavingInspProcess(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkOrderDetails",
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(response) {
          response = JSON.parse(response);
          console.log(response);

          //alert(response.workRequirement);
          $("#weav_ins_item_id").val(response.itemId);
          $("#weav_ins_work_order_id").val(response.workOrdId);
          $("#weav_ItemName").html(response.ItemName);
          $("#weav_InsoutputNext").html(response.outputNextPro);
          $("#weav_InsoutputUnit").html(response.outputUnit);
          $("#weav_processtext").html(response.processtext);
          $("#weav_outputUnitType").html(response.outputUnitType);
          $("#weav_workRequirement").html(response.workRequirement);
          $("#insp_work_warehouseId").html(response.warehouses);

        }
      });

      $('#WeavingInspProcessPop').modal({
        backdrop: 'static',
        keyboard: false
      });
    }
  </script>


  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function InspectionProcess(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkOrderDetails",
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(response) {
          response = JSON.parse(response);
          console.log(response);
          // alert(response.warehouses);	
          //alert(response.workRequirement);
          $("#ins_item_id").val(response.itemId);
          $("#ins_work_order_id").val(response.workOrdId);
          $("#ItemName").html(response.ItemName);
          $("#InsoutputNext").html(response.outputNextPro);
          $("#InsoutputUnit").html(response.outputUnit);
          $("#processtext").html(response.processtext);
          $("#outputUnitType").html(response.outputUnitType);
          $("#insp_work_warehouse_id").html(response.warehouses);
        }
      });
      $('#InspectionProcessPop').modal({
        backdrop: 'static',
        keyboard: false
      });
    }
  </script>


  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function Requisition(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkOrderDetails",
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(response) {

          response = JSON.parse(response);
          console.log(response);

          $("#itemIdReq").val(response.itemId);
          $("#work_order_id_req").val(response.workOrdId);
          $("#ItemNameReq").html(response.ItemName);
          $("#ReqProduct").html(response.itemTypeName);


        }
      });
      $('#RequisitionPop').modal({
        backdrop: 'static',
        keyboard: false
      });
    }

    function StartProcess(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkOrderDetails",
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(response) {
          response = JSON.parse(response);
          console.log(response);
          $("#itemId").val(response.itemId);
          $("#work_order_id").val(response.workOrdId);
          $("#ItemNameS").html(response.ItemName);
          $("#processNameId").html(response.processName);
          $("#RequestedItems").html(response.RequestedItems);
          $("#machineId").html(response.options);
        }
      });
      $('#StartProcessPop').modal({
        backdrop: 'static',
        keyboard: false
      });
    }

    function EndProcess(Id) {
      jQuery.ajax({
        type: "GET",
        url: siteUrl + '/' + "ajax_script/getWorkOrderDetails",
        data: {
          "_token": "{{ csrf_token() }}",
          "FId": Id,
        },
        cache: false,
        success: function(response) {
          response = JSON.parse(response);
          console.log(response);
          $("#end_item_id").val(response.itemId);
          $("#end_work_order_id").val(response.workOrdId);
          $("#ItemNameE").html(response.ItemName);
          $("#processName").html(response.processName);
          $("#output_process").val(response.processNameId);
          $("#outputNext").html(response.outputNextPro);
          $("#outputUnit").html(response.outputUnit);

        }
      });
      $('#EndProcessPop').modal({
        backdrop: 'static',
        keyboard: false
      });
    }
  </script>

  <script type="text/javascript">
    function deleteWorkOrder(id) {
      var siteUrl = "{{url('/')}}";
      if (confirm("Do you realy want to delete this record?")) {
        jQuery.ajax({
          type: "GET",
          url: siteUrl + '/' + "ajax_script/deleteWorkOrder",
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

  <script type="text/javascript">
    function selectWorkStatus(value) {
      if (value === 'Defective') {
        $('#WorkStatusProcess').show();
        $('#WorkStatusProcessReason').show();
      } else if (value === 'Completed') {
        $('#WorkStatusProcess').hide();
        $('#WorkStatusProcessReason').hide();
      }

    }

    function gatePass(value) {
      if (value === 'stock') {
        var siteUrl = "{{url('/')}}";
        var Id = Base64.encode($("#ins_work_order_id").val());
        var pageUrl = siteUrl + '/' + "print-workorder-gatepass" + '/' + Id;
        $("#ItemGatePass").html('<div class="i-check"> <a target="_blank" href=' + pageUrl + ' class="btn btn-success btn-xs">Gatepass</a></div>');
        $("#ItemGatePass").show();
      } else if (value === 'reprocess') {
        $("#ItemGatePass").hide();
      }

    }
  </script>

  <script>
    function addRow() {
      var table = document.getElementById("myTable");
      var newRow = table.insertRow(table.rows.length);
      var cell1 = newRow.insertCell(0);
      var cell2 = newRow.insertCell(1);

      cell1.innerHTML = table.rows.length - 1;
      cell2.innerHTML = '<input type="number" min="1" id="output_quan_size" class="form-control" placeholder="Size in Meter, Ex: 10" name="output_quan_size[]" required><button type="button" class="btn btn-danger btn-xs" onclick="deleteRow(this)">Delete</button>';

    }

    function deleteRow(button) {
      var row = button.parentNode.parentNode;
      row.parentNode.removeChild(row);
    }
  </script>

</body>

</html>