<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DyedFabricController;
use App\Http\Controllers\CoatedFabricController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\FinishedFabricController;
use App\Http\Controllers\WarehouseItemController;
use App\Http\Controllers\WarehouseItemOutController;
use App\Http\Controllers\WorkProcessRequirementController;
use App\Http\Controllers\WorkPurchaseRequirementController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\IndividualAddressController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Http\Request;

/*    
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function ()
{
   // return view('/welcome');
	return Redirect::guest('login');
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/show-individuals',[App\Http\Controllers\IndividualController::class,'index'])->name('show-individuals');
Route::get('/show-customers-individuals',[App\Http\Controllers\IndividualController::class,'customers_individuals'])->name('show-customers-individuals');
Route::get('/show-agents-individuals',[App\Http\Controllers\IndividualController::class,'agent_individuals'])->name('show-agents-individuals');
Route::get('/show-labourer-individuals',[App\Http\Controllers\IndividualController::class,'labourer_individuals'])->name('show-labourer-individuals');
Route::get('/show-vendors-individuals',[App\Http\Controllers\IndividualController::class,'vendors_individuals'])->name('show-vendors-individuals');
Route::get('/show-master-individuals',[App\Http\Controllers\IndividualController::class,'master_individuals'])->name('show-master-individuals');
Route::get('/show-transport-individuals',[App\Http\Controllers\IndividualController::class,'transport_individuals'])->name('show-transport-individuals');
Route::get('/show-employee-individuals',[App\Http\Controllers\IndividualController::class,'employee_individuals'])->name('show-employee-individuals');


Route::get('/edit-individual/{id}',[App\Http\Controllers\IndividualController::class,'edit_individual'])->name('edit-individual');
Route::post('/update_individual',[App\Http\Controllers\IndividualController::class,'update_individual'])->name('update_individual');
Route::get('/add-individual',[App\Http\Controllers\IndividualController::class,'create_individual'])->name('add-individual');
Route::get('/viewpersons/{id}',[App\Http\Controllers\IndividualController::class,'viewpersons'])->name('viewpersons');
Route::post('/store_individual',[App\Http\Controllers\IndividualController::class,'store_individual'])->name('store_individual');
Route::get('/ajax_script/deleteIndividual', [App\Http\Controllers\IndividualController::class,'deleteIndividual']);

Route::get('/add-customer-individual',[App\Http\Controllers\IndividualController::class,'create_customer_individual'])->name('add-customer-individual');
Route::post('/store_customer_individual',[App\Http\Controllers\IndividualController::class,'store_customer_individual'])->name('store_customer_individual');
Route::get('/add-master-individual',[App\Http\Controllers\IndividualController::class,'create_master_individual'])->name('add-master-individual');
Route::post('/store_master_individual',[App\Http\Controllers\IndividualController::class,'store_master_individual'])->name('store_master_individual');
Route::get('/add-agent-individual',[App\Http\Controllers\IndividualController::class,'create_agent_individual'])->name('add-agent-individual');
Route::post('/store_agent_individual',[App\Http\Controllers\IndividualController::class,'store_agent_individual'])->name('store_agent_individual');
Route::get('/add-labourer-individual',[App\Http\Controllers\IndividualController::class,'create_labourer_individual'])->name('add-labourer-individual');
Route::post('/store_labourer_individual',[App\Http\Controllers\IndividualController::class,'store_labourer_individual'])->name('store_labourer_individual');
Route::get('/add-vendor-individual',[App\Http\Controllers\IndividualController::class,'create_vendor_individual'])->name('add-vendor-individual');
Route::post('/store_vendor_individual',[App\Http\Controllers\IndividualController::class,'store_vendor_individual'])->name('store_vendor_individual');
Route::get('/add-employee-individual',[App\Http\Controllers\IndividualController::class,'create_employee_individual'])->name('add-employee-individual');
Route::post('/store_employee_individual',[App\Http\Controllers\IndividualController::class,'store_employee_individual'])->name('store_employee_individual');
Route::get('/add-transport-individual',[App\Http\Controllers\IndividualController::class,'create_transport_individual'])->name('add-transport-individual');
Route::post('/store_transport_individual',[App\Http\Controllers\IndividualController::class,'store_transport_individual'])->name('store_transport_individual');

Route::get('/show-departments',[App\Http\Controllers\DepartmentController::class,'index'])->name('show-departments');
Route::get('/edit-department/{id}',[App\Http\Controllers\DepartmentController::class,'edit_department'])->name('edit-department');
Route::post('/update_department',[App\Http\Controllers\DepartmentController::class,'update_department'])->name('update_department');
Route::get('/add-department',[App\Http\Controllers\DepartmentController::class,'create_department'])->name('add-department');
Route::post('/store_department',[App\Http\Controllers\DepartmentController::class,'store_department'])->name('store_department');
Route::get('/ajax_script/deleteDepartment', [App\Http\Controllers\DepartmentController::class,'deleteDepartment']);

Route::get('/show-persons/{id}',[App\Http\Controllers\PersonController::class,'index'])->name('show-persons');
Route::get('/edit-person/{id}',[App\Http\Controllers\PersonController::class,'edit_person'])->name('edit-person');
Route::post('/update_person',[App\Http\Controllers\PersonController::class,'update_person'])->name('update_person');
Route::get('/add-person/{id}',[App\Http\Controllers\PersonController::class,'create_person'])->name('add-person');
Route::post('/store_person',[App\Http\Controllers\PersonController::class,'store_person'])->name('store_person');
Route::get('/ajax_script/deletePerson', [App\Http\Controllers\PersonController::class,'deletePerson']);

Route::get('/show-colours',[App\Http\Controllers\ColourController::class,'index'])->name('show-colours');
Route::get('/edit-colour/{id}',[App\Http\Controllers\ColourController::class,'edit_colour'])->name('edit-colour');
Route::post('/update_colour',[App\Http\Controllers\ColourController::class,'update_colour'])->name('update_colour');
Route::get('/add-colour',[App\Http\Controllers\ColourController::class,'create_colour'])->name('add-colour');
Route::post('/store_colour',[App\Http\Controllers\ColourController::class,'store_colour'])->name('store_colour');
Route::get('/ajax_script/deleteColour', [App\Http\Controllers\ColourController::class,'deleteColour']);

Route::get('/show-warehouses',[App\Http\Controllers\WarehouseController::class,'index'])->name('show-warehouses');
Route::get('/edit-warehouse/{id}',[App\Http\Controllers\WarehouseController::class,'edit_warehouse'])->name('edit-warehouse');
Route::post('/update_warehouse',[App\Http\Controllers\WarehouseController::class,'update_warehouse'])->name('update_warehouse');
Route::get('/add-warehouse',[App\Http\Controllers\WarehouseController::class,'create_warehouse'])->name('add-warehouse');
Route::post('/store_warehouse',[App\Http\Controllers\WarehouseController::class,'store_warehouse'])->name('store_warehouse');
Route::get('/ajax_script/deleteWarehouse', [App\Http\Controllers\WarehouseController::class,'deleteWarehouse']);

Route::get('/show-qualities',[App\Http\Controllers\QualityController::class,'index'])->name('show-qualities');
Route::get('/edit-quality/{id}',[App\Http\Controllers\QualityController::class,'edit'])->name('edit-quality');
Route::post('/update_quality',[App\Http\Controllers\QualityController::class,'update'])->name('update_quality');
Route::get('/add-quality',[App\Http\Controllers\QualityController::class,'create'])->name('add-quality');
Route::post('/store_quality',[App\Http\Controllers\QualityController::class,'store'])->name('store_quality');

Route::get('/ajax_script/deleteQuality', [App\Http\Controllers\QualityController::class,'deleteQuality']);

 

Route::get('/show-modules',[App\Http\Controllers\ModuleController::class,'index'])->name('show-modules');
Route::get('/edit-module/{id}',[App\Http\Controllers\ModuleController::class,'edit'])->name('edit-module');
Route::post('/update_module',[App\Http\Controllers\ModuleController::class,'update'])->name('update_module');
Route::get('/add-module',[App\Http\Controllers\ModuleController::class,'create'])->name('add-module');
Route::post('/store_module',[App\Http\Controllers\ModuleController::class,'store'])->name('store_module');
Route::get('/ajax_script/deleteModule', [App\Http\Controllers\ModuleController::class,'deleteModule']);

Route::get('/show-bims',[App\Http\Controllers\BimController::class,'index'])->name('show-bims');
Route::get('/edit-bim/{id}',[App\Http\Controllers\BimController::class,'edit'])->name('edit-bim');
Route::post('/update_bim',[App\Http\Controllers\BimController::class,'update'])->name('update_bim');
Route::get('/add-bim',[App\Http\Controllers\BimController::class,'create'])->name('add-bim');
Route::post('/store_bim',[App\Http\Controllers\BimController::class,'store'])->name('store_bim');
Route::get('/ajax_script/deleteBim', [App\Http\Controllers\BimController::class,'deleteBim']);

Route::get('/show-dyings',[App\Http\Controllers\DyingController::class,'index'])->name('show-dyings');
Route::get('/edit-dying/{id}',[App\Http\Controllers\DyingController::class,'edit'])->name('edit-dying');
Route::post('/update_dying',[App\Http\Controllers\DyingController::class,'update'])->name('update_dying');
Route::get('/add-dying',[App\Http\Controllers\DyingController::class,'create'])->name('add-dying');
Route::post('/store_dying',[App\Http\Controllers\DyingController::class,'store'])->name('store_dying');
Route::get('/ajax_script/deleteDying', [App\Http\Controllers\DyingController::class,'deleteDying']);

Route::get('/show-dyedfabrics',[DyedFabricController::class,'index'])->name('show-dyedfabrics');
Route::get('/edit-dyedfabric/{id}',[DyedFabricController::class,'edit'])->name('edit-dyedfabric');
Route::post('/update_dyedfabric',[DyedFabricController::class,'update'])->name('update_dyedfabric');
Route::get('/add-dyedfabric',[DyedFabricController::class,'create'])->name('add-dyedfabric');
Route::post('/store_dyedfabric',[DyedFabricController::class,'store'])->name('store_dyedfabric');
Route::get('/ajax_script/deleteDyedFabric', [DyedFabricController::class,'deleteDyedFabric']);

Route::get('/show-finishedfabrics',[FinishedFabricController::class,'index'])->name('show-finishedfabrics');
Route::get('/edit-finishedfabric/{id}',[FinishedFabricController::class,'edit'])->name('edit-finishedfabric');
Route::post('/update_finishedfabric',[FinishedFabricController::class,'update'])->name('update_finishedfabric');
Route::get('/add-finishedfabric',[FinishedFabricController::class,'create'])->name('add-finishedfabric');
Route::post('/store_finishedfabric',[FinishedFabricController::class,'store'])->name('store_finishedfabric');
Route::get('/ajax_script/deleteFinishedFabric',[FinishedFabricController::class,'deleteFinishedFabric']);

Route::get('/show-coatedfabrics',[CoatedFabricController::class,'index'])->name('show-coatedfabrics');
Route::get('/edit-coatedfabric/{id}',[CoatedFabricController::class,'edit'])->name('edit-coatedfabric');
Route::post('/update_coatedfabric',[CoatedFabricController::class,'update'])->name('update_coatedfabric');
Route::get('/add-coatedfabric',[CoatedFabricController::class,'create'])->name('add-coatedfabric');
Route::post('/store_coatedfabric',[CoatedFabricController::class,'store'])->name('store_coatedfabric');
Route::get('/ajax_script/deleteCoatedFabric', [CoatedFabricController::class,'deleteCoatedFabric']);


Route::get('/show-vehicles',[VehicleController::class,'index'])->name('show-vehicles');
Route::get('/edit-vehicle/{id}',[VehicleController::class,'edit_vehicle'])->name('edit-vehicle');
Route::post('/update_vehicle',[VehicleController::class,'update_vehicle'])->name('update_vehicle');
Route::get('/add-vehicle',[VehicleController::class,'create_vehicle'])->name('add-vehicle');
Route::post('/store_vehicle',[VehicleController::class,'store_vehicle'])->name('store_vehicle');
Route::get('/ajax_script/deleteVehicle', [VehicleController::class,'deleteVehicle']);

Route::get('/show-banks',[App\Http\Controllers\BankController::class,'index'])->name('show-banks');
Route::get('/edit-bank/{id}',[App\Http\Controllers\BankController::class,'edit_bank'])->name('edit-bank');
Route::post('/update_bank',[App\Http\Controllers\BankController::class,'update_bank'])->name('update_bank');
Route::get('/add-bank',[App\Http\Controllers\BankController::class,'create_bank'])->name('add-bank');
Route::post('/store_bank',[App\Http\Controllers\BankController::class,'store_bank'])->name('store_bank');
Route::get('/ajax_script/deleteBank', [App\Http\Controllers\BankController::class,'deleteBank']);

Route::get('/show-chemicals',[App\Http\Controllers\ChemicalController::class,'index'])->name('show-chemicals');
Route::get('/edit-chemical/{id}',[App\Http\Controllers\ChemicalController::class,'edit_chemical'])->name('edit-chemical');
Route::post('/update_chemical',[App\Http\Controllers\ChemicalController::class,'update_chemical'])->name('update_chemical');
Route::get('/add-chemical',[App\Http\Controllers\ChemicalController::class,'create_chemical'])->name('add-chemical');
Route::post('/store_chemical',[App\Http\Controllers\ChemicalController::class,'store_chemical'])->name('store_chemical');
Route::get('/ajax_script/deleteChemical', [App\Http\Controllers\ChemicalController::class,'deleteChemical']);


Route::get('/show-warehousecompartment',[App\Http\Controllers\WareHouseCompartmentController::class,'index'])->name('show-warehousecompartment');
Route::get('/edit-warehousecompartment/{id}',[App\Http\Controllers\WareHouseCompartmentController::class,'edit_warehousecompartment'])->name('edit-warehousecompartment');
Route::post('/update_warehousecompartment',[App\Http\Controllers\WareHouseCompartmentController::class,'update_warehousecompartment'])->name('update_warehousecompartment');
Route::get('/add-warehousecompartment',[App\Http\Controllers\WareHouseCompartmentController::class,'create_warehousecompartment'])->name('add-warehousecompartment');
Route::post('/store_warehousecompartment',[App\Http\Controllers\WareHouseCompartmentController::class,'store_warehousecompartment'])->name('store_warehousecompartment');
Route::get('/ajax_script/deletewarehouseCompartment', [App\Http\Controllers\WareHouseCompartmentController::class,'deletewarehouseCompartment']);

Route::get('/show-bankaccounts',[App\Http\Controllers\BankAccountController::class,'index'])->name('show-bankaccounts');
Route::get('/edit-bankaccount/{id}',[App\Http\Controllers\BankAccountController::class,'edit_bankaccount'])->name('edit-bankaccount');
Route::post('/update_bankaccount',[App\Http\Controllers\BankAccountController::class,'update_bankaccount'])->name('update_bankaccount');
Route::get('/add-bankaccount',[App\Http\Controllers\BankAccountController::class,'create_bankaccount'])->name('add-bankaccount');
Route::post('/store_bankaccount',[App\Http\Controllers\BankAccountController::class,'store_bankaccount'])->name('store_bankaccount');
Route::get('/ajax_script/deleteBankAccount', [App\Http\Controllers\BankAccountController::class,'deleteBankAccount']);

Route::get('/show-greys',[App\Http\Controllers\GreyController::class,'index'])->name('show-greys');
Route::get('/edit-grey/{id}',[App\Http\Controllers\GreyController::class,'edit_grey'])->name('edit-grey');
Route::post('/update_grey',[App\Http\Controllers\GreyController::class,'update_grey'])->name('update_grey');
Route::get('/add-grey',[App\Http\Controllers\GreyController::class,'create_grey'])->name('add-grey');
Route::post('/store_grey',[App\Http\Controllers\GreyController::class,'store_grey'])->name('store_grey');
Route::get('/ajax_script/deleteGrey', [App\Http\Controllers\GreyController::class,'deleteGrey']);

Route::get('/show-papertubes',[App\Http\Controllers\PaperTubeController::class,'index'])->name('show-papertubes');
Route::get('/edit-papertube/{id}',[App\Http\Controllers\PaperTubeController::class,'edit_papertube'])->name('edit-papertube');
Route::post('/update_papertube',[App\Http\Controllers\PaperTubeController::class,'update_papertube'])->name('update_papertube');
Route::get('/add-papertube',[App\Http\Controllers\PaperTubeController::class,'create_papertube'])->name('add-paperTube');
Route::post('/store_papertube',[App\Http\Controllers\PaperTubeController::class,'store_papertube'])->name('store_papertube');
Route::get('/ajax_script/deletePaperTube', [App\Http\Controllers\PaperTubeController::class,'deletePaperTube']);

Route::get('/show-accountgroups',[App\Http\Controllers\AccountGroupController::class,'index'])->name('show-accountgroups');
Route::get('/edit-accountgroup/{id}',[App\Http\Controllers\AccountGroupController::class,'edit_accountgroup'])->name('edit-accountgroup');
Route::post('/update_accountgroup',[App\Http\Controllers\AccountGroupController::class,'update_accountgroup'])->name('update_accountgroup');
Route::get('/add-accountgroup',[App\Http\Controllers\AccountGroupController::class,'create_accountgroup'])->name('add-accountgroup');
Route::post('/store_accountgroup',[App\Http\Controllers\AccountGroupController::class,'store_accountgroup'])->name('store_accountgroup');
Route::get('/ajax_script/deleteAccountGroup', [App\Http\Controllers\AccountGroupController::class,'deleteAccountGroup']);

Route::get('/show-samplefolders',[App\Http\Controllers\SampleFolderController::class,'index'])->name('show-samplefolders');
Route::get('/edit-samplefolder/{id}',[App\Http\Controllers\SampleFolderController::class,'edit_samplefolder'])->name('edit-samplefolder');
Route::post('/update_samplefolder',[App\Http\Controllers\SampleFolderController::class,'update_samplefolder'])->name('update_samplefolder');
Route::get('/add-samplefolder',[App\Http\Controllers\SampleFolderController::class,'create_samplefolder'])->name('add-samplefolder');
Route::post('/store_samplefolder',[App\Http\Controllers\SampleFolderController::class,'store_samplefolder'])->name('store_samplefolder');
Route::get('/ajax_script/deleteSampleFolder', [App\Http\Controllers\SampleFolderController::class,'deleteSampleFolder']);

Route::get('/show-stationaries',[App\Http\Controllers\StationaryController::class,'index'])->name('show-stationaries');
Route::get('/edit-stationary/{id}',[App\Http\Controllers\StationaryController::class,'edit_stationary'])->name('edit-stationary');
Route::post('/update_stationary',[App\Http\Controllers\StationaryController::class,'update_stationary'])->name('update_stationary');
Route::get('/add-stationary',[App\Http\Controllers\StationaryController::class,'create_stationary'])->name('add-stationary');
Route::post('/store_stationary',[App\Http\Controllers\StationaryController::class,'store_stationary'])->name('store_stationary');
Route::get('/ajax_script/deleteStationary', [App\Http\Controllers\StationaryController::class,'deleteStationary']);

Route::get('/show-cotings',[App\Http\Controllers\CotingController::class,'index'])->name('show-cotings');
Route::get('/edit-coting/{id}',[App\Http\Controllers\CotingController::class,'edit_coting'])->name('edit-coting');
Route::post('/update_coting',[App\Http\Controllers\CotingController::class,'update_coting'])->name('update_coting');
Route::get('/add-coting',[App\Http\Controllers\CotingController::class,'create_coting'])->name('add-coting');
Route::post('/store_coting',[App\Http\Controllers\CotingController::class,'store_coting'])->name('store_coting');
Route::get('/ajax_script/deleteCoting', [App\Http\Controllers\CotingController::class,'deleteCoting']);

Route::get('/show-brands',[App\Http\Controllers\BrandController::class,'index'])->name('show-brands');
Route::get('/edit-brand/{id}',[App\Http\Controllers\BrandController::class,'edit_brand'])->name('edit-brand');
Route::post('/update_brand',[App\Http\Controllers\BrandController::class,'update_brand'])->name('update_brand');
Route::get('/add-brand',[App\Http\Controllers\BrandController::class,'create_brand'])->name('add-brand');
Route::post('/store_brand',[App\Http\Controllers\BrandController::class,'store_brand'])->name('store_brand');
Route::get('/ajax_script/deleteBrand', [App\Http\Controllers\BrandController::class,'deleteBrand']);

Route::get('/show-machines',[App\Http\Controllers\MachineController::class,'index'])->name('show-machines');
Route::get('/edit-machine/{id}',[App\Http\Controllers\MachineController::class,'edit_machine'])->name('edit-machine');
Route::post('/update_machine',[App\Http\Controllers\MachineController::class,'update_machine'])->name('update_machine');
Route::get('/add-machine',[App\Http\Controllers\MachineController::class,'create_machine'])->name('add-machine');
Route::post('/store_machine',[App\Http\Controllers\MachineController::class,'store_machine'])->name('store_machine');
Route::get('/ajax_script/deleteMachine', [App\Http\Controllers\MachineController::class,'deleteMachine']);

Route::get('/show-countries',[App\Http\Controllers\CountryController::class,'index'])->name('show-countries');
Route::get('/edit-country/{id}',[App\Http\Controllers\CountryController::class,'edit'])->name('edit-country');
Route::post('/update_country',[App\Http\Controllers\CountryController::class,'update'])->name('update_country');
Route::get('/add-country',[App\Http\Controllers\CountryController::class,'create'])->name('add-country');
Route::post('/store_country',[App\Http\Controllers\CountryController::class,'store'])->name('store_country');
Route::get('/ajax_script/deleteCountry', [App\Http\Controllers\CountryController::class,'deleteCountry']);

Route::get('/show-cities',[App\Http\Controllers\CityController::class,'index'])->name('show-cities');
Route::get('/edit-city/{id}',[App\Http\Controllers\CityController::class,'edit'])->name('edit-city');
Route::post('/update_city',[App\Http\Controllers\CityController::class,'update'])->name('update_city');
Route::get('/add-city',[App\Http\Controllers\CityController::class,'create'])->name('add-city');
Route::post('/store_city',[App\Http\Controllers\CityController::class,'store'])->name('store_city');
Route::get('/ajax_script/deleteCity', [App\Http\Controllers\CityController::class,'deleteCity']);

Route::get('/show-states',[App\Http\Controllers\StateController::class,'index'])->name('show-states');
Route::get('/edit-state/{id}',[App\Http\Controllers\StateController::class,'edit'])->name('edit-state');
Route::post('/update_state',[App\Http\Controllers\StateController::class,'update'])->name('update_state');
Route::get('/add-state',[App\Http\Controllers\StateController::class,'create'])->name('add-state');
Route::post('/store_state',[App\Http\Controllers\StateController::class,'store'])->name('store_state');
Route::get('/ajax_script/deleteState', [App\Http\Controllers\StateController::class,'deleteState']);

Route::get('/show-individualtypes',[App\Http\Controllers\IndividualTypeController::class,'index'])->name('show-individualtypes');
Route::get('/edit-individualtype/{id}',[App\Http\Controllers\IndividualTypeController::class,'edit'])->name('edit-individualtype');
Route::post('/update_individualtype',[App\Http\Controllers\IndividualTypeController::class,'update'])->name('update_individualtype');
Route::get('/add-individualtype',[App\Http\Controllers\IndividualTypeController::class,'create'])->name('add-individualtype');
Route::post('/store_individualtype',[App\Http\Controllers\IndividualTypeController::class,'store'])->name('store_individualtype');
Route::get('/ajax_script/deleteIndividualType', [App\Http\Controllers\IndividualTypeController::class,'deleteIndividualType']);

Route::get('/show-qualitytypes',[App\Http\Controllers\QualityTypeController::class,'index'])->name('show-qualitytypes');
Route::get('/edit-qualitytype/{id}',[App\Http\Controllers\QualityTypeController::class,'edit_qualitytype'])->name('edit-qualitytype');
Route::post('/update_qualitytype',[App\Http\Controllers\QualityTypeController::class,'update_qualitytype'])->name('update_qualitytype');
Route::get('/add-qualitytype',[App\Http\Controllers\QualityTypeController::class,'create_qualitytype'])->name('add-qualitytype');
Route::post('/store_qualitytype',[App\Http\Controllers\QualityTypeController::class,'store_qualitytype'])->name('store_qualitytype');
Route::get('/ajax_script/deleteQualityType', [App\Http\Controllers\QualityTypeController::class,'deleteQualityType']);

Route::get('/show-unittypes',[App\Http\Controllers\UnitTypeController::class,'index'])->name('show-unittypes');
Route::get('/edit-unittype/{id}',[App\Http\Controllers\UnitTypeController::class,'edit_unittype'])->name('edit-unittype');
Route::post('/update_unittype',[App\Http\Controllers\UnitTypeController::class,'update_unittype'])->name('update_unittype');
Route::get('/add-unittype',[App\Http\Controllers\UnitTypeController::class,'create_unittype'])->name('add-unittype');
Route::post('/store_unittype',[App\Http\Controllers\UnitTypeController::class,'store_unittype'])->name('store_unittype');
Route::get('/ajax_script/deleteUnitType', [App\Http\Controllers\UnitTypeController::class,'deleteUnitType']);


Route::get('/show-packagingtypes',[App\Http\Controllers\PackagingTypeController::class,'index'])->name('show-packagingtypes');
Route::get('/edit-packagingtype/{id}',[App\Http\Controllers\PackagingTypeController::class,'edit_packagingtype'])->name('edit-packagingtype');
Route::post('/update_packagingtype',[App\Http\Controllers\PackagingTypeController::class,'update_packagingtype'])->name('update_packagingtype');
Route::get('/add-packagingtype',[App\Http\Controllers\PackagingTypeController::class,'create_packagingtype'])->name('add-packagingtype');
Route::post('/store_packagingtype',[App\Http\Controllers\PackagingTypeController::class,'store_packagingtype'])->name('store_packagingtype');
Route::get('/ajax_script/deletePackagingType', [App\Http\Controllers\PackagingTypeController::class,'deletePackagingType']);



Route::get('/show-packagings',[App\Http\Controllers\PackagingController::class,'index'])->name('show-packagings');
Route::get('/transport-package-items/{id}',[App\Http\Controllers\PackagingController::class,'transport_packaging_items'])->name('transport-package-items');
Route::post('/transportAllotment',[App\Http\Controllers\PackagingController::class,'transportAllotment'])->name('transportAllotment');
Route::get('/ajax_script/getTransportDetails', [App\Http\Controllers\PackagingController::class,'getTransportDetails']);

Route::get('/print-package-items/{id}',[App\Http\Controllers\PackagingController::class,'print_packaging_items'])->name('print-package-items');

Route::get('/edit-packaging/{id}',[App\Http\Controllers\PackagingController::class,'edit_packaging'])->name('edit-packaging');
Route::post('/update_packaging',[App\Http\Controllers\PackagingController::class,'update_packaging'])->name('update_packaging');
Route::get('/add-packaging',[App\Http\Controllers\PackagingController::class,'create_packaging'])->name('add-packaging');
Route::post('/store_packaging',[App\Http\Controllers\PackagingController::class,'store_packaging'])->name('store_packaging');
Route::post('/genrate_package_invoice',[App\Http\Controllers\PackagingController::class,'genrate_package_invoice'])->name('genrate_package_invoice'); 
Route::get('/ajax_script/deletePackaging', [App\Http\Controllers\PackagingController::class,'deletePackaging']);



Route::get('/show-hsns',[App\Http\Controllers\HSNController::class,'index'])->name('show-hsns');
Route::get('/edit-hsn/{id}',[App\Http\Controllers\HSNController::class,'edit_hsn'])->name('edit-hsn');
Route::post('/update_hsn',[App\Http\Controllers\HSNController::class,'update_hsn'])->name('update_hsn');
Route::get('/add-hsn',[App\Http\Controllers\HSNController::class,'create_hsn'])->name('add-hsn');
Route::post('/store_hsn',[App\Http\Controllers\HSNController::class,'store_hsn'])->name('store_hsn');
Route::get('/ajax_script/deleteHSN', [App\Http\Controllers\HSNController::class,'deleteHSN']);

Route::get('/show-itemtypes',[App\Http\Controllers\ItemTypeController::class,'index'])->name('show-itemtypes');
Route::get('/edit-itemtype/{id}',[App\Http\Controllers\ItemTypeController::class,'edit_itemtype'])->name('edit-itemtype');
Route::post('/update_itemtype',[App\Http\Controllers\ItemTypeController::class,'update_itemtype'])->name('update_itemtype');
Route::get('/add-itemtype',[App\Http\Controllers\ItemTypeController::class,'create_itemtype'])->name('add-itemtype');
Route::post('/store_itemtype',[App\Http\Controllers\ItemTypeController::class,'store_itemtype'])->name('store_itemtype');
Route::get('/ajax_script/deleteItemType', [App\Http\Controllers\ItemTypeController::class,'deleteItemType']);

Route::get('/show-items',[App\Http\Controllers\ItemController::class,'index'])->name('show-items');
Route::get('/edit-item/{id}',[App\Http\Controllers\ItemController::class,'edit'])->name('edit-item');
Route::post('/update_item',[App\Http\Controllers\ItemController::class,'update'])->name('update_item');
Route::get('/add-item',[App\Http\Controllers\ItemController::class,'create'])->name('add-item');
Route::post('/store_item',[App\Http\Controllers\ItemController::class,'store'])->name('store_item');
Route::get('/ajax_script/deleteItem', [App\Http\Controllers\ItemController::class,'deleteItem']);
Route::get('/ajax_script/showItemList', [App\Http\Controllers\ItemController::class,'showItemList']);

// Route::get('item_export',[ItemController::class, 'get_item_data'])->name('item.export');
Route::get('/export-items', [ItemController::class, 'export'])->name('item.export-items');
// Route::get('/export-items', 'ItemController@export');

Route::get('/show-purchases',[App\Http\Controllers\PurchaseController::class,'index'])->name('show-purchases');
Route::get('/edit-purchase/{id}',[App\Http\Controllers\PurchaseController::class,'edit'])->name('edit-purchase');
Route::post('/update_purchase',[App\Http\Controllers\PurchaseController::class,'update'])->name('update_purchase');
Route::get('/add-purchase',[App\Http\Controllers\PurchaseController::class,'create'])->name('add-purchase');
Route::post('/store_purchase',[App\Http\Controllers\PurchaseController::class,'store'])->name('store_purchase');
Route::get('/ajax_script/deletePurchase', [App\Http\Controllers\PurchaseController::class,'deletePurchase']);
Route::get('/print-purchase/{id}',[App\Http\Controllers\PurchaseController::class,'print_purchase'])->name('print-purchase');

Route::get('/show-saleorders',[App\Http\Controllers\SaleOrderController::class,'index'])->name('show-saleorders');
Route::get('/show-saleorderitems',[App\Http\Controllers\SaleOrderController::class,'show_sale_order_items'])->name('show-saleorderitems');
Route::get('/edit-saleorder/{id}',[App\Http\Controllers\SaleOrderController::class,'edit'])->name('edit-saleorder');
Route::post('/update-saleorder',[App\Http\Controllers\SaleOrderController::class,'update'])->name('update-saleorder');
Route::get('/add-saleorder',[App\Http\Controllers\SaleOrderController::class,'create'])->name('add-saleorder');
Route::post('/store-saleorder',[App\Http\Controllers\SaleOrderController::class,'store'])->name('store-saleorder');
Route::get('/ajax_script/deleteSaleOrder', [App\Http\Controllers\SaleOrderController::class,'deleteSaleOrder']);
Route::get('/print-saleorder/{id}',[App\Http\Controllers\SaleOrderController::class,'print_saleorder'])->name('print-saleorder');

Route::get('/show-saleorder-workorder-details/{id}',[App\Http\Controllers\SaleOrderController::class,'show_saleorder_work_order_details'])->name('show-saleorder-workorder-details');

Route::get('/show-stations',[App\Http\Controllers\StationController::class,'index'])->name('show-stations');
Route::get('/edit-station/{id}',[App\Http\Controllers\StationController::class,'edit_station'])->name('edit-station');
Route::post('/update_station',[App\Http\Controllers\StationController::class,'update_station'])->name('update_station');
Route::get('/add-station',[App\Http\Controllers\StationController::class,'create_station'])->name('add-station');
Route::post('/store_station',[App\Http\Controllers\StationController::class,'store_station'])->name('store_station');
Route::get('/ajax_script/deleteStation', [App\Http\Controllers\StationController::class,'deleteStation']);

Route::get('/show-transports/{id}',[App\Http\Controllers\TransportController::class,'index'])->name('show-transports');
Route::get('/edit-transport/{id}',[App\Http\Controllers\TransportController::class,'edit_transport'])->name('edit-transport');
Route::post('/update_transport',[App\Http\Controllers\TransportController::class,'update_transport'])->name('update_transport');
Route::get('/add-transport/{id}',[App\Http\Controllers\TransportController::class,'create_transport'])->name('add-transport');
Route::post('/store_transport',[App\Http\Controllers\TransportController::class,'store_transport'])->name('store_transport');
Route::get('/ajax_script/deleteTransport', [App\Http\Controllers\TransportController::class,'deleteTransport']);

Route::get('/show-alloted-transport',[App\Http\Controllers\TransportController::class,'index'])->name('show-alloted-transport');
// new route by PK //
Route::get('/show-transport-allotments',[App\Http\Controllers\TransportController::class,'showTransportAllotments'])->name('show-transport-allotments');
// new route by PK //
Route::get('/show-individualaddresses',[App\Http\Controllers\IndividualAddressController::class,'index'])->name('show-individualaddresses');
Route::get('/edit-individualaddress/{id}',[App\Http\Controllers\IndividualAddressController::class,'edit_individualaddress'])->name('edit-individualaddress');
Route::post('/update_individualaddress',[App\Http\Controllers\IndividualAddressController::class,'update_individualaddress'])->name('update_individualaddress');
Route::get('/add-individualaddress',[App\Http\Controllers\IndividualAddressController::class,'create_individualaddress'])->name('add-individualaddress');
Route::post('/store_individualaddress',[App\Http\Controllers\IndividualAddressController::class,'store_individualaddress'])->name('store_individualaddress');
Route::get('/ajax_script/deleteIndividualAddress', [App\Http\Controllers\IndividualAddressController::class,'deleteIndividualAddress']);

Route::get('/show-individual-member-addresses/{id}',[App\Http\Controllers\IndividualAddressController::class,'get_individual_addresses_list'])->name('show-individual-member-addresses');
Route::post('/update_individual_member_address',[App\Http\Controllers\IndividualAddressController::class,'update'])->name('update_individual_member_address');
Route::get('/add-individual-member-address/{id}',[App\Http\Controllers\IndividualAddressController::class,'create'])->name('add-individual-member-address'); 
Route::get('/edit-individual-member-address/{id}',[App\Http\Controllers\IndividualAddressController::class,'edit'])->name('edit-individual-member-address');
Route::post('/store_individual_member_address',[App\Http\Controllers\IndividualAddressController::class,'store'])->name('store_individual_member_address');


Route::get('/show-vendors/{id}',[App\Http\Controllers\VendorController::class,'index'])->name('show-vendors');
Route::get('/edit-vendor/{id}',[App\Http\Controllers\VendorController::class,'edit_vendor'])->name('edit-vendor');
Route::post('/update_vendor',[App\Http\Controllers\VendorController::class,'update_vendor'])->name('update_vendor');
Route::get('/add-vendor/{id}',[App\Http\Controllers\VendorController::class,'create_vendor'])->name('add-vendor');
Route::post('/store_vendor',[App\Http\Controllers\VendorController::class,'store_vendor'])->name('store_vendor');
Route::get('/ajax_script/deleteVendor', [App\Http\Controllers\VendorController::class,'deleteVendor']);

Route::get('/show-labourers/{id}',[App\Http\Controllers\LabourerController::class,'index'])->name('show-labourers');
Route::get('/edit-labourer/{id}',[App\Http\Controllers\LabourerController::class,'edit_labourer'])->name('edit-labourer');
Route::post('/update_labourer',[App\Http\Controllers\LabourerController::class,'update_labourer'])->name('update_labourer');
Route::get('/add-labourer/{id}',[App\Http\Controllers\LabourerController::class,'create_labourer'])->name('add-labourer');
Route::post('/store_labourer',[App\Http\Controllers\LabourerController::class,'store_labourer'])->name('store_labourer');
Route::get('/ajax_script/deleteLabourer', [App\Http\Controllers\LabourerController::class,'deleteLabourer']);

Route::get('/show-agents/{id}',[App\Http\Controllers\AgentController::class,'index'])->name('show-agents');
Route::get('/edit-agent/{id}',[App\Http\Controllers\AgentController::class,'edit_agent'])->name('edit-agent');
Route::post('/update_agent',[App\Http\Controllers\AgentController::class,'update_agent'])->name('update_agent');
Route::get('/add-agent/{id}',[App\Http\Controllers\AgentController::class,'create_agent'])->name('add-agent');
Route::post('/store_agent',[App\Http\Controllers\AgentController::class,'store_agent'])->name('store_agent');
Route::get('/ajax_script/deleteAgent', [App\Http\Controllers\AgentController::class,'deleteAgent']);

Route::get('/show-masters/{id}',[App\Http\Controllers\MasterController::class,'index'])->name('show-masters');
Route::get('/edit-master/{id}',[App\Http\Controllers\MasterController::class,'edit_master'])->name('edit-master');
Route::post('/update_master',[App\Http\Controllers\MasterController::class,'update_master'])->name('update_master');
Route::get('/add-master/{id}',[App\Http\Controllers\MasterController::class,'create_master'])->name('add-master');
Route::post('/store_master',[App\Http\Controllers\MasterController::class,'store_master'])->name('store_master');
Route::get('/ajax_script/deleteMaster', [App\Http\Controllers\MasterController::class,'deleteMaster']);

Route::get('/show-customers/{id}',[App\Http\Controllers\CustomerController::class,'index'])->name('show-customers');
Route::get('/edit-customer/{id}',[App\Http\Controllers\CustomerController::class,'edit_customer'])->name('edit-customer');
Route::post('/update_customer',[App\Http\Controllers\CustomerController::class,'update_customer'])->name('update_customer');
Route::get('/add-customer/{id}',[App\Http\Controllers\CustomerController::class,'create_customer'])->name('add-customer');
Route::post('/store_customer',[App\Http\Controllers\CustomerController::class,'store_customer'])->name('store_customer');
Route::get('/ajax_script/deleteCustomer', [App\Http\Controllers\CustomerController::class,'deleteCustomer']);

Route::get('/list_vendor',[CommonController::class,'list_vendor'])->name('list_vendor');
Route::get('/list_customer',[CommonController::class,'list_customer'])->name('list_customer');
Route::get('/list_employee',[CommonController::class,'list_employee'])->name('list_employee');
Route::get('/list_transport',[CommonController::class,'list_transport'])->name('list_transport');
Route::get('/list_item',[CommonController::class,'list_item'])->name('list_item');
Route::get('/list_item_type',[CommonController::class,'list_item_type'])->name('list_item_type');
Route::get('/list_purchase_items',[CommonController::class,'list_purchase_items'])->name('list_purchase_items');
Route::get('/ajax_script/search_vendor_address', [CommonController::class,'search_vendor_address']);

Route::get('/ajax_script/search_customer_ship_address', [CommonController::class,'search_customer_ship_address']);

Route::get('/ajax_script/search_item_type', [CommonController::class,'search_item_type']);

Route::get('/list_warehouse_compartment',[CommonController::class,'list_warehouse_compartment'])->name('list_warehouse_compartment');
Route::get('/list_saleOrderNumer',[CommonController::class,'list_saleOrderNumer'])->name('list_saleOrderNumer');
Route::get('/ajax_script/search_customer_addressBilling', [CommonController::class,'search_customer_addressBilling']);
Route::get('/ajax_script/search_customer_addressShipping', [CommonController::class,'search_customer_addressShipping']);
Route::get('/ajax_script/search_customer_bill_address', [CommonController::class,'search_customer_bill_address']);
Route::get('/ajax_script/search_customer_address', [CommonController::class,'search_customer_address']);

Route::get('/fabric_list_item',[CommonController::class,'fabric_list_item'])->name('fabric_list_item');

Route::get('/find_saleOrderNumer',[CommonController::class,'find_saleOrderNumer'])->name('find_saleOrderNumer');

Route::get('/show-usermoduleassignments',[App\Http\Controllers\UserModuleAssignmentController::class,'index'])->name('show-usermoduleassignments');
Route::get('/edit-usermoduleassignment/{id}',[App\Http\Controllers\UserModuleAssignmentController::class,'edit_usermoduleassignment'])->name('edit-usermoduleassignment');
Route::post('/update_usermoduleassignment',[App\Http\Controllers\UserModuleAssignmentController::class,'update_usermoduleassignment'])->name('update_usermoduleassignment');
Route::get('/add-usermoduleassignment',[App\Http\Controllers\UserModuleAssignmentController::class,'create_usermoduleassignment'])->name('add-usermoduleassignment');
Route::post('/store_usermoduleassignment',[App\Http\Controllers\UserModuleAssignmentController::class,'store_usermoduleassignment'])->name('store_usermoduleassignment');
Route::get('/ajax_script/deleteUserModuleAssignment', [App\Http\Controllers\UserModuleAssignmentController::class,'deleteUserModuleAssignment']);

Route::get('/show-companies',[App\Http\Controllers\CompanyController::class,'index'])->name('show-companies');
Route::get('/edit-company/{id}',[App\Http\Controllers\CompanyController::class,'edit_company'])->name('edit-company');
Route::post('/update_company',[App\Http\Controllers\CompanyController::class,'update_company'])->name('update_company');
Route::get('/add-company',[App\Http\Controllers\CompanyController::class,'create_company'])->name('add-company');
Route::post('/store_company',[App\Http\Controllers\CompanyController::class,'store_company'])->name('store_company');
Route::get('/ajax_script/deleteCompany', [App\Http\Controllers\CompanyController::class,'deleteCompany']);

Route::get('/show-warehouse-item-out',[App\Http\Controllers\WarehouseItemOutController::class,'index'])->name('show-warehouse-item-out');
Route::get('/add-warehouse-item-out',[App\Http\Controllers\WarehouseItemOutController::class,'create'])->name('add-warehouse-item-out');
Route::post('/store_item_out',[App\Http\Controllers\WarehouseItemOutController::class,'store_item_out'])->name('store_item_out');

Route::get('/add-item-in-warehouse',[WarehouseItemController::class,'add_item_in_warehouse'])->name('add-item-in-warehouse');
Route::post('/store_item_in_warehouse',[WarehouseItemController::class,'store_item_in_warehouse'])->name('store_item_in_warehouse');

Route::get('/show',[WarehouseItemController::class,'index'])->name('show');
Route::get('/edit/{id}',[WarehouseItemController::class,'edit'])->name('edit');
Route::post('/update',[WarehouseItemController::class,'update'])->name('update');
Route::get('/add',[WarehouseItemController::class,'create'])->name('add');
Route::post('/store',[WarehouseItemController::class,'store'])->name('store');
Route::get('/show-warehouse-stock-report',[WarehouseItemController::class,'warehouse_stock_report'])->name('show-warehouse-stock-report');
Route::get('/show-stock-details-listing',[WarehouseItemController::class,'stock_details_listing'])->name('show-stock-details-listing');



Route::get('/ajax_script/search_warehouse_compartment', [WarehouseItemController::class,'search_warehouse_compartment']);
Route::get('/ajax_script/get_warehouse_compartment', [WarehouseItemController::class,'get_warehouse_compartment']);

Route::get('/ajax_script/getPurchaseItemDetails', [WarehouseItemController::class,'getPurchaseItemDetails']);
Route::get('/ajax_script/getPurchaseItems', [WarehouseItemController::class,'getPurchaseItems']);
Route::get('/ajax_script/getWarehouseCompEmployee', [WarehouseItemController::class,'getWarehouseCompEmployee']);
Route::post('/store',[WarehouseItemController::class,'store'])->name('store');
Route::get('/ajax_script/search_warehouse_compartm', [WarehouseItemController::class,'search_warehouse_compartm']);
Route::get('/ajax_script/deleteCompany', [App\Http\Controllers\CompanyController::class,'deleteCompany']);

Route::get('/show-users',[App\Http\Controllers\UserController::class,'index'])->name('show-users');
Route::get('/edit-user/{id}',[App\Http\Controllers\UserController::class,'edit_user'])->name('edit-user');
Route::post('/update_user',[App\Http\Controllers\UserController::class,'update_user'])->name('update_user');

// Route::get('/add-user/{id}',[App\Http\Controllers\UserController::class,'create_user'])->name('add-user');
Route::get('/add-user',[App\Http\Controllers\UserController::class,'create_user'])->name('add-user');

Route::post('/store_user',[App\Http\Controllers\UserController::class,'store_user'])->name('store_user');

Route::get('/show-saleentries',[App\Http\Controllers\SaleEntryController::class,'index'])->name('show-saleentries');
Route::post('/update_saleentry',[App\Http\Controllers\SaleEntryController::class,'update'])->name('update_saleentry');

Route::get('/add-saleentry',[App\Http\Controllers\SaleEntryController::class,'create'])->name('add-saleentry');

Route::get('/create-invoice-for-package/{id}',[App\Http\Controllers\SaleEntryController::class,'createInvoiceForPackage'])->name('create-invoice-for-package');


// Route::post('/genrate_package_invoice',[App\Http\Controllers\PackagingController::class,'genrate_package_invoice'])->name('genrate_package_invoice'); 

Route::post('/genrateInvoiceForPackage',[App\Http\Controllers\SaleEntryController::class,'genrateInvoiceForPackage'])->name('genrateInvoiceForPackage');
Route::post('/store_saleentry',[App\Http\Controllers\SaleEntryController::class,'store'])->name('store_saleentry');



Route::get('/print-saleentry/{id}',[App\Http\Controllers\SaleEntryController::class,'print_sale_entry'])->name('print-saleentry');
Route::get('/ajax_script/deleteSaleEntry', [App\Http\Controllers\SaleEntryController::class,'deleteSaleEntry']);



Route::get('/show-workorders',[App\Http\Controllers\WorkOrderController::class,'index'])->name('show-workorders');
Route::get('/add-workorder',[App\Http\Controllers\WorkOrderController::class,'create'])->name('add-workorder');
Route::post('/store_workorder',[App\Http\Controllers\WorkOrderController::class,'store'])->name('store_workorder');
Route::get('/ajax_script/deleteWorkOrder',[App\Http\Controllers\WorkOrderController::class,'deleteWorkOrder']);
Route::get('/print-workorder/{id}',[App\Http\Controllers\WorkOrderController::class,'print_workorder'])->name('print-workorder');
Route::get('/print-workorder-gatepass/{id}',[App\Http\Controllers\WorkOrderController::class,'print_workorder_gatepass'])->name('print-workorder-gatepass');
Route::get('/print-workorder-report/{id}',[App\Http\Controllers\WorkOrderController::class,'print_workorder_report'])->name('print-workorder-report');
Route::get('/show-workorder-report',[App\Http\Controllers\WorkOrderController::class,'show_workorder_report'])->name('show-workorder-report');
Route::get('/start-workorder/{id}',[App\Http\Controllers\WorkOrderController::class,'start_workorder'])->name('start-workorder');
Route::post('/update_startprocess',[App\Http\Controllers\WorkOrderController::class,'updateworkorder'])->name('update_startprocess');
Route::post('/update_endprocess',[App\Http\Controllers\WorkOrderController::class,'updateendworkorder'])->name('update_endprocess');

Route::post('/update_inspec_process',[App\Http\Controllers\WorkOrderController::class,'updateinspectionworkorder'])->name('update_inspec_process');
Route::post('/update_weaving_inspec_process',[WorkOrderController::class,'update_weaving_inspec_process'])->name('update_weaving_inspec_process');
Route::post('/update_dyeing_inspec_process',[WorkOrderController::class,'update_dyeing_inspec_process'])->name('update_dyeing_inspec_process');
Route::post('/update_coating_inspec_process',[WorkOrderController::class,'update_coating_inspec_process'])->name('update_coating_inspec_process');

Route::post('/create_work_order_for_weaving',[WorkOrderController::class,'create_work_order_for_weaving'])->name('create_work_order_for_weaving');
Route::post('/create_work_order_for_dying',[WorkOrderController::class,'create_work_order_for_dying'])->name('create_work_order_for_dying');
Route::post('/create_work_order_for_coating',[WorkOrderController::class,'create_work_order_for_coating'])->name('create_work_order_for_coating');
Route::post('/create_work_order_for_printing',[WorkOrderController::class,'create_work_order_for_printing'])->name('create_work_order_for_printing');

Route::post('/create_work_order_for_packaging',[WorkOrderController::class,'create_work_order_for_packaging'])->name('create_work_order_for_packaging');




Route::post('/accept_item_for_work',[WorkOrderController::class,'accept_item_for_work'])->name('accept_item_for_work');



// Route::get('/start-addworkorder/{id}/{itemid}/{saleordId}',[App\Http\Controllers\WorkOrderController::class,'start_addworkorder'])->name('start-addworkorder');
Route::get('/start-addworkorder/{id}/{ItemTypeId}',[App\Http\Controllers\WorkOrderController::class,'start_addworkorder'])->name('start-addworkorder');
Route::get('/check-warehouse-item-stock/{id}',[App\Http\Controllers\WorkOrderController::class,'check_warehouse_item_stock'])->name('check-warehouse-item-stock');
Route::get('/workorder-details/{id}',[App\Http\Controllers\WorkOrderController::class,'work_order_details'])->name('workorder-details');
Route::get('/start-requisition-process/{id}',[App\Http\Controllers\WorkOrderController::class,'start_requisition_process'])->name('start-requisition-process');
Route::get('/ajax_script/createWorkOrder', [App\Http\Controllers\WorkOrderController::class,'createWorkOrder']);
Route::get('/ajax_script/checkWarehouseItemStock', [App\Http\Controllers\WorkOrderController::class,'checkWarehouseItemStock']);
Route::get('/ajax_script/getWorkOrderDetails', [App\Http\Controllers\WorkOrderController::class,'getWorkOrderDetails']);
// Route::get('/ajax_script/acceptWorkOrderInWarehouse', [App\Http\Controllers\WorkOrderController::class,'acceptWorkOrderInWarehouse']);
 
Route::get('/ajax_script/checkIteminWarehouse', [App\Http\Controllers\WorkOrderController::class,'checkIteminWarehouse']);

Route::post('/accept_work_item_in_warehouse',[App\Http\Controllers\WorkOrderController::class,'accept_work_item_in_warehouse'])->name('accept_work_item_in_warehouse');
Route::get('/receive-work-item/{id}',[App\Http\Controllers\WorkOrderController::class,'receive_work_item'])->name('receive-work-item');
Route::post('/receive_work_item_in_warehouse',[App\Http\Controllers\WorkOrderController::class,'receive_work_item_in_warehouse'])->name('receive_work_item_in_warehouse');

Route::post('/add_work_requisition',[App\Http\Controllers\WorkOrderController::class,'add_work_requisition'])->name('add_work_requisition');
Route::post('/add_work_requisition_for_weaving',[App\Http\Controllers\WorkOrderController::class,'add_work_requisition_for_weaving'])->name('add_work_requisition_for_weaving');

Route::post('/add_work_requisition_for_dyeing',[App\Http\Controllers\WorkOrderController::class,'add_work_requisition_for_dyeing'])->name('add_work_requisition_for_dyeing');

Route::get('/show-purchaseorders',[App\Http\Controllers\PurchaseOrderController::class,'index'])->name('show-purchaseorders');
Route::get('/add-purchaseorder',[App\Http\Controllers\PurchaseOrderController::class,'create_purchaseorder'])->name('add-purchaseorder');
Route::post('/store_purchaseorder',[App\Http\Controllers\PurchaseOrderController::class,'store_purchaseorder'])->name('store_purchaseorder');
Route::get('/ajax_script/deletePurchaseOrder', [App\Http\Controllers\PurchaseOrderController::class,'deletePurchaseOrder']);
Route::get('/print-purchaseorder/{id}',[App\Http\Controllers\PurchaseOrderController::class,'print_purchaseorder'])->name('print-purchaseorder');

Route::get('/show-notifications',[App\Http\Controllers\NotificationController::class,'index'])->name('show-notifications');
Route::get('/show-warehouse-item-requirement',[WorkProcessRequirementController::class,'index'])->name('show-warehouse-item-requirement');

Route::get('/accept-warehouse-item-requirement/{id}',[WorkProcessRequirementController::class,'accept_warehouse_item_requirement'])->name('accept-warehouse-item-requirement');

Route::post('/StoreWarehouseStockAllotment',[WorkProcessRequirementController::class,'StoreWarehouseStockAllotment'])->name('StoreWarehouseStockAllotment');


Route::get('/ajax_script/getWorkProcessRequirement', [WorkProcessRequirementController::class,'getWorkProcessRequirement']);
Route::get('/ajax_script/getWorkProcessAllotmentView', [WorkProcessRequirementController::class,'getWorkProcessAllotmentView']);
Route::get('/ajax_script/getProcessRequirementItems', [WorkProcessRequirementController::class,'getProcessRequirementItems']);
Route::get('/ajax_script/getSumWarehouseItemStockValue', [WorkProcessRequirementController::class,'getSumWarehouseItemStockValue']);


Route::post('/add_work_purchase_requisition',[WorkPurchaseRequirementController::class,'add_work_purchase_requisition'])->name('add_work_purchase_requisition');
Route::get('/add-purchase-request',[WorkPurchaseRequirementController::class,'create'])->name('add-purchase-request');
Route::post('/store_purchase_request',[WorkPurchaseRequirementController::class,'store'])->name('store_purchase_request');
Route::get('/show-work-purchase-requirement',[WorkPurchaseRequirementController::class,'index'])->name('show-work-purchase-requirement');

Route::get('/ajax_script/AcceptWarehouseItemReq', [WorkPurchaseRequirementController::class,'AcceptWarehouseItemReq']);
Route::get('/ajax_script/DenyWarehouseItemReq', [WorkPurchaseRequirementController::class,'DenyWarehouseItemReq']);



Route::get('/print-warehouse-item-requirement-gatepass/{id}',[App\Http\Controllers\WorkProcessRequirementController::class,'print_warehouse_item_requirement_gatepass'])->name('print-warehouse-item-requirement-gatepass');



//below line added by Dinesh on 27/09/2023
Route::get('/show-gstrates',[App\Http\Controllers\GstRateController::class,'index'])->name('show-gstrates');
Route::get('/ajax_script/activateGstRate/{gst_rate_id}', [App\Http\Controllers\GstRateController::class,'activateGstRate']);
Route::get('/ajax_script/deactivateGstRate/{gst_rate_id}', [App\Http\Controllers\GstRateController::class,'deactivateGstRate']);

Route::get('/beam-card',[App\Http\Controllers\HSNController::class,'beam_card'])->name('beam-card');
Route::get('/beam-card-first',[App\Http\Controllers\HSNController::class,'beam_card_first'])->name('beam-card-first');
Route::get('/job-card',[App\Http\Controllers\HSNController::class,'job_card'])->name('job-card');
Route::get('/manage-yarn/{id}',[App\Http\Controllers\ItemController::class,'manage_yarn'])->name('manage-yarn');

Route::post('/add_manage_yarn',[App\Http\Controllers\ItemController::class,'add_manage_yarn'])->name('add_manage_yarn');
Route::get('/ajax_script/deleteYarn', [App\Http\Controllers\ItemController::class,'deleteYarn']);
Route::view('barcode', 'barcode');

Route::get('/list-sales-order/{id}',[App\Http\Controllers\SaleOrderController::class,'list_sales_order'])->name('list-sales-order/');
Route::get('/list-sales-entry/{id}',[App\Http\Controllers\SaleEntryController::class,'list_sales_entry'])->name('list-sales-entry/');

Route::get('/list-purchage-order/{id}',[App\Http\Controllers\PurchaseOrderController::class,'list_purchage_order'])->name('list-purchage-order/');
Route::get('/list-purchage-entry/{id}',[App\Http\Controllers\PurchaseController::class,'list_purchage_entry'])->name('list-purchage-entry/');

// below line using for creating sales order by only venders and customers
Route::get('/add-sales-order/{individual_id}',[App\Http\Controllers\SaleOrderController::class,'create'])->name('add-sales-order');
Route::get('/print-purchase-new/{id}',[App\Http\Controllers\PurchaseController::class,'print_purchase_new'])->name('print-purchase-new');


Route::get('/show-allpages',[App\Http\Controllers\AllPageController::class,'index'])->name('show-allpages');
Route::get('/edit-allpage/{id}',[App\Http\Controllers\AllPageController::class,'edit'])->name('edit-allpage');
Route::post('/update_allpage',[App\Http\Controllers\AllPageController::class,'update'])->name('update_allpage');
Route::get('/add-allpage',[App\Http\Controllers\AllPageController::class,'create'])->name('add-allpage');
Route::post('/store_allpage',[App\Http\Controllers\AllPageController::class,'store'])->name('store_allpage');
Route::get('/ajax_script/deleteAllPage', [App\Http\Controllers\AllPageController::class,'deleteAllPage']);



Route::get('/show-userwebpages',[App\Http\Controllers\UserWebPageController::class,'index'])->name('show-userwebpages');
Route::get('/edit-userwebpage/{id}',[App\Http\Controllers\UserWebPageController::class,'edit'])->name('edit-userwebpage');
Route::post('/update_userwebpage',[App\Http\Controllers\UserWebPageController::class,'update'])->name('update_userwebpage');
Route::get('/add-userwebpage',[App\Http\Controllers\UserWebPageController::class,'create'])->name('add-userwebpage');
Route::get('/indadd-userwebpage/{id}',[App\Http\Controllers\UserWebPageController::class,'create_userwebpage'])->name('indadd-userwebpage');
Route::post('/store_userwebpage',[App\Http\Controllers\UserWebPageController::class,'store'])->name('store_userwebpage');
Route::get('/ajax_script/deleteUserWebPage', [App\Http\Controllers\UserWebPageController::class,'deleteUserWebPage']);
  



Route::get('/ajax_script/updateDefaultAddress', [IndividualAddressController::class, 'updateDefaultAddress']);

// Route::get('/ajax_script/deleteIndividualAddress', [App\Http\Controllers\IndividualAddressController::class,'deleteIndividualAddress']);



