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
Route::get('/get-bldehs', [bldehcontroller::class, 'getbldehs']);
Route::get('/get-liftreasons', [liftreasoncontroller::class, 'getliftreasons']);
Route::get('/get-liftproritys', [liftproritycontroller::class, 'getliftproritys']);
Route::get('/get-banks', [bankcontroller::class, 'getbanks']);
Route::get('/get-streets', [streetcontroller::class, 'getstreets']);
Route::get('/get-employees', [employeecontroller::class, 'getemployees']);
Route::get('/get-containers', [containercontroller::class, 'getcontainers']);
Route::get('/get-containers1', [containercontroller::class, 'getcontainers1']);
Route::get('/get-paytypes', [paytypecontroller::class, 'getpaytypes']);
Route::get('/get-payperoids', [payperoidcontroller::class, 'getpayperoids']);
Route::get('/get-contractpaytypes', [contractpaytypecontroller::class, 'getcontractpaytypes']);
Route::get('/get-wastetypes', [wastetypecontroller::class, 'getwastetypes']);
Route::get('/get-customer/{customerid}', [customercontroller::class, 'getCustomerDetails']);
Route::post('/create-customer', [customercontroller::class, 'createCustomer']);
Route::get('/check-balance', [customercontroller::class, 'checkBalance']);
Route::get('/check-cash-customer', [customercontroller::class, 'checkCashCustomer']);
Route::get('/contact', [App\Http\Controllers\containerrequestController::class, 'contact']);
Route::get('/reqdel', [App\Http\Controllers\containerrequestController::class, 'reqdel'])->name('reqdel');
Route::post('/containerrequests/{id}/delete', [containerrequestController::class, 'delete'])->name('containerrequests.delete');
Route::post('/containerrequests/{id}/cancel', [containerrequestController::class, 'cancel'])->name('containerrequests.cancel');
Route::get('/comind', [App\Http\Controllers\containerrequestController::class, 'comind'])->name('comind');
Route::get('/{id}/complatereq', [App\Http\Controllers\containerrequestController::class, 'complatereq'])->name('complatereq');
Route::post('/{id}/comreq', [containerrequestController::class, 'comreq'])->name('comreq');
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
