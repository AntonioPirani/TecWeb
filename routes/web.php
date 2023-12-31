<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\AutoController;
use App\Http\Controllers\CittaController;
use App\Http\Controllers\MessaggiController;

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
                    /*CATALOGO*/
Route::get('/', [PublicController::class, 'showAuto'])
        ->name('auto');


                    /*FILTRI*/
Route::get('/filtroPrezzo',[PublicController::class,'filtraPrezzo'])
    ->name('prezzo');

Route::get('/filtroPosti',[PublicController::class,'filtraPosti'])
    ->name('posti');

Route::get('/filtroAnd',[PublicController::class,'filtroAnd'])
    ->name('andFilter');

Route::get('/filtroData',[PublicController::class,'filtroData'])
    ->name('data');

Route::get('/bigFilter',[PublicController::class,'dataANDprezzo'])
    ->name('bigFilter');




                    /*PRENOTAZIONI*/
Route::get('/addPrenotazione/{targa}',[UserController::class,'addPrenotazione'])
        ->name('addPrenotazione')->middleware('can:isUser');

Route::post('/storePrenotazione',[UserController::class,'storePrenotazione'])
    ->name('storePrenotazione');

Route::get('/deletePrenotazione/{id}',[UserController::class,'deletePrenotazione'])
    ->name('deletePrenotazione')->middleware('can:isUser');

Route::post('/cancellaPrenotazione',[UserController::class,'cancellaPrenotazione'])
    ->name('cancellaPrenotazione');

Route::get('/modifyPrenotazione/{id}',[UserController::class,'modifyPrenotazione'])
    ->name('modifyPrenotazione')->middleware('can:isUser');

Route::post('/updatePrenotazione',[UserController::class,'updatePrenotazione'])
    ->name('updatePrenotazione');



                /*ADMIN*/
Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin');

Route::get('/admin/addstaff', [StaffController::class, 'add'])
        ->name('addstaff');

Route::post('/admin/storestaff', [StaffController::class, 'store'])
        ->name('storestaff');

Route::get('/admin/editstaff', [StaffController::class, 'edit'])
        ->name('editstaff');

Route::post('/admin/updatestaff', [StaffController::class, 'update'])
        ->name('updatestaff');

Route::get('/admin/getstaffdetails', [StaffController::class, 'getStaffDetails'])
        ->name('getstaffdetails');

Route::delete('/admin/deletestaff', [StaffController::class, 'delete'])
        ->name('deletestaff');



            /*HOMEPAGES USER E STAFF*/
Route::get('/user', [UserController::class, 'index'])
        ->name('user')->middleware('can:isUser');

Route::get('/staff', [StaffController::class, 'index'])
        ->name('staff')->middleware('can:isStaff');



        /* --- NAVBAR --- */
Route::view('/where', 'where')
        ->name('where');

Route::view('/who', 'who')
        ->name('who');

        /*MessaggiController*/
Route::middleware(['messageMiddleware', 'auth'])->group(function () {
        Route::get('/checkMessaggiAdmin',[MessaggiController::class,'inboxAdmin'])
        ->name('inboxAdmin');

        Route::get('/rispondiAdmin',[MessaggiController::class,'rispondiAdmin'])
        ->name('rispondiAdmin');

        Route::get('/messaging', [MessaggiController::class, 'index'])

        ->name('messaging');

        Route::post('/send-message-to-admin', [MessaggiController::class, 'sendMessageToAdmin'])

        ->name('sendMessageToAdmin');
});


        /* --- FAQS --- */

Route::get('/faqs', [FaqController::class, 'index'])
        ->name('faqs');;

Route::get('/admin/addfaq', [FaqController::class, 'add'])
        ->name('addfaq');

Route::post('/admin/storefaq', [FaqController::class, 'store'])
        ->name('storefaq');

Route::get('/admin/editfaq', [FaqController::class, 'edit'])
        ->name('editfaq');

Route::post('/admin/updatefaq', [FaqController::class, 'update'])
        ->name('updatefaq');

Route::get('/admin/getfaqdetails', [FaqController::class, 'getFaqDetails'])
        ->name('getfaqdetails');

Route::delete('/admin/deletefaq', [FaqController::class, 'delete'])
        ->name('deletefaq');

        /* --- Statistiche --- */

Route::get('/admin/monthly-stats', [StatsController::class, 'monthlyStatistics'])
        ->name('monthly-stats');

        /* --- Rotte Private Condivise: Auto e Statistiche --- */

Route::middleware(['checkStaffOrAdmin', 'auth'])->group(function () {
        Route::get('/shared/addauto', [AutoController::class, 'add'])
                ->name('addauto');

        Route::post('/shared/storeauto', [AutoController::class, 'store'])
                ->name('storeauto');

        Route::get('/shared/editauto', [AutoController::class, 'edit'])
                ->name('editauto');

        Route::post('/shared/updateauto', [AutoController::class, 'update'])
                ->name('updateauto');

        Route::get('/shared/getautodetails', [AutoController::class, 'getAutoDetails'])
                ->name('getautodetails');

        Route::delete('/shared/deleteauto', [AutoController::class, 'delete'])
                ->name('deleteauto');

        Route::get('/shared/rentals', [StatsController::class, 'rentalsPerMonth'])
                ->name('rentals');
});

        /* --- Elimina Utente --- */

Route::get('/delete-user', [UserController::class, 'delete'])
        ->name('delete-user');

Route::delete('/delete-user', [UserController::class, 'deleteUser'])
        ->name('delete-user');

        /* --- Modifica Utente --- */

Route::get('/user/edit', [UserController::class, 'edit'])
        ->name('edituser');

Route::put('/user/edit', [UserController::class, 'editUser'])
        ->name('edituser');

        /* --- Indirizzi DB --- */

Route::get('/get-provinces', [CittaController::class, 'getProvinces'])
        ->name('get-provinces');

Route::get('/get-cities/{province}', [CittaController::class, 'getCities'])
        ->name('get-cities');


require __DIR__.'/auth.php';
