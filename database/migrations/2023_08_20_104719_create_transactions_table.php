<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount', 24, 2);
            $table->decimal('charge', 24, 2)->default(0);
            $table->decimal('discount_amount', 24, 2)->default(0);
            $table->enum('trx_type', ['+', '-']);
            $table->string('trx');
            $table->string('details')->nullable();
            $table->string('remark')->nullable();
            $table->json('query1')->default("{}");
            $table->enum("status", ["pending", "completed", "cancelled", "failed"])->default("pending");
            $table->enum("payment_method", ["office", "online"])->default("online");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
