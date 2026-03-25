<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Optional user (guest checkout allowed)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Order identity
            $table->string('order_number')->unique();

            // Status lifecycle
            $table->string('status')->default('pending');
            // pending | paid | processing | shipped | delivered | cancelled | refunded

            // Totals
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Address snapshot
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('country')->nullable();
            $table->string('address')->nullable();

            // Meta
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
