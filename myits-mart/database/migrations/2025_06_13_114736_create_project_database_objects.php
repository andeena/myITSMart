<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat semua objek database kustom.
     */
    public function up(): void
    {
        // ... (Schema::create untuk tabel pendukung seperti wishlists, dll. harus ada di file migrasi TERPISAH) ...

        // === MEMBUAT VIEW ===
        // CREATE OR REPLACE sudah idempotent, jadi ini aman.
        DB::unprepared('
            CREATE OR REPLACE VIEW v_user_order_history AS
            SELECT o.id AS order_id, o.order_date, o.status AS order_status, c.id AS customer_id, p.product_name, od.quantity, od.unit_price, (od.quantity * od.unit_price * (1 - od.discount)) AS subtotal
            FROM orders o JOIN order_details od ON o.id = od.order_id JOIN products p ON od.product_id = p.id JOIN customers c ON o.customer_id = c.id;

            CREATE OR REPLACE VIEW v_user_wishlist AS
            SELECT w.customer_id, p.id AS product_id, p.product_name, p.list_price, p.product_category
            FROM wishlists w JOIN products p ON w.product_id = p.id;
        ');

        // === MEMBUAT FUNCTION (Dengan Pola DROP IF EXISTS) ===
        DB::unprepared('
            DROP FUNCTION IF EXISTS IsProductInWishlist;
            CREATE FUNCTION IsProductInWishlist(p_customer_id INT, p_product_id INT)
            RETURNS TINYINT(1) DETERMINISTIC
            BEGIN
                DECLARE wishlist_count INT;
                SELECT COUNT(*) INTO wishlist_count FROM wishlists WHERE customer_id = p_customer_id AND product_id = p_product_id;
                RETURN IF(wishlist_count > 0, 1, 0);
            END;
        ');
        
        DB::unprepared('
            DROP FUNCTION IF EXISTS CalculateShippingCost;
            CREATE FUNCTION CalculateShippingCost(p_total_weight_kg DECIMAL(10,2))
            RETURNS DECIMAL(19,4) DETERMINISTIC
            BEGIN
                IF p_total_weight_kg <= 0 THEN RETURN 0;
                ELSEIF p_total_weight_kg <= 1 THEN RETURN 10000;
                ELSE RETURN 10000 + ((p_total_weight_kg - 1) * 5000);
                END IF;
            END;
        ');

        // === MEMBUAT TRIGGER (Dengan Pola DROP IF EXISTS) ===
        DB::unprepared('
            DROP TRIGGER IF EXISTS after_customer_registration_welcome;
            CREATE TRIGGER after_customer_registration_welcome
            AFTER INSERT ON customers
            FOR EACH ROW
            BEGIN
                INSERT INTO user_notifications (customer_id, message, created_at, updated_at)
                VALUES (NEW.id, "Selamat datang di myITSMart! Terima kasih telah bergabung.", NOW(), NOW());
            END;
        ');

        DB::unprepared('
            DROP TRIGGER IF EXISTS after_order_completed_add_points;
            CREATE TRIGGER after_order_completed_add_points
            AFTER UPDATE ON orders
            FOR EACH ROW
            BEGIN
                DECLARE total_spent DECIMAL(19, 4);
                DECLARE points_to_add INT;
                IF NEW.status = "Completed" AND OLD.status <> "Completed" THEN
                    SELECT SUM(quantity * unit_price) INTO total_spent FROM order_details WHERE order_id = NEW.id;
                    SET points_to_add = FLOOR(total_spent / 10000);
                    IF points_to_add > 0 THEN
                        UPDATE customers SET loyalty_points = loyalty_points + points_to_add WHERE id = NEW.customer_id;
                        INSERT INTO user_notifications (customer_id, message, created_at, updated_at)
                        VALUES (NEW.customer_id, CONCAT("Selamat! Anda mendapatkan ", points_to_add, " poin dari pesanan #", NEW.id), NOW(), NOW());
                    END IF;
                END IF;
            END;
        ');
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        // Method down() tetap sama, berisi perintah DROP untuk membersihkan
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_completed_add_points');
        DB::unprepared('DROP TRIGGER IF EXISTS after_customer_registration_welcome');
        DB::unprepared('DROP FUNCTION IF EXISTS CalculateShippingCost');
        DB::unprepared('DROP FUNCTION IF EXISTS IsProductInWishlist');
        DB::unprepared('DROP VIEW IF EXISTS v_user_wishlist');
        DB::unprepared('DROP VIEW IF EXISTS v_user_order_history');
    }
};