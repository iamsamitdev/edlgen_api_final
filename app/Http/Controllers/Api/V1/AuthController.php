<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/v1/login
     * รับ email + password + device_name แล้วคืน Sanctum Token
     */
    public function login(Request $request): JsonResponse
    {
        // 1) Validate ข้อมูลขาเข้า - ถ้าไม่ผ่าน Laravel คืน 422 ให้อัตโนมัติ
        $validated = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required', 'string'],
            'device_name' => ['required', 'string'], // เช่น "samsung-a54-somchai"
        ]);

        // 2) หา user และตรวจรหัสผ่าน
        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            // ตอบกลับแบบเดียวกันทั้ง "ไม่พบ user" และ "รหัสผิด" กันการเดา email
            throw ValidationException::withMessages([
                'email' => ['ข้อมูลเข้าสู่ระบบไม่ถูกต้อง'],
            ]);
        }

        // 3) สร้าง Token ผูกกับชื่ออุปกรณ์ (1 อุปกรณ์ = 1 token เพิกถอนแยกกันได้)
        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return response()->json([
            'message' => 'เข้าสู่ระบบสำเร็จ',
            'token'   => $token,          // Flutter เก็บค่านี้ไว้แนบทุก Request
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * POST /api/v1/register
     * รับ name + email + password + device_name แล้วคืน Sanctum Token
     */
    public function register(Request $request): JsonResponse
    {
        // 1) Validate ข้อมูลขาเข้า - ถ้าไม่ผ่าน Laravel คืน 422 ให้อัตโนมัติ
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8'], // กำหนดความยาวขั้นต่ำของรหัสผ่าน
            'device_name' => ['required', 'string'], // เช่น "samsung-a54-somchai"
        ]);

        // 2) สร้าง user ใหม่
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // hash รหัสผ่านก่อนเก็บ
        ]);

        // 3) สร้าง Token ผูกกับชื่ออุปกรณ์ (1 อุปกรณ์ = 1 token เพิกถอนแยกกันได้)
        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return response()->json([
            'message' => 'สมัครสมาชิกสำเร็จ',
            'token'   => $token,          // Flutter เก็บค่านี้ไว้แนบทุก Request
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
 
    /**
     * POST /api/v1/logout  (ต้องแนบ Bearer Token)
     * ลบเฉพาะ token ของอุปกรณ์ที่เรียกเข้ามา
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'ออกจากระบบสำเร็จ']);
    }

    /**
     * GET /api/v1/me  (ต้องแนบ Bearer Token)
     * คืนข้อมูลผู้ใช้ปัจจุบัน - ใช้ทดสอบว่า token ยังใช้ได้
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }
}