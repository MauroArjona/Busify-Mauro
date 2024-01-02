<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\TravelReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Supervisor;
use App\Models\Driver;
use App\Http\Controllers\ReportController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
]);

//crear grupo de rutas para el controlador de servicios
Route::group(['prefix' => 'user'], function () {
    Route::get('/update', [UpdateUserProfileInformation::class, 'update'])->name('client.update-user');
});

Route::group(['prefix' => 'contract'], function () {
    Route::get('/waitingApproval', [ContractController::class, 'waitingApproval'])->name('contract.waitingApproval');
    Route::get('/enabled', [ContractController::class, 'enabled'])->name('contract.enabled');
    Route::post('/approve/{id}', [ContractController::class, 'approve'])->name('contract.approve');
    Route::post('/reject/{id}', [ContractController::class, 'reject'])->name('contract.reject');
    Route::get('/contractClient', [ContractController::class, 'showContractClient'])->name('contract.contractClient');
    Route::resource('/contract', ContractController::class);
    Route::get('/historial', [ContractController::class, 'historialContract'])->name('contract.historial');
});


Route::resource('itinerary', ItineraryController::class);

Route::get('/allocate-resources/{id}', [ItineraryController::class, 'allocateResources'])->name('itinerary.allocate-resources');
Route::group(['prefix' => 'itinerary'], function () {
    Route::delete('/destroy-service/{id}', [ItineraryController::class, 'destroyService'])->name('itinerary.destroy-service');
});


Route::group(['prefix' => 'driver'], function () {
    Route::resource('/driver', DriverController::class);
    Route::post('/giveRest/{id}', [DriverController::class, 'giveRest'])->name('driver.giveRest');
    Route::post('/enable/{id}', [DriverController::class, 'enable'])->name('driver.enable');
    Route::get('/showTravelPlan', [DriverController::class, 'showTravelPlan'])->name('driver.showTravelPlan');
});

Route::resource('assistants', AssistantController::class);

Route::resource('client', ClientController::class);
Route::post('/client/desactivate/{idCliente}', [ClientController::class, 'desactivate'])->name('client.desactivate');

Route::resource('unit', UnitController::class);

Route::group(['prefix' => 'travel-report'], function () {
    Route::resource('travel-report', TravelReportController::class);
    Route::get('driverTravelReport', [TravelReportController::class, 'driverTravelReport'])->name('travel-report.driverTravelReport');
});



Route::resource('passenger', PassengerController::class);

Route::group(['prefix' => 'supervisor'], function () {
    Route::get('list-supervisors', [SupervisorController::class, 'index'])->name('supervisor.list-supervisors');
    Route::resource('supervisor', SupervisorController::class);
});


Route::resource('fee', FeeController::class);
Route::put('fee/update/{feeIds}', [FeeController::class, 'update'])->name('fee.update');


Route::post('payment/create', [PaymentController::class, 'create'])->name('payment.create');

Route::resource('payment', PaymentController::class);



Route::group(['prefix' => 'service'], function () {
    Route::resource('services', ServiceController::class);
    Route::get('list-services', [ServiceController::class, 'listServices'])->name('service.list-services');
    Route::get('service-price-simulator', [ServiceController::class, 'servicePriceSimulator'])->name('service.service-price-simulator');
    Route::post('calculate-price', [ServiceController::class, 'calculatePrice'])->name('service.calculate-price');
    Route::get('add-service', [ServiceController::class, 'addService'])->name('service.add-service');
    Route::get('load-service-modal', [ServiceController::class, 'addService'])->name('service.load-service-modal');
});

Route::resource('event', EventController::class);
Route::get('event/create/{id}', [EventController::class, 'create'])->name('event.create');


Route::group(['prefix' => 'employee'], function () {
    Route::resource('employee', EmployeeController::class);
});
Route::get('report/clients', [ReportController::class, 'showClientsReport'])->name('report-clients');
Route::get('report/units', [ReportController::class, 'showUnitsReport'])->name('report-units');
Route::get('report/incomes', [ReportController::class, 'showIncomesReport'])->name('report-incomes');

Route::resource('user', UserController::class);

//Agregar ruta a metpdo addService de controlador itinerary que tiene este encabezado y es PUT     public function addService(string $idTravelPlan, string $idService)
Route::put('itinerary/addService/{idTravelPlan}/{idService}', [ItineraryController::class, 'addService'])->name('itinerary.add-service');

Route::resource('price', PriceController::class);
