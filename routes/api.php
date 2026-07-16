<?php

use App\Http\Controllers\Api\V1\IncidentController;
use App\Http\Controllers\Api\V1\MeterReadingController;
use App\Http\Controllers\Api\V1\PowerPlantController;
use App\Http\Controllers\Api\V1\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// route ทดสอบว่า api สามารถเรียกใช้งานได้หรือไม่
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is working'
    ]);
});

// route ทดสอบ method POST
Route::post('/test-post', function (Request $request) {
    $data = $request->all(); // ดึงข้อมูลทั้งหมดจาก request
    return response()->json([
        'status' => 'success',
        'message' => 'POST request received',
        'data' => $data
    ]);
});

// route ทดสอบ method PUT
Route::put('/test-put', function (Request $request) {
    $data = $request->all(); // ดึงข้อมูลทั้งหมดจาก request
    return response()->json([
        'status' => 'success',
        'message' => 'PUT request received',
        'data' => $data
    ]);
});

// route ทดสอบ method DELETE
Route::delete('/test-delete', function (Request $request) {
    $data = $request->all(); // ดึงข้อมูลทั้งหมดจาก request
    return response()->json([
        'status' => 'success',
        'message' => 'DELETE request received',
        'data' => $data
    ]);
});

// ทุกเส้นทางในกลุ่มนี้จะขึ้นต้นด้วย /api/v1/ อัตโนมัติ
Route::prefix('v1')->group(function () {
    
    // route สำหรับการ register
    Route::post('/register', [AuthController::class, 'register']);

    // route สำหรับการ login
    Route::post('/login', [AuthController::class, 'login']);

    // middleware 'auth:sanctum' จะตรวจสอบว่า request มี token ที่ถูกต้องหรือไม่
    Route::middleware('auth:sanctum')->group(function () {
        // route สำหรับการ logout (ต้องแนบ token)
        Route::post('/logout', [AuthController::class, 'logout']);
        // route สำหรับดึงข้อมูล user ปัจจุบัน (ต้องแนบ token)
        Route::get('/me', [AuthController::class, 'me']);

        // ── เหตุขัดข้อง (Incidents) ──
        Route::get('/incidents', [IncidentController::class, 'index']);
        Route::get('/incidents/{id}', [IncidentController::class, 'show']);
        Route::post('/incidents', [IncidentController::class, 'store']);

        // ── ค่ามิเตอร์รายชั่วโมง (Meter Readings) ──
        Route::get('/meter-readings/today', [MeterReadingController::class, 'today']);
        Route::post('/meter-readings', [MeterReadingController::class, 'store']);

        // ── รายงานการผลิตรายวัน (Daily Reports) ──
        Route::get('/reports/daily', [ReportController::class, 'daily']);
    });

    // route สำหรับดึงรายการโรงไฟฟ้า (Power Plant) ทั้งหมด
    Route::get('/power-plants', [PowerPlantController::class, 'index']);
    // route สำหรับดึงข้อมูลโรงไฟฟ้า (Power Plant) ตาม ID
    Route::get('/power-plants/{id}', [PowerPlantController::class, 'show']);
    // route สำหรับสร้างโรงไฟฟ้า (Power Plant) ใหม่
    Route::post('/power-plants', [PowerPlantController::class, 'store']);

});
