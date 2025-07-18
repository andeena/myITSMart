# myITS Mart

Selamat datang di myITS Mart! Ini adalah proyek website e-commerce yang dibangun menggunakan Laravel, difokuskan pada pengalaman berbelanja dari sisi pengguna. Aplikasi ini dirancang agar cepat, efisien, dan kaya akan fitur, meniru fungsionalitas aplikasi seperti Klik Indomaret atau Alfagift. myITS Mart dibangun sebagai implementasi Final Project untuk mata kuliah Manajemen Basis Data (MBD)

## Fitur Utama

- **Autentikasi Pengguna:** Sistem registrasi dan login yang aman.
- **Katalog Produk:** Menampilkan semua produk dengan paginasi dan kemampuan filter berdasarkan kategori.
- **Keranjang Belanja:** Fungsionalitas penuh untuk menambah, memperbarui, dan menghapus item dari keranjang.
- **Proses Checkout:** Alur checkout yang sederhana untuk membuat pesanan.
- **Dashboard Pengguna:** Halaman personal untuk setiap pengguna, berisi:
    - Statistik belanja dan level keanggotaan.
    - Riwayat pesanan yang detail.
    - Halaman Wishlist untuk produk favorit.
    - Halaman Riwayat Ulasan yang pernah diberikan.
- **Fitur Wishlist:** Tombol "suka" pada setiap produk di katalog dan halaman detail.
- **Sistem Ulasan Produk:** Kemampuan bagi pengguna untuk memberikan rating dan komentar pada produk yang telah mereka beli.

## Teknologi yang Digunakan

- **Framework:** Laravel 12
- **Bahasa:** PHP 8.2
- **Database:** MySQL / MariaDB
- **Frontend:** Blade Templates, Bootstrap 5, Tailwind CSS (untuk halaman login/register)
- **Fitur Tambahan:** Laravel Breeze untuk autentikasi.

## Fitur Database Lanjutan yang Diimplementasikan

#### 1. Database View
- **`v_order_history`**: Menggabungkan 4 tabel untuk menyajikan riwayat pesanan yang lengkap dengan cepat.
- **`v_customer_dashboard_stats`**: Menyajikan data statistik ringkas (total pesanan & belanja) untuk dashboard.
- **`v_user_wishlist`**: Menampilkan daftar produk di wishlist pengguna secara efisien.

#### 2. Query JOIN (Langsung di Controller)
- **Produk Terlaris:** Menampilkan 5 produk paling populer di halaman utama.
- **Rekomendasi Produk ("Juga Dibeli"):** Menyarankan produk relevan di halaman detail produk.
- **Riwayat Ulasan:** Mengambil daftar ulasan spesifik milik pengguna beserta nama produknya.

#### 3. Database Trigger
- **`after_order_detail_insert`**: Mengurangi stok produk secara otomatis setelah ada penjualan baru.
- **`before_review_insert_check_purchase`**: Mencegah ulasan palsu dengan memastikan hanya pembeli asli yang bisa memberikan ulasan.

#### 4. Database Function
- **`GetCustomerLevel`**: Menghitung level keanggotaan (Bronze, Silver, Gold) secara dinamis berdasarkan total belanja.
