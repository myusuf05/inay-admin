# Requirement for Developer

-   PHP 8.0.2 keatas
-   Composer
-   Laragon/XAMPP/WAMPP

# Tutorial Instalasi

1. Buka terminal/CMD/Console di project
2. Ketik **composer install**
3. Buat database 'sips_inay'
4. Ketik **php artisan migrate:refresh**
5. Ketik **php artisan db:seed**
6. For development, **php artisan serve**

# Catatan

Alur membuat Rest Api di postman

1.  membuat collection baru
2.  membuat url pada fitur variabel
    -   membuat environment yang sama pada collection
    -   memberikan nama variabel di dalam tabel semisal url
    -   menyalin link website kemudian di paste initial value
    -   kemudian klik save
3.  masuk pada halaman collection

    -   klik fitur get data untuk menguji data yang akan dari website
    -   pada baris get ketik {{ url }} / nama variabel yang telah dibuat
    -   klik environment yang telah dibuat tadi
    -   klik send untuk mengecek data terkirim atau tidak
        nullable -> berfungsi untuk memperbolehkan data kolom kosong/NULL
# inay-admin
