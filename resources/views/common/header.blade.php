<?php 
use App\Http\Controllers\CommonController;
	$currentUrl = request()->url(); 
	$path 		= parse_url($currentUrl, PHP_URL_PATH); 		
	$segments 	= explode('/', $path); 
	$pageName	= $segments[1];
	// echo $segments[1]; 
	// $checkPage = CommonController::checkPagePermission($pageName);
	 
?>
<header class="main-header"> <a href="{{ route('dashboard') }}" class="logo">
  <!-- Logo -->
  <span class="logo-mini"> <img src="{{ asset('assets/dist/img/mini-logo.png') }}"> </span> <span class="logo-lg"> <img src="{{ asset('assets/dist/img/logo.png') }}"> </span> </a>
 
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">		
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Daily Entry<span class="caret"></span></a>
            <ul class="dropdown-menu">
				<?php
					$addSaleEntry 	= CommonController::checkPagePermission('add-saleentry');
					$addSaleOrder 	= CommonController::checkPagePermission('add-saleorder');
				?>

				<?php if ($addSaleEntry ==1 || $addSaleOrder ==1) { ?>
				  <li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Sale </a>
					<ul class="dropdown-menu">
					  <?php if ($addSaleEntry) { ?>
						<li><a href="{{ route('add-saleentry') }}">Add Sale Entry</a></li>
					  <?php } ?>

					  <?php if ($addSaleOrder) { ?>
						<li><a href="{{ route('add-saleorder') }}">Add Sale Order</a></li>
					  <?php } ?>
					</ul>
				  </li>
				<?php } ?>

			
				<?php
				$addPurchase 		= CommonController::checkPagePermission('add-purchase');
				$addPurchaseOrder 	= CommonController::checkPagePermission('add-purchaseorder');
				?>

				<?php if ($addPurchase ==1 || $addPurchaseOrder ==1) { ?>
				  <li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Purchase </a>
					<ul class="dropdown-menu">
					  <?php if ($addPurchase) { ?>
						<li><a href="{{ route('add-purchase') }}">Add Purchase Entry</a></li>
					  <?php } ?>

					  <?php if ($addPurchaseOrder) { ?>
						<li><a href="{{ route('add-purchaseorder') }}">Add Purchase Order</a></li>
					  <?php } ?>
					</ul>
				  </li>
				<?php } ?>

			
				<?php
				$showSaleOrderItems 	= CommonController::checkPagePermission('show-saleorderitems');
				$showWorkOrders 		= CommonController::checkPagePermission('show-workorders');
				?>

				<?php if ($showSaleOrderItems ==1 || $showWorkOrders ==1) { ?>
				  <li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Work Order </a>
					<ul class="dropdown-menu">
					  <?php if ($showSaleOrderItems) { ?>
						<li><a href="{{ route('show-saleorderitems') }}">Create Work Order</a></li>
					  <?php } ?>

					  <?php if ($showWorkOrders) { ?>
						<li><a href="{{ route('show-workorders') }}">Work Order Process</a></li>
					  <?php } ?>             
					</ul>
				  </li>
				<?php } ?>

			  
				<?php
					$addItemInWarehouse  = CommonController::checkPagePermission('add-item-in-warehouse');
					$showPurchaseRequest = CommonController::checkPagePermission('add-purchase-request');
					$showWaeItemReirment = CommonController::checkPagePermission('show-warehouse-item-requirement');
					$showWorkOrderReport = CommonController::checkPagePermission('show-workorder-report');
				?>

				<?php if ($addItemInWarehouse ==1 || $showPurchaseRequest ==1 || $showWaeItemReirment ==1 || $showWorkOrderReport ==1) { ?>
				  <li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Warehouse Stock </a>
					<ul class="dropdown-menu">
					  <?php if ($addItemInWarehouse) { ?>
						<li><a href="{{ route('add-item-in-warehouse') }}">Add Item in Warehouse</a></li>
					  <?php } ?>

					  <?php if ($showPurchaseRequest) { ?>
						<li><a href="{{ route('add-purchase-request') }}">Add Purchase Request</a></li>
					  <?php } ?>

					  <?php if ($showWaeItemReirment) { ?>
						<li><a href="{{ route('show-warehouse-item-requirement') }}">Warehouse Requirement</a></li>
					  <?php } ?>

					  <?php if ($showWorkOrderReport) { ?>
						<li><a href="{{ route('show-workorder-report') }}">Stock In Ward</a></li>
					  <?php } ?>
					</ul>
				  </li>
				<?php } ?>

			  
				<?php
					$addPackaging 		= CommonController::checkPagePermission('add-packaging');
					$showPackagings 	= CommonController::checkPagePermission('show-packagings');
					?>

					<?php if ($addPackaging ==1 || $showPackagings ==1) { ?>
					  <li class="dropdown-submenu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Packaging </a>
						<ul class="dropdown-menu">
						  <?php if ($addPackaging) { ?>
							<li><a href="{{ route('add-packaging') }}">Add Package</a></li>
						  <?php } ?>

						  <?php if ($showPackagings) { ?>
							<li><a href="{{ route('show-packagings') }}">Packaging List</a></li>
						  <?php } ?>
						</ul>
					  </li>
					<?php } ?>

			   
            </ul>
          </li>
		  
         <li class="dropdown"> 
			<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Report<span class="caret"></span></a>
			<ul class="dropdown-menu">

				<?php 
					$showSaleentries 	= CommonController::checkPagePermission('show-saleentries'); 
					$showSaleorders 	= CommonController::checkPagePermission('show-saleorders'); 
				?> 

				<?php if ($showSaleentries ==1 || $showSaleorders ==1) { ?>
					<li class="dropdown-submenu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Sale </a>
						<ul class="dropdown-menu">
							<?php if (!empty($showSaleentries)) { ?> <li><a href="{{ route('show-saleentries') }}">Sale Entry</a></li> <?php } ?>
							<?php if (!empty($showSaleorders)) { ?> <li><a href="{{ route('show-saleorders') }}">Sale Order</a></li> <?php } ?>
						</ul>
					</li>
				<?php } ?>

				<?php 
					$showpurchases 			= CommonController::checkPagePermission('show-purchases'); 
					$showpurchaseorders 	= CommonController::checkPagePermission('show-purchaseorders'); 
					$showworkPurRequ 		= CommonController::checkPagePermission('show-work-purchase-requirement'); 
				?> 

				<?php if ($showpurchases ==1 || $showpurchaseorders ==1 || $showworkPurRequ ==1) { ?>
					<li class="dropdown-submenu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Purchase </a>
						<ul class="dropdown-menu">
							<?php if (!empty($showpurchases)) { ?> <li><a href="{{ route('show-purchases') }}">Purchase Entry</a></li> <?php } ?>
							<?php if (!empty($showpurchaseorders)) { ?> <li><a href="{{ route('show-purchaseorders') }}">Purchase Order</a></li> <?php } ?>
							<?php if (!empty($showworkPurRequ)) { ?> <li><a href="{{ route('show-work-purchase-requirement') }}">Requisition Request</a></li> <?php } ?>
						</ul>
					</li>
				<?php } ?>

				<?php 
					$showWarehouse 			= CommonController::checkPagePermission('show'); 
					$showStocDetailListing 	= CommonController::checkPagePermission('show-stock-details-listing'); 
				?> 

				<?php if ($showWarehouse ==1 || $showStocDetailListing ==1) { ?>
					<li class="dropdown-submenu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Stock </a>
						<ul class="dropdown-menu">
							<?php if (!empty($showWarehouse)) { ?> <li><a href="{{ route('show') }}">Warehouse Items</a></li> <?php } ?>
							<?php if (!empty($showStocDetailListing)) { ?> <li><a href="{{ route('show-stock-details-listing') }}">Warehouse Stock Report</a></li> <?php } ?> 
						</ul>
					</li>
				<?php } ?>

			</ul>
		</li>

		
		 
		  
          <li class="dropdown"> 
			<a class "dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Masters<span class="caret"></span></a>
            <ul class="dropdown-menu">
 
			<?php
			 $showIndividuals = CommonController::checkPagePermission('show-individuals');
			?>

			<?php if ($showIndividuals ==1) { ?>
				<li><a href="{{ route('show-individuals') }}">Individuals</a></li>
			<?php } ?>


			  
		  <?php
			$showUnitTypes 	= CommonController::checkPagePermission('show-unittypes');
			$showItemTypes 	= CommonController::checkPagePermission('show-itemtypes');
			$showItems 		= CommonController::checkPagePermission('show-items');
			?>
			<?php 			 	
			if($showUnitTypes == 1 || $showItemTypes ==1 || $showItems ==1) { 
			?>
				<li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Materials </a>
					<ul class="dropdown-menu">
						@if($showUnitTypes)
							<li><a href="{{ route('show-unittypes') }}">Unit Types </a></li>
						@endif

						@if($showItemTypes)
							<li><a href="{{ route('show-itemtypes') }}">Item Types </a></li>
						@endif

						@if($showItems)
							<li><a href="{{ route('show-items') }}">Materials / Items</a></li>
						@endif
					</ul>
				</li>
			<?php } ?>
			  
			   
			  <?php
				$showWarehouses 			= CommonController::checkPagePermission('show-warehouses');
				$showWarehouseCompartment 	= CommonController::checkPagePermission('show-warehousecompartment');
				?>

				<?php if ($showWarehouses == 1 || $showWarehouseCompartment == 1) { ?>
				  <li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Warehouses </a>
					<ul class="dropdown-menu">
					  <?php if ($showWarehouses) { ?>
						<li><a href="{{ route('show-warehouses') }}">Warehouses</a></li>
					  <?php } ?>

					  <?php if ($showWarehouseCompartment) { ?>
						<li><a href="{{ route('show-warehousecompartment') }}">Warehouse Compartment</a></li>
					  <?php } ?>
					</ul>
				  </li>
				<?php } ?>

			  
			  
			  
				 <?php
				$showGSTRates 		= CommonController::checkPagePermission('show-gstrates');
				$showBanks 			= CommonController::checkPagePermission('show-banks');
				$showBankAccounts 	= CommonController::checkPagePermission('show-bankaccounts');
				$showAccountGroups 	= CommonController::checkPagePermission('show-accountgroups');
				?>

				<?php if ($showGSTRates ==1 || $showBanks ==1 || $showBankAccounts ==1 || $showAccountGroups ==1) { ?>
				  <li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Accounts</a>
					<ul class="dropdown-menu">
					  <?php if ($showGSTRates) { ?>
						<li><a href="{{ route('show-gstrates') }}">GST Rate</a></li>
					  <?php } ?>

					  <?php if ($showBanks) { ?>
						<li><a href="{{ route('show-banks') }}">Banks</a></li>
					  <?php } ?>

					  <?php if ($showBankAccounts) { ?>
						<li><a href="{{ route('show-bankaccounts') }}">Bank Account</a></li>
					  <?php } ?>

					  <?php if ($showAccountGroups) { ?>
						<li><a href="{{ route('show-accountgroups') }}">Account Group</a></li>
					  <?php } ?>
					</ul>
				  </li>
				<?php } ?>


				<?php
					$showGSTRates 		= CommonController::checkPagePermission('show-gstrates');
					$showBanks			= CommonController::checkPagePermission('show-banks');
					$showBankAccounts 	= CommonController::checkPagePermission('show-bankaccounts');
					$showAccountGroups 	= CommonController::checkPagePermission('show-accountgroups');
					?>

					<?php if ($showGSTRates ==1 || $showBanks ==1 || $showBankAccounts ==1 || $showAccountGroups ==1) { ?>
					  <li class="dropdown-submenu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Accounts</a>
						<ul class="dropdown-menu">
						  <?php if ($showGSTRates) { ?>
							<li><a href="{{ route('show-gstrates') }}">GST Rate</a></li>
						  <?php } ?>

						  <?php if ($showBanks) { ?>
							<li><a href="{{ route('show-banks') }}">Banks</a></li>
						  <?php } ?>

						  <?php if ($showBankAccounts) { ?>
							<li><a href="{{ route('show-bankaccounts') }}">Bank Account</a></li>
						  <?php } ?>

						  <?php if ($showAccountGroups) { ?>
							<li><a href="{{ route('show-accountgroups') }}">Account Group</a></li>
						  <?php } ?>
						</ul>
					  </li>
					<?php } ?>

					<?php
						$showVehicles 		= CommonController::checkPagePermission('show-vehicles');
						$showBrands 		= CommonController::checkPagePermission('show-brands');
						$showHSNS 			= CommonController::checkPagePermission('show-hsns');
						$showMachines 		= CommonController::checkPagePermission('show-machines');
						$showNotifications 	= CommonController::checkPagePermission('show-notifications');
					?>
              
					<?php if ($showVehicles ==1) { ?>
						<li><a href="{{ route('show-vehicles') }}">Vehicle</a></li>
					<?php } ?>

					<?php if ($showBrands ==1) { ?>
						<li><a href="{{ route('show-brands') }}">Brands</a></li>
					<?php } ?>

					<?php if ($showHSNS ==1) { ?>
						<li><a href="{{ route('show-hsns') }}">Show HSNS</a></li>
					<?php } ?>

					<?php if ($showMachines ==1) { ?>
						<li><a href="{{ route('show-machines') }}">Machine</a></li>
					<?php } ?>

					<?php if ($showNotifications ==1) { ?>
						<li><a href="{{ route('show-notifications') }}">Notifications</a></li>
					<?php } ?>
				 
				
				<?php
				$showAllPages 		= CommonController::checkPagePermission('show-allpages');
				$showUserWebPages 	= CommonController::checkPagePermission('show-userwebpages');
				?>

				<?php if ($showAllPages ==1 || $showUserWebPages ==1) { ?>
				  <li class="dropdown-submenu">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Permissions </a>
					<ul class="dropdown-menu">
					  <?php if ($showAllPages) { ?>
						<li><a href="{{ route('show-allpages') }}">All Pages</a></li>
					  <?php } ?>

					  <?php if ($showUserWebPages) { ?>
						<li><a href="{{ route('show-userwebpages') }}">User Permissions </a></li>
					  <?php } ?>
					</ul>
				  </li>
				<?php } ?>

				
				
            </ul>
          </li>
		   
		   <!-- Existing search form -->
			 
			<li class="nav-item">
			  <form class="navbar-form custom-search" role="search">
				<div class="form-group">
				  <div class="input-group">
					<input type="text" class="form-control" placeholder="Search">
					<span class="input-group-btn">
					  <button type="submit" class="btn btn-custom">
						<i class="fa fa-search"></i>
					  </button>
					</span>
				  </div>
				</div>
			  </form>
			</li>
 
			<!-- Additional search form (hidden by default) -->
			 

		  
          <li class="dropdown notifications-menu"> <a href="javascript:void|(0);" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-bell"></i> <span class="label label-warning">5</span> </a>
            <ul class="dropdown-menu">
              <li>
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                  <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                    <li> <a href="javascript:void|(0);" class="border-gray"> <i class="fa fa-dot-circle-o color-green"></i>Change Your font style</a> </li>
                    <li><a href="javascript:void|(0);" class="border-gray"> <i class="fa fa-dot-circle-o color-violet"></i> Add more clients and order</a> </li>
                  </ul>
                  <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div>
                  <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                </div>
              </li>
            </ul>
          </li>
		  
          <li class="dropdown dropdown-help hidden-xs"> <a href="javascript:void|(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="pe-7s-settings"></i></a>
            <ul class="dropdown-menu">
              <li><a href="javascript:void|(0);"><i class="fa fa-line-chart"></i> Networking</a></li>
              <li><a href="javascript:void|(0);"><i class="fa fa fa-bullhorn"></i> Lan settings</a></li>
              <li><a href="javascript:void|(0);"><i class="fa fa-bar-chart"></i> Settings</a></li>
              <li><a href="javascript:void|(0);"> <i class="fa fa-wifi"></i> wifi</a> </li>
            </ul>
          </li>
		  
          <li class="dropdown dropdown-user"> <a href="javascript:void|(0);" class="dropdown-toggle" data-toggle="dropdown"> <img src="{{ asset('assets/dist/img/avatar5.png') }}" class="img-circle" width="45" height="45" alt="user"></a>
            <ul class="dropdown-menu" >
              <li> <a href="javascript:void|(0);"> <i class="fa fa-user"></i> User Profile</a> </li>
              <li><a href="javascript:void|(0);"><i class="fa fa-inbox"></i> Inbox</a></li>
              <li> <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i> {{ __('Logout') }} </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
		  
        </ul>
      </div>
    </div>
  </nav>
</header>
 
 
  
 
 
 
 
 
 