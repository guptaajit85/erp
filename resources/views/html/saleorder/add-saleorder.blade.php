<?php

use \App\Http\Controllers\CommonController;

?>
<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">

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

      <section class="content">
        <div class="row">
          <!-- Form controls -->
          <div class="col-sm-12">
            {!! CommonController::display_message('message') !!}
            <div class="panel panel-bd lobidrag">
              <div class="panel-heading">
                <div class="btn-group" id="buttonlist"> <a class="btn btn-add " href="javascript:void|(0);"> <i class="fa fa-list"></i> New Sale Order </a> </div>
              </div>
              <div class="panel-body">
                <form method="post" action="{{ route('store-saleorder')}}" onSubmit="return check_form();" autocomplete="off">
                  @csrf
                  <div class="row">
                    <div class="col-md-12"> </div>
                    <div class="col-md-12">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>

                            <td style="width:150px;"><label for="sale_order_number">Order Type</label>
                              <select class="form-control" name="sale_order_type" required id="sale_order_type" value="{{old('sale_order_type')}}" onchange="saleOrderType(this.value)">
                                <option value="">Select Order Type</option>
                                <option value="1">Customer</option>
                                <option value="2">Self</option>
                              </select>
                            </td>

                            <td style="width:150px;"><label for="lot_number">AJY Number</label>
                              <input type="text" id="lot_number" required class="form-control" readonly name="lot_number" value="<?= $totSleord; ?>">
                            </td>
                            <td style="width:150px;"><label for="sale_order_number">Sale Order Number</label>
                              <input type="text" id="sale_order_number" required class="form-control" name="sale_order_number" value="{{old('sale_order_number')}}">
                            </td>
                            <td style="width:150px;"><label for="sale_order_date">Sale Order Date</label>
                              <input type="text" id="sale_order_date" required class="form-control" data-date-format="dd-mm-yyyy" name="sale_order_date" onblur="changedeliveryDate();" value="{{old('sale_order_date')}}">
                            </td>
                            <td style="width:150px;"><label for="">Sales Order</label>
                              <select id="sales_order" name="sales_order" onChange="changeSaleOrder();" class="form-control" value="{{old('sales_order')}}" required>
                                <option value="">Select Sales Order</option>
                                <option value="direct">Direct</option>
                                <option value="agent">Agent</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="whatsapp">Whatsapp</option>
                              </select>
                            </td>
                            <td style="width:150px;">
                              <span id="agentId" style="display:none">
                                <label for="agent_name">Agent Name</label>
                                <select class="form-control" name="ind_agent_id" id="ind_agent_id" value="{{old('ind_agent_id')}}">
                                  <option value="">Select Agent</option>
                                  <?php foreach ($dataI as $valIT) { ?>
                                    <option value="<?= $valIT->id; ?>"> <?= $valIT->name; ?> </option>
                                  <?php } ?>
                                </select>
                              </span>
                              <span id="sale_order_fromId">
                                <label for="sale_order_from">Sale Order From</label>
                                <input type="text" class="form-control" name="sale_order_from" id="sale_order_from" value="{{old('sale_order_from')}}">
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td style="width:150px;"><label for="Order By Employee">Order By Employee</label>
                              <select class="form-control" name="ind_employee_id" required id="ind_employee_id" value="{{old('ind_employee_id')}}">
                                <option value="">Select Order By </option>
                                <?php foreach ($dataE as $valIT) { ?>
                                  <option value="<?= $valIT->id; ?>"> <?= $valIT->name; ?> </option>
                                <?php } ?>
                              </select>
                            </td>
                            <td style="width:150px;"><label for="order_priority">Sale Order Priority</label>
                              <select id="order_priority" name="order_priority" onChange="orderPriority();" class="form-control" value="{{old('order_priority')}}" required>
                                <option value="">Select Order Priority</option>
                                <?php foreach ($priorityArr as $pArr) { ?>
                                  <option value="<?= $pArr ?>"><?= $pArr ?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td style="width:150px;">
                              <div class="hidden">
                                <label for="exampleInputCategory1">Customer Type *</label>
                                <br>
                                <input type="radio" name="cust_type" class="" placeholder="" value="1" checked>
                                Existing &nbsp;&nbsp;&nbsp;
                                <input type="radio" id="cust_type_raw" name="cust_type" class="" placeholder="" value="0">
                                New
                              </div>
                              <label for="exampleInputCategory1">Customer Name *</label>
                              <input type="text" id="cus_name" name="cus_name" class="form-control" placeholder="Customer Name" required autofocus="autofocus" autocomplete="off" value="{{old('cus_name')}}">
                              <input type="hidden" id="individual_id" name="individual_id" required>
                              <label for="exampleInputCategory1">Phone : <span id="phone"></span> </label>
                              </br>
                              <input type="hidden" name="mobile" id="mobile" class="form-control" placeholder="Mobile">
                              <input type="hidden" name="email" id="email" class="form-control" placeholder="Email">
                              <label for="exampleInputCategory1">GSTIN :<span id="gst_label"></span></label>
                              <input type="hidden" name="cst" id="cst" class="form-control" placeholder="GSTIN">
                              <input type="hidden" required name="com_state" id="com_state" value="41">
                            </td>
                            <td><label for="exampleInputCategory1">Billing Address </label>
                              <br />
                              <p><a class="btn btn-primary btn-sm pull-left" id="add_billing_shipping_address" target="_blank" href="{{ route('add-individualaddress')}}">Add Billing & Shipping Address</a></p>
                              <br />
                              <p>

                                <span id="address">
                                </span>
                              </p>
                            </td>
                            <td><label for="exampleInputCategory1">Shipping Address </label>
                              <p><span id="Shipaddress"></span></p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="col-md-12" id="main_div" style="display:llnone">

                      <div class="row">
                        <div class="col-xs-12">
                          <!--table part start-->
                          <div class="table-responsive table-responsive-custom">
                            <table class="table table-bordered">
                              <tbody>
                                <tr>
                                  <th>Item Name</th>
                                  <th>Greige/Quality</th>
                                  <th>Dyeing/Color</th>
                                  <th>Coated/PVC</th>
                                  <th>Print Job</th>
                                  <th>Extra Job</th>
                                  <th>Expected Delivery Date</th>
                                </tr>

                                <tr>
                                  <td><input type="text" id="product_name" name="product_name" value="{{old('product_name')}}" class="form-control" placeholder="Name"></td>
                                  <td><input type="text" id="grey_quality" name="grey_quality" value="" class="form-control" placeholder="Greige or Quality Name"></td>
                                  <td><input type="text" id="dyeing_color" name="dyeing_color" value="" class="form-control" placeholder="Dyeing or Color Name"></td>
                                  <td><input type="text" id="coated_pvc" name="coated_pvc" value="" class="form-control" placeholder="Coated or PVC Name"></td>
                                  <td><input type="text" id="print_job" name="print_job" value="" class="form-control" placeholder="Print Job"></td>
                                  <td><input type="text" id="extra_job" name="extra_job" value="" class="form-control" placeholder="Extra Job"></td>
                                  <td><input type="text" id="expect_delivery_date" name="expect_delivery_date" value="" class="form-control" value="<?= $ExpDeliveryDate; ?>"></td>
                                </tr>

                              </tbody>
                            </table>

                            <table class="table table-bordered">
                              <tbody>
                                <tr>
                                  <td style="width: 6%;">
                                    <div class="input-group">

                                      <p>Unit</p>
                                      <select id="unit" name="unit" class="form-control">
                                        <?php foreach ($dataUT as $utVal) { ?>
                                          <option value="<?= $utVal->unit_type_name; ?>"> <?= $utVal->unit_type_name; ?> </option>
                                        <?php } ?>
                                      </select>
                                    </div>
                                  </td>
                                  <td style="width:6%">
                                    <div class="input-group">
                                      <p>PCs</p>
                                      <input type="text" id="pcs" name="pcs" onBlur="calculate_price();" class="form-control" value="1">
                                    </div>
                                  </td>
                                  <td style="width:6%">
                                    <div class="input-group">
                                      <p>CUT</p>
                                      <input type="text" id="cut" name="cut" onBlur="calculate_price();" class="form-control" value="1">
                                    </div>
                                  </td>
                                  <td style="width:10%">
                                    <div class="input-group">
                                      <p>Meter</p>
                                      <input type="text" id="meter" name="meter" readonly onBlur="calculate_price();" class="form-control" value="1">
                                    </div>
                                  </td>
                                  <td style="width:10%">
                                    <div class="input-group">
                                      <p>Rate</p>
                                      <input type="text" id="rate" name="rate" onBlur="calculate_price();" class="form-control" value="1">
                                    </div>
                                  </td>
                                  <td style="width:10%"><input type="hidden" id="pro_id" name="pro_id">
                                    <div class="input-group ">
                                      <p class="mrplabel">Amount</p>
                                      <input type="text" id="amount" name="amount" onBlur="calculate_price();" class="form-control">
                                    </div>
                                  </td>
                                  <td style="width:10%">
                                    <div class="input-group">
                                      <label>Dis Type</label>
                                      <select id="dis_type" name="dis_type" class="form-control" onChange="calculate_price(this.value);">
                                        <option value="1">%</option>
                                        <option value="2">Rs.</option>
                                      </select>
                                      <p>Discount </p>
                                      <input type="text" id="discount" name="discount" class="form-control" onBlur="calculate_price();" value="0">
                                      <input type="hidden" id="profitrs" name="profitrs" value="0">
                                    </div>
                                  </td>
                                  <td style="width:8%">
                                    <div class="input-group">
                                      <p>Discount Amount</p>
                                      <input type="text" id="discount_amount" name="discount_amount" class="form-control" onBlur="calculate_price();" value="0" readonly>
                                    </div>
                                  </td>
                                  <td style="width:10%">
                                    <div class="input-group">
                                      <p>Net Amount</p>
                                      <input type="text" id="final_price" name="final_price" class="form-control" value="0" readonly>
                                    </div>
                                  </td>
                                  <td style="width:10%"><label for="remarks">Remark</label>
                                    <input type="text" id="remarks" class="form-control" name="remarks">
                                  </td>
                                  <td style="width:12%"><label for="remarks">Priority</label>
                                    <select id="order_item_priority" name="order_item_priority" class="form-control">
                                      <?php foreach ($priorityArr as $pArr) { ?>
                                        <option value="<?= $pArr ?>" <?php if ($pArr == 'High') { ?> selected <?php } ?>><?= $pArr ?></option>
                                      <?php } ?>
                                    </select>
                                  </td>


                                  <td style="width:10%"><button type="button" id="Add_To_Purchase" class="btn btn-primary">+</button></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="box-body">
                          <table id="example1" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>Item Name</th>
                                <th>Greige/Quality</th>
                                <th>Dyeing/Color</th>
                                <th>Coated/PVC</th>
                                <th>Print Job</th>
                                <th>Extra Job</th>
                                <th>Expect Delivery Date </th>
                              </tr>
                            </thead>
                            <tbody id="trExt" style="max-height: 100%;overflow-y: auto;overflow-x: hidden;">
                            </tbody>
                          </table>

                          <table id="example2" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th style="width:10%">Unit</th>
                                <th style="width:10%">PCs</th>
                                <th style="width:5%">Cut</th>
                                <th style="width:8%">Meter</th>
                                <th style="width:10%">Rate</th>
                                <th style="width:10%" class="mrplabel">Amount</th>
                                <th style="width:10%">Discount</th>
                                <th style="width:10%">Discount Amount</th>
                                <th style="width:10%">Net Amount</th>
                                <th style="width:10%">Remarks</th>
                                <th style="width:10%">Priority</th>
                                <th style="width:10%">Action</th>
                              </tr>
                            </thead>
                            <tbody id="tbody" style="max-height: 100%;overflow-y: auto;overflow-x: hidden;">
                            </tbody>
                            <tfoot>

                              <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th colspan="2" style="width:10%"><input type="number" name="total" id="total" min="0" value="0" step="any" class="form-control" readonly></th>
                                <th></th>
                              </tr>
                              <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Frieght</th>
                                <th colspan="2" style="width:10%"><input type="number" name="frieght" id="frieght" value="0" min="0" step="any" class="form-control"></th>
                                <th>Round Off</th>
                                <th colspan="2" style="width:10%"><input type="number" name="round_discount" id="round_discount" value="0" min="0" step="any" class="form-control"></th>
                                <th>G. Total</th>
                                <th colspan="2" style="width:10%"><input type="number" name="subtotal" id="subtotal" value="0" min="0" step="any" class="form-control" readonly></th>
                                <th></th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>

                      <button type="submit" id="confirmBtn" style="display:none" class="btn btn-primary pull-left">Confirm</button>
                      <button type="reset" id="resetBtn" style="display:none" class="btn btn-danger pull-left"><i class="fa fa-times"></i>Discard</button>
                    </div>
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
  @include('common.formfooterscript')


  <script type="text/javascript">
    function changeSaleOrder() {
      var saleOrderDate = $('#sales_order').val();
      if (saleOrderDate == 'agent') {
        $("#agentId").show();
        $("#sale_order_fromId").hide();
      } else {
        $("#agentId").hide();
        $("#sale_order_fromId").show();
      }
    }
    // this code added by:Prasun date: 21/dec/2023 //
    function saleOrderType(val) {
      //alert(val);
      if (val == "2") {
        $("#sales_order").prop('disabled', true);
        $("#sale_order_from").prop('disabled', true);
        $("#cus_name").prop('disabled', true);
        $("#add_billing_shipping_address").attr("disabled", "disabled");
        $("#add_billing_shipping_address").css('pointer-events', 'none');
        $("#individual_id").prop('disabled', true);
      } else {
        $("#sales_order").prop('disabled', false);
        $("#sale_order_from").prop('disabled', false);
        $("#cus_name").prop('disabled', false);
        $("#add_billing_shipping_address").removeAttr("disabled");
        $("#add_billing_shipping_address").css('pointer-events', '');
        $("#individual_id").prop('disabled', false);
      }
    }
    // $('#sale_order_number').keypress(function(e) {
    //   alert("test22");
    //   var regex = new RegExp("^[a-zA-Z0-9]+$");
    //   var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    //   if (regex.test(str)) {
    //     return true;
    //   }
    //   e.preventDefault();
    //   return false;
    // });
    $('#sale_order_number').bind('keyup blur', function() {
      if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
        this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
        alert("You are entering the non alpha numeric value");
      }
    });
    // this code added by:Prasun date: 21/dec/2023 //
  </script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function calcAddress(stateId) {
      $('#com_state').val(stateId);
      $('#main_div').show();
    }
  </script>

  <script>
    const orderPrioritySelect = document.getElementById('order_priority');
    const orderItemPrioritySelect = document.getElementById('order_item_priority');

    function orderPriority() {
      const selectedValue = orderPrioritySelect.value;
      orderItemPrioritySelect.value = selectedValue;
    }
    orderPriority();
  </script>

  <script>
    function chkbill_based() {
      if ($('#bill_based').val() == 'price') {
        $('.mrplabel').html("MRP");
      } else {
        $('.mrplabel').html("Rate");
      }
    }


    function check_form() {
      if (!$('#cust_type_raw').is(':checked')) {
        var sale_order_type = $("#sale_order_type").val();
        if ($('#individual_id').val() == "" && sale_order_type == "Customer") {
          alert("Please select a vendor.");
          $('#cus_name').focus();
          return false;
        }
      }

      if (parseInt($('#count_product').val()) == 0) {
        alert("Please Add a product in purchase List.");
        $('#product_name').focus();
        return false;
      } else {
        // return false;
        return true;
      }
    }

    function calculate_price() {
      var cut = parseFloat($('#cut').val());
      var pcs = parseFloat($('#pcs').val());
      var meter = parseFloat($('#meter').val());
      var rate = parseFloat($('#rate').val());
      var dis_type = parseFloat($('#dis_type').val());
      var discount = parseFloat($('#discount').val());
      var meterV = cut * pcs;

      $('#meter').val(meterV.toFixed(2));

      var amount = meterV * rate;
      $('#amount').val(amount.toFixed(2));

      if (dis_type == '1') {
        var discountRs = (amount * discount) / 100;
      } else if (dis_type == '2') {
        var discountRs = discount;
      } else {
        var discountRs = (amount * discount) / 100;
      }

      var final_price = amount - discountRs;
      $('#final_price').val(final_price);
      $('#discount_amount').val(discountRs);
    }


    function changedeliveryDate() {
      $('#expect_delivery_date').prop('disabled', false);
      var saleOrderDate = $('#sale_order_date').val();
      var ExpDeliveryDate = '<?php echo $ExpDeliveryDate; ?>';
      if (saleOrderDate) {
        var inputDate = $('#sale_order_date').val();
        var daysToAdd = <?php echo $expDeliverydays; ?>;

        // alert(daysToAdd);
        var newDate = addDaysToDate(inputDate, daysToAdd);
        $('#expect_delivery_date').val(newDate);
      } else {
        $('#expect_delivery_date').val(ExpDeliveryDate);
      }
    }
    if ($('#sale_order_date').val() == "") {
      $('#expect_delivery_date').prop('disabled', true);
    }
    $(function() {

      $(".remove").on('click', 'a', function(event) {
        // alert( $(this).data('trid') );
      });

      $('#saleprice_wot').keyup(function() {
        // calculatepurchaseprice();
      });

      $('#discount,#qty,#cess').blur(function() {
        calculateprice();
      });


      $('#dis_type').change(function() {
        $('#discount').trigger('blur');
      });



      function getCustomerShipAddress(individualId) {
        $.ajax({
          type: "GET",
          url: siteUrl + '/' + "ajax_script/search_customer_ship_address",
          data: {
            "_token": "{{ csrf_token() }}",
            "individualId": individualId,
          },
          cache: false,
          success: function(res) {

            $("#Shipaddress").html(res);
            // $( "#Shipaddress" ).html( ui.item.state_name );

          }
        })
      }

      function getCustomerBillAddress(individualId) {
        $.ajax({
          type: "GET",
          url: siteUrl + '/' + "ajax_script/search_customer_bill_address",
          data: {
            "_token": "{{ csrf_token() }}",
            "individualId": individualId,
          },
          cache: false,
          success: function(res) {

            $("#address").html(res);
            // $( "#address" ).html( ui.item.state_name );

          }
        })
      }



      $('#total,#round_discount,#frieght').change(function() {

        var total = parseFloat($('#total').val());

        var frieght = parseFloat($('#frieght').val());
        var round_discount = parseFloat($('#round_discount').val());
        var subtotal = frieght + total - round_discount;
        $('#subtotal').val(subtotal.toFixed(2));

      });
      $('[data-toggle="tooltip"]').tooltip();

      $("#sale_order_date").datepicker({
        dateFormat: "dd-mm-yy",
        minDate: -2,
        maxDate: 2,
        autoclose: true,
        onChange: function(date) {
          changedeliveryDate();
        },
      });
      $("#expect_delivery_date").datepicker({
        dateFormat: "dd-mm-yy",
        minDate: -2,
        maxDate: 15,
        autoclose: true,
        onChange: function(date) {
          changedeliveryDate();
        },
      });
      $("#cus_name").autocomplete({

          minLength: 0,
          source: siteUrl + '/' + "list_customer",
          focus: function(event, ui) {
            //console.log(ui);
            $("#cus_name").val(ui.item.name);
            return false;
          },
          select: function(event, ui) {

            var individualId = ui.item.id;

            getCustomerShipAddress(individualId);
            getCustomerBillAddress(individualId);
            $("#individual_id").val(ui.item.id);
            $("#cus_name").val(ui.item.name);
            $("#mobile").val(ui.item.phone);
            $("#phone").val(ui.item.phone);
            $("#email").val(ui.item.email);
            $("#gst_label").html(ui.item.gstin);
            $("#phone").html(ui.item.phone);
            return false;
          }
        })
        .autocomplete("instance")._renderItem = function(ul, item) {
          return $("<li>")
            .append("<div>" + item.name + "<br> GSTIN - " + item.gstin + "</div>")
            .appendTo(ul);
        };
      $('#cus_name').keyup(function() {
        if ($('#cus_name').val() === '') {
          $('#phone').hide();
          $("#gst_label").hide();
          $("#address").hide();
          $("#Shipaddress").hide();
        } else {
          //console.log("test");
          $('#phone').show();
          $("#gst_label").show();
          $("#address").show();
          $("#Shipaddress").show();
        }
      });
      //========================================================
      $("#product_name").autocomplete({


          minLength: 0,

          source: siteUrl + '/' + "fabric_list_item",
          focus: function(event, ui) {
            if (ui.item.part_number != '') {
              $("#product_name").val(ui.item.item_name);
              //$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code );
            } else {
              $("#product_name").val(ui.item.item_name);
            }
            return false;
          },
          select: function(event, ui) {


            // alert(ui.item.unit_type.unit_type_name);

            $("#pro_id").val(ui.item.item_id);
            $("#unit").val(ui.item.unit_type.unit_type_name);



            if (ui.item.part_number != '') {
              $("#product_name").val(ui.item.item_name);
              //$( "#product_name" ).val( ui.item.item_name + ' ' + ui.item.item_code);
            } else {
              $("#product_name").val(ui.item.item_name);
            }
            $("#mrp").val(ui.item.unit_price);
            $("#rate").val(ui.item.unit_price);
            $("#price").val(ui.item.unit_price);
            $("#final_price").val(ui.item.unit_price);
            $("#grey_quality").val(ui.item.internal_item_name);

            return false;

            calculateprice();


            return false;
          }
        })
        .autocomplete("instance")._renderItem = function(ul, item) {
          return $("<li>")
            //.append( "<div>" + item.item_name + " </div>" )
            .append("<div>" + item.item_name + "<br> Item Code: " + item.item_code + "<br> Internal Name:" + item.internal_item_name + " </div>")
            .appendTo(ul);
        };


      $('#sale_order_number').blur(function() {
        if ($('#sale_order_number').val().length > 2) {
          var id = $('#sale_order_number').val();
          $.ajax({
            type: "POST",
            url: siteUrl + '/' + "ajax_script/search_sale_order_number",
            data: {
              "_token": "{{ csrf_token() }}",
              "sale_order_number": id,
            },
            cache: false,
            success: function(res) {
              if (res != 1) {
                alert("You have entereds Duplicate Sale Order Number");
                $('#sale_order_number').val('').focus();
              }
            }
          })
        }
      });
    });



    function remove_tr(saleprice) {

      var total = 0;
      $('.total_arr').each(function() {
        // alert($(this).val());
        total = total + parseFloat($(this).val());
        // alert(total);
      });

      if (total.toFixed(2) > 0) {
        $('#total').val(total.toFixed(2)).trigger('change');
      } else {
        $('#total').val(0).trigger('change');
      }

      // alert($(this).html());
    }
  </script>

  <script>
    $(function() {
      $('#Add_To_Purchase').click(function() {
        if ($('#product_name').val() != '') {
          $("#resetBtn").show();
          $("#confirmBtn").show();

          if ($('#final_price').val() != 0) {
            var count_product = parseInt($('#count_product').val()) + 1;
            // alert(parseFloat($('#total').val()) +' -- '+ $('#final_price').val());
            var total = parseFloat($('#total').val()) + parseFloat($('#final_price').val());

            var new_pro2 = "<tr id='trr_" + count_product + "'>" +
              "<th><input readonly value='" + $('#product_name').val() + "' type='text' class='form-control' name='product_name_arr[]'></th>" +
              "<th><input readonly value='" + $('#grey_quality').val() + "' type='text' class='form-control' name='grey_quality[]'></th>" +
              "<th><input readonly value='" + $('#dyeing_color').val() + "' type='text' class='form-control' name='dyeing_color[]'></th>" +
              "<th><input readonly value='" + $('#coated_pvc').val() + "' type='text' class='form-control' name='coated_pvc[]'></th>" +
              "<th><input readonly value='" + $('#print_job').val() + "' type='text' class='form-control' name='print_job[]'></th>" +
              "<th><input readonly value='" + $('#extra_job').val() + "' type='text' class='form-control' name='extra_job[]'></th>" +
              "<th><input readonly value='" + $('#expect_delivery_date').val() + "' type='text' class='form-control' name='expect_delivery_date[]'></th>" +
              "</tr>";

            var new_pro = "<tr id='tr_" + count_product + "'>" +
              "<input value='" + $('#pro_id').val() + "' type='hidden' name='pro_id_arr[]' readonly><input value='" + $('#dis_type').val() + "' type='hidden' name='dis_type_arr[]' readonly>" +
              "<td><input readonly value='" + $('#unit').val() + "' type='text' class='form-control' name='unit_arr[]'></td>" +

              "<td><input readonly value='" + $('#pcs').val() + "' type='text' class='form-control' name='pcs_arr[]'></td>" +
              "<td><input readonly value='" + $('#cut').val() + "' type='text' class='form-control' name='cut_arr[]'></td>" +
              "<td><input readonly value='" + $('#meter').val() + "' type='text' class='form-control' name='meter_arr[]'></td>" +
              "<td><input readonly value='" + $('#rate').val() + "' type='text' class='form-control' name='rate_arr[]'></td>" +
              "<td><input readonly value='" + $('#amount').val() + "' type='text' class='form-control' name='amount_arr[]' readonly></td>" +
              "<td><input readonly value='" + $('#discount').val() + "' type='text' class='form-control' name='discount_arr[]' readonly></td>" +
              "<td><input readonly value='" + $('#discount_amount').val() + "' type='text' class='form-control' name='discount_amount_arr[]' readonly></td>" +
              "<td><input readonly value='" + $('#final_price').val() + "' type='text' class='form-control total_arr' name='total_arr[]'></td>" +
              "<td><input readonly value='" + $('#remarks').val() + "' type='text' class='form-control' name='remarks_arr[]'></td>" +
              "<td><input readonly value='" + $('#order_item_priority').val() + "' type='text' class='form-control' name='order_item_priority_arr[]'></td>" +


              "<td><a data-toggle='tooltip' href='javascript:void(0);' onclick='removeRows(\"trr_" + count_product + "\", \"tr_" + count_product + "\", " + $('#saleprice').val() + ");' title='Remove'><span class='glyphicon glyphicon-remove-circle remove' data-trid='tr_" + count_product + "' ></span></a></td>" +


              "</tr>";

            $('#trExt').append(new_pro2);
            $('#tbody').append(new_pro);
            $('#count_product').val(count_product);
            $('#product_name,#price,#saleprice').val('');
            $('#unit').val('1');
            $('#pcs').val('1');
            $('#cut').val('1');
            $('#meter').val('1');
            $('#rate').val('0');
            $('#mrp').val('0');
            $('#amount').val('');
            $('#remarks').val('');
            $('#grey_quality').val('');
            $('#dyeing_color').val('');
            $('#coated_pvc').val('');
            $('#extra_job').val('');
            $('#total').val(total.toFixed(2)).trigger('change');
            $('#pro_id').val(0);
            $('#saleprice').val('');
            $('#final_price').val('');
            $('#discount').val('0');
            $('#discount_amount').val('0');
            $('#product_name').focus();
          } else {
            alert("Please Check Discount/Quantity/Tax/Net Price");
            $('#discount').focus();

          }
        } else {
          $('#product_name').focus();
        }
      });

    });


    function removeRows(rowId1, rowId2, salePrice) {
      $("#" + rowId1).remove();
      $("#" + rowId2).remove();
      remove_tr(salePrice);
    }
  </script>

</body>

</html>