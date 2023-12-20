 <?php $cPath = Request::path();
// $cPath_1 = str_replace("","",$cPath);
$cPath_1 = $cPath;
$cPaths = explode("/", $cPath_1);
if(!isset($cPaths[1])) $cPaths[1] = '';
?>
<div class="sidebar">
   <!-- sidebar menu -->
   <ul class="sidebar-menu">
	  <li class="active">
		 <a href="{{ route('dashboard') }}"><i class="fa fa-tachometer"></i><span>Dashboard</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>

	   <li class="@if($cPaths[0]=='show-individuals' || $cPaths[0]=='edit-individual' || $cPaths[0]=='add-individuals') active @endif">
		 <a href="{{ route('show-individuals') }}">
		 <i class="fa fa-home"></i> <span>Individuals</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
      <li class="@if($cPaths[0]=='show-users') active @endif">
        <a href="{{ route('show-users') }}">
        <i class="fa fa-home"></i> <span>Users</span>
        <span class="pull-right-container">
        </span>
        </a>
     </li>
    
	  <li class="@if($cPaths[0]=='show-customers-individuals') active @endif">
		 <a href="{{ route('show-customers-individuals') }}">
		 <i class="fa fa-home"></i> <span>Cutomers Individuals List</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>

	  
	  <li class="@if($cPaths[0]=='show-master-individuals') active @endif">
		 <a href="{{ route('show-master-individuals') }}">
		 <i class="fa fa-home"></i> <span>Master Individuals List</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li class="@if($cPaths[0]=='show-agents-individuals') active @endif">
		 <a href="{{ route('show-agents-individuals') }}">
		 <i class="fa fa-home"></i> <span>Agents Individuals List</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li class="@if($cPaths[0]=='show-labourer-individuals') active @endif">
		 <a href="{{ route('show-labourer-individuals') }}">
		 <i class="fa fa-home"></i> <span>Labourer Individuals List</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>

	  <li class="@if($cPaths[0]=='show-vendors-individuals') active @endif">
		 <a href="{{ route('show-vendors-individuals') }}">
		 <i class="fa fa-home"></i> <span>Vendors Individuals List</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>

	  <li class="@if($cPaths[0]=='show-employee-individuals') active @endif">
		 <a href="{{ route('show-employee-individuals') }}">
		 <i class="fa fa-home"></i> <span>Employee Individuals List</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>


	  <li class="@if($cPaths[0]=='show-individuals') active @endif">
		 <a href="{{ route('show-transport-individuals') }}">
		 <i class="fa fa-home"></i> <span>Transport Individuals List</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  
	  
	   <li class="@if($cPaths[0]=='show-items' || $cPaths[0]=='edit-item' || $cPaths[0]=='add-item') active @endif">
		 <a href="{{ route('show-items') }}">
		 <i class="fa fa-home"></i> <span>Items</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  
	 
	  <li class="treeview @if($cPaths[0]=='show-warehouses' || $cPaths[0]=='edit-warehouse' || $cPaths[0]=='add-warehouse' || $cPaths[0]=='show-warehousecompartment' || $cPaths[0]=='edit-warehousecompartment' || $cPaths[0]=='add-warehousecompartment') active @endif">
		 <a href="javascript:void(0);"><i class="fa fa-edit"></i><span>Warehouse</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		 <ul class="treeview-menu">
			<li><a href="{{ route('show-warehouses') }}">Warehouses</a></li>
			<li><a href="{{ route('show-warehousecompartment') }}">Warehouse Compartment</a></li>			
		 </ul>
	  </li>
	   
	 
	 
	  <li class="treeview @if($cPaths[0]=='show' || $cPaths[0]=='edit' || $cPaths[0]=='add' || $cPaths[0]=='show-warehouse-stock-report' || $cPaths[0]=='show-warehouse-item-out' || $cPaths[0]=='add-warehouse-item-out' || $cPaths[0]=='show-warehouse-item-requirement') active @endif">
		 <a href="javascript:void(0);"><i class="fa fa-edit"></i><span>Warehouse Stock</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		 <ul class="treeview-menu">
			<li><a href="{{ route('show') }}">Warehouse Items</a></li>
			<li><a href="{{ route('show-warehouse-stock-report') }}">Warehouse Stock Report</a></li>
			<li><a href="{{ route('show-warehouse-item-out') }}">Warehouse Items Out</a></li>	
			<li><a href="{{ route('show-warehouse-item-requirement') }}">Warehouse Requirement</a></li>	
 
			
		 </ul>
	  </li>
      
	  
 
	  <li class="treeview @if($cPaths[0]=='show-purchases' || $cPaths[0]=='show-work-purchase-requirement' || $cPaths[0]=='edit-purchase' || $cPaths[0]=='add-purchase' || $cPaths[0]=='show-purchaseorders') active @endif">
		 <a href="javascript:void(0);"><i class="fa fa-edit"></i><span>Purchases</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		 <ul class="treeview-menu">
			<li><a href="{{ route('show-purchases') }}">Purchase Entry</a></li>
			<li><a href="{{ route('show-purchaseorders') }}">Purchase Orders</a></li>	
			<li><a href="{{ route('show-work-purchase-requirement') }}">Purchase Request</a></li>			
		 </ul>
	  </li>
	  
	  <li class="treeview @if($cPaths[0]=='show-saleorders' || $cPaths[0]=='edit-saleorder' || $cPaths[0]=='add-saleorder' || $cPaths[0]=='show-saleentries') active @endif">
		 <a href="javascript:void(0);"><i class="fa fa-edit"></i><span>Sale Order</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		 <ul class="treeview-menu">
			<li><a href="{{ route('show-saleentries') }}">Sale Entry</a></li>
			<li><a href="{{ route('show-saleorders') }}">Sale Orders</a></li>			
		 </ul>
	  </li>
	  
	  <li class="treeview @if($cPaths[0]=='show-workorders' || $cPaths[0]=='edit-workorder' || $cPaths[0]=='add-workorder' || $cPaths[0]=='show-workorder-report') active @endif">
		 <a href="javascript:void(0);"><i class="fa fa-edit"></i><span>Work Order</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		 <ul class="treeview-menu">
			<li><a href="{{ route('show-saleorderitems') }}">Create Work Order</a></li>
			<li><a href="{{ route('show-workorders') }}">Work Order</a></li>
			<li><a href="{{ route('show-workorder-report') }}">Work Order Report</a></li>			
		 </ul>
	  </li>
	   
	   <li class="treeview @if($cPaths[0]=='show-hsns' || $cPaths[0]=='edit-hsn' || $cPaths[0]=='add-hsn' || $cPaths[0]=='show-machines' || $cPaths[0]=='edit-machine' || $cPaths[0]=='add-machine' || $cPaths[0]=='show-stations' || $cPaths[0]=='edit-station' || $cPaths[0]=='add-station' || $cPaths[0]=='show-stationaries' || $cPaths[0]=='edit-stationary' || $cPaths[0]=='add-stationary' || $cPaths[0]=='show-cotings' || $cPaths[0]=='edit-coting' || $cPaths[0]=='add-coting' || $cPaths[0]=='show-vehicles' || $cPaths[0]=='edit-vehicle' || $cPaths[0]=='add-vehicle' || $cPaths[0]=='show-samplefolders' || $cPaths[0]=='edit-samplefolder' || $cPaths[0]=='add-samplefolder' || $cPaths[0]=='show-papertubes' || $cPaths[0]=='edit-papertube' || $cPaths[0]=='add-papertube' || $cPaths[0]=='show-greys' || $cPaths[0]=='edit-grey' || $cPaths[0]=='add-grey' || $cPaths[0]=='show-finishedfabrics' || $cPaths[0]=='edit-finishedfabric' || $cPaths[0]=='add-finishedfabric' || $cPaths[0]=='show-dyedfabrics' || $cPaths[0]=='edit-dyedfabric' || $cPaths[0]=='add-dyedfabric' || $cPaths[0]=='show-departments' || $cPaths[0]=='edit-department' || $cPaths[0]=='add-department' || $cPaths[0]=='show-colours' || $cPaths[0]=='edit-colour' || $cPaths[0]=='add-colour' || $cPaths[0]=='show-coatedfabrics' || $cPaths[0]=='edit-coatedfabric' || $cPaths[0]=='add-coatedfabric' || $cPaths[0]=='show-unittypes' || $cPaths[0]=='edit-unittype' || $cPaths[0]=='add-unittype' || $cPaths[0]=='show-itemtypes' || $cPaths[0]=='edit-itemtypes' || $cPaths[0]=='add-itemtypes' || $cPaths[0]=='show-qualitytypes' || $cPaths[0]=='edit-qualitytype' || $cPaths[0]=='add-qualitytype' || $cPaths[0]=='show-packagings' || $cPaths[0]=='edit-packaging' || $cPaths[0]=='add-packaging' || $cPaths[0]=='show-individualaddresses' || $cPaths[0]=='edit-individualaddress' || $cPaths[0]=='add-individualaddress' || $cPaths[0]=='show-brands' || $cPaths[0]=='edit-brand' || $cPaths[0]=='add-brand' || $cPaths[0]=='show-chemicals' || $cPaths[0]=='edit-chemical' || $cPaths[0]=='add-chemical' || $cPaths[0]=='show-banks' || $cPaths[0]=='edit-bank' || $cPaths[0]=='add-bank' || $cPaths[0]=='show-bankaccounts' || $cPaths[0]=='edit-bankaccount' || $cPaths[0]=='add-bankaccount' || $cPaths[0]=='show-accountgroups' || $cPaths[0]=='edit-accountgroup' || $cPaths[0]=='add-accountgroup' || $cPaths[0]=='show-usermoduleassignments' || $cPaths[0]=='edit-usermoduleassignment' || $cPaths[0]=='add-usermoduleassignment' || $cPaths[0]=='show-dyings' || $cPaths[0]=='edit-dying' || $cPaths[0]=='add-dying' || $cPaths[0]=='show-bims' || $cPaths[0]=='edit-bim' || $cPaths[0]=='add-bim' || $cPaths[0]=='show-modules' || $cPaths[0]=='edit-module' || $cPaths[0]=='add-module' || $cPaths[0]=='show-departments' || $cPaths[0]=='edit-department' || $cPaths[0]=='add-department' || $cPaths[0]=='show-notifications' || $cPaths[0]=='edit-notification' || $cPaths[0]=='add-notification' ||  $cPaths[0]=='show-qualities' || $cPaths[0]=='edit-quality' || $cPaths[0]=='add-quality') active @endif">	   
		 <a href="javascript:void(0);">
		 <i class="fa fa-users"></i><span>Masters</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="{{ route('show-hsns') }}">Show HSNS</a></li>
			<li><a href="{{ route('show-machines') }}">Machine </a></li>
			<li><a href="{{ route('show-stations') }}">Station</a></li>
			<li><a href="{{ route('show-stationaries') }}">Stationary</a></li>
			<li><a href="{{ route('show-cotings') }}">Coting</a></li>
			<li><a href="{{ route('show-vehicles') }}"> Vehicle  </a></li>
			<li><a href="{{ route('show-samplefolders') }}"> Sample Folder </a></li>
			<li><a href="{{ route('show-papertubes') }}"> Papertube </a></li>
			<li><a href="{{ route('show-greys') }}"> Greys </a></li>
			<li><a href="{{ route('show-finishedfabrics') }}"> Finished Fabrics </a></li>
			<li><a href="{{ route('show-dyedfabrics') }}"> Dyed Fabric </a></li>
			<li><a href="{{ route('show-departments') }}"> Departments </a></li>
			<li><a href="{{ route('show-colours') }}"> Colours </a></li>
			<li><a href="{{ route('show-coatedfabrics') }}"> Coted Fabrics </a></li>
			<li><a href="{{ route('show-unittypes') }}"> Unit Types </a></li>
			<li><a href="{{ route('show-itemtypes') }}"> Item Types </a></li>
			<li><a href="{{ route('show-qualitytypes') }}"> Quality Types </a></li>
			<li><a href="{{ route('show-packagings') }}"> Packagings </a></li>
			<li><a href="{{ route('show-individualaddresses') }}"> Individual Addresses </a></li>
			<li><a href="{{ route('show-brands') }}"> Brands </a></li>
			<li><a href="{{ route('show-chemicals') }}"> Chemicals </a></li>
			<li><a href="{{ route('show-banks') }}"> Banks </a></li>
			<li><a href="{{ route('show-bankaccounts') }}"> Bank Account </a></li>
			<li><a href="{{ route('show-accountgroups') }}"> Account Group </a></li>
			<li><a href="{{ route('show-usermoduleassignments') }}">User Module Assignments</a></li>
			<li><a href="{{ route('show-dyings') }}">Dyings</a></li>
			<li><a href="{{ route('show-bims') }}">Beams</a></li>
			<li><a href="{{ route('show-modules') }}">Modules</a></li>
			<li><a href="{{ route('show-notifications') }}">Notifications</a></li>
			<li><a href="{{ route('show-qualities') }}">Qualities</a></li> 
		 </ul>
	  </li> 
   </ul>
</div>
<!-- /.sidebar -->
