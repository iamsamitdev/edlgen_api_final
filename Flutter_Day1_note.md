# Basic to Advanced Laravel 13 & Flutter - วันที่ 1: เตรียมเครื่องมือ + Laravel 13 API Layer + Riverpod Async State

**หลักสูตรอบรมเชิงปฏิบัติการ: Basic to Advanced Laravel 13 and Flutter Framework (30 ชั่วโมง, 5 วัน)**
**Course ID: MOB-15 | Category: Mobile / Full-Stack**
**จัดอบรมให้: EDL-Generation Public Company (EDL-Gen) ผู้ผลิตไฟฟ้ารายใหญ่ของ สปป.ลาว**
**วันที่ 1: เตรียมเครื่องมือและตรวจสอบความพร้อม + Laravel 13 API Layer + Riverpod Async State**
วันที่: วันจันทร์ที่ 13 กรกฎาคม 2569 | เวลา 09:30-16:30 น. (พักกลางวัน 12:00-13:00 น.) | Onsite Workshop ณ สถาบันไอทีจีเนียส เอ็นจิเนียริ่ง
ผู้สอน: อ.สามิตร โกยม

---

## 🎯 วัตถุประสงค์การเรียนรู้ประจำวัน

เมื่อจบการอบรมวันที่ 1 ผู้เรียนจะสามารถ:

1. ติดตั้งและตรวจสอบความพร้อมของเครื่องมือทั้งหมด (PHP 8.3, Composer, Docker, Flutter SDK, Android Studio, VS Code) ได้ด้วยตนเอง
2. สร้างโปรเจกต์ Laravel 13 พร้อมวางสถาปัตยกรรม API แบบ Repository Pattern (แยก Controller / Service / Repository) และกำหนด API Versioning `/api/v1/` ได้
3. ออกแบบและเขียนระบบ Authentication ด้วย Laravel Sanctum แบบ Token-based สำหรับ Mobile Client ครอบคลุม Login/Logout Flow และ Middleware Guard ได้
4. แปลง Eloquent Model เป็น JSON Response ที่สะอาดด้วย API Resources, Nested Collection และ Conditional Fields เพื่อป้องกัน Over-fetching ได้
5. เขียน Repository Interface + Concrete Implementation ที่สลับ Database Driver ระหว่าง MariaDB และ PostgreSQL ได้โดยไม่แก้ Business Logic รวมถึงใช้ Migration, Seeder และ Database Transaction ได้
6. อธิบาย State Machine ของ `AsyncValue` (data / loading / error) ใน Riverpod 3.0 และ Consume ผล API ด้วย `when()` / `AsyncValue.guard()` ได้
7. สร้าง `AsyncNotifier` สำหรับงาน CRUD และใช้ Mutations API ใหม่ของ Riverpod 3.0 ที่มี Lifecycle `idle -> pending -> success/error` พร้อมทำ UI Feedback แต่ละ State ได้
8. เพิ่ม Automatic Retry ด้วย `retry` parameter และเขียน Custom Exception Handler สำหรับสภาวะเครือข่ายไม่เสถียรได้

> **หมายเหตุสำคัญของหลักสูตรนี้:** ตลอด 5 วันเราจะพัฒนาแอปเดียวต่อเนื่องคือ **EDL-Gen Monitoring App** ระบบติดตามการผลิตไฟฟ้า (ใช้ข้อมูลจำลองทั้งหมด ไม่เกี่ยวกับข้อมูลการผลิตจริงขององค์กร) ประกอบด้วย 2 โปรเจกต์คือ Laravel Backend ชื่อ `edlgen_api` และ Flutter App ชื่อ `edlgen_monitoring` โค้ดทุกส่วนที่เขียนวันนี้จะถูกนำไปต่อยอดจนถึง Workshop วันสุดท้าย

---

## 🧭 กำหนดการวันที่ 1 (โดยสังเขป)

| เวลา        | หัวข้อ                                                                          |
| ----------- | ------------------------------------------------------------------------------- |
| 09:30-09:50 | ทดสอบก่อนเรียน (Pretest) + แนะนำหลักสูตรและโปรเจกต์ EDL-Gen Monitoring App     |
| 09:50-10:50 | **Module 0** การเตรียมเครื่องมือและตรวจสอบความพร้อม (Environment Setup)         |
| 10:50-11:30 | **Module 1** Laravel 13 Project Setup + API Architecture (Repository Pattern)   |
| 11:30-12:00 | **Module 2 (ตอนที่ 1)** Authentication ด้วย Laravel Sanctum - แนวคิดและติดตั้ง |
| 12:00-13:00 | พักกลางวัน                                                                      |
| 13:00-13:30 | **Module 2 (ตอนที่ 2)** Login/Logout Flow + Middleware Guard + ทดสอบด้วย Postman |
| 13:30-14:00 | **Module 3** API Resources & Collections                                        |
| 14:00-14:30 | **Module 4** MariaDB/PostgreSQL Repository Pattern + Migration + Transaction    |
| 14:30-15:00 | **Module 5** Riverpod 3.0 AsyncValue (State Machine: data/loading/error)        |
| 15:00-15:30 | **Module 6-7** AsyncNotifier + Mutations API + Automatic Retry                  |
| 15:30-16:30 | **🔬 Lab วันที่ 1** Laravel API Endpoint + Sanctum Auth + Flutter AsyncValue UI |

---

## ✅ ทดสอบก่อนเรียน (Pretest)

### เวลา 09:30-09:50 น.

ก่อนเริ่มเรียน ให้ผู้เรียนทำแบบทดสอบก่อนเรียนตามลิงก์ที่วิทยากรแจ้งในห้องอบรม เพื่อวัดพื้นฐานความเข้าใจเดิมเกี่ยวกับ PHP/Laravel, SQL, Dart/Flutter และ State Management ผลทดสอบนี้ **ไม่มีผลต่อการประเมิน** ใช้เพียงเพื่อปรับจังหวะการสอนให้เหมาะกับกลุ่มผู้เรียน

หัวข้อที่ Pretest ครอบคลุม (ประมาณ 15 ข้อ, 15 นาที):

- PHP OOP พื้นฐาน (Class, Interface, Dependency Injection)
- SQL พื้นฐาน (SELECT, JOIN, INSERT) บน MariaDB/PostgreSQL
- แนวคิด RESTful API และ HTTP Status Code
- Dart พื้นฐาน (Function, Class, async/await, Future)
- Flutter Widget เบื้องต้น (StatelessWidget, StatefulWidget)

จากนั้นวิทยากรแนะนำภาพรวมหลักสูตร 5 วัน และโปรเจกต์ EDL-Gen Monitoring App ที่จะสร้างร่วมกันตลอดหลักสูตร

```
ภาพรวมระบบ EDL-Gen Monitoring App (เป้าหมายปลายทางวันที่ 5):

┌──────────────────────────┐         ┌──────────────────────────────┐
│  Flutter App             │  HTTP   │  Laravel 13 API (edlgen_api) │
│  (edlgen_monitoring)     │ ──────► │  /api/v1/...                 │
│                          │  JSON   │                              │
│  - Login (Sanctum Token) │ ◄────── │  Controller → Service        │
│  - Dashboard Real-time   │         │       → Repository           │
│  - รายงานการผลิต          │         │            │                 │
│  - แจ้งเหตุขัดข้อง          │         │            ▼                 │
│  State: Riverpod 3.0     │         │   MariaDB 11 / PostgreSQL 16 │
│         + Cubit (Day 4)  │         │   (สลับ Driver ได้)           │
└──────────────────────────┘         └──────────────────────────────┘
        วันนี้เราวางรากฐานฝั่งขวาทั้งหมด + Async State ฝั่งซ้าย
```

---

## 📚 Module 0: การเตรียมเครื่องมือและตรวจสอบความพร้อม (Environment Setup)

### เวลา 09:50-10:50 น.

> 💡 **หัวใจของ Module นี้:** "เครื่องพร้อม = เรียนราบรื่นทั้ง 5 วัน" ปัญหาส่วนใหญ่ของการอบรมเชิงปฏิบัติการไม่ได้อยู่ที่โค้ด แต่อยู่ที่ Environment ที่ไม่พร้อม Module นี้จะไล่ตรวจทีละรายการจนทุกเครื่องผ่าน Checklist ครบ 100% ก่อนเริ่มเขียนโค้ดจริง

---

### 0.1 ภาพรวมเครื่องมือที่ใช้ตลอดหลักสูตร

| เครื่องมือ                | เวอร์ชันที่ใช้      | ใช้ทำอะไร                                            |
| ------------------------- | ------------------- | ---------------------------------------------------- |
| PHP                       | 8.3+                | รัน Laravel 13 (ต้องการ PHP 8.3 ขึ้นไป)               |
| Composer                  | 2.x                 | Package Manager ของ PHP / ติดตั้ง Laravel            |
| PHP 8.3 ZIP (Windows)     | 8.3 VS16 x64 TS     | ติดตั้ง PHP ตรง ๆ ที่ `C:\php83` (Thread Safe, x64)  |
| Docker Desktop            | ล่าสุด              | รัน MariaDB 11.x และ PostgreSQL 16 แบบ Container     |
| Flutter SDK               | 3.x (stable)        | พัฒนา Mobile App (มาพร้อม Dart 3.x)                  |
| Android Studio            | Ladybug+            | Android SDK + Emulator                               |
| VS Code                   | ล่าสุด              | Editor หลัก (ทั้ง PHP และ Flutter)                   |
| Git                       | 2.x                 | Version Control + ดึง Starter Kit                    |
| Postman หรือ Bruno        | ล่าสุด              | ทดสอบ API ก่อนเชื่อมกับ Flutter                      |
| TablePlus หรือ DBeaver    | ล่าสุด              | GUI ดูข้อมูลใน MariaDB/PostgreSQL                    |

> 📌 **สเปกเครื่องแนะนำ:** RAM 16 GB ขึ้นไป (Android Studio + Laravel + Database Container รันพร้อมกัน) พื้นที่ดิสก์ว่างอย่างน้อย 30 GB และเปิด Virtualization (VT-x/AMD-V) ใน BIOS สำหรับ Emulator และ Docker

### 0.2 ติดตั้ง PHP 8.3 + Composer 2.x

#### ฝั่ง Windows - ติดตั้ง PHP 8.3 (VS16 x64 Thread Safe) แบบ Manual

เราจะไม่ใช้ Laragon แต่ดาวน์โหลด PHP 8.3 มาติดตั้งตรง ๆ เพื่อควบคุมเวอร์ชันและ Extension ได้เต็มที่ โปร่งใส และเข้าใจว่า PHP วางอยู่ที่ไหนจริง ๆ:

1. เปิดหน้า `https://windows.php.net/download/` (หรือ `https://www.php.net/downloads.php?os=windows` แล้วเลือก **ZIP Downloads / version 8.3**) เลื่อนหาหมวด **VS16 x64 Thread Safe** แล้วกด **Zip** เพื่อดาวน์โหลด
   - **VS16** = คอมไพล์ด้วย Visual Studio 2019
   - **x64** = สำหรับ Windows 64-bit (แนะนำ)
   - **Thread Safe (TS)** = ใช้ได้ทั้งกับ Apache (mod_php) และ CLI จึงยืดหยุ่นกว่าในห้องอบรม
2. แตกไฟล์ Zip ทั้งหมดไปไว้ที่ `C:\php83` (ภายในต้องมี `php.exe`, `php.ini-development` และโฟลเดอร์ `ext\`)
3. ติดตั้ง **Microsoft Visual C++ Redistributable for Visual Studio 2015-2022 (x64)** ก่อนถ้าเครื่องยังไม่มี ไม่งั้น `php.exe` จะเปิดไม่ขึ้น (ดาวน์โหลด `https://aka.ms/vs/17/release/vc_redist.x64.exe`)
4. สร้างไฟล์ตั้งค่า: คัดลอก `C:\php83\php.ini-development` แล้วเปลี่ยนชื่อสำเนาเป็น `C:\php83\php.ini`
5. เพิ่ม `C:\php83` เข้า **System Environment Variables > Path**:
   - เปิด Settings > System > About > Advanced system settings > **Environment Variables**
   - ที่ช่อง **System variables** เลือก **Path** > **Edit** > **New** > พิมพ์ `C:\php83` > **OK** ทุกหน้าต่าง
6. **เปิด PowerShell/Terminal ใหม่** (ต้องเปิดใหม่หลังแก้ PATH เสมอ) แล้วตรวจสอบ:

```powershell
php -v
# ต้องเห็น: PHP 8.3.x (cli) (built: ...) (ZTS Visual C++ 2019 x64)
#          Zend Engine v4.3.x ...

where.exe php
# ต้องเห็น: C:\php83\php.exe   (ยืนยันว่า Windows เรียก PHP จาก C:\php83 จริง)
```

> ✅ **จุดสำคัญ:** คำว่า **ZTS** ในบรรทัด `php -v` ย่อมาจาก Zend Thread Safe แปลว่าเราโหลดตัว Thread Safe มาถูกแล้ว ถ้าเห็น **NTS** แสดงว่าโหลดผิดตัว ให้ดาวน์โหลด VS16 x64 **Thread Safe** ใหม่

7. เปิด `C:\php83\php.ini` ด้วย VS Code เพื่อเปิดใช้งาน Extension ที่ Laravel 13 ต้องใช้ โดยลบเครื่องหมาย `;` หน้าบรรทัดต่อไปนี้ และตั้งค่า `extension_dir` ให้ถูก:

```ini
; ชี้ไปยังโฟลเดอร์ ext (ลบ ; หน้าบรรทัดนี้ออก)
extension_dir = "ext"

; เปิด Extension ที่ Laravel 13 ต้องใช้ (ลบ ; หน้าแต่ละบรรทัด)
extension=curl
extension=fileinfo
extension=mbstring
extension=openssl
extension=pdo_mysql
extension=pdo_pgsql
extension=pdo_sqlite
extension=gd
extension=exif
extension=zip
```

บันทึกไฟล์ แล้วเปิด Terminal ใหม่รัน `php -m` เพื่อยืนยันว่า Extension ทั้งหมดถูกเปิด (ดูหัวข้อ "ตรวจสอบ PHP Extension" ด้านล่าง)

#### ติดตั้ง Composer 2.x แยกต่างหาก (Windows)

เมื่อไม่ใช้ Laragon แล้ว Composer ก็ไม่ได้ติดมาให้ ต้องติดตั้งเองแยก โดยชี้ให้ Composer ใช้ PHP จาก `C:\php83`:

**วิธีที่ 1 (แนะนำ) - ผ่าน Composer-Setup.exe:**

1. ดาวน์โหลดและรัน `https://getcomposer.org/Composer-Setup.exe`
2. เมื่อ Installer ถามหา Command-line PHP ให้ชี้ไปที่ `C:\php83\php.exe`
3. Installer จะเพิ่ม Composer เข้า PATH ให้อัตโนมัติ (จบแล้วเปิด Terminal ใหม่)

**วิธีที่ 2 - แบบ Manual (กรณีติดตั้งแบบพกพา):**

```powershell
cd C:\php83
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=C:\php83 --filename=composer
php -r "unlink('composer-setup.php');"
# ได้ไฟล์ C:\php83\composer.phar และ C:\php83\composer.bat (เรียกด้วยคำสั่ง composer ได้เลยเพราะ C:\php83 อยู่ใน PATH แล้ว)
```

ตรวจสอบทั้ง PHP และ Composer (เปิด Terminal ใหม่ก่อน):

```powershell
php -v
# ต้องเห็น: PHP 8.3.x (cli) ... (ZTS Visual C++ 2019 x64)

composer -V
# ต้องเห็น: Composer version 2.x.x
```

> ⚠️ **ข้อควรระวัง (Windows):** ถ้าพิมพ์ `php -v` แล้วขึ้น `'php' is not recognized...` แปลว่า PATH ยังไม่ถูกตั้ง หรือยังไม่ได้เปิด Terminal ใหม่ ให้ตรวจว่ามี `C:\php83` อยู่ใน System Path แล้วปิด-เปิด PowerShell ใหม่อีกครั้ง (ตัวแปร PATH โหลดตอนเปิด Terminal เท่านั้น) และยืนยันตำแหน่งด้วย `where.exe php` ต้องได้ `C:\php83\php.exe`

#### ฝั่ง macOS - ผ่าน Homebrew

```bash
# ติดตั้ง Homebrew ก่อน (ถ้ายังไม่มี)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# ติดตั้ง PHP 8.3 และ Composer
brew install php@8.3 composer

# ผูก php@8.3 เข้ากับ PATH (กรณีมี PHP หลายเวอร์ชัน)
brew link php@8.3 --force

# ตรวจสอบ
php -v
composer -V
```

#### ตรวจสอบ PHP Extension ที่ Laravel 13 ต้องใช้

```bash
php -m
# ต้องมีอย่างน้อย: ctype, curl, dom, fileinfo, filter, hash, mbstring,
# openssl, pcre, pdo, pdo_mysql, pdo_pgsql, session, tokenizer, xml
```

> ✅ **จุดสำคัญ:** ต้องเปิดทั้ง `pdo_mysql` (สำหรับ MariaDB) และ `pdo_pgsql` (สำหรับ PostgreSQL) เพราะวันนี้เราจะสาธิตการสลับ Driver ระหว่างสองฐานข้อมูล ถ้าไม่เจอให้เปิดใน `php.ini` โดยเอา `;` หน้าบรรทัด `extension=pdo_mysql` และ `extension=pdo_pgsql` ออก แล้ว Restart Terminal

### 0.3 ติดตั้ง Docker Desktop + Database Container

เราใช้ Docker รันฐานข้อมูลทั้งสองตัวเพื่อให้ทุกเครื่องมีสภาพแวดล้อมเหมือนกัน 100% และไม่ต้องติดตั้งฐานข้อมูลลงเครื่องตรง ๆ

1. ดาวน์โหลด Docker Desktop จาก `https://www.docker.com/products/docker-desktop/`
2. Windows: ต้องเปิดใช้ WSL 2 (Docker จะแนะนำขั้นตอนให้ตอนติดตั้ง) / macOS: เลือกไฟล์ตรงกับชิป (Apple Silicon หรือ Intel)
3. เปิด Docker Desktop รอจน Status มุมล่างซ้ายเป็นสีเขียว (Engine running)
4. ตรวจสอบ:

```bash
docker --version
# Docker version 27.x ขึ้นไป

docker compose version
# Docker Compose version v2.x
```

#### ไฟล์ docker-compose.yml สำหรับหลักสูตร (ใช้จริงตลอด 5 วัน)

สร้างโฟลเดอร์ `edlgen-workshop` แล้วสร้างไฟล์ `docker-compose.yml` ภายใน:

```yaml
# docker-compose.yml - ฐานข้อมูลสำหรับ EDL-Gen Monitoring Workshop
# รัน MariaDB 11.x และ PostgreSQL 16 พร้อมกัน (Laravel สลับ Driver ได้)
services:
  mariadb:
    image: mariadb:11.4
    container_name: edlgen_mariadb
    restart: unless-stopped
    environment:
      MARIADB_ROOT_PASSWORD: secret        # รหัส root (ใช้เฉพาะในห้องอบรม)
      MARIADB_DATABASE: edlgen             # สร้างฐานข้อมูลให้อัตโนมัติ
      MARIADB_USER: edlgen_user            # ผู้ใช้สำหรับ Laravel
      MARIADB_PASSWORD: edlgen_pass
    ports:
      - "3306:3306"                        # เครื่องเรา:คอนเทนเนอร์
    volumes:
      - mariadb_data:/var/lib/mysql        # เก็บข้อมูลถาวร ปิดเครื่องแล้วข้อมูลไม่หาย

  postgres:
    image: postgres:16
    container_name: edlgen_postgres
    restart: unless-stopped
    environment:
      POSTGRES_DB: edlgen
      POSTGRES_USER: edlgen_user
      POSTGRES_PASSWORD: edlgen_pass
    ports:
      - "5432:5432"
    volumes:
      - postgres_data:/var/lib/postgresql/data

volumes:
  mariadb_data:
  postgres_data:
```

สั่งรันและตรวจสอบ:

```bash
cd edlgen-workshop

# รันทั้งสองฐานข้อมูลแบบ background
docker compose up -d

# ตรวจสอบว่า Container ทำงานทั้งคู่ (STATUS ต้องเป็น Up)
docker compose ps

# ทดสอบเข้า MariaDB shell
docker exec -it edlgen_mariadb mariadb -u edlgen_user -pedlgen_pass edlgen

# ทดสอบเข้า PostgreSQL shell
docker exec -it edlgen_postgres psql -U edlgen_user -d edlgen
```

> ⚠️ **ข้อควรระวัง:** ถ้า Port 3306 หรือ 5432 ถูกใช้อยู่แล้ว (เช่น เคยติดตั้ง MySQL/XAMPP ไว้ในเครื่อง) Container จะรันไม่ขึ้น ให้แก้ฝั่งซ้ายของ ports เป็นเลขอื่น เช่น `"3307:3306"` แล้วปรับ `DB_PORT` ในไฟล์ `.env` ของ Laravel ให้ตรงกัน หรือปิด Service MySQL เดิมก่อน

### 0.4 ติดตั้ง Flutter SDK 3.x + ตรวจด้วย flutter doctor

1. ดาวน์โหลด Flutter SDK (stable channel) จาก `https://docs.flutter.dev/get-started/install`
2. Windows: แตกไฟล์ไปไว้ที่ `C:\dev\flutter` (หลีกเลี่ยงโฟลเดอร์ที่มีช่องว่างหรือภาษาไทยในพาธ เช่น `C:\Program Files`) / macOS: แนะนำ `~/development/flutter`
3. เพิ่ม `flutter\bin` เข้า PATH:
   - Windows: Settings > System > About > Advanced system settings > Environment Variables > Path > เพิ่ม `C:\dev\flutter\bin`
   - macOS (zsh): เพิ่ม `export PATH="$PATH:$HOME/development/flutter/bin"` ใน `~/.zshrc`
4. เปิด Terminal ใหม่แล้วรัน:

```bash
flutter --version
# Flutter 3.x.x (channel stable) / Dart 3.x.x

flutter doctor
```

ตัวอย่างผลลัพธ์ `flutter doctor` ที่ "พร้อมเรียน":

```
Doctor summary (to see all details, run flutter doctor -v):
[✓] Flutter (Channel stable, 3.x.x)
[✓] Windows Version (Installed version of Windows is version 10 or higher)
[✓] Android toolchain - develop for Android devices (Android SDK version 35.x)
[✓] Chrome - develop for the web
[✓] Android Studio (version 2024.x)
[✓] VS Code (version 1.x)
[✓] Connected device (2 available)
[✓] Network resources
```

> ✅ **จุดสำคัญ:** แถว **Flutter**, **Android toolchain**, **Android Studio** และ **Connected device** ต้องเป็นเครื่องหมายถูกทั้งหมด ถ้า Android toolchain ขึ้น `! Some Android licenses not accepted` ให้รัน `flutter doctor --android-licenses` แล้วกด `y` ยอมรับทุกข้อ

### 0.5 Android Studio + Emulator / เครื่องจริง

1. ติดตั้ง Android Studio จาก `https://developer.android.com/studio` (ตอนติดตั้งให้เลือก Android SDK, SDK Platform และ Android Virtual Device ครบ)
2. สร้าง Emulator: เปิด Android Studio > **More Actions > Virtual Device Manager > Create Virtual Device** > เลือก Pixel 7 > System Image Android 14 (API 34) ขึ้นไป > Finish
3. กดปุ่ม Play เพื่อบูต Emulator แล้วตรวจว่า Flutter มองเห็น:

```bash
flutter devices
# ต้องเห็น emulator-5554 (android) หรือชื่อเครื่องจริงของเรา
```

**กรณีใช้เครื่องจริง (Android 9 ขึ้นไป) - แนะนำเมื่อ Emulator ช้า:**

1. เปิด Settings > About phone > แตะ Build number 7 ครั้งเพื่อเปิด Developer options
2. เปิด **USB debugging** ใน Developer options
3. เสียบสาย USB เลือกโหมด File transfer แล้วกด Allow บนหน้าจอมือถือเมื่อถูกถาม
4. รัน `flutter devices` ต้องเห็นชื่อรุ่นมือถือปรากฏ

> ⚠️ **ข้อควรระวัง:** เครื่องที่ CPU ไม่รองรับ Hardware Acceleration (VT-x/AMD-V หรือ Hyper-V ถูกปิด) Emulator จะช้ามากหรือบูตไม่ขึ้น ให้เปิดใน BIOS ก่อน หรือใช้เครื่องจริงแทนตลอดหลักสูตร

### 0.6 VS Code + Extensions ที่แนะนำ

ติดตั้ง VS Code จาก `https://code.visualstudio.com/` แล้วติดตั้ง Extension ต่อไปนี้ (กด `Ctrl+Shift+X` แล้วค้นหา):

| Extension                    | ผู้พัฒนา      | ใช้ทำอะไร                                       |
| ---------------------------- | ------------- | ----------------------------------------------- |
| Flutter                      | Dart Code     | รัน/ดีบัก Flutter + Hot Reload ใน VS Code       |
| Dart                         | Dart Code     | Language Support ของ Dart (มากับ Flutter)       |
| PHP Intelephense             | Ben Mewburn   | Autocomplete + Go to Definition ของ PHP         |
| Laravel Extension Pack       | Winnie Lin    | รวม Blade, Artisan, Snippets สำหรับ Laravel     |
| DotENV                       | mikestead     | Syntax Highlight ไฟล์ .env                      |
| Error Lens                   | Alexander     | โชว์ Error/Warning ท้ายบรรทัดทันที เห็นง่าย     |
| GitLens                      | GitKraken     | ดูประวัติ Git ในไฟล์                            |
| Thunder Client (ทางเลือก)    | Ranga V.      | ทดสอบ API ใน VS Code ได้เลย ไม่ต้องสลับโปรแกรม |

### 0.7 Git + Postman/Bruno + TablePlus/DBeaver

```bash
# ตรวจสอบ Git (ถ้าไม่มี: Windows ติดตั้งจาก git-scm.com / macOS: brew install git)
git --version
# git version 2.x

# ตั้งค่าครั้งแรก (ใช้ชื่อ-อีเมลของผู้เรียนเอง)
git config --global user.name "Your Name"
git config --global user.email "you@example.com"
```

- **Postman** (`https://www.postman.com/downloads/`) หรือ **Bruno** (`https://www.usebruno.com/downloads` - โอเพนซอร์ส เก็บ Collection เป็นไฟล์ในโปรเจกต์ ไม่ต้องล็อกอิน) ใช้ทดสอบ API ที่เราสร้างในวันนี้ก่อนเชื่อมกับ Flutter
- **TablePlus** (`https://tableplus.com/`) หรือ **DBeaver Community** (`https://dbeaver.io/download/` - ฟรี 100%) ใช้เปิดดูตารางและข้อมูลใน MariaDB/PostgreSQL

ทดสอบเชื่อมต่อฐานข้อมูลจาก TablePlus/DBeaver ด้วยค่าจาก docker-compose.yml:

| ค่า        | MariaDB       | PostgreSQL    |
| ---------- | ------------- | ------------- |
| Host       | 127.0.0.1     | 127.0.0.1     |
| Port       | 3306          | 5432          |
| User       | edlgen_user   | edlgen_user   |
| Password   | edlgen_pass   | edlgen_pass   |
| Database   | edlgen        | edlgen        |

### 0.8 ข้อควรระวังเรื่อง Firewall และ Port

หลักสูตรนี้ใช้ Port ต่อไปนี้ ให้ตรวจว่าไม่ถูก Firewall หรือ Antivirus ขวาง:

| Port | ใช้โดย                              | หมายเหตุ                                            |
| ---- | ----------------------------------- | --------------------------------------------------- |
| 8000 | Laravel (`php artisan serve`)       | Flutter บน Emulator เรียกผ่าน `10.0.2.2:8000`       |
| 6001 | Laravel WebSocket (ใช้วันที่ 4-5)   | Real-time Dashboard                                 |
| 3306 | MariaDB Container                   | ชนกับ MySQL เดิมในเครื่องได้ ดูหัวข้อ 0.3           |
| 5432 | PostgreSQL Container                | ชนกับ PostgreSQL เดิมในเครื่องได้                   |

> ⚠️ **ข้อควรระวังสำคัญ (เจอบ่อยที่สุดในห้องอบรม):**
> 1. Windows Defender Firewall มักถามสิทธิ์ตอนรัน `php artisan serve` ครั้งแรก ให้กด **Allow access** ทั้ง Private และ Public network
> 2. ทดสอบ API จาก **Android Emulator** ห้ามใช้ `localhost` หรือ `127.0.0.1` เพราะจะชี้ไปที่ตัว Emulator เอง ให้ใช้ **`10.0.2.2`** (Alias พิเศษที่ชี้กลับมาเครื่อง Host)
> 3. ทดสอบจาก **เครื่องจริง** ต้องรัน `php artisan serve --host=0.0.0.0` และใช้ IP วง LAN ของเครื่อง Host (ดูด้วย `ipconfig` / `ifconfig`) โดยมือถือกับคอมพิวเตอร์ต้องอยู่ Wi-Fi วงเดียวกัน

### 0.9 ✅ Checklist ความพร้อมก่อนเริ่มเรียน

ให้ผู้เรียนไล่รันคำสั่งทั้งหมดนี้แล้วติ๊กถูกทีละข้อ วิทยากรและทีมผู้ช่วยจะเดินตรวจทุกเครื่อง:

```bash
php -v            # [ ] PHP 8.3.x
composer -V       # [ ] Composer 2.x
docker --version  # [ ] Docker 27.x+
docker compose ps # [ ] edlgen_mariadb และ edlgen_postgres สถานะ Up
flutter --version # [ ] Flutter 3.x (stable) / Dart 3.x
flutter doctor    # [ ] ไม่มีข้อ [✗] ที่เกี่ยวกับ Android
flutter devices   # [ ] เห็น Emulator หรือเครื่องจริงอย่างน้อย 1 เครื่อง
git --version     # [ ] Git 2.x
```

- [ ] เปิด Postman/Bruno ได้
- [ ] TablePlus/DBeaver เชื่อมต่อ MariaDB (127.0.0.1:3306) และ PostgreSQL (127.0.0.1:5432) สำเร็จ
- [ ] VS Code ติดตั้ง Extension Flutter + PHP Intelephense แล้ว

> ✅ **ผลลัพธ์ที่คาดหวังของ Module 0:** ทุกเครื่องในห้องผ่าน Checklist ครบทุกข้อ = พร้อมเริ่ม Module 1 ทันที

---

## 📚 Module 1: Laravel 13 Project Setup + API Architecture

### เวลา 10:50-11:30 น.

> 💡 **หัวใจของ Module นี้:** Laravel เขียนแบบ "ทุกอย่างยัดใน Controller" ก็ทำงานได้ แต่จะดูแลไม่ไหวเมื่อระบบโต เราจึงวางสถาปัตยกรรมแบบ Repository Pattern ตั้งแต่บรรทัดแรก แยก Controller (รับ Request) / Service (Business Logic) / Repository (คุยกับฐานข้อมูล) ให้ Clean และ Testable

---

### 1.1 สร้างโปรเจกต์ edlgen_api

```bash
# สร้างโปรเจกต์ Laravel 13 (Composer จะเลือกเวอร์ชันล่าสุดที่รองรับ PHP 8.3)
composer create-project laravel/laravel edlgen_api

cd edlgen_api

# Laravel รุ่นใหม่แยกส่วน API ออกมา ต้องติดตั้งเพิ่มด้วยคำสั่งเดียว
# คำสั่งนี้จะสร้าง routes/api.php และติดตั้ง Laravel Sanctum ให้อัตโนมัติ
php artisan install:api

# รันเซิร์ฟเวอร์ทดสอบ
php artisan serve
# INFO  Server running on [http://127.0.0.1:8000]
```

เปิดเบราว์เซอร์ไปที่ `http://127.0.0.1:8000` ต้องเห็นหน้า Welcome ของ Laravel

> ✅ **จุดสำคัญ:** คำสั่ง `php artisan install:api` คือจุดเปลี่ยนของ Laravel ยุคใหม่ (ตั้งแต่ Laravel 11 เป็นต้นมา) โปรเจกต์เริ่มต้นจะไม่มี `routes/api.php` มาให้ ต้องสั่งติดตั้งเอง และคำสั่งนี้แถม Sanctum ให้เลย ซึ่งเราจะใช้ใน Module 2

### 1.2 ตั้งค่า .env เชื่อมต่อ MariaDB

แก้ไฟล์ `.env` ให้ชี้ไปที่ MariaDB Container จาก Module 0:

```env
APP_NAME="EDL-Gen API"
APP_ENV=local
APP_URL=http://localhost:8000

# --- Database: MariaDB (Container edlgen_mariadb) ---
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edlgen
DB_USERNAME=edlgen_user
DB_PASSWORD=edlgen_pass
```

ทดสอบว่าเชื่อมต่อได้จริงด้วยการรัน Migration เริ่มต้นของ Laravel:

```bash
php artisan migrate
# ต้องเห็นตาราง users, cache, jobs, personal_access_tokens ถูกสร้าง
```

> ⚠️ **ข้อควรระวัง:** ถ้าเจอ `SQLSTATE[HY000] [2002] Connection refused` ให้ตรวจ 3 อย่างตามลำดับ: (1) `docker compose ps` Container ยัง Up อยู่หรือไม่ (2) `DB_PORT` ตรงกับ ports ใน docker-compose.yml หรือไม่ (3) เปลี่ยน `DB_HOST` เป็น `127.0.0.1` แทน `localhost` (เลี่ยงปัญหา socket บนบางเครื่อง)

### 1.3 สถาปัตยกรรม API แบบแยกชั้น (Controller / Service / Repository)

```
Request จาก Flutter App
        │
        ▼
┌─────────────────────────────────────────────────────────┐
│ routes/api.php  (/api/v1/...)                           │
│        │                                                │
│        ▼                                                │
│ Controller   → รับ Request, Validate, คืน Response      │
│        │        (บาง ๆ ไม่มี Business Logic)             │
│        ▼                                                │
│ Service      → Business Logic เช่น คำนวณกำลังผลิตรวม,   │
│        │        กติกาการแจ้งเหตุขัดข้อง                    │
│        ▼                                                │
│ Repository   → คุยกับฐานข้อมูลผ่าน Interface             │
│   (Interface)   สลับ MariaDB ⇄ PostgreSQL ได้            │
│        │                                                │
│        ▼                                                │
│ MariaDB 11.x / PostgreSQL 16                            │
└─────────────────────────────────────────────────────────┘
```

| ชั้น        | หน้าที่                                        | ตัวอย่างใน edlgen_api                       |
| ----------- | ---------------------------------------------- | -------------------------------------------- |
| Controller  | รับ HTTP Request, Validate, ส่งต่อให้ Service  | `PowerPlantController`                       |
| Service     | Business Logic ล้วน ๆ ไม่รู้จัก HTTP/ฐานข้อมูล  | `PowerPlantService`                          |
| Repository  | Query ฐานข้อมูล ซ่อนรายละเอียด Eloquent        | `PowerPlantRepositoryInterface` + Eloquent   |

วางโครงสร้างโฟลเดอร์เพิ่มใน `app/`:

```
app/
├── Http/
│   └── Controllers/
│       └── Api/
│           └── V1/                    ← Controller ของ API เวอร์ชัน 1
│               ├── AuthController.php
│               └── PowerPlantController.php
├── Services/                          ← Business Logic
│   └── PowerPlantService.php
├── Repositories/
│   ├── Contracts/                     ← Interface (สัญญา)
│   │   └── PowerPlantRepositoryInterface.php
│   └── Eloquent/                      ← Implementation จริง
│       └── EloquentPowerPlantRepository.php
└── Models/
    ├── PowerPlant.php
    ├── EnergyReading.php
    └── Incident.php
```

### 1.4 API Versioning ด้วย /api/v1/

การใส่เลขเวอร์ชันใน URL ทำให้เราออก v2 ในอนาคตได้โดยที่ Mobile App รุ่นเก่ายังใช้ v1 ต่อได้ ไม่พังกลางอากาศ กำหนด Prefix ที่ `routes/api.php`:

```php
<?php
// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PowerPlantController;

// ทุกเส้นทางในกลุ่มนี้จะขึ้นต้นด้วย /api/v1/ อัตโนมัติ
Route::prefix('v1')->group(function () {

    // Route สาธารณะ (ไม่ต้องล็อกอิน)
    Route::post('/login', [AuthController::class, 'login']);

    // Route ที่ต้องมี Token (เพิ่มใน Module 2)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::apiResource('power-plants', PowerPlantController::class);
    });
});
```

ตรวจสอบเส้นทางทั้งหมดที่ระบบรู้จัก:

```bash
php artisan route:list --path=api
# GET|HEAD  api/v1/power-plants ............ power-plants.index
# POST      api/v1/login ................... AuthController@login
# ...
```

> 📌 `Route::apiResource()` สร้างให้ครบ 5 เส้นทางมาตรฐาน: `index` (GET รายการ), `store` (POST สร้าง), `show` (GET รายตัว), `update` (PUT/PATCH), `destroy` (DELETE) โดยไม่มีหน้า create/edit แบบเว็บ

### 🧪 Lab 1.1 - ทดสอบ Endpoint แรกของ edlgen_api

> **เป้าหมาย:** พิสูจน์ว่าโปรเจกต์ + Route Versioning ทำงาน โดยยังไม่ต้องมีฐานข้อมูล

**ขั้นที่ 1** เพิ่ม Route ทดสอบใน `routes/api.php` (ในกลุ่ม `prefix('v1')` นอก Middleware):

```php
Route::get('/ping', function () {
    return response()->json([
        'service' => 'EDL-Gen Monitoring API',
        'version' => 'v1',
        'time'    => now()->toIso8601String(),
    ]);
});
```

**ขั้นที่ 2** รัน `php artisan serve` แล้วเปิด Postman/Bruno ยิง `GET http://127.0.0.1:8000/api/v1/ping`

> ✅ **ผลลัพธ์ที่คาดหวัง:** ได้ JSON `{"service":"EDL-Gen Monitoring API","version":"v1","time":"2026-07-13T..."}` พร้อม Status 200 = โครง API Versioning พร้อมใช้งาน

---

## 📚 Module 2: Authentication ด้วย Laravel Sanctum (Token-based สำหรับ Mobile)

### เวลา 11:30-12:00 น. (ตอนที่ 1) และ 13:00-13:30 น. (ตอนที่ 2)

> 💡 **หัวใจของ Module นี้:** Mobile App ไม่มี Session/Cookie แบบเว็บ เราจึงใช้ **API Token**: ผู้ใช้ Login ครั้งเดียว รับ Token กลับไปเก็บ แล้วแนบ Token ใน Header `Authorization: Bearer <token>` ทุกครั้งที่เรียก API ที่ต้องยืนยันตัวตน Laravel Sanctum คือเครื่องมือมาตรฐานของงานนี้

---

### 2.1 ทำไมเลือก Sanctum และเทียบกับ JWT

| ประเด็น                    | Sanctum (ที่เราใช้)                          | JWT (แพ็กเกจภายนอก เช่น tymon/jwt-auth)     |
| -------------------------- | -------------------------------------------- | -------------------------------------------- |
| การเก็บ Token              | เก็บในตาราง `personal_access_tokens`         | Stateless ไม่เก็บฝั่ง Server                 |
| เพิกถอน Token (Revoke)     | ลบแถวเดียวจบ มีผลทันที                       | ทำยาก ต้องมี Blacklist เพิ่มเอง              |
| ติดตั้ง                    | มากับ `php artisan install:api` แล้ว         | ติดตั้งแพ็กเกจ + ตั้งค่า Secret เพิ่ม        |
| ข้อมูลใน Token             | สุ่ม (Opaque) ปลอดภัย อ่านอะไรไม่ได้         | Payload ถอดอ่านได้ (Base64) ต้องระวังข้อมูล  |
| เหมาะกับ                   | Mobile App คุยกับ Backend ตัวเอง             | Microservices / ข้ามระบบที่ต้อง Verify เอง   |

> ✅ **สรุปการตัดสินใจ:** EDL-Gen Monitoring App คุยกับ Backend ของตัวเองโดยตรง และองค์กรต้องการสั่ง Logout ทุกอุปกรณ์ได้ทันทีเมื่อพนักงานลาออกหรืออุปกรณ์หาย เราจึงใช้ **Sanctum Personal Access Token** เป็นหลัก (แนวคิด Bearer Token เหมือน JWT ทุกประการ ฝั่ง Flutter เขียนโค้ดแบบเดียวกัน)

```
Login/Logout Flow ของ EDL-Gen Monitoring:

Flutter App                              Laravel API (Sanctum)
    │  POST /api/v1/login                       │
    │  {email, password, device_name}           │
    │ ─────────────────────────────────────────►│ ตรวจรหัสผ่าน (Hash::check)
    │                                           │ createToken() บันทึกลง DB
    │  ◄───────────────────────────────────── │ คืน {token, user}
    │  เก็บ token (วันที่ 4: flutter_secure_storage)
    │                                           │
    │  GET /api/v1/power-plants                 │
    │  Header: Authorization: Bearer 1|abc...   │
    │ ─────────────────────────────────────────►│ middleware auth:sanctum
    │  ◄───────────────────────────────────── │ ผ่าน → คืนข้อมูล JSON
    │                                           │
    │  POST /api/v1/logout                      │
    │ ─────────────────────────────────────────►│ ลบ token ออกจาก DB
    │  ◄───────────────────────────────────── │ token ใช้ต่อไม่ได้อีก
```

### 2.2 เตรียม Model User + ตรวจว่า Sanctum พร้อม

`php artisan install:api` ติดตั้ง Sanctum และ Migration ตาราง `personal_access_tokens` ให้แล้ว เหลือเพียงเพิ่ม Trait ใน Model:

```php
<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;   // ⬅ เพิ่มบรรทัดนี้

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;  // ⬅ เพิ่ม HasApiTokens

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',   // Laravel hash รหัสผ่านให้อัตโนมัติ
        ];
    }
}
```

### 2.3 AuthController - Login / Logout / Me

```bash
php artisan make:controller Api/V1/AuthController
```

```php
<?php
// app/Http/Controllers/Api/V1/AuthController.php
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
```

> 📌 **Token หลายอุปกรณ์:** ผู้ใช้คนเดียว Login จากมือถือ 2 เครื่องจะได้ 2 Token แยกกัน ถ้าต้องการ "Logout ทุกอุปกรณ์" ใช้ `$request->user()->tokens()->delete();` (มีประโยชน์มากตอนพนักงานทำเครื่องหาย)

### 2.4 Middleware Guard - ป้องกัน Route ที่ต้องล็อกอิน

Route ที่ครอบด้วย `Route::middleware('auth:sanctum')` (ตั้งไว้แล้วใน Module 1.4) จะตรวจ Header `Authorization: Bearer <token>` อัตโนมัติ:

- Token ถูกต้อง → เข้าถึง `$request->user()` ได้ทันที
- ไม่มี Token / Token ถูกลบไปแล้ว → Laravel คืน `401 Unauthorized` พร้อม `{"message": "Unauthenticated."}` โดยเราไม่ต้องเขียนอะไรเพิ่ม

> ⚠️ **ข้อควรระวัง:** ตอนยิงทดสอบด้วย Postman ต้องใส่ Header `Accept: application/json` เสมอ ถ้าลืม เมื่อ Auth ไม่ผ่าน Laravel อาจพยายาม Redirect ไปหน้า login แบบเว็บแล้วตอบ 500/HTML แทน 401 JSON ทำให้งงว่าผิดตรงไหน

### 2.5 สร้างผู้ใช้ทดสอบด้วย Seeder

```php
<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // วิศวกรทดสอบของ EDL-Gen (ข้อมูลจำลอง)
        User::factory()->create([
            'name'     => 'Somphone Engineer',
            'email'    => 'engineer@edlgen.la',
            'password' => Hash::make('password123'),
        ]);
    }
}
```

```bash
php artisan db:seed
```

### 🧪 Lab 2.1 - ทดสอบ Auth Flow ครบวงจรด้วย Postman/Bruno

> **เป้าหมาย:** เห็น Lifecycle ของ Token ครบ: ได้ Token → ใช้ Token → ลบ Token → ใช้ซ้ำไม่ได้

**ขั้นที่ 1 - Login** ยิง `POST http://127.0.0.1:8000/api/v1/login` (Body แบบ JSON, Header `Accept: application/json`):

```json
{
  "email": "engineer@edlgen.la",
  "password": "password123",
  "device_name": "postman-test"
}
```

ได้ Response 200 พร้อม `token` เช่น `1|Xy9AbC...` ให้คัดลอกเก็บไว้

**ขั้นที่ 2 - เรียก Route ที่ป้องกันไว้** ยิง `GET http://127.0.0.1:8000/api/v1/me` โดยตั้ง Authorization Type เป็น **Bearer Token** แล้ววาง Token ลงไป → ได้ข้อมูล user กลับมา (200)

**ขั้นที่ 3 - ลองไม่ใส่ Token** ยิง `/api/v1/me` แบบไม่มี Header → ได้ `401 {"message":"Unauthenticated."}`

**ขั้นที่ 4 - Logout** ยิง `POST /api/v1/logout` พร้อม Token → 200 จากนั้นยิง `/api/v1/me` ด้วย Token เดิมอีกครั้ง → ได้ 401 เพราะ Token ถูกลบจากตาราง `personal_access_tokens` แล้ว (เปิดดูใน TablePlus/DBeaver ประกอบได้)

> ✅ **ผลลัพธ์ที่คาดหวัง:** ผ่านครบ 4 ขั้น = ระบบ Auth สำหรับ Mobile พร้อมใช้งานจริง และผู้เรียนเข้าใจว่า Token "เกิดที่ไหน เก็บที่ไหน ตายเมื่อไร"

---

## 📚 Module 3: API Resources & Collections

### เวลา 13:30-14:00 น.

> 💡 **หัวใจของ Module นี้:** ห้าม `return $model;` ตรง ๆ จาก Controller เพราะจะเผยทุกคอลัมน์ในตาราง (รวมของที่ไม่ควรเผย) และผูกโครงสร้าง JSON ติดกับโครงสร้างฐานข้อมูล API Resource คือ "ชั้นแปลงร่าง" ที่ควบคุมว่า JSON หน้าตาเป็นอย่างไร ส่งอะไร ไม่ส่งอะไร

---

### 3.1 เตรียมตารางข้อมูลของ EDL-Gen (Model + Migration)

ก่อนทำ Resource เราต้องมีข้อมูลก่อน สร้าง Model พร้อม Migration ของ 3 ตารางหลักที่ใช้ตลอดหลักสูตร:

```bash
php artisan make:model PowerPlant -m      # โรงไฟฟ้า
php artisan make:model EnergyReading -m   # ค่าการผลิตรายช่วงเวลา
php artisan make:model Incident -m        # เหตุขัดข้อง
```

```php
<?php
// database/migrations/xxxx_create_power_plants_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('power_plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // เช่น "Nam Ngum 1"
            $table->string('code', 20)->unique();        // เช่น "NN1"
            $table->enum('type', ['hydro', 'solar', 'thermal'])->default('hydro');
            $table->decimal('capacity_mw', 8, 2);        // กำลังผลิตติดตั้ง (MW)
            $table->string('province');                  // แขวงที่ตั้ง เช่น "Vientiane"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('power_plants');
    }
};
```

```php
<?php
// database/migrations/xxxx_create_energy_readings_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energy_readings', function (Blueprint $table) {
            $table->id();
            // FK → power_plants ลบโรงไฟฟ้าแล้วค่าการอ่านหายตาม (เฉพาะข้อมูลจำลอง)
            $table->foreignId('power_plant_id')->constrained()->cascadeOnDelete();
            $table->decimal('output_mw', 8, 2);          // กำลังผลิตขณะนั้น (MW)
            $table->decimal('frequency_hz', 5, 2);       // ความถี่ระบบ เช่น 50.02
            $table->decimal('voltage_kv', 6, 2);         // แรงดัน (kV)
            $table->timestamp('recorded_at')->index();   // เวลาที่อ่านค่า (index เพื่อ query ช่วงเวลา)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energy_readings');
    }
};
```

```php
<?php
// database/migrations/xxxx_create_incidents_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('power_plant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('users');
            $table->string('title');                                  // หัวข้อเหตุขัดข้อง
            $table->text('description')->nullable();
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->enum('status', ['open', 'investigating', 'resolved'])->default('open');
            $table->timestamp('occurred_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
```

กำหนดความสัมพันธ์ใน Model:

```php
<?php
// app/Models/PowerPlant.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PowerPlant extends Model
{
    protected $fillable = [
        'name', 'code', 'type', 'capacity_mw', 'province', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'capacity_mw' => 'decimal:2',
            'is_active'   => 'boolean',
        ];
    }

    // โรงไฟฟ้า 1 แห่ง มีค่าการอ่านหลายรายการ
    public function readings(): HasMany
    {
        return $this->hasMany(EnergyReading::class);
    }

    // โรงไฟฟ้า 1 แห่ง มีเหตุขัดข้องหลายรายการ
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }
}
```

```bash
php artisan migrate
# สร้างตาราง power_plants, energy_readings, incidents ใน MariaDB
```

### 3.2 Resource Class - ควบคุมหน้าตา JSON

```bash
php artisan make:resource V1/PowerPlantResource
php artisan make:resource V1/EnergyReadingResource
```

```php
<?php
// app/Http/Resources/V1/PowerPlantResource.php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PowerPlantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'code'        => $this->code,
            'type'        => $this->type,
            'capacity_mw' => (float) $this->capacity_mw,   // บังคับเป็น number ไม่ใช่ string
            'province'    => $this->province,
            'is_active'   => $this->is_active,

            // Conditional Field: ส่ง readings เฉพาะเมื่อ Controller สั่ง eager load มา
            // ป้องกัน N+1 Query และ Over-fetching ไปพร้อมกัน
            'latest_readings' => EnergyReadingResource::collection(
                $this->whenLoaded('readings')
            ),

            // Conditional Field: จำนวนเหตุขัดข้องที่ยังไม่ปิด ส่งเฉพาะเมื่อ withCount มา
            'open_incidents_count' => $this->whenCounted('incidents'),

            // ส่ง updated_at ให้เฉพาะผู้ใช้ที่ล็อกอิน (ตัวอย่าง when แบบเงื่อนไข)
            'updated_at' => $this->when(
                $request->user() !== null,
                fn () => $this->updated_at?->toIso8601String()
            ),
        ];
    }
}
```

```php
<?php
// app/Http/Resources/V1/EnergyReadingResource.php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnergyReadingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'output_mw'    => (float) $this->output_mw,
            'frequency_hz' => (float) $this->frequency_hz,
            'voltage_kv'   => (float) $this->voltage_kv,
            'recorded_at'  => $this->recorded_at->toIso8601String(),
        ];
    }
}
```

| เทคนิคใน Resource   | ใช้ทำอะไร                                                        |
| ------------------- | ----------------------------------------------------------------- |
| `whenLoaded('x')`   | ใส่ความสัมพันธ์เฉพาะเมื่อถูก Eager Load (`with('x')`) มาแล้ว     |
| `whenCounted('x')`  | ใส่ค่านับเฉพาะเมื่อใช้ `withCount('x')`                          |
| `when(เงื่อนไข)`     | ใส่ Field ตามเงื่อนไข เช่น สิทธิ์ผู้ใช้                            |
| `(float)` casting   | ค่า decimal จากฐานข้อมูลมาเป็น string ต้อง cast ก่อนส่งให้ Mobile |

> ⚠️ **ข้อควรระวัง (เจอบ่อยตอนเชื่อม Flutter):** MariaDB คืนค่า `DECIMAL` เป็น string เช่น `"12.50"` ถ้าไม่ cast เป็น `(float)` ฝั่ง Dart ที่ประกาศ `double output_mw` จะ throw `type 'String' is not a subtype of type 'double'` ทันที จุดนี้คือเหตุผลว่าทำไม Resource สำคัญกับ Mobile มาก

### 3.3 Collection + โครงสร้าง Response มาตรฐานของหลักสูตร

เมื่อคืนหลายรายการ ใช้ `Resource::collection()` และ Laravel จะห่อทั้งหมดใน key `data` ให้อัตโนมัติ เรากำหนดมาตรฐานทีมว่า **ทุก Response ต้องมี key `data` เสมอ** ฝั่ง Flutter จะ parse ง่ายและสม่ำเสมอ:

```json
{
  "data": [
    {
      "id": 1,
      "name": "Nam Ngum 1",
      "code": "NN1",
      "type": "hydro",
      "capacity_mw": 155.0,
      "province": "Vientiane",
      "is_active": true,
      "open_incidents_count": 2
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 42 }
}
```

> 📌 `links` และ `meta` จะโผล่มาอัตโนมัติเมื่อส่ง Paginator เข้า Collection (`PowerPlantResource::collection(PowerPlant::paginate(15))`) ซึ่งฝั่ง Flutter ใช้ทำ Infinite Scroll ได้ทันทีในวันที่ 3

---

## 📚 Module 4: MariaDB/PostgreSQL Repository Pattern

### เวลา 14:00-14:30 น.

> 💡 **หัวใจของ Module นี้:** Business Logic ไม่ควรรู้ว่าข้อมูลมาจาก MariaDB, PostgreSQL หรือแม้แต่ Mock ในเทสต์ Repository Pattern คือการคุยผ่าน "สัญญา" (Interface) แล้วให้ Laravel Service Container ฉีด Implementation จริงให้ ผลคือสลับฐานข้อมูลได้โดยแก้โค้ดศูนย์บรรทัดใน Service/Controller

---

### 4.1 Repository Interface (สัญญา)

```php
<?php
// app/Repositories/Contracts/PowerPlantRepositoryInterface.php
namespace App\Repositories\Contracts;

use App\Models\PowerPlant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PowerPlantRepositoryInterface
{
    /** ดึงรายการโรงไฟฟ้าแบบแบ่งหน้า พร้อมจำนวนเหตุขัดข้อง */
    public function paginateWithIncidentCount(int $perPage = 15): LengthAwarePaginator;

    /** หาโรงไฟฟ้าตาม id พร้อมค่าการอ่านล่าสุด */
    public function findWithLatestReadings(int $id, int $readingLimit = 10): ?PowerPlant;

    /** สร้างโรงไฟฟ้าใหม่ */
    public function create(array $attributes): PowerPlant;

    /** บันทึกค่าการอ่านพร้อมอัปเดตสถานะโรงไฟฟ้าใน Transaction เดียว */
    public function storeReadingWithStatus(int $plantId, array $reading): PowerPlant;
}
```

### 4.2 Concrete Implementation ด้วย Eloquent

```php
<?php
// app/Repositories/Eloquent/EloquentPowerPlantRepository.php
namespace App\Repositories\Eloquent;

use App\Models\PowerPlant;
use App\Repositories\Contracts\PowerPlantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentPowerPlantRepository implements PowerPlantRepositoryInterface
{
    public function paginateWithIncidentCount(int $perPage = 15): LengthAwarePaginator
    {
        return PowerPlant::query()
            ->withCount(['incidents' => fn ($q) => $q->where('status', '!=', 'resolved')])
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function findWithLatestReadings(int $id, int $readingLimit = 10): ?PowerPlant
    {
        return PowerPlant::query()
            ->with(['readings' => fn ($q) => $q->latest('recorded_at')->limit($readingLimit)])
            ->find($id);
    }

    public function create(array $attributes): PowerPlant
    {
        return PowerPlant::create($attributes);
    }

    public function storeReadingWithStatus(int $plantId, array $reading): PowerPlant
    {
        // Database Transaction: สองคำสั่งนี้ต้องสำเร็จ "ทั้งคู่" หรือ "ไม่เกิดเลย"
        // ถ้าเขียน reading สำเร็จแต่อัปเดตสถานะพัง Laravel จะ rollback ให้อัตโนมัติ
        return DB::transaction(function () use ($plantId, $reading) {
            $plant = PowerPlant::lockForUpdate()->findOrFail($plantId);

            $plant->readings()->create($reading);

            // Business Rule จำลอง: ถ้ากำลังผลิตเป็น 0 ถือว่าโรงไฟฟ้าหยุดเดินเครื่อง
            $plant->update(['is_active' => $reading['output_mw'] > 0]);

            return $plant->refresh();
        });
    }
}
```

> ✅ **จุดสำคัญ:** โค้ดข้างบนใช้ Eloquent ล้วน ๆ ไม่มี SQL เฉพาะยี่ห้อ จึงทำงานได้ทั้ง MariaDB และ PostgreSQL โดยไม่แก้อะไรเลย นี่คือพลังของการทำงานผ่าน ORM + Repository ร่วมกัน ถ้าวันหนึ่งต้องเขียน Raw SQL เฉพาะยี่ห้อ (เช่น Full-text Search) ก็สร้าง `PostgresPowerPlantRepository` แยกอีกคลาสโดย Interface เดิม

### 4.3 Binding Interface เข้ากับ Implementation

```php
<?php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use App\Repositories\Contracts\PowerPlantRepositoryInterface;
use App\Repositories\Eloquent\EloquentPowerPlantRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // เมื่อคลาสไหนขอ Interface นี้ ให้ฉีด Eloquent Implementation ให้
        $this->app->bind(
            PowerPlantRepositoryInterface::class,
            EloquentPowerPlantRepository::class,
        );
    }
}
```

### 4.4 Service + Controller ที่บาง

```php
<?php
// app/Services/PowerPlantService.php
namespace App\Services;

use App\Repositories\Contracts\PowerPlantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PowerPlantService
{
    // Constructor Property Promotion (PHP 8) + Dependency Injection
    public function __construct(
        private readonly PowerPlantRepositoryInterface $repository,
    ) {}

    public function listForDashboard(int $perPage): LengthAwarePaginator
    {
        // จุดวาง Business Logic เพิ่มเติมในอนาคต เช่น กรองตามสิทธิ์แขวงของผู้ใช้
        return $this->repository->paginateWithIncidentCount($perPage);
    }
}
```

```php
<?php
// app/Http/Controllers/Api/V1/PowerPlantController.php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PowerPlantResource;
use App\Services\PowerPlantService;
use Illuminate\Http\Request;

class PowerPlantController extends Controller
{
    public function __construct(
        private readonly PowerPlantService $service,
    ) {}

    /** GET /api/v1/power-plants */
    public function index(Request $request)
    {
        $plants = $this->service->listForDashboard(
            perPage: (int) $request->query('per_page', 15),
        );

        return PowerPlantResource::collection($plants);
    }
}
```

### 4.5 Seeder ข้อมูลจำลองโรงไฟฟ้า

```php
<?php
// database/seeders/PowerPlantSeeder.php
namespace Database\Seeders;

use App\Models\PowerPlant;
use Illuminate\Database\Seeder;

class PowerPlantSeeder extends Seeder
{
    public function run(): void
    {
        // ข้อมูลจำลองอิงชื่อโรงไฟฟ้าจริงเพื่อความคุ้นเคย แต่ตัวเลขสมมติทั้งหมด
        $plants = [
            ['name' => 'Nam Ngum 1',   'code' => 'NN1', 'type' => 'hydro',   'capacity_mw' => 155.00, 'province' => 'Vientiane'],
            ['name' => 'Nam Ngum 2',   'code' => 'NN2', 'type' => 'hydro',   'capacity_mw' => 615.00, 'province' => 'Vientiane'],
            ['name' => 'Theun-Hinboun','code' => 'THB', 'type' => 'hydro',   'capacity_mw' => 500.00, 'province' => 'Bolikhamxay'],
            ['name' => 'Houay Ho',     'code' => 'HH',  'type' => 'hydro',   'capacity_mw' => 152.00, 'province' => 'Champasak'],
            ['name' => 'Solar Farm 1', 'code' => 'SF1', 'type' => 'solar',   'capacity_mw' => 30.00,  'province' => 'Savannakhet'],
        ];

        foreach ($plants as $plant) {
            $created = PowerPlant::create($plant);

            // สร้างค่าการอ่านย้อนหลัง 24 ชั่วโมง ทุก 1 ชั่วโมง
            foreach (range(1, 24) as $hour) {
                $created->readings()->create([
                    'output_mw'    => round($created->capacity_mw * (mt_rand(55, 92) / 100), 2),
                    'frequency_hz' => round(mt_rand(4985, 5015) / 100, 2),  // 49.85 - 50.15 Hz
                    'voltage_kv'   => round(mt_rand(2180, 2320) / 10, 2),   // 218.0 - 232.0 kV
                    'recorded_at'  => now()->subHours($hour),
                ]);
            }
        }
    }
}
```

```bash
# ลงทะเบียน PowerPlantSeeder ใน DatabaseSeeder::run() ด้วย $this->call(PowerPlantSeeder::class);
php artisan migrate:fresh --seed
```

### 4.6 สลับ Driver: MariaDB ⇄ PostgreSQL ใน 1 นาที

เพิ่มค่าเชื่อมต่อ PostgreSQL เตรียมไว้ใน `.env` แล้วสลับด้วยการแก้บรรทัดเดียว:

```env
# --- สลับมาใช้ PostgreSQL: แก้แค่ DB_CONNECTION + PORT + comment/uncomment ---
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=edlgen
DB_USERNAME=edlgen_user
DB_PASSWORD=edlgen_pass
```

```bash
php artisan config:clear        # ล้าง config cache ก่อนเสมอหลังแก้ .env
php artisan migrate:fresh --seed # สร้างตาราง + ข้อมูลชุดเดิมบน PostgreSQL
```

ยิง `GET /api/v1/power-plants` อีกครั้ง → ได้ผลเหมือนเดิมทุกประการ ทั้งที่ฐานข้อมูลเปลี่ยนยี่ห้อแล้ว

> ✅ **จุดสำคัญ:** Controller, Service, Repository, Resource **ไม่ถูกแก้แม้แต่บรรทัดเดียว** ตอนสลับ Driver นี่คือหลักฐานเชิงประจักษ์ของ Repository Pattern + ORM ที่ออกแบบดี (ในห้องอบรมเราจะสลับกลับมาใช้ MariaDB เป็นหลักต่อ)

### 🧪 Lab 4.1 - ตรวจข้อมูลจำลองผ่าน API และ GUI

**ขั้นที่ 1** ยิง `GET http://127.0.0.1:8000/api/v1/power-plants` พร้อม Bearer Token จาก Lab 2.1
**ขั้นที่ 2** เปิด TablePlus/DBeaver ดูตาราง `energy_readings` ต้องมีประมาณ 120 แถว (5 โรงไฟฟ้า x 24 ชั่วโมง)
**ขั้นที่ 3** ทดลองสลับ Driver เป็น `pgsql` ตามหัวข้อ 4.6 แล้วยิงซ้ำ

> ✅ **ผลลัพธ์ที่คาดหวัง:** ได้ JSON โรงไฟฟ้า 5 แห่งพร้อม `open_incidents_count` และโครง `data/links/meta` ครบ ทั้งบน MariaDB และ PostgreSQL

---

## 📚 Module 5: Riverpod 3.0 AsyncValue - State Machine ของงาน Async

### เวลา 14:30-15:00 น.

> 💡 **หัวใจของ Module นี้:** ทุกการเรียก API มี 3 ชะตากรรมเสมอ: กำลังโหลด / สำเร็จ / ล้มเหลว `AsyncValue<T>` ของ Riverpod บังคับให้เราจัดการครบทั้ง 3 กรณีตั้งแต่ตอน compile จะลืมเขียนหน้า Error แบบที่ชอบเกิดกับ `setState` ไม่ได้อีกต่อไป

---

### 5.1 สร้างโปรเจกต์ edlgen_monitoring + ติดตั้ง Riverpod 3.0

```bash
# สร้างโปรเจกต์ Flutter (กำหนด org ตั้งแต่ต้น แก้ทีหลังยุ่งยาก)
flutter create --org la.edlgen edlgen_monitoring
cd edlgen_monitoring

# Riverpod 3.0 + Code Generation + HTTP Client
flutter pub add flutter_riverpod:^3.0.0 riverpod_annotation:^3.0.0 dio:^5.7.0

# Dev dependencies: ตัวสร้างโค้ดและตัวตรวจ
flutter pub add dev:build_runner dev:riverpod_generator:^3.0.0 dev:custom_lint dev:riverpod_lint:^3.0.0
```

สรุป `pubspec.yaml` ส่วนสำคัญที่ต้องได้:

```yaml
# pubspec.yaml (เฉพาะส่วน dependencies ของวันนี้)
name: edlgen_monitoring
description: "EDL-Gen Monitoring App - Day 1. Mock data only."
publish_to: "none"
version: 1.0.0+1

environment:
  sdk: ^3.6.0

dependencies:
  flutter:
    sdk: flutter
  flutter_riverpod: ^3.0.0        # แกนหลัก Riverpod 3.0
  riverpod_annotation: ^3.0.0     # annotation @riverpod
  dio: ^5.7.0                     # HTTP Client เรียก Laravel API

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^5.0.0
  build_runner: ^2.4.13           # engine สร้างโค้ด
  riverpod_generator: ^3.0.0      # อ่าน @riverpod แล้วสร้าง .g.dart
  custom_lint: ^0.7.0
  riverpod_lint: ^3.0.0           # กฎ lint เฉพาะ Riverpod
```

ครอบแอปด้วย `ProviderScope` ที่ราก:

```dart
// lib/main.dart
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

void main() {
  runApp(
    const ProviderScope(              // เก็บ state ของทุก provider ต้องอยู่นอกสุด
      child: EdlGenApp(),
    ),
  );
}

class EdlGenApp extends StatelessWidget {
  const EdlGenApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'EDL-Gen Monitoring',
      theme: ThemeData(useMaterial3: true, colorSchemeSeed: Colors.teal),
      home: const Placeholder(),      // จะแทนที่ด้วยหน้าจริงใน Lab ท้ายวัน
    );
  }
}
```

> 📌 **Riverpod 3.0 กับ Code Generation:** ไฟล์ที่ใช้ `@riverpod` ต้องมี `part 'ชื่อไฟล์.g.dart';` และต้องรัน `dart run build_runner watch --delete-conflicting-outputs` ค้างไว้ระหว่างเรียน ใน Riverpod 3.0 ฟังก์ชัน provider รับพารามิเตอร์เป็น `Ref` ตรง ๆ (ของเดิมสาย 2.x เป็น typed ref เช่น `HelloRef` ซึ่งถูกยุบรวมแล้ว)

### 5.2 AsyncValue คือ State Machine

```
State Machine ของ AsyncValue<T>:

                 เริ่ม watch provider ครั้งแรก
                            │
                            ▼
                  ┌──────────────────┐
                  │  AsyncLoading    │ ← isLoading = true
                  └────────┬─────────┘
              สำเร็จ        │        ล้มเหลว (throw)
            ┌──────────────┴──────────────┐
            ▼                             ▼
   ┌──────────────────┐         ┌──────────────────┐
   │  AsyncData<T>    │         │  AsyncError      │
   │  (มี .value)     │         │  (มี .error)     │
   └────────┬─────────┘         └────────┬─────────┘
            │      ref.invalidate() /    │
            └────── refresh → กลับสู่ loading (เก็บค่าเดิมไว้โชว์ได้)
```

| สถานะ          | ตรวจด้วย        | ความหมาย                                        |
| -------------- | --------------- | ------------------------------------------------ |
| `AsyncLoading` | `isLoading`     | กำลังรอผล (ครั้งแรก หรือกำลัง refresh)          |
| `AsyncData`    | `hasValue`      | ได้ข้อมูลแล้ว เข้าถึงผ่าน `.value`               |
| `AsyncError`   | `hasError`      | เกิดข้อผิดพลาด เข้าถึงผ่าน `.error` และ `.stackTrace` |

### 5.3 Provider ดึงรายชื่อโรงไฟฟ้าจาก Laravel API

```dart
// lib/features/power_plant/data/api_client.dart
import 'package:dio/dio.dart';
import 'package:riverpod_annotation/riverpod_annotation.dart';

part 'api_client.g.dart';

/// Base URL ของ Laravel API
/// - Android Emulator ใช้ 10.0.2.2 (ชี้กลับเครื่อง Host)
/// - เครื่องจริงใช้ IP วง LAN เช่น http://192.168.1.50:8000
const apiBaseUrl = 'http://10.0.2.2:8000/api/v1';

@riverpod
Dio apiClient(Ref ref) {
  return Dio(
    BaseOptions(
      baseUrl: apiBaseUrl,
      connectTimeout: const Duration(seconds: 10),
      receiveTimeout: const Duration(seconds: 10),
      headers: {'Accept': 'application/json'},  // สำคัญ! ให้ Laravel ตอบ JSON เสมอ
    ),
  );
}
```

```dart
// lib/features/power_plant/domain/power_plant.dart
/// โมเดลโรงไฟฟ้า (วันที่ 2 จะยกระดับเป็น freezed)
class PowerPlant {
  const PowerPlant({
    required this.id,
    required this.name,
    required this.code,
    required this.type,
    required this.capacityMw,
    required this.province,
    required this.isActive,
  });

  final int id;
  final String name;
  final String code;
  final String type;
  final double capacityMw;
  final String province;
  final bool isActive;

  factory PowerPlant.fromJson(Map<String, dynamic> json) {
    return PowerPlant(
      id: json['id'] as int,
      name: json['name'] as String,
      code: json['code'] as String,
      type: json['type'] as String,
      capacityMw: (json['capacity_mw'] as num).toDouble(),
      province: json['province'] as String,
      isActive: json['is_active'] as bool,
    );
  }
}
```

```dart
// lib/features/power_plant/data/power_plant_providers.dart
import 'package:riverpod_annotation/riverpod_annotation.dart';
import '../domain/power_plant.dart';
import 'api_client.dart';

part 'power_plant_providers.g.dart';

/// ดึงรายชื่อโรงไฟฟ้าทั้งหมด - คืน Future แต่ UI จะเห็นเป็น AsyncValue
@riverpod
Future<List<PowerPlant>> powerPlantList(Ref ref) async {
  final dio = ref.watch(apiClientProvider);

  final response = await dio.get('/power-plants');

  // Laravel Resource Collection ห่อผลลัพธ์ใน key "data" เสมอ (Module 3)
  final items = response.data['data'] as List<dynamic>;

  return items
      .map((json) => PowerPlant.fromJson(json as Map<String, dynamic>))
      .toList();
}
```

### 5.4 Consume ด้วย when() - บังคับจัดการครบ 3 สถานะ

```dart
// lib/features/power_plant/presentation/power_plant_list_view.dart
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../data/power_plant_providers.dart';

class PowerPlantListView extends ConsumerWidget {
  const PowerPlantListView({super.key});

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final asyncPlants = ref.watch(powerPlantListProvider);

    return Scaffold(
      appBar: AppBar(title: const Text('โรงไฟฟ้า EDL-Gen')),
      body: asyncPlants.when(
        // 1) กำลังโหลด → Spinner
        loading: () => const Center(child: CircularProgressIndicator()),

        // 2) ล้มเหลว → ข้อความ + ปุ่มลองใหม่
        error: (error, stackTrace) => Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const Icon(Icons.cloud_off, size: 48, color: Colors.grey),
              const SizedBox(height: 8),
              Text('เชื่อมต่อไม่สำเร็จ: $error', textAlign: TextAlign.center),
              const SizedBox(height: 12),
              FilledButton.icon(
                // invalidate → ทิ้ง state เดิม แล้ว provider ทำงานใหม่ตั้งแต่ต้น
                onPressed: () => ref.invalidate(powerPlantListProvider),
                icon: const Icon(Icons.refresh),
                label: const Text('ลองใหม่'),
              ),
            ],
          ),
        ),

        // 3) สำเร็จ → รายการโรงไฟฟ้า
        data: (plants) => RefreshIndicator(
          onRefresh: () => ref.refresh(powerPlantListProvider.future),
          child: ListView.builder(
            itemCount: plants.length,
            itemBuilder: (context, index) {
              final plant = plants[index];
              return ListTile(
                leading: CircleAvatar(child: Text(plant.code)),
                title: Text(plant.name),
                subtitle: Text('${plant.province} · ${plant.capacityMw} MW'),
                trailing: Icon(
                  plant.isActive ? Icons.bolt : Icons.power_off,
                  color: plant.isActive ? Colors.green : Colors.red,
                ),
              );
            },
          ),
        ),
      ),
    );
  }
}
```

> ⚠️ **ข้อควรระวัง:** `ref.invalidate()` กับ `ref.refresh()` ต่างกัน - `invalidate` สั่งทิ้ง state (โหลดใหม่เมื่อมีคน watch) ส่วน `refresh` คืนค่าใหม่ทันทีเป็น Future ที่นำไปใช้ต่อได้ (เหมาะกับ `RefreshIndicator`) ห้ามเรียก `ref.refresh` แล้วทิ้งค่าโดยไม่ใช้ เพราะ lint จะเตือน

### 5.5 AsyncValue.guard() - ห่อ try/catch ให้เป็นระเบียบ

เมื่อเราแก้ state เองใน Notifier การเขียน `try/catch` ทุกจุดจะรก `AsyncValue.guard()` ช่วยห่อให้: ถ้าสำเร็จได้ `AsyncData` ถ้า throw ได้ `AsyncError` อัตโนมัติ

```dart
// แบบเขียน try/catch เอง (รกและลืมง่าย)
state = const AsyncLoading();
try {
  final result = await repository.fetchReadings();
  state = AsyncData(result);
} catch (err, stack) {
  state = AsyncError(err, stack);
}

// แบบใช้ guard (มาตรฐานของหลักสูตรนี้)
state = const AsyncLoading();
state = await AsyncValue.guard(() => repository.fetchReadings());
```

> ✅ **จุดสำคัญ:** `guard()` จับเฉพาะ Exception แล้วแปลงเป็น state ที่ UI จัดการต่อได้ ไม่ใช่การ "กลืน error เงียบ ๆ" เพราะ error ยังอยู่ครบใน `AsyncError` พร้อม stackTrace สำหรับ log

---

## 📚 Module 6: AsyncNotifier + Mutations API (Riverpod 3.0)

### เวลา 15:00-15:20 น.

> 💡 **หัวใจของ Module นี้:** `FutureProvider` เหมาะกับ "อ่านอย่างเดียว" แต่งานจริงต้องเพิ่ม/แก้ข้อมูลด้วย `AsyncNotifier` คือคลาสที่รวมข้อมูล async + เมธอดแก้ไขไว้ด้วยกัน และ **Mutations API** ของ Riverpod 3.0 ช่วยติดตามสถานะ "การกระทำ" (เช่น กดปุ่มบันทึก) แยกจากสถานะ "ข้อมูล" ด้วย Lifecycle: `idle -> pending -> success/error`

---

### 6.1 AsyncNotifier สำหรับรายการเหตุขัดข้อง (Incidents)

```dart
// lib/features/incident/data/incident_list_notifier.dart
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:riverpod_annotation/riverpod_annotation.dart';
import '../domain/incident.dart';
import '../../power_plant/data/api_client.dart';

part 'incident_list_notifier.g.dart';

@riverpod
class IncidentList extends _$IncidentList {
  /// build() คือการโหลดข้อมูลครั้งแรก - คืน Future ได้เลย
  @override
  Future<List<Incident>> build() async {
    final dio = ref.watch(apiClientProvider);
    final response = await dio.get('/incidents');
    final items = response.data['data'] as List<dynamic>;
    return items.map((j) => Incident.fromJson(j as Map<String, dynamic>)).toList();
  }

  /// เพิ่มเหตุขัดข้องใหม่ แล้วอัปเดตรายการในหน้าจอทันที
  Future<Incident> addIncident({
    required int powerPlantId,
    required String title,
    required String severity,
  }) async {
    final dio = ref.read(apiClientProvider);

    final response = await dio.post('/incidents', data: {
      'power_plant_id': powerPlantId,
      'title': title,
      'severity': severity,
      'occurred_at': DateTime.now().toIso8601String(),
    });

    final created = Incident.fromJson(
      response.data['data'] as Map<String, dynamic>,
    );

    // อัปเดต state โดยไม่ต้องยิง GET ใหม่ทั้งหน้า (แทรกรายการใหม่ไว้บนสุด)
    final current = await future;              // รอค่า data ปัจจุบัน
    state = AsyncData([created, ...current]);

    return created;
  }

  /// อัปเดตสถานะเหตุขัดข้อง เช่น open -> investigating -> resolved
  Future<void> updateStatus(int id, String status) async {
    final dio = ref.read(apiClientProvider);
    await dio.patch('/incidents/$id', data: {'status': status});

    // โหลดรายการใหม่ทั้งชุดด้วย guard - พังก็กลายเป็น AsyncError อย่างเป็นระเบียบ
    state = const AsyncLoading();
    state = await AsyncValue.guard(build);
  }
}
```

### 6.2 Mutations API - Lifecycle ของ "การกระทำ"

ปัญหาคลาสสิก: ตอนผู้ใช้กดปุ่ม "บันทึก" เราอยากโชว์ Spinner บนปุ่ม, กันกดซ้ำ, แจ้งผลสำเร็จ/ล้มเหลว โดย **ไม่ทำให้รายการทั้งหน้ากลายเป็น loading** Mutations API แยกสถานะของปุ่มออกจากสถานะของข้อมูลให้เรา

```
Lifecycle ของ Mutation (Riverpod 3.0):

   MutationIdle ──── run() ────► MutationPending
        ▲                              │
        │                 ┌────────────┴────────────┐
        │             สำเร็จ                      throw
        │                 ▼                         ▼
        │         MutationSuccess            MutationError
        │                 │                         │
        └──────── reset()/ผู้ฟังหมด ────────────────┘
```

```dart
// lib/features/incident/presentation/add_incident_button.dart
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
// Mutations API ยังอยู่ในกลุ่ม experimental ของ Riverpod 3.0
import 'package:flutter_riverpod/experimental/mutation.dart';
import '../data/incident_list_notifier.dart';

// ประกาศ mutation ระดับ global เหมือน provider ตัวหนึ่ง
final addIncidentMutation = Mutation<void>();

class AddIncidentButton extends ConsumerWidget {
  const AddIncidentButton({super.key, required this.powerPlantId});

  final int powerPlantId;

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    // watch สถานะของ "การกระทำ" - ไม่กระทบสถานะของ "ข้อมูล"
    final mutationState = ref.watch(addIncidentMutation);

    // UI Feedback ครบทุก state ด้วย switch expression ของ Dart 3
    final (label, color) = switch (mutationState) {
      MutationIdle() => ('แจ้งเหตุขัดข้อง', Colors.teal),
      MutationPending() => ('กำลังส่ง...', Colors.grey),
      MutationSuccess() => ('ส่งสำเร็จ ✓', Colors.green),
      MutationError() => ('ล้มเหลว - แตะเพื่อลองใหม่', Colors.red),
    };

    return FilledButton(
      style: FilledButton.styleFrom(backgroundColor: color),
      // กันกดซ้ำระหว่าง pending
      onPressed: mutationState is MutationPending
          ? null
          : () {
              // สั่งรัน mutation - lifecycle เปลี่ยนเป็น pending ทันที
              addIncidentMutation.run(ref, (tsx) async {
                await tsx.get(incidentListProvider.notifier).addIncident(
                      powerPlantId: powerPlantId,
                      title: 'Turbine vibration ผิดปกติ',
                      severity: 'high',
                    );
              });
            },
      child: mutationState is MutationPending
          ? const SizedBox(
              width: 18, height: 18,
              child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
            )
          : Text(label),
    );
  }
}
```

| Mutation State    | เกิดเมื่อ                       | UI Feedback ที่แนะนำ                    |
| ----------------- | ------------------------------- | ---------------------------------------- |
| `MutationIdle`    | ยังไม่เคยรัน / ถูก reset        | ปุ่มปกติ พร้อมกด                        |
| `MutationPending` | `run()` กำลังทำงาน              | Spinner บนปุ่ม + disable กันกดซ้ำ       |
| `MutationSuccess` | ทำงานจบไม่มี throw              | สีเขียว/ไอคอนถูก + SnackBar แจ้งสำเร็จ  |
| `MutationError`   | มี Exception ระหว่างทำงาน       | สีแดง + ข้อความ error + เปิดให้กดใหม่   |

> ✅ **จุดสำคัญ:** สังเกตว่าใน `run()` เราเรียก notifier ผ่าน `tsx.get(...)` ไม่ใช่ `ref.read(...)` เพราะ Mutation ต้องการติดตามว่า transaction นี้ไปแตะ provider ใดบ้าง และรายการเหตุขัดข้องบนหน้าจอยังแสดงข้อมูลเดิมตลอดช่วง pending ไม่กะพริบเป็น loading ทั้งหน้า นี่คือความต่างจากการยัดทุกอย่างใน AsyncNotifier state เดียว

---

## 📚 Module 7: Automatic Retry - รับมือเครือข่ายไม่เสถียร

### เวลา 15:20-15:30 น.

> 💡 **หัวใจของ Module นี้:** หน้างานจริงของ EDL-Gen (โรงไฟฟ้าในพื้นที่ห่างไกล) สัญญาณอาจหลุดเป็นช่วง ๆ Riverpod 3.0 มีระบบ **Retry อัตโนมัติในตัว**: เมื่อ provider ล้มเหลว มันจะลองใหม่ให้แบบ Exponential Backoff โดยเราปรับแต่งผ่าน `retry` parameter ได้ทั้งระดับทั้งแอปและรายตัว

---

### 7.1 กำหนด Retry ทั้งแอปผ่าน ProviderScope

```dart
// lib/main.dart (ปรับปรุง)
import 'dart:io';
import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

/// นโยบาย retry กลางของแอป: คืน Duration = รอเท่านี้แล้วลองใหม่, คืน null = เลิกลอง
Duration? edlgenRetry(int retryCount, Object error) {
  // อย่า retry ในกรณีที่ลองใหม่กี่ครั้งก็ไม่หาย
  if (error is DioException) {
    final status = error.response?.statusCode;
    if (status == 401 || status == 403) return null; // token หมดอายุ/ไม่มีสิทธิ์
    if (status == 422) return null;                  // validation ผิด แก้ข้อมูลก่อน
  }

  // ลองสูงสุด 5 ครั้ง
  if (retryCount >= 5) return null;

  // Exponential Backoff: 200ms, 400ms, 800ms, 1.6s, 3.2s
  return Duration(milliseconds: 200 * (1 << retryCount));
}

void main() {
  runApp(
    ProviderScope(
      retry: edlgenRetry,        // ใช้กับทุก provider ในแอป
      child: const EdlGenApp(),
    ),
  );
}
```

### 7.2 Override เฉพาะ Provider ด้วย @Riverpod(retry: ...)

```dart
// provider ที่ยอมให้ retry ถี่กว่าปกติ เช่น ค่าการอ่านล่าสุดบน Dashboard
Duration? fastRetry(int retryCount, Object error) =>
    retryCount >= 3 ? null : const Duration(milliseconds: 500);

@Riverpod(retry: fastRetry)
Future<List<EnergyReading>> latestReadings(Ref ref, int plantId) async {
  final dio = ref.watch(apiClientProvider);
  final response = await dio.get('/power-plants/$plantId');
  final items = response.data['data']['latest_readings'] as List<dynamic>;
  return items
      .map((j) => EnergyReading.fromJson(j as Map<String, dynamic>))
      .toList();
}
```

### 7.3 Custom Exception Handler - แปลง DioException เป็นข้อความที่ผู้ใช้เข้าใจ

```dart
// lib/core/errors/app_exception.dart
import 'package:dio/dio.dart';

/// Exception กลางของแอป - UI แสดง message ได้ทันที ไม่ต้องรู้จัก Dio
class AppException implements Exception {
  const AppException(this.message, {this.canRetry = true});

  final String message;
  final bool canRetry;   // บอก UI ว่าควรโชว์ปุ่ม "ลองใหม่" หรือไม่

  @override
  String toString() => message;

  /// โรงงานแปลง DioException → AppException ภาษาคน
  factory AppException.fromDio(DioException e) {
    return switch (e.type) {
      DioExceptionType.connectionTimeout ||
      DioExceptionType.receiveTimeout =>
        const AppException('เครือข่ายช้า กรุณาลองใหม่'),
      DioExceptionType.connectionError =>
        const AppException('เชื่อมต่อเซิร์ฟเวอร์ไม่ได้ ตรวจสอบสัญญาณเครือข่าย'),
      DioExceptionType.badResponse => switch (e.response?.statusCode) {
          401 => const AppException('เซสชันหมดอายุ กรุณาเข้าสู่ระบบใหม่', canRetry: false),
          403 => const AppException('ไม่มีสิทธิ์เข้าถึงข้อมูลนี้', canRetry: false),
          422 => const AppException('ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบ', canRetry: false),
          >= 500 => const AppException('เซิร์ฟเวอร์ขัดข้อง กรุณาลองใหม่ภายหลัง'),
          _ => const AppException('เกิดข้อผิดพลาดที่ไม่คาดคิด'),
        },
      _ => const AppException('เกิดข้อผิดพลาดในการเชื่อมต่อ'),
    };
  }
}
```

ผูกเข้ากับ Dio ผ่าน Interceptor ครั้งเดียว ใช้ได้ทั้งแอป:

```dart
// เพิ่มใน apiClient provider (Module 5.3)
@riverpod
Dio apiClient(Ref ref) {
  final dio = Dio(BaseOptions(
    baseUrl: apiBaseUrl,
    connectTimeout: const Duration(seconds: 10),
    receiveTimeout: const Duration(seconds: 10),
    headers: {'Accept': 'application/json'},
  ));

  dio.interceptors.add(
    InterceptorsWrapper(
      onError: (DioException e, handler) {
        // แปลงทุก DioException เป็น AppException ก่อนถึงมือ provider/UI
        handler.reject(e.copyWith(error: AppException.fromDio(e)));
      },
    ),
  );

  return dio;
}
```

> ⚠️ **ข้อควรระวัง:** อย่า retry ทุก error แบบหว่านแห - error กลุ่ม 4xx (401/403/422) retry กี่ครั้งผลก็เหมือนเดิมและเปลือง Battery/Data ของผู้ใช้ นโยบาย retry ที่ดีต้อง "เลือก retry เฉพาะ error ชั่วคราว" เช่น timeout, connection error, 5xx เท่านั้น ตามที่เขียนใน `edlgenRetry`

---

## 🛠️ Lab วันที่ 1 - Laravel API Endpoint + Sanctum Auth + Flutter AsyncValue UI

### เวลา 15:30-16:30 น.

> **โจทย์:** สร้างเส้นทางครบวงจรเส้นแรกของ EDL-Gen Monitoring App: ฝั่ง Laravel มี Endpoint `GET /api/v1/power-plants` ที่ป้องกันด้วย Sanctum ฝั่ง Flutter มีหน้า Login แบบง่าย + หน้ารายการโรงไฟฟ้าที่แสดง AsyncValue ครบ 3 สถานะ (Loading / Error / Data) และทดสอบ Error State ด้วยการปิดเซิร์ฟเวอร์จริง

### ✅ เช็คก่อนเริ่ม Lab

- [ ] `docker compose ps` เห็น edlgen_mariadb สถานะ Up
- [ ] `php artisan serve` รันอยู่ที่ port 8000 (ใช้ `--host=0.0.0.0` ถ้าทดสอบด้วยเครื่องจริง)
- [ ] `php artisan migrate:fresh --seed` ผ่านแล้ว (มี user + โรงไฟฟ้า 5 แห่ง)
- [ ] Emulator/เครื่องจริงพร้อม และ `dart run build_runner watch --delete-conflicting-outputs` รันค้างไว้

### ขั้นที่ 1 - ตรวจฝั่ง Laravel ให้ครบ (สรุปสิ่งที่ทำใน Module 1-4)

รายการไฟล์ที่ต้องมีครบก่อนไปต่อ:

```
edlgen_api/
├── routes/api.php                                  ← prefix v1 + auth:sanctum
├── app/Http/Controllers/Api/V1/AuthController.php  ← login/logout/me
├── app/Http/Controllers/Api/V1/PowerPlantController.php
├── app/Http/Resources/V1/PowerPlantResource.php
├── app/Http/Resources/V1/EnergyReadingResource.php
├── app/Services/PowerPlantService.php
├── app/Repositories/Contracts/PowerPlantRepositoryInterface.php
├── app/Repositories/Eloquent/EloquentPowerPlantRepository.php
└── database/seeders/PowerPlantSeeder.php
```

ยืนยันด้วย Postman อีกครั้ง: Login ได้ Token → `GET /api/v1/power-plants` พร้อม Token ได้ข้อมูล 5 โรงไฟฟ้า → ไม่ใส่ Token ได้ 401

### ขั้นที่ 2 - Flutter: เก็บ Token ด้วย Notifier + แนบอัตโนมัติผ่าน Interceptor

```dart
// lib/features/auth/data/auth_providers.dart
import 'package:riverpod_annotation/riverpod_annotation.dart';

part 'auth_providers.g.dart';

/// เก็บ token ปัจจุบันในหน่วยความจำ (Day 4 จะย้ายไป flutter_secure_storage)
@Riverpod(keepAlive: true)   // ห้าม auto-dispose เพราะทั้งแอปต้องใช้
class AuthToken extends _$AuthToken {
  @override
  String? build() => null;   // null = ยังไม่ได้ล็อกอิน

  void setToken(String token) => state = token;
  void clear() => state = null;
}
```

ปรับ `apiClient` ให้แนบ Token อัตโนมัติทุก Request:

```dart
// lib/features/power_plant/data/api_client.dart (ฉบับสมบูรณ์ของวันนี้)
import 'package:dio/dio.dart';
import 'package:riverpod_annotation/riverpod_annotation.dart';
import '../../auth/data/auth_providers.dart';
import '../../../core/errors/app_exception.dart';

part 'api_client.g.dart';

const apiBaseUrl = 'http://10.0.2.2:8000/api/v1';

@riverpod
Dio apiClient(Ref ref) {
  final dio = Dio(BaseOptions(
    baseUrl: apiBaseUrl,
    connectTimeout: const Duration(seconds: 10),
    receiveTimeout: const Duration(seconds: 10),
    headers: {'Accept': 'application/json'},
  ));

  dio.interceptors.add(
    InterceptorsWrapper(
      onRequest: (options, handler) {
        // แนบ Bearer Token อัตโนมัติถ้าล็อกอินแล้ว
        final token = ref.read(authTokenProvider);
        if (token != null) {
          options.headers['Authorization'] = 'Bearer $token';
        }
        handler.next(options);
      },
      onError: (DioException e, handler) {
        handler.reject(e.copyWith(error: AppException.fromDio(e)));
      },
    ),
  );

  return dio;
}
```

### ขั้นที่ 3 - หน้า Login แบบง่าย (เรียก /api/v1/login จริง)

```dart
// lib/features/auth/presentation/login_page.dart
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../data/auth_providers.dart';
import '../../power_plant/data/api_client.dart';
import '../../power_plant/presentation/power_plant_list_view.dart';

class LoginPage extends ConsumerStatefulWidget {
  const LoginPage({super.key});

  @override
  ConsumerState<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends ConsumerState<LoginPage> {
  final _email = TextEditingController(text: 'engineer@edlgen.la');
  final _password = TextEditingController(text: 'password123');
  bool _loading = false;
  String? _error;

  @override
  void dispose() {
    _email.dispose();
    _password.dispose();
    super.dispose();
  }

  Future<void> _login() async {
    setState(() { _loading = true; _error = null; });

    try {
      final dio = ref.read(apiClientProvider);
      final response = await dio.post('/login', data: {
        'email': _email.text.trim(),
        'password': _password.text,
        'device_name': 'flutter-day1-lab',
      });

      // เก็บ token เข้า provider - Interceptor จะแนบให้ทุก request ต่อจากนี้
      ref.read(authTokenProvider.notifier)
          .setToken(response.data['token'] as String);

      if (!mounted) return;
      Navigator.of(context).pushReplacement(
        MaterialPageRoute(builder: (_) => const PowerPlantListView()),
      );
    } catch (e) {
      setState(() => _error = e.toString());
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(24),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const Icon(Icons.bolt, size: 64, color: Colors.teal),
              const Text('EDL-Gen Monitoring',
                  style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold)),
              const SizedBox(height: 24),
              TextField(
                controller: _email,
                decoration: const InputDecoration(labelText: 'Email'),
              ),
              const SizedBox(height: 12),
              TextField(
                controller: _password,
                obscureText: true,
                decoration: const InputDecoration(labelText: 'Password'),
              ),
              const SizedBox(height: 16),
              if (_error != null)
                Text(_error!, style: const TextStyle(color: Colors.red)),
              const SizedBox(height: 8),
              SizedBox(
                width: double.infinity,
                child: FilledButton(
                  onPressed: _loading ? null : _login,
                  child: _loading
                      ? const SizedBox(
                          width: 20, height: 20,
                          child: CircularProgressIndicator(strokeWidth: 2))
                      : const Text('เข้าสู่ระบบ'),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
```

> 📌 หน้า Login วันนี้ใช้ `setState` ธรรมดาก่อนโดยตั้งใจ เพื่อให้เห็น "ความเจ็บปวด" เทียบกับ AsyncValue ในหน้ารายการ - วันที่ 4 เราจะ Refactor เป็น AuthCubit เต็มรูปแบบ

### ขั้นที่ 4 - ตั้ง LoginPage เป็นหน้าแรก แล้วรัน

```dart
// ใน EdlGenApp เปลี่ยน home
home: const LoginPage(),
```

```bash
dart run build_runner build --delete-conflicting-outputs
flutter run
```

### ขั้นที่ 5 - ทดสอบครบ 3 สถานะของ AsyncValue

| การทดสอบ                 | วิธีทำ                                                     | สิ่งที่ต้องเห็น                                     |
| ------------------------ | ----------------------------------------------------------- | ---------------------------------------------------- |
| **Loading State**        | Login แล้วเข้าหน้ารายการทันที                              | CircularProgressIndicator ระหว่างรอ API              |
| **Data State**           | รอ API ตอบ                                                  | รายการโรงไฟฟ้า 5 แห่ง พร้อมไอคอนสถานะเขียว/แดง      |
| **Error State + Retry**  | หยุด `php artisan serve` (Ctrl+C) แล้วดึง Pull-to-refresh  | ไอคอน cloud_off + ข้อความ AppException + ปุ่มลองใหม่ |
| **Retry สำเร็จ**         | รัน `php artisan serve` ใหม่ แล้วกดปุ่ม "ลองใหม่"           | กลับสู่ Loading → Data ตามลำดับ                     |
| **Auth Guard**           | ลบบรรทัด setToken ชั่วคราวแล้ว Hot Restart                 | Error 401 → ข้อความ "เซสชันหมดอายุ..." (canRetry=false) |

### ขั้นที่ 6 (โจทย์เสริม สำหรับคนทำเสร็จก่อน)

1. เพิ่ม Endpoint `GET /api/v1/power-plants/{id}` ฝั่ง Laravel (`show` method ใช้ `findWithLatestReadings`) แล้วสร้างหน้า Detail ฝั่ง Flutter ด้วย `@riverpod` provider แบบรับ parameter `plantId`
2. เพิ่มปุ่ม Logout บน AppBar: เรียก `POST /api/v1/logout` แล้ว `ref.read(authTokenProvider.notifier).clear()` และเด้งกลับหน้า Login
3. ทดลองใส่ `retry: fastRetry` (Module 7.2) กับ `powerPlantListProvider` แล้วปิดเซิร์ฟเวอร์ สังเกต log ว่ามีการลองใหม่อัตโนมัติก่อนขึ้น Error State

> ✅ **ผลลัพธ์ที่คาดหวังของ Lab วันที่ 1:** ผู้เรียนทุกคนมี (1) Laravel API ที่ Login ด้วย Sanctum และคืนรายการโรงไฟฟ้าผ่าน Resource + Repository Pattern (2) Flutter App ที่ Login ได้จริง เก็บ Token แนบอัตโนมัติ และแสดงผล AsyncValue ครบ Loading/Error/Data พร้อมปุ่ม Retry - โค้ดชุดนี้คือรากฐานที่ Day 2-5 จะต่อยอดทั้งหมด

---

## 📝 สรุปประจำวันที่ 1

**Module 0 - เตรียมเครื่องมือ:**

- ติดตั้งและตรวจครบ: PHP 8.3 + Composer 2.x (Windows: PHP ZIP ที่ `C:\php83` / macOS: Homebrew), Docker Desktop + MariaDB 11.4 + PostgreSQL 16 (docker-compose.yml เดียวรันสองฐานข้อมูล), Flutter SDK 3.x, Android Studio + Emulator, VS Code + Extensions, Git, Postman/Bruno, TablePlus/DBeaver
- จุดที่พลาดบ่อย: PATH ของ PHP, Port 3306/5432 ชนของเดิม, Emulator ต้องใช้ `10.0.2.2` แทน `localhost`, Firewall ต้อง Allow Port 8000

**Laravel 13 API Layer:**

- `php artisan install:api` คือคำสั่งเปิดโหมด API (สร้าง routes/api.php + ติดตั้ง Sanctum)
- วางสถาปัตยกรรม 3 ชั้น: Controller (บาง) → Service (Business Logic) → Repository (คุยฐานข้อมูลผ่าน Interface) พร้อม API Versioning `/api/v1/`
- Sanctum Token-based Auth: `createToken()` ตอน Login, Middleware `auth:sanctum` คุ้มครอง Route, ลบ Token = Logout มีผลทันที
- API Resource ควบคุม JSON: `whenLoaded`/`whenCounted`/`when` ป้องกัน Over-fetching และ cast `(float)` ป้องกัน type error ฝั่ง Dart
- Repository Pattern + Eloquent ทำให้สลับ MariaDB ⇄ PostgreSQL ได้โดยแก้แค่ `.env` และ `DB::transaction()` ทำให้หลายคำสั่ง "สำเร็จทั้งคู่หรือไม่เกิดเลย"

**Riverpod 3.0 Async State:**

- `AsyncValue<T>` คือ State Machine 3 สถานะ (loading/data/error) - `when()` บังคับจัดการครบ, `AsyncValue.guard()` แทน try/catch
- `AsyncNotifier` (`@riverpod class`) รวมการโหลด + เมธอดแก้ไขข้อมูลไว้ที่เดียว
- Mutations API (experimental): แยกสถานะ "การกระทำ" ออกจาก "ข้อมูล" ด้วย Lifecycle `idle -> pending -> success/error` ทำ UI Feedback บนปุ่มได้โดยรายการไม่กะพริบ
- Automatic Retry: กำหนดผ่าน `ProviderScope(retry: ...)` ทั้งแอป หรือ `@Riverpod(retry: ...)` รายตัว + Custom `AppException` แปลง DioException เป็นภาษาคน และ retry เฉพาะ error ชั่วคราวเท่านั้น

---

## ✅ ตรวจสอบความพร้อมก่อนวันพรุ่งนี้ (Day 2: Flutter Foundation + Widget System)

ก่อนกลับวันนี้ / ก่อนเริ่มเรียนพรุ่งนี้ ให้ตรวจสอบว่า:

- [ ] โปรเจกต์ `edlgen_api` รันได้ (`php artisan serve`) และ Login + `GET /api/v1/power-plants` ผ่าน Postman ได้
- [ ] โปรเจกต์ `edlgen_monitoring` รันบน Emulator/เครื่องจริงได้ Login แล้วเห็นรายการโรงไฟฟ้า 5 แห่ง
- [ ] Commit โค้ดทั้งสองโปรเจกต์เข้า Git (`git add . && git commit -m "Day 1: API + Auth + AsyncValue"`) เผื่อพรุ่งนี้ต้องย้อนดู
- [ ] Docker Container ทั้งสองยังรันอยู่ (หรือจำวิธี `docker compose up -d` ได้)
- [ ] ทบทวนศัพท์ที่จะใช้หนักพรุ่งนี้: Widget Tree, StatelessWidget vs StatefulWidget, BuildContext, `setState`
- [ ] (แนะนำ) อ่าน Layout พื้นฐานล่วงหน้า: Column, Row, Expanded, ListView.builder ที่ `docs.flutter.dev/ui/layout`

**สิ่งที่จะเรียนพรุ่งนี้:** Flutter Rendering Pipeline (Widget/Element/RenderObject Tree), สร้าง UI ด้วย StatefulWidget + setState จนเห็น "ปัญหา" ของ State ที่กระจัดกระจาย, Layout Widgets สำหรับ Dashboard, Custom Widgets (StatCard, StatusBadge, AlertTile) และ Navigation ด้วย GoRouter - ปิดท้ายด้วย Lab สร้าง App Skeleton ของ EDL-Gen Monitoring ครบทุกหน้า

---

## 📖 เอกสารอ้างอิงและแหล่งเรียนรู้เพิ่มเติม

**Laravel:**

- Laravel Documentation: `https://laravel.com/docs` (Routing, Eloquent, Migrations, API Resources)
- Laravel Sanctum: `https://laravel.com/docs/sanctum` (Mobile Application Authentication)
- Eloquent API Resources: `https://laravel.com/docs/eloquent-resources`
- Database Transactions: `https://laravel.com/docs/database#database-transactions`
- Laravel News (ติดตามของใหม่): `https://laravel-news.com`

**Riverpod / Flutter:**

- Riverpod Official Docs: `https://riverpod.dev` (AsyncValue, AsyncNotifier, Code Generation)
- Mutations API (Riverpod 3.0): `https://riverpod.dev/docs/concepts/mutations`
- Automatic Retry: `https://riverpod.dev/docs/whats_new` (What's new in Riverpod 3.0)
- flutter_riverpod บน pub.dev: `https://pub.dev/packages/flutter_riverpod`
- riverpod_generator: `https://pub.dev/packages/riverpod_generator`
- dio (HTTP Client): `https://pub.dev/packages/dio`
- Flutter Official Docs: `https://docs.flutter.dev` (Get Started, Layout, State Management)
- Dart Language Tour (switch expression, records): `https://dart.dev/language`

**เครื่องมือ:**

- PHP for Windows (ZIP): `https://windows.php.net/download/` | Composer: `https://getcomposer.org/download/` | Homebrew (macOS): `https://brew.sh`
- Docker Desktop: `https://www.docker.com/products/docker-desktop/`
- MariaDB Docker Image: `https://hub.docker.com/_/mariadb` | PostgreSQL: `https://hub.docker.com/_/postgres`
- Postman: `https://www.postman.com` | Bruno: `https://www.usebruno.com`
- TablePlus: `https://tableplus.com` | DBeaver: `https://dbeaver.io`

---

*เอกสารประกอบการอบรมวันที่ 1 หลักสูตร Basic to Advanced Laravel 13 and Flutter Framework (MOB-15)*
*สถาบันไอทีจีเนียส เอ็นจิเนียริ่ง - จัดอบรมให้ EDL-Generation Public Company | ผู้สอน: อ.สามิตร โกยม*




