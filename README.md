# EDL-Gen Monitoring API (`edlgen_api`)

Backend API สำหรับ **EDL-Gen Monitoring App** ระบบติดตามการผลิตไฟฟ้า (ข้อมูลจำลองทั้งหมด) พัฒนาด้วย **Laravel 13** ให้บริการฝั่ง Flutter App (`edlgen_monitoring`) ผ่าน RESTful API พร้อมระบบยืนยันตัวตนแบบ Token ด้วย **Laravel Sanctum**

> โปรเจกต์นี้เป็นส่วนหนึ่งของหลักสูตรอบรม **Basic to Advanced Laravel 13 and Flutter Framework (MOB-15)** จัดอบรมให้ EDL-Generation Public Company (สปป.ลาว) — ดูรายละเอียดเนื้อหาวันที่ 1 ได้ที่ [Flutter_Day1_note.md](Flutter_Day1_note.md)

## สแตกเทคโนโลยี

- PHP 8.3+ / Laravel 13
- Laravel Sanctum — Token-based Authentication สำหรับ Mobile Client
- MariaDB 11 (รันผ่าน Docker) — รองรับสลับเป็น PostgreSQL 16 ได้ผ่าน `.env`
- Pest / PHPUnit สำหรับทดสอบ

## โครงสร้างโดเมนหลัก

| Model           | ตาราง             | คำอธิบาย                                    |
| --------------- | ----------------- | -------------------------------------------- |
| `User`          | `users`           | ผู้ใช้งาน/วิศวกร ใช้ล็อกอินผ่าน Sanctum      |
| `PowerPlant`    | `power_plants`    | โรงไฟฟ้า (ชื่อ, รหัส, ประเภท, กำลังผลิต, แขวง) |
| `EnergyReading` | `energy_readings` | ค่าการผลิตไฟฟ้ารายชั่วโมง (output/frequency/voltage) |
| `Incident`      | `incidents`       | เหตุขัดข้องของแต่ละโรงไฟฟ้า                  |

## เริ่มต้นใช้งาน (Local Setup)

### 1. ติดตั้ง Dependencies

```bash
composer install
copy .env.example .env      # Windows (PowerShell: Copy-Item .env.example .env)
php artisan key:generate
```

### 2. ตั้งค่าฐานข้อมูล

โปรเจกต์นี้ตั้งค่าให้ใช้ **MariaDB** เป็นค่าเริ่มต้น (รันผ่าน Docker) แก้ไขค่าต่อไปนี้ใน `.env` ให้ตรงกับฐานข้อมูลของคุณ:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edlgen
DB_USERNAME=edlgen_user
DB_PASSWORD=edlgen_pass
```

> รองรับสลับไปใช้ PostgreSQL ได้ทันทีโดยแก้เป็น `DB_CONNECTION=pgsql` และ `DB_PORT=5432` เท่านั้น (ดู Repository Pattern ใน `app/Repositories/`)

### 3. รัน Migration และ Seeder

```bash
php artisan migrate:fresh --seed
```

คำสั่งนี้จะสร้างตารางทั้งหมดและใส่ข้อมูลจำลอง:

- ผู้ใช้ทดสอบ: `engineer@edlgen.la` / รหัสผ่าน `password123`
- โรงไฟฟ้าจำลอง 5 แห่ง พร้อมค่าการอ่านย้อนหลัง 24 ชั่วโมง/แห่ง

### 4. รันเซิร์ฟเวอร์

```bash
php artisan serve
```

เปิด `http://127.0.0.1:8000` ต้องเห็นหน้า Welcome ของ Laravel และเรียก API ได้ที่ `http://127.0.0.1:8000/api/v1/...`

> **ทดสอบจาก Android Emulator:** ใช้ `http://10.0.2.2:8000` แทน `localhost`
> **ทดสอบจากเครื่องจริง:** รัน `php artisan serve --host=0.0.0.0` แล้วใช้ IP วง LAN ของเครื่อง

## API Endpoints

Base URL: `/api/v1`

### Authentication

| Method | Endpoint    | Auth | คำอธิบาย                                  |
| ------ | ----------- | ---- | ------------------------------------------ |
| POST   | `/register` | -    | สมัครสมาชิกใหม่ คืน Sanctum Token          |
| POST   | `/login`    | -    | เข้าสู่ระบบด้วย email/password คืน Token   |
| POST   | `/logout`   | ✅   | ออกจากระบบ (ลบ Token ปัจจุบัน)             |
| GET    | `/me`       | ✅   | ข้อมูลผู้ใช้ปัจจุบัน                       |

Request ตัวอย่างของ `/login` และ `/register`:

```json
{
  "email": "engineer@edlgen.la",
  "password": "password123",
  "device_name": "postman-test"
}
```

### Power Plants

| Method | Endpoint             | Auth | คำอธิบาย                     |
| ------ | --------------------- | ---- | ------------------------------ |
| GET    | `/power-plants`       | ✅   | รายการโรงไฟฟ้าทั้งหมด          |
| GET    | `/power-plants/{id}`  | ✅   | ข้อมูลโรงไฟฟ้ารายตัว           |
| POST   | `/power-plants`       | ✅   | สร้างโรงไฟฟ้าใหม่              |

Request ตัวอย่างของ `POST /power-plants`:

```json
{
  "name": "Nam Ngum 3",
  "code": "NN3",
  "type": "hydro",
  "capacity_mw": 440,
  "province": "Xaisomboun"
}
```

> เส้นทางที่มีเครื่องหมาย ✅ ต้องแนบ Header `Authorization: Bearer <token>` และ `Accept: application/json` เสมอ

## ทดสอบ API ด้วย Postman/Bruno

1. ยิง `POST /api/v1/login` เพื่อรับ Token
2. นำ Token ไปตั้งเป็น `Authorization: Bearer <token>` สำหรับเรียก endpoint ที่ต้องยืนยันตัวตน
3. ยิง `GET /api/v1/power-plants` เพื่อดูรายการโรงไฟฟ้า

## รันเทส

```bash
php artisan test
```

## เอกสารเพิ่มเติม

- เนื้อหา Workshop วันที่ 1 (Environment Setup, Sanctum Auth, API Resources, Repository Pattern, Riverpod AsyncValue): [Flutter_Day1_note.md](Flutter_Day1_note.md)
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
