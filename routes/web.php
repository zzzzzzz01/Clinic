<?php

use App\Http\Controllers\FaqtController;   
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\ReceptionistController; 
use App\Http\Controllers\TagController; 
use App\Http\Controllers\FaqController; 
use App\Http\Controllers\PageController; 
use App\Http\Controllers\RoomController; 
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\DoctorController; 
use App\Http\Controllers\NurseController;  
use App\Http\Controllers\PatientController; 
use App\Http\Controllers\AppointmentSlotController;   
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FeatureController; 
use App\Http\Controllers\SupplierController; 
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DiagnoseController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\HospitalizationController; 
use App\Http\Controllers\MessageNotificationController; 
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\PharmacistSaleController;
use App\Http\Controllers\ChMessageController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{lang}', [PageController::class, 'language'])
    ->where('lang', 'uz|ru|en');

Route::get('/', [PageController::class, 'index'])->name('home.page'); 
Route::get('about', [PageController::class, 'about'])->name('about.page');
Route::get('services', [PageController::class, 'services'])->name('services.page');  

Route::get('/services/search', [PageController::class, 'search'])->name('services.search');

Route::get('services/{slug}', [PageController::class, 'serviceDetail'])->name('services.detail');
Route::get('services/{slug}/appointments/{doctor}', [PageController::class, 'serviceAppointment'])->name('services.appointment');
Route::post('appointment/store', [PageController::class, 'store'])->name('appointment.store');
Route::get('blogs', [PageController::class, 'blog'])->name('blogs.page');
Route::get('contact', [PageController::class, 'contact'])->name('contact.page');
Route::get('chief/doctors', [PageController::class, 'chiefDoctors'])->name('chief.doctors');
Route::get('/blogs/{id}', [PageController::class, 'detail'])->name('blogs.detail');
Route::get('category/{slug}/blogs', [PageController::class, 'blogCategory'])->name('blog.category');
Route::get('questions', [PageController::class, 'question'])->name('questions.page');

Route::get('/my-appointments', [PageController::class, 'patientAppointments'])->name('patient.appointments');
Route::get('/appointments/{appointment}', [PageController::class, 'patientAppointmentShow'])->name('appointments.show');

Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancelAppointment'])->name('appointments.cancel');
Route::get('/appointments/{id}/details', [AppointmentController::class, 'getAppointmentDetails'])->name('appointments.details');

// Faqs
Route::get('faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::get('faqs/create', [FaqController::class, 'create'])->name('faqs.create');
Route::post('faqs', [FaqController::class, 'store'])->name('faqs.store');
Route::get('faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
Route::put('faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
Route::delete('faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

// Postlar
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
Route::get('category/{slug}/posts', [PostController::class, 'categoryPosts'])->name('category.posts');
Route::get('tag/{slug}/posts', [PostController::class, 'tagPosts'])->name('tag.posts');
Route::get('tag/{slug}/posts', [PostController::class, 'tagPosts'])->name('tag.posts');
Route::get('/posts/{post}/show', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('posts/{post}/update', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

Route::post('/posts/{id}/toggle-like', [PostController::class, 'toggleLike'])->name('posts.toggle.like');
Route::post('/posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('/posts/{id}/dislike', [PostController::class, 'dislike'])->name('posts.dislike');


//Bemor uchun doctorlar royhati 
Route::get('service/doctors', [DoctorController::class, 'doctorService'])->name('doctors.service.index');



//Camment
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');

// Category 
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

// Tag 
Route::post('/tags', [TagController::class, 'store'])->name('tags.store');


// Login
Route::get('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('authanticate',[AuthController::class, 'authanticate'])->name('authanticate');

//logout
Route::post('logout',[AuthController::class, 'logout'])->name('logout');


Route::get('register', [AuthController::class, 'registerPage'])->name('register.page');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard.index');
Route::get('/doctor/dashboard', [AdminController::class, 'doctorIndex'])->name('doctor.dashboard');
Route::get('/nurse/dashboard', [AdminController::class, 'nurseIndex'])->name('nurse.dashboard');
Route::get('/pharmacist/dashboard', [AdminController::class, 'pharmacistIndex'])->name('pharmacist.dashboard');
Route::get('/laboratory/dashboard', [AdminController::class, 'laboratoryIndex'])->name('laboratory.dashboard');
Route::get('/receptionist/dashboard', [AdminController::class, 'receptionistIndex'])->name('receptionist.dashboard');

Route::get('profil', [PageController::class,'profil'])->name('profil');
Route::get('personal-data', [PageController::class,'personalData'])->name('personal.data');
Route::put('/profile/password', [PageController::class, 'updatePassword'])->name('profile.password.update');


Route::get('create/patient', [PatientController::class, 'create'])->name('patient.create');
Route::post('patient/store', [PatientController::class, 'store'])->name('patient.store');

Route::get('/login-history', [AuthController::class, 'loginHistory'])
    ->name('login.history')
    ->middleware('auth');


Route::middleware(['auth', 'role:Receptionist'])->group(function () {
    Route::get('/receptionist/patinets', [ReceptionistController::class, 'index'])->name('receptionist.index');
    Route::get('/appointments/{patient}/create', [ReceptionistController::class, 'create'])->name('appointments.create');
    Route::post('/receptionist/appointments', [ReceptionistController::class, 'storeAppointment'])->name('receptionist.appointments.store');

    // ✅ AJAX uchun route lar
    Route::get('/receptionist/doctors-by-department/{department_id}', [ReceptionistController::class, 'getDoctorsByDepartment'])->name('receptionist.doctors.by.department');
    Route::get('/receptionist/slots-by-doctor-date', [ReceptionistController::class, 'getSlotsByDoctorDate'])->name('receptionist.slots.by.doctor.date');
});



Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
    Route::post('doctors', [DoctorController::class, 'store'])->name('doctors.store');
    Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    Route::get('doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
    Route::put('doctors/{doctor}/cancel-password', [DoctorController::class, 'cancelPassword'])->name('doctors.cancel-password');
    Route::delete('doctors/{doctor}/delete', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::get('doctor/{doctor}/appointment/slots', [DoctorController::class, 'doctorAppointmentSlots'])->name('doctor.appointment.slots');

    Route::get('doctor/appointment/slots/create/{type}/{id}', [AppointmentSlotController::class, 'create'])->name('appointmentSlots.create');
    Route::get('schedule/{type}/{id}', [PageController::class, 'schedule'])->name('schedule.show');
    // Patients - (Bemorlar)
    Route::get('ambulator/doctors/{doctor}/patient', [DoctorController::class, 'ambulatorDoctor'])->name('ambulator.doctor');

     // Hamshira
    Route::get('nurses', [NurseController::class, 'index'])->name('nurses.index');
    Route::post('/nurses', [NurseController::class, 'store'])->name('nurses.store');
    Route::get('nurses/create', [NurseController::class, 'create'])->name('nurses.create');
    Route::get('nurses/{nurse}/show', [NurseController::class, 'show'])->name('nurses.show');
    Route::get('nurses/{nurse}/edit', [NurseController::class, 'edit'])->name('nurses.edit');
    Route::delete('/nurses/{nurse}', [NurseController::class, 'destroy'])->name('nurses.destroy');
    Route::put('/nurses/{nurse}/update', [NurseController::class, 'update'])->name('nurses.update');
    Route::post('/admin/nurses/{nurse}/notify', [MessageNotificationController::class, 'send'])->name('admin.nurse.notify');
    Route::put('/nurses/{nurse}/cancel-password', [NurseController::class, 'cancelPassword'])->name('nurses.cancel-password');
    
    // Bitta route - POST va PUT uchun
    Route::match(['post', 'put'], 'schedule/{type}/{id}', [PageController::class, 'saveSchedule'])->name('schedule.save');

    // Room features - (Honala qulayliklari)
    Route::get('features', [FeatureController::class, 'index'])->name('features.index');
    Route::post('/features/store', [FeatureController::class, 'store'])->name('features.store');
    Route::put('/features/{feature}', [FeatureController::class, 'update'])->name('features.update');
    Route::get('features/{feature}/edit', [FeatureController::class, 'edit'])->name('features.edit');
    Route::delete('/features/{feature}', [FeatureController::class, 'destroy'])->name('features.destroy');

    // Yetkazib berivchilar - (Suppliers)
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::get('suppliers/{supplier}/show', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('suppliers/{supplier}/update', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/{supplier}/destroy', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Dorilar - Medicine
    Route::get('medicine/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('medicines/store', [MedicineController::class, 'store'])->name('medicines.store');
    Route::get('medicine/receive', [MedicineController::class, 'receiveMedicine'])->name('medicine.receive');
    Route::post('medicine/receive/store', [MedicineController::class, 'storeReceive'])->name('medicine.receive.store');
    Route::get('medicine/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
    Route::put('medicine/{medicine}/update', [MedicineController::class, 'update'])->name('medicine.update');
    Route::delete('/medicine/{medicine}/destroy', [MedicineController::class, 'destroy'])->name('medicines.medicine');

    // 1-chi store - Pending holatida saqlash
    Route::post('/medicine-receive/pending', [MedicineController::class, 'savePending'])->name('medicine.receive.pending');

    // 2-chi store - Saqlash va yakunlash (Complete)
    Route::post('/medicine-receive/complete', [MedicineController::class, 'saveAndComplete'])->name('medicine.receive.complete');

    // Update - Pending holatidagilarni tahrirlash
    Route::put('/medicine-receive/{id}', [MedicineController::class, 'updatePending'])->name('medicine.receive.update');

    // Delete - Pending holatidagilarni o'chirish
    Route::delete('/medicine-receive/{id}', [MedicineController::class, 'deletePending'])->name('medicine.receive.delete');

    // Test
    Route::get('tests', [TestController::class, 'index'])->name('tests.index'); 
    Route::post('tests/store', [TestController::class, 'store'])->name('tests.store');
    Route::put('/tests/{test}', [TestController::class, 'update'])->name('tests.update');
    Route::delete('/tests/{test}', [TestController::class, 'destroy'])->name('tests.destroy');

    // TestPanel
    Route::get('tests/panels', [TestController::class, 'panels'])->name('tests.panels');
    Route::post('test-panels/store', [TestController::class, 'panelStore'])->name('test-panels.store');
    Route::get('test-panels/{panel}/edit', [TestController::class, 'panelEdit'])->name('test-panels.edit');
    Route::delete('/test-panels/{panel}', [TestController::class, 'panelDestroy'])->name('test-panels.destroy');
    Route::put('test-panels/{panel}/update', [TestController::class, 'panelUpdate'])->name('test-panel.update');

    // Protseduralar
    Route::get('procedures', [ProcedureController::class, 'index'])->name('procedures.index');
    Route::get('procedures/{id}/show', [ProcedureController::class, 'show'])->name('procedures.show');
    Route::get('procedures/create', [ProcedureController::class, 'create'])->name('procedures.create');
    Route::post('procedures/store', [ProcedureController::class, 'store'])->name('procedures.store');
    Route::get('procedures/{procedure}/edit', [ProcedureController::class, 'edit'])->name('procedures.edit');
    Route::delete('procedures/{procedure}', [ProcedureController::class, 'destroy'])->name('procedures.destroy');
    Route::put('procedures/{procedure}/update', [ProcedureController::class, 'update'])->name('procedures.update');

    // Bemorga hona biriktirish
    Route::post('hospitalization/beds/{hospitalization}/store', [HospitalizationController::class, 'roomStore'])->name('hospitalization.rooms.store');

    // Bemorga retsept yozish 
    Route::post('/hospitalization/{hospitalization}/prescriptions/store', [HospitalizationController::class, 'prescriptionStore'])->name('hospitalization.prescriptions.store');
    Route::post('/hospitalization/prescription/administrations/store', [HospitalizationController::class, 'prescriptionAdministrationStore'])->name('hospitalization.prescription.administrations.store');

    // Bemorga test buyurtma qilish
    Route::post('hospitalization/tests/{hospitalization}/store', [HospitalizationController::class, 'testStore'])->name('hospitalization.tests.store');
    Route::get('hospitalization/tests/{hospitalization}/test-panel/{item}/show', [HospitalizationController::class, 'testPanelShow'])->name('test.panel.show');

    // Bemorga Procedura buyurtma qilish
    Route::post('hospitalization/procedures/{hospitalization}/store', [HospitalizationController::class, 'procedureStore'])->name('hospitalization.procedure.store');

    // Bemorni procedurasini yakunlash
    Route::post('hospitalization/procedures-administation/store', [HospitalizationController::class, 'procedurAedministrationStore'])->name('hospitalization.procedure.administation.store');
    Route::post('hospitalization/procedures-administration/cancel',[HospitalizationController::class, 'procedureAdministrationCancel'])->name('hospitalization.procedure.administation.cancel');
    Route::put('hospitalization/procedures/update', [HospitalizationController::class, 'procedureUpdate'])->name('hospitalization.procedure.update');
    Route::delete('hospitalization/procedures/{id}/destroy', [HospitalizationController::class, 'procedureDestroy'])->name('hospitalization.procedure.destroy');

    // Doctir va Hamshirani bemorga biriktirish
    Route::post('statsional/patients/store', [HospitalizationController::class, 'staffStore'])->name('hospitalization.doctor.store');


    




    // Room - Xonalar 
    

    // Department - (Bo'limlar)
    Route::get('departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('departments/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('departments/store', [DepartmentController::class, 'store'])->name('department.store');
});

Route::middleware(['auth', 'role:Admin,Receptionist'])->group(function () { 
    // Room - Xonalar
    Route::get('room', [RoomController::class, 'index'])->name('room.index');
    Route::get('room/{room}/show', [RoomController::class, 'show'])->name('room.show');
    Route::get('room/create', [RoomController::class, 'create'])->name('room.create');
    Route::post('room/store', [RoomController::class, 'store'])->name('room.store');
    Route::get('room/{room}/edit', [RoomController::class, 'edit'])->name('room.edit');
    Route::put('/room/{room}', [RoomController::class, 'update'])->name('room.update');
    Route::post('/rooms/{room}/assign-patient', [RoomController::class, 'assignPatient'])->name('room.assign-patient');
    Route::post('/rooms/{room}/discharge-patient', [RoomController::class, 'dischargePatient'])->name('rooms.discharge-patient');
    Route::put('/rooms/{room}/discharge-patient', [RoomController::class, 'dischargePatient'])->name('room.discharge-patient');
    Route::post('/rooms/{room}/complete-maintenance', [RoomController::class, 'completeMaintenance'])->name('room.complete-maintenance');
});

Route::middleware(['auth', 'role:Admin,Laboratory Technician'])->group(function () {
    // Laboratoriya 
    Route::get('laboratory/tests', [HospitalizationController::class, 'laboratoryTest'])->name('laboratory.test');
    Route::get('laboratory/tests/{item}/show', [HospitalizationController::class, 'laboratoryTestShow'])->name('laboratory.show');
    Route::put('laboratory/tests/update', [HospitalizationController::class, 'laboratoryTestUpdate'])->name('laboratory.update');
});

Route::middleware(['auth', 'role:Doctor,Admin'])->group(function () {
    // Doctor qabuli 
    Route::get('doctor/appointments', [DoctorController::class, 'doctorAppointment'])->name('doctor.appointments');
    Route::get('/doctor/consultation/{appointment}', [DoctorController::class, 'consultation'])->name('doctor.consultation'); 
    Route::post('doctor/visits/{appointment}/consultation/store', [DiagnoseController::class, 'store'])->name('diagnose.store');

});

Route::middleware(['auth', 'role:Doctor'])->group(function () {
    

    // Retsept yozish doctor uchun
    Route::post('/prescriptions/store', [PrescriptionController::class, 'store'])->name('doctor.prescriptions.store');
    Route::get('/prescriptions/{appointmentId}', [PrescriptionController::class, 'getByAppointment'])->name('doctor.prescriptions.get');

});

Route::middleware(['auth', 'role:Nurse'])->group(function () {
    // Nurse uchun dori va mualaja berishlar 
    Route::get('nurse-treatment-sheets', [NurseController::class, 'nurseTreatmentSheet'])->name('nurse.treatment.sheets');
    Route::post('nurse-treatment-sheets/save-status', [NurseController::class, 'saveStatus'])->name('nurse-treatment-sheets.saveStatus');
});


Route::middleware(['auth', 'role:Admin,Doctor,Nurse,Receptionist'])->group(function () {
    Route::get('hospitalization/patients', [HospitalizationController::class, 'index'])->name('hospitalizations.index');
    Route::get('hospitalizations/{hospitalization}/show', [HospitalizationController::class, 'Show'])->name('hospitalizations.show');
});

Route::middleware(['auth', 'role:Admin,Pharmacist'])->group(function () {
    Route::get('medicine', [MedicineController::class, 'index'])->name('medicines.index'); 
    Route::get('medicine/{medicine}/show', [MedicineController::class, 'show'])->name('medicines.show');
    Route::get('medicine/inventory', [MedicineController::class, 'inventory'])->name('medicine.inventory'); 
    Route::get('medicine/history/{medicine}', [MedicineController::class, 'history'])->name('medicine.history');
});


Route::prefix('departments')->group(function () {
    Route::get('departments/{department}/rooms', [DepartmentController::class, 'departmentRooms'])->name('departments.rooms');

    Route::get('/{id}/staff', [DepartmentController::class, 'getStaff'])->name('departments.staff');
    Route::get('/{id}/data', [DepartmentController::class, 'getDepartment'])->name('departments.data');
    Route::put('/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

// AJAX routes
Route::prefix('ajax')->group(function () {
    Route::get('/search-patients', [PatientController::class, 'searchPatients'])->name('ajax.search-patients');
    Route::post('/cancel-booked-appointment', [PatientController::class, 'cancelBookedAppointment'])->name('ajax.cancel.booked');
    Route::post('/store-appointment', [PatientController::class, 'storeAppointment'])->name('ajax.store.appointment');


});

// Appointment slot routes
Route::prefix('appointment-slots')->group(function () {
    Route::post('/store/{type}/{id}', [AppointmentSlotController::class, 'store'])
        ->name('appointment.slots.store');
    Route::get('/show/{id}', [AppointmentSlotController::class, 'show'])
        ->name('appointment.slots.show');
});


Route::get('/pharmacist/sales', [PharmacistSaleController::class, 'sales'])->name('pharmacist.sales');
Route::post('/pharmacist/sale/store', [PharmacistSaleController::class, 'storeSale'])->name('pharmacist.sale.store');
Route::get('/pharmacist/search-medicines', [PharmacistSaleController::class, 'searchMedicines'])->name('pharmacist.search.medicines');
Route::get('/pharmacist/sales-report', [PharmacistSaleController::class, 'salesReport'])->name('pharmacist.report');


// Notifications 
Route::get('/notifications/page', [MessageNotificationController::class, 'notificationPage'])->name('notification.page');
Route::post('/notifications/mark-all-read', [MessageNotificationController::class, 'markAllAsRead'])->name('notification.markAllRead');
Route::post('/notifications/{notification}/mark-read', [MessageNotificationController::class, 'markAsRead'])->name('notification.read');
Route::delete('/notifications/{notification}', [MessageNotificationController::class, 'destroy'])->name('notification.destroy');

// Chat
Route::get('chat', [ChMessageController::class, 'index'])->name('chat.index');
Route::post('/chat/send', [ChMessageController::class, 'send'])->name('chat.send');
Route::get('/chat/messages/{userId}', [ChMessageController::class, 'messages'])->name('chat.messages');
