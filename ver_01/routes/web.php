<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DeletedStudentController;

use App\Http\Controllers\ProfileController;

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
    // return view('welcome');
    return redirect()->route('students.index');
});

Route::resource('/student', StudentController::class)->middleware(['auth', 'verified']);
Route::resource("/student", StudentController::class)->only(['edit', 'create'])->middleware(['user-role:editor,admin']);

Route::post('/restore/{id}', [DeletedStudentController::class, 'restore'])->name('student.restore');

Route::get('/storage/user.pdf',function(){
    $pdfPath = storage_path('user.pdf');
    $headers = [
        'Content-Type' => 'application/pdf',
    ];
    return response()->file($pdfPath, $headers);
});

Route::resource('/student', StudentController::class);

Route::get('/deleted_student', [DeletedStudentController::class, 'index'])->name('deleted_student.index');


Route::controller(StudentController::class)->group(function(){
    Route::get('student', 'index')->middleware(['auth', 'verified'])->name('students.index');
    Route::get('student-export', 'export')->middleware(['user-role:user,editor,admin'])->name('students.export');
    Route::post('student-import', 'import')->middleware(['user-role:admin'])->name('students.import');
    Route::match(['get', 'post'],'pdf', 'pdf')->middleware(['user-role:admin'])->name('student.pdf');
    });

Route::get('test', function () {
    return view('test');
})->name('test.test');

// countryマスタ
Route::get('/getCountry', [CountryController::class, 'getCountry']);
Route::post('/addCountry', [CountryController::class, 'newCountry']);
Route::post('/delCountry', [CountryController::class, 'delCountry']);

// staffマスタ
Route::get('/getStaff', [StaffController::class, 'getStaff']);
Route::post('/newStaff', [StaffController::class, 'newStaff']);
Route::post('/delStaff', [StaffController::class, 'delStaff']);

// departmentマスタ
Route::get('/getDpmt', [DepartmentController::class, 'getDpmt']);
Route::post('/newDpmt', [DepartmentController::class, 'newDpmt']);
Route::post('/delDpmt', [DepartmentController::class, 'delDpmt']);

// apply_departmentマスタ
Route::get('/getApply', [ApplyController::class, 'getApply']);
Route::post('/newApply', [ApplyController::class, 'newApply']);
Route::post('/delApply', [ApplyController::class, 'delApply']);

// working_placeマスタ
Route::get('/getPlace', [PlaceController::class, 'getPlace']);
Route::post('/newPlace', [PlaceController::class, 'newPlace']);
Route::post('/delPlace', [PlaceController::class, 'delPlace']);

// skillマスタ
Route::get('/getSkill', [SkillController::class, 'getSkill']);
Route::post('/newSkill', [SkillController::class, 'newSkill']);
Route::post('/delSkill', [SkillController::class, 'delSkill']);


// FILE UPLOAD/DOWNLOAD CONTROLLER
Route::middleware(['user-role:editor,admin'])->group(function () {
    Route::get('/student/{id}/files', [FileController::class, 'index'])->name('files.index');
    Route::get('/student/{id}/file/{fileName}', [FileController::class, 'show'])->name('file.show');
    Route::post('/student/{id}/upload', [FileController::class, 'upload'])->name('file.upload');
    Route::get('/student/{id}/download/{fileName}', [FileController::class, 'download'])->name('file.download');
    Route::get('/student/{id}/delete/{fileName}', [FileController::class, 'delete'])->middleware(['user-role:admin'])->name('file.delete');
});

// ACCESS DENIED PAGE
Route::get('/access-denied', function () {
    return view('access_denied');
});

// DASHBOARD PAGE
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// USER PROFILE PAGE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
