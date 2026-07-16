FROM php:8.3-fpm-alpine

# ติดตั้ง library ที่จำเป็นสำหรับคอมไพล์ extension บน Alpine (เช่น mbstring ต้องการ oniguruma)
RUN apk add --no-cache oniguruma-dev

# ติดตั้ง extensions ที่ Laravel 13 จำเป็นต้องใช้
# - mbstring: framework บังคับใช้ (composer.json ระบุ ext-mbstring)
# - pdo, pdo_mysql: เชื่อมต่อฐานข้อมูล MySQL บน Aiven
# - bcmath: ใช้โดย Laravel/Sanctum ในการคำนวณเลขทศนิยมความแม่นยำสูง
RUN docker-php-ext-install pdo pdo_mysql bcmath mbstring

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# คัดลอกโค้ดโปรเจกต์
COPY . .

# ติดตั้ง Dependencies สำหรับ Production (ไม่รวม require-dev เช่น phpunit, pail)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ตั้งสิทธิ์โฟลเดอร์สำหรับ Laravel (ใช้ -R ตัวใหญ่ = Recursive เท่านั้น บน Alpine ตัวเล็ก -r ใช้ไม่ได้)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# รัน Migration + Seeder อัตโนมัติทุกครั้งที่ Container เริ่มทำงาน (ทั้งตอน Deploy ใหม่ และตอนตื่นจาก Sleep Mode บน Free Tier)
# หมายเหตุ: Render Free Plan ไม่มี Shell/One-Off Jobs ให้ (เป็นฟีเจอร์ของแพลนเสียเงิน)
# จึงต้องผูก db:seed ไว้ในนี้ด้วย โดย Seeder ของโปรเจกต์นี้ถูกเขียนให้ idempotent (ใช้ firstOrCreate) จึงรันซ้ำได้อย่างปลอดภัย ไม่สร้างข้อมูลซ้ำ
# หมายเหตุ: ถ้า migrate/seed ล้มเหลว container จะไม่ start และ Render จะโชว์ error ใน Logs ทันที
#
# storage:link --force: สร้าง symlink public/storage → storage/app/public
# เพื่อให้รูปแจ้งเหตุ (photo_url) เปิดผ่าน /storage/incidents/... ได้
# (ต้องรันตอน start ทุกครั้ง เพราะ filesystem ของ Render Free เป็นแบบชั่วคราว)
#
# ${PORT:-80}: Render กำหนดพอร์ตผ่านตัวแปร PORT - ถ้าไม่มี (รัน local) ใช้ 80
CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && php artisan storage:link --force && php artisan serve --host=0.0.0.0 --port=${PORT:-80}"]
