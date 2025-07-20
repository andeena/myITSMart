<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW v_order_history AS
            SELECT
                o.id AS order_id,
                o.order_date AS order_date,
                o.status AS order_status,
                o.customer_id AS customer_id,
                u.name AS customer_name,
                p.id AS product_id,
                p.product_name AS product_name,
                p.image AS product_image, -- Menambahkan kolom image
                od.quantity AS quantity,
                od.unit_price AS unit_price,
                (od.quantity * od.unit_price) AS subtotal
            FROM
                orders AS o
            JOIN
                users AS u ON o.customer_id = u.id
            JOIN
                order_details AS od ON o.id = od.order_id
            JOIN
                products AS p ON od.product_id = p.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_order_history");
    }
};