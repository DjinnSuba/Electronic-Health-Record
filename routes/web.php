<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;


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

Route::get('/',  [UserController::class, 'login']) -> middleware('LoggedIn');

//registration
Route::get('/registration', [UserController::class, 'register']) -> middleware('AlreadyLoggedIn');
Route::post('/user-registration', [UserController::class, 'registerUser']) -> name ('user-registration');

//logging in
Route::get('/logins', [UserController::class, 'login']) -> name('logins') -> middleware('AlreadyLoggedIn');
Route::post('/user-login', [UserController::class, 'loginUser']) -> name ('user-login')-> middleware('LoggedIn');


//logging out
Route::get('/logouts', [UserController::class, 'logout'])  -> middleware('IsLoggedIn');
Route::get('/home', [UserController::class, 'home'])  -> middleware('IsLoggedIn');

/**staff routes*/
Route::get('/dashboard',[UserController::class, 'physician_dashboard'])->name('physician.dashboard') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/profile',[UserController::class, 'physician_pfp'])->name('physician.pfp') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/records',[UserController::class, 'physician_records'])->name('physician.records') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/files',[UserController::class, 'physician_files'])->name('physician.files') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/patients',[UserController::class, 'physician_patients'])->name('physician.patients') -> middleware(['AlreadyLoggedIn', 'isStaff']);
//Route::get('uploads',[UserController::class, 'physician_uploads']);//removed
Route::get('/clinic_records',[UserController::class, 'physician_clinic_records'])->name('physician.clinic_records') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/create_request',[UserController::class, 'physician_request_access']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/accept_access/{patientId}/{attendingId}/{accessId}',[UserController::class, 'acceptAccess']) -> middleware(['AlreadyLoggedIn', 'isStaff']);

/**physician routes */
Route::get('/register_patient',[UserController::class, 'physician_register_patients'])->name('physician.register') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/register-user', [UserController::class, 'storePatient']) -> name('storePatient') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/edit_patient/{id}',[UserController::class, 'editPatient']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/update-patient/{id}', [UserController::class, 'updatePatient']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/view_patient/{id}', [UserController::class, 'physician_view_patient']) -> middleware(['AlreadyLoggedIn', 'isStaff']);

/**admin routes */
Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard') -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::get('/admin/physicians', [AdminController::class, 'physicians'])->name('admin.physicians') -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients') -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests') -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::get('/admin/register', [AdminController::class, 'register'])->name('admin.register') -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::get('/admin/edit/{id}', [AdminController::class, 'edit']) -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::post('/admin/update/{id}', [AdminController::class, 'update']) -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::post('/admin/register-user', [AdminController::class, 'registerUser']) -> name('register-user') -> middleware(['AlreadyLoggedIn', 'isAdmin']);
Route::get('/admin/delete/{id}', [AdminController::class, 'deleteStaff']) -> middleware(['AlreadyLoggedIn', 'isAdmin']);

//pt
Route::get('/mprogress-report',[UserController::class, 'pt_mProgressReport'])->name('pt.progress_report') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/madd-progress-report', [UserController::class, 'mstoreProgressReport']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/add-progress-report/{patientCode}',[UserController::class, 'storeProgressReport']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/pt-register-user', [UserController::class, 'storePTPatient']) -> name('storePTPatient') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/add-progress-report/{id}', [UserController::class, 'updateProgress']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/edit_consultation/{patientId}/{dateOfConsult}', [UserController::class, 'editConsultation']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/update-follow-consult/{id}/{dateOfConsult}', [UserController::class, 'updateFollowConsult']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/update-progress-report/{id}/{dateOfConsult}', [UserController::class, 'updateProgressReport']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/update-assessment-report/{id}', [UserController::class, 'updateAssessmentReport']) -> middleware(['AlreadyLoggedIn', 'isStaff']);

//consultaion
//Route::get('/new-consulation/{id}',[UserController::class, 'newConsultation']);
Route::get('/new-consulation/{patientCode}',[UserController::class, 'newConsultation']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/newConsult/{patientCode}',[UserController::class, 'storeAddConsult'])-> name('storeAddConsult') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/add-consulation/{id}', [UserController::class, 'addConsultation']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/mnew-consultation', [UserController::class, 'mnewConsultation']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/mnewConsult',[UserController::class, 'mstoreAddConsult']) -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/view_consultation/{id}/{dateOfConsult}', [UserController::class, 'viewConsultation']) -> middleware(['AlreadyLoggedIn', 'isStaff']);


Route::get('/patients/{patientCode}',[UserController::class, 'viewPatientRecords']) -> middleware(['AlreadyLoggedIn', 'isStaff']);

//search
Route::get('/records-search',[UserController::class, 'search'])-> name('records.search') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::get('/patients-search',[UserController::class, 'searchPatients'])-> name('patients.search') -> middleware(['AlreadyLoggedIn', 'isStaff']);
//filter
Route::get('/records/filter', [UserController::class, 'filterRecords'])->name('records.filter')  -> middleware(['AlreadyLoggedIn', 'isStaff']);

//upload pic

Route::get('/profile-upload', [UserController::class, 'upload'])->name('profile.upload') -> middleware(['AlreadyLoggedIn', 'isStaff']);
Route::post('/profile-save', [UserController::class, 'uploadSave'])->name('uploadSave') -> middleware(['AlreadyLoggedIn', 'isStaff']) ;
Route::get('/profile/delete/{id}/{profile}', [UserController::class, 'deleteProfile'])  -> middleware(['AlreadyLoggedIn', 'isStaff']);

/** 
Route::get('/profile-upload/{physicianCode}', [UserController::class, 'upload'])->name('profile.upload');
Route::post('/profile-save/{physicianCode}', [UserController::class, 'uploadSave'])->name('profile.save');*/

//symlink
Route::get('/create-symlink', function (){
    symlink(storage_path('/app/public'), public_path('storage'));
    echo "Symlink Created. Thanks";
});
