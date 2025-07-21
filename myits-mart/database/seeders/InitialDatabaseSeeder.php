<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Shipper;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

// class InitialDatabaseSeeder extends Seeder
// {
//     public function run(): void
//     {
        // $now = Carbon::now();

        // // 1. Tambah Customer
        // $customer = Customer::create([
        //     'name'           => 'Andina Test 2',
        //     'email_address'  => 'andinatest2@mail.com',
        //     'mobile_phone'   => '08123456789',
        //     'address'        => 'Jl. Contoh No.123',
        //     'password'       => Hash::make('andinatest2'),
        //     'membership'     => false,
        //     'loyalty_points' => 0,
        //     'created_at'     => $now,
        //     'updated_at'     => $now,
        // ]);

        // // 2. Tambah User dengan customer_id
        // $user = User::create([
        //     'name'              => 'Andina Test 2',
        //     'email'             => 'andinatest2@mail.com',
        //     'password'          => Hash::make('andinatest2'),
        //     'role'              => 'customer',
        //     'customer_id'       => $customer->id,
        //     'email_verified_at' => $now,
        //     'remember_token'    => Str::random(60),
        //     'created_at'        => $now,
        //     'updated_at'        => $now,
        // ]);

        // // 3. Tambah Shipper
        // $shipper = Shipper::create([
        //     'company_name'       => 'FastExpress',
        //     'phone'      => '081234567890',
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);

        // // 4. Tambah Produk
        // $product1 = Product::create([
        //     'name'        => 'Produk A',
        //     'description' => 'Deskripsi Produk A',
        //     'price'       => 12000,
        //     'stock'       => 100,
        //     'created_at'  => $now,
        //     'updated_at'  => $now,
        // ]);

        // $product2 = Product::create([
        //     'name'        => 'Produk B',
        //     'description' => 'Deskripsi Produk B',
        //     'price'       => 25000,
        //     'stock'       => 50,
        //     'created_at'  => $now,
        //     'updated_at'  => $now,
        // ]);

        // // 5. Tambah Order
        // $order = Order::create([
        //     'customer_id'   => $customer->id,
        //     'shipper_id'    => $shipper->id,
        //     'order_date'    => $now,
        //     'ship_address'  => 'Jl. Testing No.123',
        //     'total_amount'  => 37000,
        //     'status'        => 'Completed',
        //     'shipping_fee'  => 0,
        //     'created_at'    => $now,
        //     'updated_at'    => $now,
        // ]);

        // // 6. Tambah Order Items
        // OrderItem::create([
        //     'order_id'   => $order->id,
        //     'product_id' => $product1->id,
        //     'quantity'   => 1,
        //     'price'      => 12000,
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);

        // OrderItem::create([
        //     'order_id'   => $order->id,
        //     'product_id' => $product2->id,
        //     'quantity'   => 1,
        //     'price'      => 25000,
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);
//     }
// }
