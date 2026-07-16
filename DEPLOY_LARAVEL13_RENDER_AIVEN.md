# 🚀 ขั้นตอนการ Deploy Laravel 13 บน Render + MySQL บน Aiven (Free Tier)

คู่มือสรุปขั้นตอนการนำโปรเจกต์ Laravel 13 ขึ้นระบบ Cloud ของ Render ร่วมกับฐานข้อมูล MySQL ของ Aiven โดยใช้แพ็กเกจฟรี 100%

---

## 🛠️ Step 1: เตรียมโปรเจกต์ Laravel 13 บนเครื่อง

### 1.1 สร้างไฟล์ `Dockerfile`

สร้างไฟล์ชื่อ `Dockerfile` (ไม่มีนามสกุลไฟล์) ไว้ที่โฟลเดอร์นอกสุด (Root Directory) ของโปรเจกต์:

```dockerfile
FROM php:8.3-fpm-alpine

# ติดตั้ง library ที่จำเป็นสำหรับคอมไพล์ extension บน Alpine (เช่น mbstring ต้องการ oniguruma)
RUN apk add --no-cache oniguruma-dev

# ติดตั้ง PHP extensions ที่ Laravel 13 จำเป็นต้องใช้ (composer.json ของโปรเจกต์นี้ระบุ ext-mbstring ไว้)
RUN docker-php-ext-install pdo pdo_mysql bcmath mbstring

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# คัดลอกโค้ดโปรเจกต์ทั้งหมด
COPY . .

# ติดตั้ง Dependencies สำหรับ Production (ไม่รวม require-dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ตั้งสิทธิ์โฟลเดอร์สำหรับ Laravel Storage และ Cache (-R ตัวใหญ่เท่านั้น)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# รัน Migration + Seeder + storage:link อัตโนมัติทุกครั้งที่ Container เริ่มทำงาน
# - storage:link: ให้รูปแจ้งเหตุเปิดผ่าน /storage/incidents/... ได้ (filesystem ของ Render เป็นแบบชั่วคราว จึงต้องสร้าง link ใหม่ทุกครั้ง)
# - ${PORT:-80}: Render กำหนดพอร์ตผ่านตัวแปร PORT ให้อัตโนมัติ ถ้ารันในเครื่องเองใช้ 80
# หมายเหตุ: Render Free Plan ไม่มี Shell/One-Off Jobs ให้ (เป็นฟีเจอร์ของแพลนเสียเงิน)
# จึงต้องผูก db:seed ไว้ในนี้ด้วย โดย Seeder ของโปรเจกต์นี้ถูกเขียนให้ idempotent (ใช้ firstOrCreate) จึงรันซ้ำได้อย่างปลอดภัย ไม่สร้างข้อมูลซ้ำ
CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && php artisan storage:link --force && php artisan serve --host=0.0.0.0 --port=${PORT:-80}"]
```

> ⚠️ **ข้อควรระวัง:** ห้ามใช้ `chown -r` (ตัว r เล็ก) เพราะ BusyBox ของ Alpine รองรับเฉพาะ `-R` (ตัวใหญ่) แบบเดียวกับ Linux ทั่วไป ถ้าพิมพ์ผิดตัวเล็กจะได้ error `chown: unrecognized option` และ build ล้มเหลวทันที

> 📌 **ทำไมให้ migrate + seed รันใน Docker เลย แทนที่จะเข้า Shell มาสั่งเอง:** เพราะ **Render Free Plan ไม่มีเมนู Shell และ One-Off Jobs ให้ใช้งาน** (ในหน้า Dashboard จะเห็นไอคอนสายฟ้า ⚡ กำกับอยู่ที่เมนู Shell, Scaling, Disk, One-Off Jobs ซึ่งหมายถึงต้องอัปเกรดเป็นแพลนเสียเงินก่อนถึงจะกดใช้ได้) วิธีเดียวที่รันคำสั่งบน Container ของ Free Plan ได้คือผูกไว้กับคำสั่งเริ่มต้น (`CMD`) เท่านั้น จึงต้องออกแบบให้ทั้ง `migrate` และ `db:seed` รันซ้ำได้อย่างปลอดภัยทุกครั้งที่ Container Start (ดูหัวข้อ Seeder แบบ Idempotent ด้านล่าง)

### 1.2 ดันโค้ดขึ้น GitHub

- สร้างคลังเก็บโค้ด (Repository) บน GitHub (ตั้งเป็น Private ได้)
- ดันโค้ดโปรเจกต์ทั้งหมด รวมถึงไฟล์ `Dockerfile` ขึ้นไปบน GitHub

---

## 🗄️ Step 2: ดึงข้อมูลเชื่อมต่อฐานข้อมูลจาก Aiven MySQL

1. เข้าสู่ระบบ **[Aiven.io](https://aiven.io)**
2. สร้างบริการใหม่: กด **Create service** -> เลือก **MySQL** -> เลือกแพ็กเกจ **Free Tier**
3. รอจนสถานะเปลี่ยนเป็น **Running** จากนั้นคัดลอกข้อมูลในหัวข้อ **Connection info** เก็บไว้:
    - **Host:** (เช่น `mysql-xxxxxxxx-yourproject.aivencloud.com`)
    - **Port:** (เช่น `27000`)
    - **User:** `avnadmin`
    - **Password:** _(รหัสผ่านที่ระบบสร้างให้)_
    - **Database:** `defaultdb`
    - **CA Certificate (ca.pem):** ดาวน์โหลดจากปุ่ม **CA Certificate** ในหน้าเดียวกัน (Aiven บังคับเชื่อมต่อผ่าน SSL เสมอ)

---

## 🌐 Step 3: ตั้งค่าและสร้าง Web Service บน Render

1. เข้าสู่ระบบ **[Render.com](https://render.com)**
2. กดปุ่ม **New +** (มุมขวาบน) -> เลือก **Web Service**
3. เลือก **Connect a repository** และเลือกโปรเจกต์ Laravel จาก GitHub ของคุณ
4. ตั้งค่าหน้าแรกดังนี้:
    - **Name:** ตั้งชื่อแอปพลิเคชันของคุณ
    - **Language:** เลือก **Docker** (ระบบจะตรวจเจอ Dockerfile อัตโนมัติ)
    - **Instance Type:** เลือก **Free**

---

## 🔑 Step 4: ตั้งค่า Environment Variables (.env) บน Render

ในหน้าตั้งค่าเดิม ให้เลื่อนลงมาที่หัวข้อ **Environment Variables** หรือกด **Add Environment Variable** เพื่อใส่ค่าคอนฟิกเหล่านี้:

| Key                 | Value                                  | หมายเหตุ                                                             |
| :------------------ | :------------------------------------- | :------------------------------------------------------------------- |
| `APP_ENV`           | `production`                           | รันระบบในโหมดใช้งานจริง                                              |
| `APP_KEY`           | _คัดลอกมาจากไฟล์ .env ในเครื่องของคุณ_ | คีย์หลักประจำแอป (เช่น `base64:xxx...`)                              |
| `APP_DEBUG`         | `false`                                | ปิดการแสดง Code Error เพื่อความปลอดภัย                               |
| `DB_CONNECTION`     | `mysql`                                | ระบุชนิดฐานข้อมูลเป็น MySQL                                          |
| `DB_HOST`           | _ค่า Host ที่ได้จาก Aiven_             | เช่น `mysql-xxxxxxxx-yourproject.aivencloud.com`                     |
| `DB_PORT`           | _ค่า Port ที่ได้จาก Aiven_             | เช่น `27000`                                                         |
| `DB_DATABASE`       | `defaultdb`                            | ชื่อฐานข้อมูลเริ่มต้นของ Aiven                                       |
| `DB_USERNAME`       | `avnadmin`                             | ชื่อผู้ใช้เริ่มต้นของ Aiven                                          |
| `DB_PASSWORD`       | _รหัสผ่านที่ได้จาก Aiven_              | รหัสผ่านฐานข้อมูล                                                    |
| `MYSQL_ATTR_SSL_CA` | `/var/www/ca.pem`                      | Path ของไฟล์ CA Certificate (ดู Step 5.1) — Aiven บังคับใช้ SSL เสมอ |
| `APP_URL`           | `https://your-app.onrender.com`        | ใส่ URL จริงที่ Render สร้างให้ (ดูได้หลัง Deploy ครั้งแรก)          |

_เมื่อใส่ครบถ้วนแล้ว ให้กดปุ่ม **Create Web Service** เพื่อเริ่มกระบวนการ Build_

> 📌 **เรื่อง SSL กับ Aiven MySQL:** โปรเจกต์นี้ใช้ `config/database.php` มาตรฐานของ Laravel ซึ่งอ่านค่า `MYSQL_ATTR_SSL_CA` มาใส่เป็น PDO Option ให้อัตโนมัติอยู่แล้ว สิ่งที่ต้องทำเพิ่มคือนำไฟล์ `ca.pem` ที่ดาวน์โหลดจาก Aiven มาวางไว้ที่ root ของโปรเจกต์ก่อน commit ขึ้น GitHub (Dockerfile มีคำสั่ง `COPY . .` อยู่แล้ว จึงถูกคัดลอกเข้า image ให้โดยอัตโนมัติที่ path `/var/www/ca.pem`) แล้วตั้งค่า Environment Variable `MYSQL_ATTR_SSL_CA=/var/www/ca.pem` ตามตารางด้านบน

---

## ⚡ Step 5: ตรวจสอบว่า Migration + Seed สำเร็จ (ไม่ต้องเข้า Shell)

ตั้งแต่ Step 1.1 ทั้ง `php artisan migrate --force` และ `php artisan db:seed --force` ถูกผูกไว้กับ `CMD` ของ Dockerfile แล้ว ดังนั้น**ไม่ต้องเข้า Shell มาสั่งเองเลย** — และบน Render Free Plan ก็**ไม่มีเมนู Shell ให้ใช้อยู่แล้ว** (ต้องอัปเกรดแพลนก่อนถึงจะปลดล็อก) ทุกครั้งที่ Deploy สำเร็จและ container เริ่มทำงาน ทั้งโครงสร้างตารางและข้อมูลตัวอย่างจะถูกสร้าง/อัปเดตบน Aiven MySQL ให้อัตโนมัติ

วิธีตรวจสอบว่าขั้นตอนนี้สำเร็จ (ใช้ได้ทั้งบน Free Plan):

1. รอจนสถานะบน Render ขึ้นสีเขียว **Live**
2. เปิดแท็บ **Logs** ทางเมนูด้านซ้าย ต้องเห็นบรรทัดประมาณนี้ก่อนที่ server จะเริ่มทำงาน:
    ```
    Migrating: 2026_07_14_071459_create_power_plants_table
    Migrated:  2026_07_14_071459_create_power_plants_table (xx.xxms)
    ...
    INFO  Server running on [http://0.0.0.0:80].
    ```
3. ทดสอบเรียก API จริงผ่านเบราว์เซอร์หรือ Postman ที่ `https://<ชื่อแอปของคุณ>.onrender.com/api/v1/login` ด้วยข้อมูลผู้ใช้ทดสอบ `engineer@edlgen.la` / `password123` — ถ้า Login ผ่านและ `GET /api/v1/power-plants` คืนโรงไฟฟ้า 5 แห่ง แปลว่า Migration และ Seed ทำงานสำเร็จครบ
4. ถ้าต้อง Deploy ใหม่ในอนาคตและมี Migration ไฟล์เพิ่ม ก็ไม่ต้องทำอะไรเพิ่มเติม เพราะ `CMD` จะรัน migrate/seed ให้เองทุกครั้งตามข้อ 1-2

> 📌 **เรื่อง Seeder แบบ Idempotent:** เพราะต้องรัน `db:seed` ซ้ำได้ทุกครั้งที่ container start (ไม่มี Shell ให้สั่งครั้งเดียว) โค้ดใน `DatabaseSeeder.php` และ `PowerPlantSeeder.php` จึงถูกปรับให้ใช้ `firstOrCreate()` แทน `create()`/`factory()->create()` — เช็คก่อนว่ามี `email`/`code` นั้นอยู่แล้วหรือยัง ถ้ามีแล้วจะข้ามไปเลย ไม่สร้างข้อมูลซ้ำหรือชน unique constraint

---

## ⚠️ ข้อจำกัดของแพลนฟรีที่ต้องระวัง

- **เซิร์ฟเวอร์หลับ (Sleep Mode):** หากไม่มีผู้ใช้งานเข้าเว็บนานเกิน 15 นาที Render จะปิดตัวเองชั่วคราว การเข้าเว็บครั้งต่อไปจะใช้เวลาปลุกเซิร์ฟเวอร์ประมาณ 30-50 วินาที
- **ไม่มี Shell / One-Off Jobs:** เมนู **Shell**, **Scaling**, **Disk**, **One-Off Jobs** ในหน้า Dashboard ของ Free Plan จะมีไอคอนสายฟ้า ⚡ กำกับไว้ หมายถึงต้องอัปเกรดเป็นแพลนเสียเงินก่อนถึงจะใช้ได้ ดังนั้นคำสั่งใด ๆ ที่ต้องรันหลัง Deploy (เช่น migrate, seed) **ต้องผูกไว้กับ `CMD` ของ Dockerfile เท่านั้น** จะเข้าไปพิมพ์คำสั่งเองแบบ interactive ไม่ได้ (ดู Step 1.1 และ Step 5)
- **พื้นที่เก็บไฟล์ชั่วคราว:** การอัปโหลดไฟล์ผ่าน `Laravel Storage` บน Render แพลนฟรี ไฟล์จะหายไปเมื่อเซิร์ฟเวอร์สั่ง Restart แนะนำให้ใช้บริการภายนอก เช่น **Cloudinary** หรือ **AWS S3** ในการเก็บรูปภาพ/ไฟล์ถาวร

---

## 🐞 Troubleshooting เฉพาะโปรเจกต์นี้

- **`Class "App\Http\Controllers\Api\V1\...Controller" not found` หลัง Deploy (แสดงเป็น `{"message": "Server Error"}` เพราะ `APP_DEBUG=false`):** เครื่องพัฒนา Windows/macOS มองชื่อไฟล์แบบไม่สนตัวพิมพ์เล็ก-ใหญ่ (Case-insensitive) แต่ Container บน Render รันบน Alpine Linux ซึ่ง**สนตัวพิมพ์เล็ก-ใหญ่**ของชื่อโฟลเดอร์/ไฟล์เสมอ เคยเจอปัญหานี้ในโปรเจกต์นี้จริง (โฟลเดอร์ Controller เป็น `app/Http/Controllers/api/v1/` ตัวเล็ก แต่ประกาศ `namespace App\Http\Controllers\Api\V1;` ตัวใหญ่) — **แก้ไว้แล้ว**โดย `git mv` เปลี่ยนชื่อโฟลเดอร์เป็น `Api/V1` ให้ตรงกับ namespace ถ้าเจอ error แบบนี้อีกในอนาคต (เช่น เพิ่ม Controller ใหม่) ให้ตรวจ 3 จุดนี้ให้ตรงกันเสมอ: ชื่อโฟลเดอร์จริง, `namespace` ที่ประกาศในไฟล์ Controller, และ `use ...Controller;` ใน `routes/api.php`

#### ℹ️ ทำไมต้องเป็น Linux ถึงพัง แต่ Windows รันผ่าน?

ไม่ใช่ข้อจำกัดของ Linux ที่ "ห้ามใช้ตัวเล็ก" — Linux เป็น case-sensitive filesystem แปลว่ามันมองว่า `api` กับ `Api` คือคนละโฟลเดอร์กัน ต้นตอบั๊กจริง ๆ คือ **ชื่อโฟลเดอร์กับ `namespace` ที่ประกาศในไฟล์ไม่ตรงกัน** ไม่ใช่เพราะเป็นตัวเล็ก ถ้าตั้งเป็น `api/v1` ตัวเล็กล้วน แล้วให้ทุกจุด (โฟลเดอร์, `namespace`, `use`) เป็นตัวเล็กเหมือนกันหมด ก็จะรันได้ปกติทั้งบน Windows และ Linux เช่นกัน — Windows ไม่สนเรื่อง case เลยรันผ่านได้ปกติแม้ตอนนั้นจะไม่ตรงกัน แต่พอไป Linux (Render) แล้วมันหา path `Api/V1/...` (ตามที่ `namespace`/`use` ระบุ) แต่ของจริงอยู่ที่ `api/v1/...` เลย "Class not found"

#### ℹ️ ทำไมเลือกแก้เป็น `Api/V1` (ตัวใหญ่) ไม่ใช่ `api/v1` (ตัวเล็ก) — เป็น Convention ของ PSR-4/Laravel

1. **PSR-4 Autoloading** (มาตรฐานกลางของ PHP ที่ Composer ใช้) กำหนดว่า namespace แต่ละ segment จะ map ตรงกับชื่อโฟลเดอร์ 1:1 แบบ exact-case และตาม **PSR-1 coding standard** namespace/class name ต้องเขียนแบบ **StudlyCaps** (ตัวใหญ่ขึ้นต้นทุกคำ) เช่น `App\Http\Controllers`, `App\Models` — สังเกตว่า `Http`, `Controllers`, `Models` ที่ Laravel สร้างให้ตั้งแต่ต้นก็เป็นตัวใหญ่ทั้งหมด ไม่มีที่ไหนเป็นตัวเล็ก
2. ถ้าใช้คำสั่ง `php artisan make:controller Api/V1/AuthController` (พิมพ์ตัวใหญ่ตามธรรมเนียมที่เอกสาร Laravel แนะนำ) Laravel จะสร้างโฟลเดอร์ `Api/V1` ให้เองพร้อม namespace ตรงกันอัตโนมัติ — กรณีนี้คนเขียนโค้ดน่าจะ copy โค้ดที่มี `namespace ...Api\V1;` มาวางในโฟลเดอร์ที่ตั้งชื่อเองว่า `api/v1` (ตัวเล็ก) ทำให้เกิดความไม่ตรงกัน
3. ถ้าเลือกแก้เป็นเลอะเทอะ (ลด namespace ลงเป็นตัวเล็กหมดแทน) จะขัดกับธรรมเนียมทั้ง Ecosystem เช่น ถ้าวันหลังมีคนรัน `php artisan make:controller Api/V1/SomethingController` (พิมพ์ตัวใหญ่ตามปกติ) จะได้โฟลเดอร์ `Api/V1` ใหม่ซ้อนขึ้นมาอีกอัน แยกจาก `api/v1` เดิม (บน Linux เห็นเป็นคนละโฟลเดอร์) เกิดโครงสร้างซ้ำซ้อนสับสนถาวร

สรุปคือไม่ใช่ข้อจำกัดของ Linux แต่เป็นเรื่อง **ต้องเลือกให้ตรงกันทุกจุด** และเลือกทางที่ตรงกับ convention มาตรฐานของ Laravel/PSR-4 เพื่อไม่ให้ชนกับพฤติกรรมของเครื่องมือ (artisan generator) และโค้ดอื่น ๆ ในอนาคต

- **`SQLSTATE[HY000] [2002] ... SSL connection error` / Deploy ค้างที่สถานะ "Deploy failed":** เพราะ `migrate` รันอัตโนมัติใน `CMD` แล้ว ถ้า SSL ผิดพลาด container จะไม่ start เลย ให้ดูสาเหตุที่แท็บ **Logs** ก่อนเสมอ ปกติแปลว่ายังไม่ได้ตั้งค่า `MYSQL_ATTR_SSL_CA` หรือไฟล์ `ca.pem` ไม่ถูกคัดลอกเข้า image (ดู Step 4)
- **Container ขึ้น "Deploy failed" เพราะ Migration ไฟล์มีปัญหา:** เนื่องจาก migrate ผูกกับ `CMD` ทุกครั้งที่ start ถ้ามี Migration ใดพังกลางทาง แอปทั้งตัวจะไม่ขึ้นเลย (ต่างจากตอนรันมือที่แก้แล้วลองใหม่ได้ทันที) ให้แก้ไฟล์ Migration ที่ผิดแล้ว push โค้ดใหม่เพื่อ Deploy ซ้ำ
- **อยากรันคำสั่ง artisan อื่น ๆ เอง (เช่น debug ข้อมูล) แต่ไม่มี Shell:** บน Free Plan ทำไม่ได้โดยตรง ทางเลือกคือ (1) อัปเกรดเป็นแพลนเสียเงินเพื่อปลดล็อก Shell/One-Off Jobs หรือ (2) เพิ่ม Route ชั่วคราวใน `routes/api.php` ที่เรียก Artisan command ผ่าน `Artisan::call()` แล้วลบออกทันทีหลังใช้งานเสร็จ (ห้ามปล่อยทิ้งไว้เพราะเป็นช่องโหว่ความปลอดภัย)
- **`composer install` ล้มเหลวเพราะ `ext-mbstring` หายไป:** อิมเมจ `php:8.3-fpm-alpine` ไม่มี `mbstring` มาให้ตั้งแต่ต้น ต้องติดตั้งผ่าน `docker-php-ext-install mbstring` ร่วมกับ `apk add oniguruma-dev` ก่อนเสมอ (แก้ไว้ใน `Dockerfile` แล้ว)
