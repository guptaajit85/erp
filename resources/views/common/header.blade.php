 
<header class="main-header"> <a href="{{ route('dashboard') }}" class="logo">
  <!-- Logo -->
  <span class="logo-mini"> <img src="{{ asset('assets/dist/img/mini-logo.png') }}"> </span> <span class="logo-lg"> <img src="{{ asset('assets/dist/img/logo.png') }}"> </span> </a>

<?php /* ?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">  
	<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">	 
        <li class="dropdown active">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Warehouse<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('show') }}">Warehouse</a></li>
            <li class="dropdown-submenu">
              <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Submenu 1<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Submenu Item 1</a></li>
                <li class="dropdown-submenu">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Submenu 1.1<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Submenu Item 1.1.1</a></li>
                    <li><a href="#">Submenu Item 1.1.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li> 
    </ul>
  </div>
  </div>
</nav> 
<?php */ ?>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">		
          <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Daily Entry<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-submenu"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Sale </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('add-saleentry') }}">Add Sale Entry</a></li>
                  <li><a href="{{ route('add-saleorder') }}">Add Sale Order</a></li>
                </ul>
              </li>
              <li class="dropdown-submenu"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Purchase </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('add-purchase') }}">Add Purchase Entry</a></li>
                  <li><a href="{{ route('add-purchaseorder') }}">Add Purchase Order</a></li>
                </ul>
              </li>
              <li class="dropdown-submenu"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Work Order </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('show-saleorderitems') }}">Create Work Order</a></li>
                  <li><a href="{{ route('show-workorders') }}">Work Order Process</a></li>                 
                </ul>
              </li>
              <li class="dropdown-submenu"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Warehouse Stock </a>
                <ul class="dropdown-menu"> 
                  <li><a href="{{ route('add-item-in-warehouse') }}">Add Item in Warehouse</a></li>
                  <li><a href="{{ route('add-purchase-request') }}">Add Purchase Request</a></li>
                  <li><a href="{{ route('show-warehouse-item-requirement') }}">Warehouse Requirement</a></li>
				  <li><a href="{{ route('show-workorder-report') }}">Stock In Ward</a></li>
                </ul>
              </li>
            </ul>
          </li>
		  
          <li class="dropdown"> 
			<a class "dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Report<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-submenu"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Sale </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('show-saleentries') }}">Sale Entry</a></li>
                  <li><a href="{{ route('show-saleorders') }}">Sale Order</a></li>
                </ul>
              </li>
              <li class="dropdown-submenu"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Purchase </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('show-purchases') }}">Purchase Entry</a></li>
                  <li><a href="{{ route('show-purchaseorders') }}">Purchase Order</a></li>
                  <li><a href="{{ route('show-work-purchase-requirement') }}">Requisition Request</a></li>
                </ul>
              </li> 
			  <li class="dropdown-submenu"> <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Stock </a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('show') }}">Warehouse Items</a></li>
                  <li><a href="{{ route('show-stock-details-listing') }}">Warehouse Stock Report</a></li>
                 <!--- <li><a href="{{ route('show-warehouse-stock-report') }}">Warehouse Stock Report</a></li>
                  <li><a href="{{ route('show-warehouse-item-out') }}">Warehouse Items Out</a></li> --->				  
                </ul>
              </li>			  
            </ul>
          </li>		.

		  
          <li class="dropdown"> 
			<a class "dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Masters<span class="caret"></span></a>
            <ul class="dropdown-menu">
              
			  <li><a href="{{ route('show-individuals') }}">Individuals</a></li>			   
			  <li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Materials </a>
                <ul class="dropdown-menu">
					<li><a href="{{ route('show-unittypes') }}">Unit Types </a></li>
					<li><a href="{{ route('show-itemtypes') }}">Item Types </a></li>
					<li><a href="{{ route('show-items') }}">Materials / Items</a></li>
                </ul>
              </li> 
			  
			  <li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Warehouses </a>
                <ul class="dropdown-menu">
					<li><a href="{{ route('show-warehouses') }}">Warehouses</a></li>
					<li><a href="{{ route('show-warehousecompartment') }}">Warehouse Compartment</a></li>					 
                </ul>
              </li>
			  
			  <li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Accounts </a>
                <ul class="dropdown-menu">
					<li><a href="{{ route('show-gstrates') }}">GST Rate</a></li>
					<li><a href="{{ route('show-banks') }}"> Banks </a></li>
					<li><a href="{{ route('show-bankaccounts') }}">Bank Account </a></li>	
					<li><a href="{{ route('show-accountgroups') }}"> Account Group </a></li>					
                </ul>
              </li>
              
				<li><a href="{{ route('show-vehicles') }}">Vehicle </a></li>
				<li><a href="{{ route('show-brands') }}">Brands </a></li>
				<li><a href="{{ route('show-hsns') }}">Show HSNS</a></li>
				<li><a href="{{ route('show-machines') }}">Machine </a></li>
				<li><a href="{{ route('show-notifications') }}">Notifications</a></li>
				 
				
			 <li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Permissions </a>
                <ul class="dropdown-menu">
					<li><a href="{{ route('show-allpages') }}">All Pages</a></li>
					<li><a href="{{ route('show-userwebpages') }}">User Permissions </a></li> 	
                </ul>
              </li>
				
				
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
 
 
  
 
 
 
 
 
 