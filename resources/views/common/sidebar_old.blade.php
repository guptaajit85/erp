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
	   
	 
	 
	  <li class="treeview @if($cPaths[0]=='show' || $cPaths[0]=='edit' || $cPaths[0]=='add' || $cPaths[0]=='show-warehouse-item-out' || $cPaths[0]=='add-warehouse-item-out') active @endif">
		 <a href="javascript:void(0);"><i class="fa fa-edit"></i><span>Warehouse Stock</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		 <ul class="treeview-menu">
			<li><a href="{{ route('show') }}">Warehouse Items</a></li>
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

		 

	  
	  
	  
 
	   
	 <?php /* ?>  <li class="@if($cPaths[0]=='show-persons' || $cPaths[0]=='edit-person' || $cPaths[0]=='add-person') active @endif">
		 <a href="{{ route('show-persons') }}">
		 <i class="fa fa-home"></i> <span>Persons</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li> <?php */ ?>
	  
	  <!----

	   <li class="@if($cPaths[0]=='show-qualities' || $cPaths[0]=='edit-quality' || $cPaths[0]=='add-quality') active @endif">
		 <a href="{{ route('show-qualities') }}">
		 <i class="fa fa-home"></i> <span>Qualities</span>
	      <span class="pull-right-container"> </span>
		 </a>
	  </li>

	  <li class="@if($cPaths[0]=='show-notifications' || $cPaths[0]=='edit-notification' || $cPaths[0]=='add-notification') active @endif">
		 <a href="{{ route('show-notifications') }}">
		 <i class="fa fa-home"></i> <span>Notifications</span>
	      <span class="pull-right-container"> </span>
		 </a>
	  </li> 

	   <li class="@if($cPaths[0]=='show-departments' || $cPaths[0]=='edit-department' || $cPaths[0]=='add-department') active @endif">
		 <a href="{{ route('show-departments') }}">
		 <i class="fa fa-home"></i> <span>Departments</span>

		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>

	  <li class="@if($cPaths[0]=='show-modules' || $cPaths[0]=='edit-module' || $cPaths[0]=='add-module') active @endif">
		 <a href="{{ route('show-modules') }}">
		 <i class="fa fa-home"></i> <span>Modules</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  
	   <li class="@if($cPaths[0]=='show-bims' || $cPaths[0]=='edit-bim' || $cPaths[0]=='add-bim') active @endif">
		 <a href="{{ route('show-bims') }}">
		 <i class="fa fa-home"></i> <span>Beams</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  
	  <li class="@if($cPaths[0]=='show-dyings' || $cPaths[0]=='edit-dying' || $cPaths[0]=='add-dying') active @endif">
		 <a href="{{ route('show-dyings') }}">
		 <i class="fa fa-home"></i> <span>Dyings</span>
		<span class="pull-right-container">
		 </span>
		 </a>
	  </li>

      <li class="@if($cPaths[0]=='show-usermoduleassignments' || $cPaths[0]=='edit-usermoduleassignment' || $cPaths[0]=='add-usermoduleassignment') active @endif">
        <a href="{{ route('show-usermoduleassignments') }}">
        <i class="fa fa-home"></i> <span>User Module Assignments</span>

        <span class="pull-right-container">
        </span>
        </a>
     </li>
 
	   <li class="@if($cPaths[0]=='show-accountgroups' || $cPaths[0]=='edit-accountgroup' || $cPaths[0]=='add-accountgroup') active @endif">
		 <a href="{{ route('show-accountgroups') }}">
		 <i class="fa fa-home"></i> <span>Account Group</span>

		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li> 
	  
	   <li class="@if($cPaths[0]=='show-bankaccounts' || $cPaths[0]=='edit-bankaccount' || $cPaths[0]=='add-bankaccount') active @endif">
		 <a href="{{ route('show-bankaccounts') }}">
		 <i class="fa fa-home"></i> <span>Bank Account</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-banks' || $cPaths[0]=='edit-bank' || $cPaths[0]=='add-bank') active @endif">
		 <a href="{{ route('show-banks') }}">
		 <i class="fa fa-home"></i> <span>Banks</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-chemicals' || $cPaths[0]=='edit-chemical' || $cPaths[0]=='add-chemical') active @endif">
		 <a href="{{ route('show-chemicals') }}">
		 <i class="fa fa-home"></i> <span>Chemicals</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

       <li class="@if($cPaths[0]=='show-brands' || $cPaths[0]=='edit-brand' || $cPaths[0]=='add-brand') active @endif">
        <a href="{{ route('show-brands') }}">
        <i class="fa fa-home"></i> <span>Brands</span>
        <span class="pull-right-container">
        </span>
        </a>
      </li>

      <li class="@if($cPaths[0]=='show-individualaddresses' || $cPaths[0]=='edit-individualaddress' || $cPaths[0]=='add-individualaddress') active @endif">
        <a href="{{ route('show-individualaddresses') }}">
        <i class="fa fa-home"></i> <span>Individual Addresses</span>
        <span class="pull-right-container">
        </span>
        </a>
      </li>

      <li class="@if($cPaths[0]=='show-packagings' || $cPaths[0]=='edit-packaging' || $cPaths[0]=='add-packaging') active @endif">
        <a href="{{ route('show-packagings') }}">
        <i class="fa fa-home"></i> <span>Packagings</span>
        <span class="pull-right-container">
        </span>
        </a>
      </li>

      <li class="@if($cPaths[0]=='show-qualitytypes' || $cPaths[0]=='edit-qualitytype' || $cPaths[0]=='add-qualitytype') active @endif">
        <a href="{{ route('show-qualitytypes') }}">
        <i class="fa fa-home"></i> <span>Quality Types</span>
        <span class="pull-right-container">
        </span>
        </a>
      </li>

	  <li class="@if($cPaths[0]=='show-itemtypes' || $cPaths[0]=='edit-itemtypes' || $cPaths[0]=='add-itemtypes') active @endif">
		 <a href="{{ route('show-itemtypes') }}">
		 <i class="fa fa-home"></i> <span>Item Types</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
  
      <li class="@if($cPaths[0]=='show-unittypes' || $cPaths[0]=='edit-unittype' || $cPaths[0]=='add-unittype') active @endif">
        <a href="{{ route('show-unittypes') }}">
        <i class="fa fa-home"></i> <span>Unit Types</span>
        <span class="pull-right-container">
        </span>
        </a>
      </li>

	   <li class="@if($cPaths[0]=='show-coatedfabrics' || $cPaths[0]=='edit-coatedfabric' || $cPaths[0]=='add-coatedfabric') active @endif">
		 <a href="{{ route('show-coatedfabrics') }}">
		 <i class="fa fa-home"></i> <span>Coted Fabrics</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-colours' || $cPaths[0]=='edit-colour' || $cPaths[0]=='add-colour') active @endif">
		 <a href="{{ route('show-colours') }}">
		 <i class="fa fa-home"></i> <span>Colours</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>
 
	   <li class="@if($cPaths[0]=='show-departments' || $cPaths[0]=='edit-department' || $cPaths[0]=='add-department') active @endif">
		 <a href="{{ route('show-departments') }}">
		 <i class="fa fa-home"></i> <span>Department</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>
	   
	   <li class="@if($cPaths[0]=='show-dyedfabrics' || $cPaths[0]=='edit-dyedfabric' || $cPaths[0]=='add-dyedfabric') active @endif">
		 <a href="{{ route('show-dyedfabrics') }}">
		 <i class="fa fa-home"></i> <span>Dyed Fabric</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-finishedfabrics' || $cPaths[0]=='edit-finishedfabric' || $cPaths[0]=='add-finishedfabric') active @endif">
		 <a href="{{ route('show-finishedfabrics') }}">
		 <i class="fa fa-home"></i> <span>Finished Fabrics</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-greys' || $cPaths[0]=='edit-grey' || $cPaths[0]=='add-grey') active @endif">
		 <a href="{{ route('show-greys') }}">
		 <i class="fa fa-home"></i> <span>Greys</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>
	   
	   <li class="@if($cPaths[0]=='show-papertubes' || $cPaths[0]=='edit-papertube' || $cPaths[0]=='add-papertube') active @endif">
		 <a href="{{ route('show-papertubes') }}">
		 <i class="fa fa-home"></i> <span>Papertube</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-samplefolders' || $cPaths[0]=='edit-samplefolder' || $cPaths[0]=='add-samplefolder') active @endif">
		 <a href="{{ route('show-samplefolders') }}">
		 <i class="fa fa-home"></i> <span>Sample Folder</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>
	   
	   <li class="@if($cPaths[0]=='show-vehicles' || $cPaths[0]=='edit-vehicle' || $cPaths[0]=='add-vehicle') active @endif">
		 <a href="{{ route('show-vehicles') }}">
		 <i class="fa fa-home"></i> <span>Vehicle</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>
	  
	   <li class="@if($cPaths[0]=='show-cotings' || $cPaths[0]=='edit-coting' || $cPaths[0]=='add-coting') active @endif">
		 <a href="{{ route('show-cotings') }}">
		 <i class="fa fa-home"></i> <span>Coting</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-stationaries' || $cPaths[0]=='edit-stationary' || $cPaths[0]=='add-stationary') active @endif">
		 <a href="{{ route('show-stationaries') }}">
		 <i class="fa fa-home"></i> <span>Stationary</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-stations' || $cPaths[0]=='edit-station' || $cPaths[0]=='add-station') active @endif">
		 <a href="{{ route('show-stations') }}">
		 <i class="fa fa-home"></i> <span>Station</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>
	   
	   <li class="@if($cPaths[0]=='show-machines' || $cPaths[0]=='edit-machine' || $cPaths[0]=='add-machine') active @endif">
		 <a href="{{ route('show-machines') }}">
		 <i class="fa fa-home"></i> <span>Machine</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>

	   <li class="@if($cPaths[0]=='show-hsns' || $cPaths[0]=='edit-hsn' || $cPaths[0]=='add-hsn') active @endif">
		 <a href="{{ route('show-hsns') }}">
		 <i class="fa fa-home"></i> <span>Hsn</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	   </li>
	   
	   ---------->
	 
	 <!--- <li class="treeview">
		 <a href="">
		 <i class="fa fa-users"></i><span>Customers</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="add-customer.html">Add Customer</a></li>
			<li><a href="clist.html">List</a></li>
			<li><a href="group.html">Groups</a></li>
		 </ul>
	  </li>
	  ---->
	  <?php /* ?>

	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-shopping-basket"></i><span>Transaction</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="deposit.html">New Deposit</a></li>
			<li><a href="expense.html">New Expense</a></li>
			<li><a href="transfer.html">Transfer</a></li>
			<li><a href="view-tsaction.html">View transaction</a></li>
			<li><a href="balance.html">Balance Sheet</a></li>
			<li><a href="treport.html">Transfer Report</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-shopping-cart"></i><span>Sales</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="invoice.html">Invoices</a></li>
			<li><a href="ninvoices.html">New Invoices</a></li>
			<li><a href="recurring.html">Recurring invoices</a></li>
			<li><a href="nrecurring.html">New Recurring invoices</a></li>
			<li><a href="quote.html">quotes</a></li>
			<li><a href="nquote.html">New quote</a></li>
			<li><a href="payment.html">Payments</a></li>
			<li><a href="taxeport.html">Tax Rates</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-book"></i><span>Task</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="rtask.html">Running Task</a></li>
			<li><a href="atask.html">Archive Task</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-shopping-bag"></i><span>Accounting</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="cpayment.html">Client payment</a></li>
			<li><a href="emanage.html">Expense management</a></li>
			<li><a href="ecategory.html">Expense Category</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-file-text"></i><span>Report</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="preport.html">Project Report</a></li>
			<li><a href="creport.html">Client Report</a></li>
			<li><a href="ereport.html">Expense Report</a></li>
			<li><a href="incomexp.html">Income expense comparesion</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-bell"></i><span>Attendance</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="thistory.html">Time History</a></li>
			<li><a href="timechange.html">Time Change Request</a></li>
			<li><a href="atreport.html">Attendance Report</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-edit"></i><span>Recruitment</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="jpost.html">Jobs Posted</a></li>
			<li><a href="japp.html">Jobs Application</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-shopping-basket"></i><span>payroll</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="salary.html">Salary Template</a></li>
			<li><a href="hourly.html">Hourly</a></li>
			<li><a href="managesal.html">Manage salary</a></li>
			<li><a href="empsallist.html">Employee salary list</a></li>
			<li><a href="mpayment.html">Make payment</a></li>
			<li><a href="generatepay.html">Generate payslip</a></li>
			<li><a href="paysum.html">Payroll summary</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-bitbucket-square"></i><span>Stock</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="stockcat.html">Stock category</a></li>
			<li><a href="manstock.html">Manage Stock</a></li>
			<li><a href="astock.html">Assign stock</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-ticket"></i><span>Tickets</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="ticanswer.html">Answered</a></li>
			<li><a href="ticopen.html">Open</a></li>
			<li><a href="iprocess.html">Inprocess</a></li>
			<li><a href="close.html">CLosed</a></li>
			<li><a href="allticket.html">All Tickets</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-list"></i>
		 <span>Utilities</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="ativitylog.html">Activity Log</a></li>
			<li><a href="emailmes.html">Email message log</a></li>
			<li><a href="systemsts.html">System status</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-bar-chart"></i><span>Charts</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li class=""><a href="charts_flot.html">Flot Chart</a></li>
			<li><a href="charts_Js.html">Chart js</a></li>
			<li><a href="charts_morris.html">Morris Charts</a></li>
			<li><a href="charts_sparkline.html">Sparkline Charts</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-briefcase"></i>
		 <span>Icons</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="icons_bootstrap.html">Bootstrap Icons</a></li>
			<li><a href="icons_fontawesome.html">Fontawesome Icon</a></li>
			<li><a href="icons_flag.html">Flag Icons</a></li>
			<li><a href="icons_material.html">Material Icons</a></li>
			<li><a href="icons_weather.html">Weather Icons </a></li>
			<li><a href="icons_line.html">Line Icons</a></li>
			<li><a href="icons_pe.html">Pe Icons</a></li>
			<li><a href="icon_socicon.html">Socicon Icons</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-list"></i> <span>Other page</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="login.html">Login</a></li>
			<li><a href="register.html">Register</a></li>
			<li><a href="profile.html">Profile</a></li>
			<li><a href="forget_password.html">Forget password</a></li>
			<li><a href="lockscreen.html">Lockscreen</a></li>
			<li><a href="404.html">404 Error</a></li>
			<li><a href="505.html">505 Error</a></li>
			<li><a href="blank.html">Blank Page</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-bitbucket"></i><span>UI Elements</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="buttons.html">Buttons</a></li>
			<li><a href="tabs.html">Tabs</a></li>
			<li><a href="notification.html">Notification</a></li>
			<li><a href="tree-view.html">Tree View</a></li>
			<li><a href="progressbars.html">Progressber</a></li>
			<li><a href="list.html">List View</a></li>
			<li><a href="typography.html">Typography</a></li>
			<li><a href="panels.html">Panels</a></li>
			<li><a href="modals.html">Modals</a></li>
			<li><a href="icheck_toggle_pagination.html">iCheck, Toggle, Pagination</a></li>
			<li><a href="labels-badges-alerts.html">Labels, Badges, Alerts</a></li>
		 </ul>
	  </li>
	  <li class="treeview">
		 <a href="#">
		 <i class="fa fa-gear"></i>
		 <span>settings</span>
		 <span class="pull-right-container">
		 <i class="fa fa-angle-left pull-right"></i>
		 </span>
		 </a>
		 <ul class="treeview-menu">
			<li><a href="gsetting.html">Genaral settings</a></li>
			<li><a href="stfsetting.html">Staff settings</a></li>
			<li><a href="emailsetting.html">Email settings</a></li>
			<li><a href="paysetting.html">Payment</a></li>
		 </ul>
	  </li>
	  <li>
		 <a href="company.html">
		 <i class="fa fa-home"></i> <span>Companies</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="holiday.html">
		 <i class="fa fa-stop-circle"></i> <span>Public Holiday</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="user.html">
		 <i class="fa fa-user-circle"></i><span>User</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="items.html">
		 <i class="fa fa-file-o"></i><span>Items</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="department.html">
		 <i class="fa fa-tree"></i><span>Departments</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="document.html">
		 <i class="fa fa-file-text"></i> <span>Documents</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="train.html">
		 <i class="fa fa-clock-o"></i><span>Training</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="calender.html">
		 <i class="fa fa-calendar"></i> <span>Calender</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="notice.html">
		 <i class="fa fa-file-text"></i> <span>Notice Board</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="message.html">
		 <i class="fa fa-envelope-o"></i> <span>Message</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>
	  <li>
		 <a href="note.html">
		 <i class="fa fa-comment"></i> <span>Notes</span>
		 <span class="pull-right-container">
		 </span>
		 </a>
	  </li>   <?php */ ?>
   
   </ul>
</div>
<!-- /.sidebar -->
