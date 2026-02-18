<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users (Admin, Kasir, Dapur)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'cashier', 'kitchen'])->default('cashier');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Categories (Makanan, Minuman)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['food', 'drink', 'snack']);
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        // 3. Products (Menu)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price', 12, 2); // Cukup untuk Rupiah
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Tables (Meja)
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->timestamps();
        });

        // 5. Shifts (PENTING: Kontrol Uang Kasir)
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Siapa yang shift
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->decimal('start_cash', 12, 2); // Modal awal
            $table->decimal('expected_cash', 12, 2)->default(0); // Hitungan sistem
            $table->decimal('actual_end_cash', 12, 2)->nullable(); // Input fisik kasir
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });

        // 6. Orders (Transaksi)
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained(); // Link ke shift kasir
            $table->foreignId('table_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained(); // Kasir yang input
            $table->string('customer_name')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->enum('payment_method', ['cash', 'qris']);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // 7. Order Items (Detail Pesanan)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
            $table->decimal('price', 12, 2); // Snapshot harga saat beli
            $table->string('note')->nullable(); // "Jangan pedas"
            $table->timestamps();
        });
        
        // Sessions (Wajib untuk Login Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        // Hapus tabel dengan urutan terbalik agar tidak error FK
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('tables');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
};