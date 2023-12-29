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
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-sm-12"> {!! CommonController::display_message('message') !!}
            <div class="panel panel-bd lobidrag">
              <div class="panel-heading">
                <div class="btn-group" id="buttonexport">
                  <h4>Individual List</h4>
                  </a>
                </div>
              </div>
              <div class="panel-body">
                <div class="row" style="margin-bottom:5px">
                  <form action="{{ route('show-individuals') }}" method="GET" role="search">
                    @csrf
                    <div class="col-sm-4 col-xs-12">
                      <input type="text" class="form-control" name="qsearch" id="qsearch" value="" placeholder="Search by Name, Email, Company Name, GSTIN, Nick Name, ">
                    </div>

                    <div class="col-sm-2 col-xs-12">
                      <input type="submit" name="sbtSearch" class="btn btn-success" value="Search">
                    </div>
                  </form>
                  <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-exp btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                    <ul class="dropdown-menu exp-drop" role="menu">
                      <li class="divider"></li>
                      <li> <a href="javascript:void(0);" onClick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});"> <img src="assets/dist/img/xls.png" width="24" alt="logo"> XLS</a> </li>
                    </ul>
                  </div>
                  <!-- <div class="col-sm-2 col-xs-12"> <a class="btn btn-add" href="add-individual"> <i class="fa fa-plus"></i> Add Individual </a> </div> -->
                </div>
                <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                <div class="table-responsive">
                  <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="info">
                        <th style="text-align: center;">Transport Name</th>
                        <th style="text-align: center;">Mobile</th>
                        <th style="text-align: center;">Phone</th>
                        <th style="text-align: center;">Email</th>
                        <!---	<th style="text-align: center;">Company Name</th> ----->
                        <th style="text-align: center;">GSTN</th>
                        <th style="text-align: center;">Booking Date</th>
                        <th style="text-align: center;">LR Number</th>
                        <th style="text-align: center;">From Station</th>
                        <th style="text-align: center;">To Station</th>
                        <th style="text-align: center;">Remarks</th>
                        <th style="text-align: center;">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($dataI as $data)
                      <?php
                      $id =  base64_encode($data->id);
                      // echo "<pre>"; print_r($data['User']);// exit;
                      ?>
                      <tr id="Mid{{ $data->id }}">
                        <td> {{ $data->transport_name }} </td>
                        <td> {{ $data->mobile }} </td>
                        <td> {{ $data->phone }} </td>
                        <td> {{ $data->email }} </td>
                        <td> {{ $data->gstin }} </td>
                        <td> {{ date("d-m-Y",strtotime($data->booking_date)) }} </td>
                        <td> {{ $data->lr_number }} </td>
                        <td> {{ $data->locationDetailsFrom->station }} </td>
                        <td> {{ $data->locationDetailsTo->station }} </td>
                        <td> {{ $data->remark }} </td>
                        <td>

                          <a href="edit-individual/{{ $id }}" class="tooltip-info" title="Edit indivisual"><i class="fa fa-pencil"></i></a> &nbsp;
                        </td>


                      </tr>
                      @endforeach

                      <tr class="center text-center">
                        <td class="center" colspan="11">
                          <div class="pagination">
                            <span class="pagination-links">
                              {{ $dataI->links('vendor.pagination.bootstrap-4') }}
                            </span>
                            <span class="manual-page-input">
                              <label for="manualPageInput">Go to page:</label>
                              <input type="number" id="manualPageInput" min="1" max="{{ $dataI->lastPage() }}" value="{{ $dataI->currentPage() }}">
                              <button class="btn btn-sm btn-success" id="goToPageButton">Go</button>
                            </span>
                          </div>
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
    document.getElementById('goToPageButton').addEventListener('click', function() {
      var pageInput = document.getElementById('manualPageInput').value;
      if (pageInput > 0 && pageInput <= {
          {
            $dataI - > lastPage()
          }
        }) {
        var baseUrl = window.location.href.split('?')[0];
        var params = new URLSearchParams(window.location.search);
        params.set('page', pageInput);
        window.location.href = baseUrl + '?' + params.toString();
      }
    });
  </script>
  <script type="text/javascript">
    var siteUrl = "{{url('/')}}";

    function deleteIndividual(id) {
      if (confirm("Do you realy want to delete this record?")) {
        jQuery.ajax({
          type: "GET",
          url: siteUrl + '/' + "ajax_script/deleteIndividual",
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