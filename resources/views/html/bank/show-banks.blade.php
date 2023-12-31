<?php	 
	use App\Http\Controllers\CommonController;
?>
<!DOCTYPE html>
<html lang="en">
<head>@include('common.head')
</head>
<body class="hold-transition sidebar-mini">
     
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('common.header')
       <div class="content-wrapperd">
            <!-- Content Header (Page header) -->


            <!-- Main content -->
            {!! CommonController::display_message('message') !!}
            <section class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-heading">
                                <div class="btn-group" id="buttonexport">


                                        <h4> Bank</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                                <div class="row" style="margin-bottom:5px">
                                    <form action="{{ route('show-banks') }}" method="GET" role="search">
                                      @csrf
                                      <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" name="search" placeholder="Search..."
                                        value="{{ request()->query('search') }}" />
                                      </div>



                                      <div class="col-sm-2 col-xs-12">
                                        <button class="btn btn-add">Search</button>
                                      </div>
                                      </form>


                                      <div class="col-sm-2 col-xs-12">
                                       <button class="btn btn-exp btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button>
                                          <ul class="dropdown-menu exp-drop" role="menu">

                                             <li class="divider"></li>

                                             <li>
                                                <a href="javascript:void(0);" onclick="$('#dataTableExample1').tableExport({type:'excel',escape:'false'});">
                                                <img src="assets/dist/img/xls.png" width="24" alt="logo"> XLS</a>
                                             </li>

                                          </ul>

                                      </div>

                                     <div class="col-sm-2 col-xs-12">
                                        <a class="btn btn-add" href="add-bank"> <i class="fa fa-plus"></i> Add
                                            Bank
                                        </a>
                                      </div>
                                    </div>
                                <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                                <div class="table-responsive">
                                    <table id="dataTableExample1"
                                        class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th> Name </th>
                                                <th>Action</th>
                                                <th>Delete </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($dataP as $data)
                                                <tr id="Mid{{ $data->id }}">
                                                    <td> {{ $data->bank_name }} </td>
                                                    <td><a href="edit-bank/{{ base64_encode($data->id) }}"
                                                            class="tooltip-info"><i class="fa fa-pencil"></i></a></td>
                                                    <td class="center"><a href="javascript:void(0);"
                                                            onclick="deleteBank({{ $data->id }})"
                                                            class="btn btn-danger btn-xs"><i
                                                                class="fa fa-trash-o"></i></a> </td>
                                                </tr>
                                            @endforeach

                                            <tr class="center text-center">
                                                <td class="center" colspan="5"><div class="pagination">{{ $dataP->links() }}</div></td>
                                               </tr>


                                        </tbody>
                                    </table>
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
            <script type="text/javascript">
			var siteUrl = "{{url('/')}}";
                function deleteBank(id) {
                    if (confirm("Do you realy want to delete this record?")) {
                        jQuery.ajax({
                            type: "GET",
                            url: siteUrl + '/' +"ajax_script/deleteBank",
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

