<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
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
use UniSharp\LaravelFilemanager\Lfm;

Route::group([
    'prefix' => 'laravel-filemanager',
    'middleware' => ['web'],
], function () {
    Lfm::routes();
});
Route::get('/adm', function () {
    $user = new User;
    $user->name = 'shobhit';
    $user->email = 'admmin@gmail.com';
    $user->username = 'shobhit';
    $user->status = 1;
    $user->password = Hash::make('shob@7277');
    $user->save();

    return view('front.home');
});

Route::get('/', function () {
    return view('front.home');
});

Route::get('/about-us', function () {
    return view('front.about');
});
// Route::get('/bk', function () {
//     return view('layouts.backend');
// });

Route::get('/api/branches', function () {
    return \App\Models\Branch::select('id', 'branchName as name')->get();
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'isAdmin'], function () {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('role/{role_id}/give-perminssion', [App\Http\Controllers\RoleController::class, 'givePerminssion'])->name('givePerminssion');
    Route::put('role/{role_id}/give-perminssion', [App\Http\Controllers\RoleController::class, 'addPermissionsToRole'])->name('addPermissionsToRole');
    Route::resource('users', App\Http\Controllers\UserController::class);

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/settings', [App\Http\Controllers\OptionController::class, 'GeneralSettings'])->name('settings');
    Route::get('home-page', [App\Http\Controllers\OptionController::class, 'homePage'])->name('home-page');
    Route::get('social-login', [App\Http\Controllers\OptionController::class, 'socialLogin'])->name('social-login');
    Route::post('save-settings', [App\Http\Controllers\OptionController::class, 'update'])->name('save_settings');
    Route::resource('payment', App\Http\Controllers\PaymentController::class);
    Route::resource('schedules', App\Http\Controllers\ScheduleController::class);
    Route::resource('branches', App\Http\Controllers\BranchController::class);
    Route::resource('servicetypes', App\Http\Controllers\ServiceTypeController::class);
    Route::resource('modes', App\Http\Controllers\ModeController::class);
    Route::resource('patients', App\Http\Controllers\PatientController::class);
    Route::resource('collection', App\Http\Controllers\CollectionController::class);
    Route::resource('bills', App\Http\Controllers\BillController::class);
    Route::resource('invoices', App\Http\Controllers\InvoiceController::class);
    Route::resource('ecat', App\Http\Controllers\EcatController::class);
    Route::resource('expenses', App\Http\Controllers\ExpenseController::class);
    Route::resource('opd', App\Http\Controllers\OpdController::class);
    //Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    //    \UniSharp\LaravelFilemanager\Lfm::routes();
    //});

    Route::patch('hide-patient/{patient}', [App\Http\Controllers\PatientController::class, 'hidePatient'])->name('hidePatient');
    Route::get('sea', [App\Http\Controllers\PatientController::class, 'cr'])->name('search');
    Route::get('search', [App\Http\Controllers\PatientController::class, 'search']);
    Route::get('exp-data', [App\Http\Controllers\ExpenseController::class, 'expData'])->name('expData');
    Route::get('receipt', [App\Http\Controllers\PaymentController::class, 'receipt'])->name('receipt');
    Route::get('bill', [App\Http\Controllers\PaymentController::class, 'bill'])->name('bill');
    Route::get('schedule', [App\Http\Controllers\ScheduleController::class, 'schedule'])->name('schedule');
    Route::patch('update/{payment}', [App\Http\Controllers\PaymentController::class, 'updateDate'])->name('updateDate');
    Route::patch('revert/{schedule}', [App\Http\Controllers\ScheduleController::class, 'revertAbsent'])->name('revertAbsent');

    Route::get('collectionPrint/{id}', [App\Http\Controllers\CollectionController::class, 'collectionPrint'])->name('collectionPrint');
    Route::get('invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'invoice'])->name('invoices.make');
    Route::get('invoice/create/{id}', [App\Http\Controllers\InvoiceController::class, 'create'])->name('invoices.cr');
    Route::get('ss', [App\Http\Controllers\ScheduleController::class, 'biDay'])->name('ss');

    Route::get('cashOfDay', [App\Http\Controllers\CollectionController::class, 'cashOfDay'])->name('cashOfDay');
    Route::post('refund', [App\Http\Controllers\CollectionController::class, 'storeRefund'])->name('storeRefund');
    Route::post('search-2', [App\Http\Controllers\PatientController::class, 'searchP'])->name('searchP');
    Route::get('montth-wise', [App\Http\Controllers\CollectionController::class, 'monthWise'])->name('monthWise');
    Route::get('hidden-patients', [App\Http\Controllers\PatientController::class, 'hiddenPatients'])->name('hiddenPatients');

    Route::get('dpc', [App\Http\Controllers\ScheduleController::class, 'Dpc'])->name('Dpc');
    Route::post('p/d', [App\Http\Controllers\ScheduleController::class, 'DailyPatients'])->name('DailyPatients');
    Route::get('today/sch', [App\Http\Controllers\ScheduleController::class, 'todayPatients'])->name('todayPatients');
    Route::get('today/cash', [App\Http\Controllers\CollectionController::class, 'todayCash'])->name('todayCash');
    Route::get('profit/create', [App\Http\Controllers\HomeController::class, 'crProfit'])->name('crProfit');
    Route::post('profit', [App\Http\Controllers\HomeController::class, 'profit'])->name('profit');
    Route::get('search-by-reg', [App\Http\Controllers\PatientController::class, 'searchPatientByReg'])->name('searchPatientByReg');
    Route::post('search-by-reg-result', [App\Http\Controllers\PatientController::class, 'searchPatientByRegDate'])->name('searchPatientByRegDate');

    Route::get('schedule-r/{pid}/{payId}', [App\Http\Controllers\ScheduleController::class, 'getRefundDetail'])->name('getRefundDetail');

    Route::get('listPatients', [App\Http\Controllers\HomeController::class, 'listPatients'])->name('listPatients');
    Route::post('list-Patients-result', [App\Http\Controllers\HomeController::class, 'listPatientsResult'])->name('listPatientsResult');

    Route::post('hide-patients-list', [App\Http\Controllers\HomeController::class, 'hidePatientsList'])->name('hidePatientsList');
    Route::get('hiden-patients-list', [App\Http\Controllers\HomeController::class, 'hiddenPatientsLists'])->name('hiddenPatientsLists');

    Route::get('expenseReport', [App\Http\Controllers\ExpenseController::class, 'expenseReport'])->name('expenseReport');
    Route::get('expenseReportCustom', [App\Http\Controllers\ExpenseController::class, 'expenseReportCustom'])->name('expenseReportsCustom');
    Route::get('collectionReport', [App\Http\Controllers\CollectionController::class, 'collectionReport'])->name('collectionReport');
    Route::get('collectionReportCustom', [App\Http\Controllers\CollectionController::class, 'collectionReportCustom'])->name('collectionReportCustom');
    Route::get('refundReport', [App\Http\Controllers\CollectionController::class, 'refundReport'])->name('refundReport');
    Route::get('crd', [App\Http\Controllers\CollectionController::class, 'crd'])->name('crd');
    Route::get('coll-data', [App\Http\Controllers\CollectionController::class, 'collData'])->name('crdIndex');
    Route::get('patient-data', [App\Http\Controllers\PatientController::class, 'patientData'])->name('patientData');
    Route::get('dueReport', [App\Http\Controllers\DueController::class, 'dueReport'])->name('dueReport');
    Route::get('dueReportCustom', [App\Http\Controllers\DueController::class, 'dueReportCustom'])->name('dueReportCustom');

    Route::get('edit-date/{payment}', [App\Http\Controllers\PaymentController::class, 'editDate'])->name('editDate');
    Route::get('payView/{id}', [App\Http\Controllers\PaymentController::class, 'payIndex'])->name('payIndex');
    Route::get('refund/{id}', [App\Http\Controllers\CollectionController::class, 'getRefund'])->name('getRefund');
    Route::patch('activate/{payment}', [App\Http\Controllers\PaymentController::class, 'makeActive'])->name('makeActive');
    Route::patch('sch/{schedule}', [App\Http\Controllers\ScheduleController::class, 'makeAbsent'])->name('makeAbsent');
    Route::get('p-schedule/{patient}', [App\Http\Controllers\PatientController::class, 'schedule'])->name('scheduleP');
    Route::get('deposit/{id}', [App\Http\Controllers\CollectionController::class, 'cr'])->name('collection.cr');

    Route::get('/get-service-type/{id}', [App\Http\Controllers\OpdController::class, 'getServiceType'])->name('getServiceType');
    Route::get('/opd', [App\Http\Controllers\OpdController::class, 'create'])->name('opd');
    Route::get('/opd-old', [App\Http\Controllers\OpdController::class, 'oldOpd'])->name('oldOpd');
    Route::post('/opd', [App\Http\Controllers\OpdController::class, 'store'])->name('opdStore');
    Route::post('/opd/old', [App\Http\Controllers\OpdController::class, 'old'])->name('opdOld');
    Route::get('profile', [App\Http\Controllers\HomeController::class, 'profile']);

    Route::get('customDailyReport', [App\Http\Controllers\HomeController::class, 'customDailyReport'])->name('customDailyReport');
    Route::get('collectionDetail/{id}', [App\Http\Controllers\HomeController::class, 'collectionDetail'])->name('collectionDetail');
    Route::get('serviceDetail/{id}', [App\Http\Controllers\HomeController::class, 'serviceDetail'])->name('serviceDetail');
    Route::get('dues-details', [App\Http\Controllers\HomeController::class, 'duesDetails'])->name('duesDetails');
    Route::get('cash-today', [App\Http\Controllers\HomeController::class, 'cashToday'])->name('cashToday');
    Route::get('online-today', [App\Http\Controllers\HomeController::class, 'onlineToday'])->name('onlineToday');
    Route::get('patient-today', [App\Http\Controllers\HomeController::class, 'patientToday'])->name('patientToday');
    Route::get('cash-expenses-today', [App\Http\Controllers\HomeController::class, 'cashExpensesToday'])->name('cashExpensesToday');
    Route::get('online-expenses-today', [App\Http\Controllers\HomeController::class, 'onlineExpensesToday'])->name('onlineExpensesToday');
    Route::get('total-expenses-today', [App\Http\Controllers\HomeController::class, 'totalExpensesToday'])->name('totalExpensesToday');
    Route::get('refund-today', [App\Http\Controllers\HomeController::class, 'refundToday'])->name('refundToday');
    Route::get('net-cash-today', [App\Http\Controllers\HomeController::class, 'netCashToday'])->name('netCashToday');
    Route::get('today-branch-details/{id}', [App\Http\Controllers\HomeController::class, 'todayBranchDetails'])->name('todayBranchDetails');

    Route::get('change-branch/{id}', [App\Http\Controllers\PatientController::class, 'getChangeBranch'])->name('getChangeBranch');
    Route::post('changeBranch/{id}', [App\Http\Controllers\PatientController::class, 'changeBranch'])->name('changeBranch');

    Route::get('discontinued', [App\Http\Controllers\HomeController::class, 'discontinued'])->name('discontinued');

    Route::resource('calls', App\Http\Controllers\CallController::class);
    Route::get('call/{id}', [App\Http\Controllers\CallController::class, 'getCreateCall'])->name('getCreateCall');
    Route::get('patient-calls/{id}', [App\Http\Controllers\CallController::class, 'getPatientCalls'])->name('getPatientCalls');
    Route::get('rangeDailyReport', [App\Http\Controllers\HomeController::class, 'rangeDailyReport'])->name('rangeDailyReport');

    Route::resource('images', App\Http\Controllers\ImageController::class);
    Route::post('image-up/{id}', [App\Http\Controllers\ImageController::class, 'storeImages'])->name('storeImages');

    Route::get('/check-service', [App\Http\Controllers\ServiceTypeController::class, 'checkService'])->name('check.service');
    Route::resource('services', App\Http\Controllers\ServiceController::class);
    Route::get('service-list', [App\Http\Controllers\ServiceController::class, 'frontServicePage'])->name('frontServicePage');
    Route::get('service-details/{slug}', [App\Http\Controllers\ServiceController::class, 'frontServiceSingle'])->name('frontServiceSingle');

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('appointments', App\Http\Controllers\AppointmentController::class);
        Route::resource('sliders', App\Http\Controllers\Admin\SliderController::class);
        Route::resource('blogs', App\Http\Controllers\Admin\BlogPostController::class);
        Route::resource('blog.categories', App\Http\Controllers\Admin\BlogCategoryController::class);
        Route::resource('blog.tags', App\Http\Controllers\Admin\BlogTagController::class);
        Route::get('blog/comments', [App\Http\Controllers\Admin\BlogPostController::class, 'comments'])->name('blog.comments.index');
        Route::post('blog/comments/{comment}/approve', [App\Http\Controllers\Admin\BlogPostController::class, 'approveComment'])->name('blog.comments.approve');
        Route::delete('blog/comments/{comment}', [App\Http\Controllers\Admin\BlogPostController::class, 'deleteComment'])->name('blog.comments.delete');

        Route::resource('contacts', App\Http\Controllers\ContactController::class)->only(['index', 'show', 'destroy']);
        Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'adminIndex'])->name('IndexContact');
        Route::patch('contacts/{contact}/mark-read', [App\Http\Controllers\ContactController::class, 'markRead'])->name('contacts.markRead');
        Route::patch('contacts/{contact}/mark-unread', [App\Http\Controllers\ContactController::class, 'markUnread'])->name('contacts.markUnread');

    });

});

Route::get('book/appointment', [App\Http\Controllers\Front\HomeControlle::class, 'bookAppointment'])->name('bookAppointment');
Route::get('appointment/confirmation/{id?}', [App\Http\Controllers\Front\HomeControlle::class, 'appointmentConfirmation'])->name('appointment.confirmation');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact-submit', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.submit');

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/post/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{slug}', [App\Http\Controllers\BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{slug}', [App\Http\Controllers\BlogController::class, 'tag'])->name('blog.tag');
Route::post('/blog/post/{post}/comment', [App\Http\Controllers\BlogController::class, 'comment'])->name('blog.comment');
