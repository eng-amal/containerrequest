<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\containerrequestController;
use App\Http\Controllers\containersizeController;
use App\Http\Controllers\citycontroller;
use App\Http\Controllers\streetcontroller;
use App\Http\Controllers\paytypecontroller;
use App\Http\Controllers\containercontroller;
use App\Http\Controllers\employeecontroller;
use App\Http\Controllers\customercontroller;
use App\Http\Controllers\bankcontroller;
use App\Http\Controllers\liftreasoncontroller;
use App\Http\Controllers\liftproritycontroller;
use App\Http\Controllers\liftreqcontroller;
use App\Http\Controllers\bldehcontroller;
use App\Http\Controllers\payperoidcontroller;
use App\Http\Controllers\contractpaytypecontroller;
use App\Http\Controllers\wastetypecontroller;
use App\Http\Controllers\carcontroller;
use Barryvdh\DomPDF\Facade as PDF;
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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('containerrequests', containerrequestController::class);
Route::get('/get-containersizes', [containersizeController::class, 'getcontainersizes']);
Route::get('/get-cities', [citycontroller::class, 'getcities']);
Route::get('/get-cars', [carcontroller::class, 'getcars']);
Route::get('/get-bldehs', [bldehcontroller::class, 'getbldehs']);
Route::get('/get-liftreasons', [liftreasoncontroller::class, 'getliftreasons']);
Route::get('/get-liftproritys', [liftproritycontroller::class, 'getliftproritys']);
Route::get('/get-banks', [bankcontroller::class, 'getbanks']);
Route::get('/get-streets', [streetcontroller::class, 'getstreets']);
Route::get('/get-employees', [employeecontroller::class, 'getemployees']);
Route::get('/get-drivers', [employeecontroller::class, 'getdrivers']);
Route::get('/get-containers', [containercontroller::class, 'getcontainers']);
Route::get('/get-containers1', [containercontroller::class, 'getcontainers1']);
Route::get('/get-paytypes', [paytypecontroller::class, 'getpaytypes']);
Route::get('/get-payperoids', [payperoidcontroller::class, 'getpayperoids']);
Route::get('/get-contractpaytypes', [contractpaytypecontroller::class, 'getcontractpaytypes']);
Route::get('/get-wastetypes', [wastetypecontroller::class, 'getwastetypes']);
Route::get('/get-customer/{customerid}', [customercontroller::class, 'getCustomerDetails']);
Route::post('/create-customer', [customercontroller::class, 'createCustomer']);
Route::post('/get-customers', [customercontroller::class, 'getcustomers']);
Route::get('/check-balance', [customercontroller::class, 'checkBalance']);
Route::get('/check-cash-customer', [customercontroller::class, 'checkCashCustomer']);
Route::get('/contact', [App\Http\Controllers\containerrequestController::class, 'contact']);
Route::get('/reqdel', [App\Http\Controllers\containerrequestController::class, 'reqdel'])->name('reqdel');
Route::post('/containerrequests/{id}/delete', [containerrequestController::class, 'delete'])->name('containerrequests.delete');
Route::post('/containerrequests/{id}/cancel', [containerrequestController::class, 'cancel'])->name('containerrequests.cancel');
Route::get('/comind', [App\Http\Controllers\containerrequestController::class, 'comind'])->name('comind');
Route::get('/{id}/complatereq', [App\Http\Controllers\containerrequestController::class, 'complatereq'])->name('complatereq');
Route::post('/{id}/comreq', [containerrequestController::class, 'comreq'])->name('comreq');
Route::get('/{id}/comppending', [App\Http\Controllers\containerrequestController::class, 'comppending'])->name('comppending');
Route::post('/{id}/compendingreq', [containerrequestController::class, 'compendingreq'])->name('compendingreq');
Route::get('/showRequests', [App\Http\Controllers\containerrequestController::class, 'showRequests'])->name('showRequests');
Route::get('/{id}/fillreq', [App\Http\Controllers\containerrequestController::class, 'fillreq'])->name('fillreq');
Route::post('/store', [liftreqcontroller::class, 'store'])->name('store');

Route::get('/master', [App\Http\Controllers\containerrequestController::class, 'master'])->name('master');
Route::get('containerrequests/send/{id}', [ContainerRequestController::class, 'send'])->name('containerrequests.send');
Route::get('/managefillreq', [App\Http\Controllers\liftreqcontroller::class, 'managefillreq'])->name('managefillreq');
Route::get('/{id}/editfill', [App\Http\Controllers\liftreqcontroller::class, 'editfill'])->name('editfill');
Route::delete('/{id}/destroyfill', [App\Http\Controllers\liftreqcontroller::class, 'destroyfill'])->name('destroyfill');
Route::post('/{id}/updatereq', [App\Http\Controllers\liftreqcontroller::class, 'updatereq'])->name('updatereq');
Route::get('/send/{id}', [App\Http\Controllers\liftreqcontroller::class, 'send'])->name('send');
Route::get('/comfillind', [App\Http\Controllers\liftreqcontroller::class, 'comfillind'])->name('comfillind');
Route::get('/{id}/compfillreq', [App\Http\Controllers\liftreqcontroller::class, 'compfillreq'])->name('compfillreq');
Route::post('/{id}/compfillreq1', [App\Http\Controllers\liftreqcontroller::class, 'compfillreq1'])->name('compfillreq1');
Route::get('/uncomfillind', [App\Http\Controllers\liftreqcontroller::class, 'uncomfillind'])->name('uncomfillind');
Route::get('/{id}/uncompfillreq', [App\Http\Controllers\liftreqcontroller::class, 'uncompfillreq'])->name('uncompfillreq');
Route::post('/{id}/uncompfillreq1', [App\Http\Controllers\liftreqcontroller::class, 'uncompfillreq1'])->name('uncompfillreq1');
Route::get('/emptyind', [App\Http\Controllers\liftreqcontroller::class, 'emptyind'])->name('emptyind');
Route::get('/{id}/compemptyreq', [App\Http\Controllers\liftreqcontroller::class, 'compemptyreq'])->name('compemptyreq');
Route::get('/unemptyind', [App\Http\Controllers\liftreqcontroller::class, 'unemptyind'])->name('unemptyind');
Route::get('/{id}/uncompemptyreq', [App\Http\Controllers\liftreqcontroller::class, 'uncompemptyreq'])->name('uncompemptyreq');
Route::get('/createcontract', [App\Http\Controllers\contractcontroller::class, 'createcontract'])->name('createcontract');
Route::post('/storecontract', [App\Http\Controllers\contractcontroller::class, 'storecontract'])->name('storecontract');
Route::get('/contractindex', [App\Http\Controllers\contractcontroller::class, 'contractindex'])->name('contractindex');
Route::get('/{id}/contractedit', [App\Http\Controllers\contractcontroller::class, 'contractedit'])->name('contractedit');
Route::delete('/{id}/destroycontract', [App\Http\Controllers\contractcontroller::class, 'destroycontract'])->name('destroycontract');
Route::post('/{id}/contractupdate', [App\Http\Controllers\contractcontroller::class, 'contractupdate'])->name('contractupdate');
Route::get('/invoiceindex/{id}', [App\Http\Controllers\invoicecontroller::class, 'invoiceindex'])->name('invoiceindex');
Route::get('/{id}/createinvoice', [App\Http\Controllers\invoicecontroller::class, 'createinvoice'])->name('createinvoice');
Route::post('/storeinvoice', [App\Http\Controllers\invoicecontroller::class, 'storeinvoice'])->name('storeinvoice');
Route::get('/{id}/invoiceedit', [App\Http\Controllers\invoicecontroller::class, 'invoiceedit'])->name('invoiceedit');
Route::delete('/{id}/destroyinvoice', [App\Http\Controllers\invoicecontroller::class, 'destroyinvoice'])->name('destroyinvoice');
Route::post('/{id}/invoiceupdate', [App\Http\Controllers\invoicecontroller::class, 'invoiceupdate'])->name('invoiceupdate');
Route::get('/{id}/addcontractreq', [App\Http\Controllers\contractcontroller::class, 'addcontractreq'])->name('addcontractreq');
Route::post('/storecontactreq', [App\Http\Controllers\containerrequestController::class, 'storecontactreq'])->name('storecontactreq');
Route::get('/getRequests', [containerrequestController::class, 'getRequests'])->name('getRequests');
Route::get('/getContactRequests', [containerrequestController::class, 'getContactRequests'])->name('getContactRequests');
Route::get('/get-cost', [App\Http\Controllers\contsizecostcontroller::class, 'getCost']);
Route::get('/newfillrequest', [App\Http\Controllers\liftreqcontroller::class, 'newfillrequest'])->name('newfillrequest');
//department
Route::get('/departmentindex', [App\Http\Controllers\departmentcontroller::class, 'departmentindex'])->name('departmentindex');
Route::get('/createdepartment', [App\Http\Controllers\departmentcontroller::class, 'createdepartment'])->name('createdepartment');
Route::post('/storedepartment', [App\Http\Controllers\departmentcontroller::class, 'storedepartment'])->name('storedepartment');
Route::get('/{id}/departmentedit', [App\Http\Controllers\departmentcontroller::class, 'departmentedit'])->name('departmentedit');
Route::delete('/{id}/destroydepartment', [App\Http\Controllers\departmentcontroller::class, 'destroydepartment'])->name('destroydepartment');
Route::post('/{id}/departmentupdate', [App\Http\Controllers\departmentcontroller::class, 'departmentupdate'])->name('departmentupdate');
Route::get('/get-departments', [App\Http\Controllers\departmentcontroller::class, 'getdepartments']);
//position
Route::get('/positionindex', [App\Http\Controllers\positioncontroller::class, 'positionindex'])->name('positionindex');
Route::get('/createposition', [App\Http\Controllers\positioncontroller::class, 'createposition'])->name('createposition');
Route::post('/storeposition', [App\Http\Controllers\positioncontroller::class, 'storeposition'])->name('storeposition');
Route::get('/{id}/positionedit', [App\Http\Controllers\positioncontroller::class, 'positionedit'])->name('positionedit');
Route::delete('/{id}/destroyposition', [App\Http\Controllers\positioncontroller::class, 'destroyposition'])->name('destroyposition');
Route::post('/{id}/positionupdate', [App\Http\Controllers\positioncontroller::class, 'positionupdate'])->name('positionupdate');
Route::get('/get-positions', [App\Http\Controllers\positioncontroller::class, 'getpositions']);
//employee
Route::get('/employeeindex', [App\Http\Controllers\employeecontroller::class, 'employeeindex'])->name('employeeindex');
Route::get('/createemployee', [App\Http\Controllers\employeecontroller::class, 'createemployee'])->name('createemployee');
Route::post('/storeemployee', [App\Http\Controllers\employeecontroller::class, 'storeemployee'])->name('storeemployee');
Route::get('/{id}/employeeedit', [App\Http\Controllers\employeecontroller::class, 'employeeedit'])->name('employeeedit');
Route::delete('/{id}/destroyemployee', [App\Http\Controllers\employeecontroller::class, 'destroyemployee'])->name('destroyemployee');
Route::post('/{id}/employeeupdate', [App\Http\Controllers\employeecontroller::class, 'employeeupdate'])->name('employeeupdate');
//nationality
Route::get('/get-nationalitys', [App\Http\Controllers\nationalitycontroller::class, 'getnationalitys']);
//addition
Route::get('/additionindex/{id}', [App\Http\Controllers\additioncontroller::class, 'additionindex'])->name('additionindex');
Route::get('/{id}/createaddition', [App\Http\Controllers\additioncontroller::class, 'createaddition'])->name('createaddition');
Route::post('/storeaddition', [App\Http\Controllers\additioncontroller::class, 'storeaddition'])->name('storeaddition');
Route::get('/{id}/additionedit', [App\Http\Controllers\additioncontroller::class, 'additionedit'])->name('additionedit');
Route::post('/{id}/additionupdate', [App\Http\Controllers\additioncontroller::class, 'additionupdate'])->name('additionupdate');
Route::delete('/{id}/destroyaddition', [App\Http\Controllers\additioncontroller::class, 'destroyaddition'])->name('destroyaddition');
//decision
Route::get('/decisionindex/{id}', [App\Http\Controllers\decisioncontroller::class, 'decisionindex'])->name('decisionindex');
Route::get('/{id}/createdecision', [App\Http\Controllers\decisioncontroller::class, 'createdecision'])->name('createdecision');
Route::post('/storedecision', [App\Http\Controllers\decisioncontroller::class, 'storedecision'])->name('storedecision');
Route::get('/{id}/decisionedit', [App\Http\Controllers\decisioncontroller::class, 'decisionedit'])->name('decisionedit');
Route::post('/{id}/decisionupdate', [App\Http\Controllers\decisioncontroller::class, 'decisionupdate'])->name('decisionupdate');
Route::delete('/{id}/destroydecision', [App\Http\Controllers\decisioncontroller::class, 'destroydecision'])->name('destroydecision');
//stay

Route::get('/stayindex/{id}', [App\Http\Controllers\staycontroller::class, 'stayindex'])->name('stayindex');
Route::get('/{id}/createstay', [App\Http\Controllers\staycontroller::class, 'createstay'])->name('createstay');
Route::post('/storestay', [App\Http\Controllers\staycontroller::class, 'storestay'])->name('storestay');
Route::get('/{id}/stayedit', [App\Http\Controllers\staycontroller::class, 'stayedit'])->name('stayedit');
Route::post('/{id}/stayupdate', [App\Http\Controllers\staycontroller::class, 'stayupdate'])->name('stayupdate');
Route::delete('/{id}/destroystay', [App\Http\Controllers\staycontroller::class, 'destroystay'])->name('destroystay');
//vacation

Route::get('/vacationindex/{id}', [App\Http\Controllers\vacationcontroller::class, 'vacationindex'])->name('vacationindex');
Route::get('/{id}/createvacation', [App\Http\Controllers\vacationcontroller::class, 'createvacation'])->name('createvacation');
Route::post('/storevacation', [App\Http\Controllers\vacationcontroller::class, 'storevacation'])->name('storevacation');
Route::get('/{id}/vacationedit', [App\Http\Controllers\vacationcontroller::class, 'vacationedit'])->name('vacationedit');
Route::post('/{id}/vacationupdate', [App\Http\Controllers\vacationcontroller::class, 'vacationupdate'])->name('vacationupdate');
Route::delete('/{id}/destroyvacation', [App\Http\Controllers\vacationcontroller::class, 'destroyvacation'])->name('destroyvacation');
//salary
Route::get('/salaryindex', [App\Http\Controllers\employeecontroller::class, 'salaryindex'])->name('salaryindex');
Route::get('/calculateSalaries', [App\Http\Controllers\employeecontroller::class, 'calculateSalaries'])->name('calculateSalaries');
//login
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
//home
Route::get('/home', [App\Http\Controllers\homecontroller::class, 'home'])->name('home');
//user
Route::get('/resetPassword/{id}', [App\Http\Controllers\usercontroller::class, 'resetPassword'])->name('resetPassword');
Route::get('/userindex', [App\Http\Controllers\usercontroller::class, 'userindex'])->name('userindex');
Route::get('/createuser', [App\Http\Controllers\usercontroller::class, 'createuser'])->name('createuser');
Route::post('/storeuser', [App\Http\Controllers\usercontroller::class, 'storeuser'])->name('storeuser');
Route::delete('/{id}/destroyuser', [App\Http\Controllers\usercontroller::class, 'destroyuser'])->name('destroyuser');
//acount
Route::get('/get-accounts2', [App\Http\Controllers\accountcontroller::class, 'getaccounts2']);
Route::get('/get-accounts3', [App\Http\Controllers\accountcontroller::class, 'getaccounts3']);
Route::get('/get-accounts', [App\Http\Controllers\accountcontroller::class, 'getaccounts']);
Route::get('/createaccount', [App\Http\Controllers\accountcontroller::class, 'createaccount'])->name('createaccount');
Route::post('/storeaccount', [App\Http\Controllers\accountcontroller::class, 'storeaccount'])->name('storeaccount');
Route::delete('/{id}/destroyaccount', [App\Http\Controllers\accountcontroller::class, 'destroyaccount'])->name('destroyaccount');
Route::get('/accountindex', [App\Http\Controllers\accountcontroller::class, 'accountindex'])->name('accountindex');
Route::get('/get-next-account-code', [App\Http\Controllers\accountController::class, 'getNextAccountCode'])->name('get-next-account-code');
Route::get('/accountbalance', [App\Http\Controllers\accountController::class, 'accountbalance'])->name('accountbalance');
//sand
Route::get('/createsand', [App\Http\Controllers\sandcontroller::class, 'createsand'])->name('createsand');
Route::post('/storesand', [App\Http\Controllers\sandcontroller::class, 'storesand'])->name('storesand');
Route::get('/sandSearch', [App\Http\Controllers\sandcontroller::class, 'sandSearch'])->name('sandSearch');
//customer
Route::get('/customerindex', [App\Http\Controllers\customercontroller::class, 'customerindex'])->name('customerindex');
Route::get('/createcustomers', [App\Http\Controllers\customercontroller::class, 'createcustomers'])->name('createcustomers');
Route::post('/storecustomer', [App\Http\Controllers\customercontroller::class, 'storecustomer'])->name('storecustomer');
Route::get('/{id}/customeredit', [App\Http\Controllers\customercontroller::class, 'customeredit'])->name('customeredit');
Route::delete('/{id}/destroycustomer', [App\Http\Controllers\customercontroller::class, 'destroycustomer'])->name('destroycustomer');
Route::post('/{id}/customerupdate', [App\Http\Controllers\customercontroller::class, 'customerupdate'])->name('customerupdate');
//city
Route::get('/cityindex', [App\Http\Controllers\citycontroller::class, 'cityindex'])->name('cityindex');
Route::get('/createcity', [App\Http\Controllers\citycontroller::class, 'createcity'])->name('createcity');
Route::post('/storecity', [App\Http\Controllers\citycontroller::class, 'storecity'])->name('storecity');
Route::delete('/{id}/destroycity', [App\Http\Controllers\citycontroller::class, 'destroycity'])->name('destroycity');

//street
Route::get('/streetindex/{id}', [App\Http\Controllers\streetcontroller::class, 'streetindex'])->name('streetindex');
Route::get('/{id}/createstreet', [App\Http\Controllers\streetcontroller::class, 'createstreet'])->name('createstreet');
Route::post('/storestreet', [App\Http\Controllers\streetcontroller::class, 'storestreet'])->name('storestreet');
Route::delete('/{id}/destroystreet', [App\Http\Controllers\streetcontroller::class, 'destroystreet'])->name('destroystreet');

//containersize
Route::get('/containersizeindex', [App\Http\Controllers\containersizecontroller::class, 'containersizeindex'])->name('containersizeindex');
Route::get('/createcontainersize', [App\Http\Controllers\containersizecontroller::class, 'createcontainersize'])->name('createcontainersize');
Route::post('/storecontainersize', [App\Http\Controllers\containersizecontroller::class, 'storecontainersize'])->name('storecontainersize');
Route::delete('/{id}/destroycontainersize', [App\Http\Controllers\containersizecontroller::class, 'destroycontainersize'])->name('destroycontainersize');

//container
Route::get('/containerindex/{id}', [App\Http\Controllers\containercontroller::class, 'containerindex'])->name('containerindex');
Route::get('/{id}/createcontainer', [App\Http\Controllers\containercontroller::class, 'createcontainer'])->name('createcontainer');
Route::post('/storecontainer', [App\Http\Controllers\containercontroller::class, 'storecontainer'])->name('storecontainer');
Route::delete('/{id}/destroycontainer', [App\Http\Controllers\containercontroller::class, 'destroycontainer'])->name('destroycontainer');
//bank
Route::get('/bankindex', [App\Http\Controllers\bankcontroller::class, 'bankindex'])->name('bankindex');
Route::get('/createbank', [App\Http\Controllers\bankcontroller::class, 'createbank'])->name('createbank');
Route::post('/storebank', [App\Http\Controllers\bankcontroller::class, 'storebank'])->name('storebank');
Route::delete('/{id}/destroybank', [App\Http\Controllers\bankcontroller::class, 'destroybank'])->name('destroybank');
//bldeh
Route::get('/bldehindex', [App\Http\Controllers\bldehcontroller::class, 'bldehindex'])->name('bldehindex');
Route::get('/createbldeh', [App\Http\Controllers\bldehcontroller::class, 'createbldeh'])->name('createbldeh');
Route::post('/storebldeh', [App\Http\Controllers\bldehcontroller::class, 'storebldeh'])->name('storebldeh');
Route::delete('/{id}/destroybldeh', [App\Http\Controllers\bldehcontroller::class, 'destroybldeh'])->name('destroybldeh');
//basicclass
Route::get('/basicclassindex', [App\Http\Controllers\basicclasscontroller::class, 'basicclassindex'])->name('basicclassindex');
Route::get('/createbasicclass', [App\Http\Controllers\basicclasscontroller::class, 'createbasicclass'])->name('createbasicclass');
Route::post('/storebasicclass', [App\Http\Controllers\basicclasscontroller::class, 'storebasicclass'])->name('storebasicclass');
Route::delete('/{id}/destroybasicclass', [App\Http\Controllers\basicclasscontroller::class, 'destroybasicclass'])->name('destroybasicclass');

//secclass
Route::get('/secclassindex/{id}', [App\Http\Controllers\secclasscontroller::class, 'secclassindex'])->name('secclassindex');
Route::get('/{id}/createsecclass', [App\Http\Controllers\secclasscontroller::class, 'createsecclass'])->name('createsecclass');
Route::post('/storesecclass', [App\Http\Controllers\secclasscontroller::class, 'storesecclass'])->name('storesecclass');
Route::delete('/{id}/destroysecclass', [App\Http\Controllers\secclasscontroller::class, 'destroysecclass'])->name('destroysecclass');
Route::get('/get-basicclasss', [App\Http\Controllers\basicclasscontroller::class, 'getbasicclasss']);
Route::get('/get-secclasss', [App\Http\Controllers\secclasscontroller::class, 'getsecclasss']);
//nationality
Route::get('/nationalityindex', [App\Http\Controllers\nationalitycontroller::class, 'nationalityindex'])->name('nationalityindex');
Route::get('/createnationality', [App\Http\Controllers\nationalitycontroller::class, 'createnationality'])->name('createnationality');
Route::post('/storenationality', [App\Http\Controllers\nationalitycontroller::class, 'storenationality'])->name('storenationality');
Route::delete('/{id}/destroynationality', [App\Http\Controllers\nationalitycontroller::class, 'destroynationality'])->name('destroynationality');
//car
Route::get('/carindex', [App\Http\Controllers\carcontroller::class, 'carindex'])->name('carindex');
Route::get('/createcars', [App\Http\Controllers\carcontroller::class, 'createcars'])->name('createcars');
Route::post('/storecar', [App\Http\Controllers\carcontroller::class, 'storecar'])->name('storecar');
Route::get('/{id}/caredit', [App\Http\Controllers\carcontroller::class, 'caredit'])->name('caredit');
Route::delete('/{id}/destroycar', [App\Http\Controllers\carcontroller::class, 'destroycar'])->name('destroycar');
Route::post('/{id}/carupdate', [App\Http\Controllers\carcontroller::class, 'carupdate'])->name('carupdate');
//car examin
Route::get('/carexaminindex/{id}', [App\Http\Controllers\carexamincontroller::class, 'carexaminindex'])->name('carexaminindex');
Route::get('/{id}/createcarexamin', [App\Http\Controllers\carexamincontroller::class, 'createcarexamin'])->name('createcarexamin');
Route::post('/storecarexamin', [App\Http\Controllers\carexamincontroller::class, 'storecarexamin'])->name('storecarexamin');
Route::delete('/{id}/destroycarexamin', [App\Http\Controllers\carexamincontroller::class, 'destroycarexamin'])->name('destroycarexamin');
//operation card
Route::get('/operationcardindex/{id}', [App\Http\Controllers\operationcardcontroller::class, 'operationcardindex'])->name('operationcardindex');
Route::get('/{id}/createoperationcard', [App\Http\Controllers\operationcardcontroller::class, 'createoperationcard'])->name('createoperationcard');
Route::post('/storeoperationcard', [App\Http\Controllers\operationcardcontroller::class, 'storeoperationcard'])->name('storeoperationcard');
Route::delete('/{id}/destroyoperationcard', [App\Http\Controllers\operationcardcontroller::class, 'destroyoperationcard'])->name('destroyoperationcard');
//drivercard
Route::get('/drivercardindex/{id}', [App\Http\Controllers\drivercardcontroller::class, 'drivercardindex'])->name('drivercardindex');
Route::get('/{id}/createdrivercard', [App\Http\Controllers\drivercardcontroller::class, 'createdrivercard'])->name('createdrivercard');
Route::post('/storedrivercard', [App\Http\Controllers\drivercardcontroller::class, 'storedrivercard'])->name('storedrivercard');
Route::delete('/{id}/destroydrivercard', [App\Http\Controllers\drivercardcontroller::class, 'destroydrivercard'])->name('destroydrivercard');
//vendor
Route::get('/vendorindex', [App\Http\Controllers\vendorcontroller::class, 'vendorindex'])->name('vendorindex');
Route::get('/createvendor', [App\Http\Controllers\vendorcontroller::class, 'createvendor'])->name('createvendor');
Route::post('/storevendor', [App\Http\Controllers\vendorcontroller::class, 'storevendor'])->name('storevendor');
Route::get('/{id}/vendoredit', [App\Http\Controllers\vendorcontroller::class, 'vendoredit'])->name('vendoredit');
Route::delete('/{id}/destroyvendor', [App\Http\Controllers\vendorcontroller::class, 'destroyvendor'])->name('destroyvendor');
Route::post('/{id}/vendorupdate', [App\Http\Controllers\vendorcontroller::class, 'vendorupdate'])->name('vendorupdate');
Route::get('/get-vendors', [App\Http\Controllers\vendorcontroller::class, 'getvendors']);
//stock
Route::get('/createstock', [App\Http\Controllers\stockcontroller::class, 'createstock'])->name('createstock');
Route::post('/stockstore', [App\Http\Controllers\stockcontroller::class, 'stockstore'])->name('stockstore');
Route::get('/stockindex', [App\Http\Controllers\stockcontroller::class, 'stockindex'])->name('stockindex');
//evaluation
//template
Route::get('/createevaluationtemplate', [App\Http\Controllers\evaluationtemplatecontroller::class, 'createevaluationtemplate'])->name('createevaluationtemplate');
Route::post('/evaluationtemplatestore', [App\Http\Controllers\evaluationtemplatecontroller::class, 'evaluationtemplatestore'])->name('evaluationtemplatestore');
Route::get('/get-tems', [App\Http\Controllers\evaluationtemplatecontroller::class, 'gettems']);
//evaluation
Route::get('/createevaluation', [App\Http\Controllers\evaluationcontroller::class, 'createevaluation'])->name('createevaluation');
Route::post('/storeevaluation', [App\Http\Controllers\evaluationcontroller::class, 'storeevaluation'])->name('storeevaluation');
Route::get('/employee-evaluation/{id}', [App\Http\Controllers\empevaluationcontroller::class, 'showEvaluations'])->name('employee.evaluation');
Route::get('/evaluation-details/{evaluationId}/{employeeId}', [App\Http\Controllers\empevaluationcontroller::class, 'loadEvaluationDetails'])->name('employee.evaluation.details');
Route::post('/store-evaluation', [App\Http\Controllers\empevaluationcontroller::class, 'store'])->name('employee.evaluation.store');
Route::get('/evaluation', [App\Http\Controllers\empevaluationcontroller::class, 'evaluationindex'])->name('evaluation.index'); // Display the evaluation page
Route::get('/evaluation/results/{evaluationId}', [App\Http\Controllers\empevaluationcontroller::class, 'evaluationresults'])->name('evaluation.results'); // Fetch filtered results based on evaluationId
//contracttemplate
Route::get('/createcontracttemplate', [App\Http\Controllers\contracttemplatecontroller::class, 'createcontracttemplate'])->name('createcontracttemplate');
Route::post('/contracttemplatestore', [App\Http\Controllers\contracttemplatecontroller::class, 'contracttemplatestore'])->name('contracttemplatestore');
Route::get('/get-contems', [App\Http\Controllers\contracttemplatecontroller::class, 'getcontems']);
Route::get('/showcontracttemplates', [App\Http\Controllers\contractformcontroller::class, 'showcontracttemplates'])->name('showcontracttemplates');
Route::get('/contracttemplatedetails/{evaluationId}', [App\Http\Controllers\contractformcontroller::class, 'loadcontracttemplateDetails'])->name('contracttemplatedetails');
Route::post('/storecontractform', [App\Http\Controllers\contractformcontroller::class, 'storecontractform'])->name('storecontractform');
Route::get('/contract-report/{contracttemplateId}', [App\Http\Controllers\contractformcontroller::class, 'showReport'])->name('contract.report');
// تقارير
Route::get('/containers-report', [containerrequestController::class, 'showContainersReport'])->name('containers.report');
Route::get('/accounts-report', [App\Http\Controllers\accountController::class, 'showaccountReport'])->name('account.report');
Route::get('/evaluation/report/{evaluationId}', [App\Http\Controllers\empevaluationcontroller::class,'showevaReport'])->name('evaluation.report');
Route::get('/sales/report', [containerrequestController::class, 'showDailySalesReport'])->name('sales.report');
Route::get('/createsalereport', [containerrequestController::class, 'createsalereport'])->name('createsalereport');
Route::get('/createcontractreport', [App\Http\Controllers\contractcontroller::class, 'createcontractreport'])->name('createcontractreport');
Route::get('/contracts/report', [App\Http\Controllers\contractcontroller::class, 'showcontractReport'])->name('contracts.report');
Route::get('/createinvoicesreport', [App\Http\Controllers\invoicecontroller::class, 'createinvoicesreport'])->name('createinvoicesreport');
Route::get('/invoices/report', [App\Http\Controllers\invoicecontroller::class, 'showinvoiceReport'])->name('invoices.report');
Route::get('/createsandssreport', [App\Http\Controllers\sandcontroller::class, 'createsandssreport'])->name('createsandssreport');
Route::get('/sands/report', [App\Http\Controllers\sandcontroller::class, 'showsandReport'])->name('sands.report');
Route::get('/createmainrequestsreport', [App\Http\Controllers\maintinancerequestcontroller::class, 'createmainrequestsreport'])->name('createmainrequestsreport');
Route::get('/showmainReport', [App\Http\Controllers\maintinancerequestcontroller::class, 'showmainReport'])->name('showmainReport');
Route::get('/generate-report', [App\Http\Controllers\sandcontroller::class, 'generatesand']);
Route::get('/showstockReport', [App\Http\Controllers\stockController::class, 'showstockReport'])->name('showstockReport');
Route::get('/createpurchasereport', [App\Http\Controllers\purchaseordercontroller::class, 'createpurchasereport'])->name('createpurchasereport');
Route::get('/purchases/report', [App\Http\Controllers\purchaseordercontroller::class, 'showpurchaseReport'])->name('purchases.report');
Route::get('/createitemsreport', [App\Http\Controllers\stockcontroller::class, 'createitemsreport'])->name('createitemsreport');
Route::get('/items/report', [App\Http\Controllers\stockcontroller::class, 'showitemsReport'])->name('items.report');
Route::get('/createsandreq', [App\Http\Controllers\sandcontroller::class, 'createsandreq'])->name('createsandreq');
Route::get('/generatesandreq', [App\Http\Controllers\sandcontroller::class, 'generatesandreq']);
Route::get('/showcustomerReport', [App\Http\Controllers\customercontroller::class, 'showcustomerReport']);
//purchase
Route::get('/createpurchase', [App\Http\Controllers\purchaseordercontroller::class, 'createpurchase'])->name('createpurchase');
Route::post('/purchasestore', [App\Http\Controllers\purchaseordercontroller::class, 'purchasestore'])->name('purchasestore');
//custpay
Route::get('/generatereq-report', [App\Http\Controllers\custpaymentcontroller::class, 'generatecustpay']);
Route::get('/createcustpayment', [App\Http\Controllers\custpaymentcontroller::class, 'createcustpayment'])->name('createcustpayment');
Route::post('/storecustpayment', [App\Http\Controllers\custpaymentcontroller::class, 'storecustpayment'])->name('storecustpayment');
//complamintreason
Route::get('/complamintreasonindex', [App\Http\Controllers\complamintreasoncontroller::class, 'complamintreasonindex'])->name('complamintreasonindex');
Route::get('/createcomplamintreason', [App\Http\Controllers\complamintreasoncontroller::class, 'createcomplamintreason'])->name('createcomplamintreason');
Route::post('/storecomplamintreason', [App\Http\Controllers\complamintreasoncontroller::class, 'storecomplamintreason'])->name('storecomplamintreason');
Route::delete('/{id}/destroycomplamintreason', [App\Http\Controllers\complamintreasoncontroller::class, 'destroycomplamintreason'])->name('destroycomplamintreason');
Route::get('/get-complamintreasons', [App\Http\Controllers\complamintreasoncontroller::class, 'getcomplamintreasons']);
//complament
Route::get('/complamintindex', [App\Http\Controllers\complamintcontroller::class, 'complamintindex'])->name('complamintindex');
Route::get('/createcomplamint', [App\Http\Controllers\complamintcontroller::class, 'createcomplamint'])->name('createcomplamint');
Route::post('/storecomplamint', [App\Http\Controllers\complamintcontroller::class, 'storecomplamint'])->name('storecomplamint');
Route::get('/{id}/complamintedit', [App\Http\Controllers\complamintcontroller::class, 'complamintedit'])->name('complamintedit');
Route::delete('/{id}/destroycomplamint', [App\Http\Controllers\complamintcontroller::class, 'destroycomplamint'])->name('destroycomplamint');
Route::post('/{id}/complamintupdate', [App\Http\Controllers\complamintcontroller::class, 'complamintupdate'])->name('complamintupdate');
//maintinance
Route::get('/maintinancerequestindex', [App\Http\Controllers\maintinancerequestcontroller::class, 'maintinancerequestindex'])->name('maintinancerequestindex');
Route::get('/maintinancerequestindex1', [App\Http\Controllers\maintinancerequestcontroller::class, 'maintinancerequestindex1'])->name('maintinancerequestindex1');
Route::get('/createmaintinancerequest', [App\Http\Controllers\maintinancerequestcontroller::class, 'createmaintinancerequest'])->name('createmaintinancerequest');
Route::post('/storemaintinancerequest', [App\Http\Controllers\maintinancerequestcontroller::class, 'storemaintinancerequest'])->name('storemaintinancerequest');
Route::get('/{id}/maintinancerequestedit', [App\Http\Controllers\maintinancerequestcontroller::class, 'maintinancerequestedit'])->name('maintinancerequestedit');
Route::get('/{id}/maintinancerequestclos', [App\Http\Controllers\maintinancerequestcontroller::class, 'maintinancerequestclos'])->name('maintinancerequestclos');
Route::post('/{id}/maintinancerequestupdate', [App\Http\Controllers\maintinancerequestcontroller::class, 'maintinancerequestupdate'])->name('maintinancerequestupdate');
Route::post('/{id}/maintinancerequestclose', [App\Http\Controllers\maintinancerequestcontroller::class, 'maintinancerequestclose'])->name('maintinancerequestclose');
