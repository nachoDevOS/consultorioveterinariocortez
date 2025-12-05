<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnamnesisFormController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MicroServiceController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WhatsappController;

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

Route::get('login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/', [HomeController::class, 'index']);
Route::post('/appointment', [HomeController::class, 'storeAppointment'])->name('appointment.store');
// Ruta para obtener las razas de un animal vía AJAX
Route::get('/api/races/{animal}', [HomeController::class, 'getRaces'])->name('api.races');


Route::get('/info/{id?}', [ErrorController::class , 'error'])->name('errors');
// Route::get('/development', [ErrorController::class , 'error503'])->name('development');

Route::group(['prefix' => 'admin', 'middleware' => ['loggin', 'system']], function () {
    Voyager::routes();

    Route::get('appointments', [AppointmentController::class, 'index'])->name('voyager.appointments.index');
    Route::get('appointments/ajax/list', [AppointmentController::class, 'list']);
    Route::post('appointments', [AppointmentController::class, 'store'])->name('voyager.appointments.store');
    Route::put('appointments/{id}', [AppointmentController::class, 'update'])->name('voyager.appointments.update');

    Route::get('people', [PersonController::class, 'index'])->name('voyager.people.index');
    Route::get('people/ajax/list', [PersonController::class, 'list']);
    Route::post('people', [PersonController::class, 'store'])->name('voyager.people.store');
    Route::put('people/{id}', [PersonController::class, 'update'])->name('voyager.people.update');

    Route::get('pets', [PetController::class, 'index'])->name('voyager.pets.index');
    Route::get('pets/ajax/list', [PetController::class, 'list']);
    Route::get('pets/create', [PetController::class, 'create'])->name('voyager.pets.create');
    Route::get('pets/{id}', [PetController::class, 'show'])->name('voyager.pets.show');
    Route::get('pets/{id}/edit', [PetController::class, 'edit'])->name('voyager.pets.edit');
    Route::post('pets', [PetController::class, 'store'])->name('voyager.pets.store');
    Route::put('pets/{id}', [PetController::class, 'update'])->name('voyager.pets.update');
    Route::delete('pets/{id}', [PetController::class, 'destroy'])->name('voyager.pets.destroy');
    Route::get('pets/{id}/history/create', [PetController::class, 'createHistory'])->name('voyager.pets.history.create');
    Route::post('pets/{pet}/history', [AnamnesisFormController::class, 'store'])->name('voyager.pets.history.store');

    Route::get('whatsapp', [MicroServiceController::class, 'message'])->name('whatsapp.message');


    Route::get('animals', [AnimalController::class, 'index'])->name('voyager.animals.index');
    Route::get('animals/ajax/list', [AnimalController::class, 'list']);
    Route::get('animals/{id}', [AnimalController::class, 'show'])->name('voyager.animals.show');

    // --- Rutas para Razas (Races) ---
    Route::post('races', [RaceController::class, 'store'])->name('voyager.races.store');
    Route::get('races/{id}/edit', [RaceController::class, 'edit'])->name('voyager.races.edit');
    Route::put('races/{id}', [RaceController::class, 'update'])->name('voyager.races.update');
    Route::delete('races/{id}', [RaceController::class, 'destroy'])->name('voyager.races.destroy');
    // Ruta para la lista AJAX de razas por animal
    Route::get('animals/{id}/races/ajax', [RaceController::class, 'ajaxList'])->name('animals.races.ajax');
    Route::post('races/ajax-store', [PetController::class, 'ajaxStoreRace'])->name('voyager.races.ajax.store');


    Route::resource('incomes', IncomeController::class);
    Route::get('incomes/ajax/list', [IncomeController::class, 'list']);
    Route::get('incomes/item/ajax', [AjaxController::class, 'itemList']);//Para obtener los item que esten registrado
    Route::post('incomes/{id}/payment', [IncomeController::class, 'storePayment'])->name('incomes-payment.store');
    Route::post('incomes/{id}/file', [IncomeController::class, 'fileStore'])->name('incomes-file.store');
    // Route::get('incomes/{id}/file/download', [IncomeController::class, 'downloadFile'])->name('incomes.file.download');

    Route::post('incomes/{id}/incomeDetail/transfer', [IncomeController::class, 'transferIncomeDetail'])->name('incomes-incomeDetail.transfer');//Para transferir los item a las sucursale que pue tengan stop  los item
    Route::delete('incomes/{id}/incomeDetail/transfer/{transfer}', [IncomeController::class, 'destroyTransferIncomeDetail'])->name('incomes-incomeDetail-transfer.destroy');

    Route::get('items', [ItemController::class, 'index'])->name('voyager.items.index');
    Route::get('items/ajax/list', [ItemController::class, 'list']);
    Route::post('items', [ItemController::class, 'store'])->name('voyager.items.store');
    Route::put('items/{id}', [ItemController::class, 'update'])->name('voyager.items.update');
    Route::get('items/{id}', [ItemController::class, 'show'])->name('voyager.items.show');
    Route::get('items/{id}/stock/ajax/list', [ItemController::class, 'listStock']);
    // Route::get('items/{id}/sales/ajax/list', [ItemController::class, 'listSales']);

    Route::post('items/{id}/stock', [ItemController::class, 'storeStock'])->name('items-stock.store');
    Route::delete('items/{id}/stock/{stock}', [ItemController::class, 'destroyStock'])->name('items-stock.destroy');




    // Users
    Route::get('users/ajax/list', [UserController::class, 'list']);
    Route::post('users/store', [UserController::class, 'store'])->name('voyager.users.store');
    Route::put('users/{id}', [UserController::class, 'update'])->name('voyager.users.update');
    Route::delete('users/{id}/deleted', [UserController::class, 'destroy'])->name('voyager.users.destroy');

    // Roles
    Route::get('roles/ajax/list', [RoleController::class, 'list']);


    Route::get('ajax/personList', [AjaxController::class, 'personList']);
    Route::post('ajax/person/store', [AjaxController::class, 'personStore']);

});


// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');

    // Artisan::call('db:seed', ['--class' => 'UpdateBreadSeeder']);
    // Artisan::call('db:seed', ['--class' => 'UpdatePermissionsSeeder']);
    
    return redirect('/admin/profile')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');