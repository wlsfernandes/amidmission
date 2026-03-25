<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

                                            // ----------------------------------
                                            // Polymorphic "what is this payment for"
                                            // ----------------------------------
            $table->string('payable_type'); // Donation, Orderrder, Subscription, etc.
            $table->unsignedBigInteger('payable_id');

            // ----------------------------------
            // Stripe references
            // ----------------------------------
            $table->string('stripe_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent_id')->nullable()->unique();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_customer_id')->nullable();

            // ----------------------------------
            // Payment details
            // ----------------------------------
            $table->enum('payment_type', ['one_time', 'subscription'])->default('one_time');
            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'refunded',
                'canceled',
            ])->default('pending');

            $table->integer('amount'); // stored in cents
            $table->string('currency', 10)->default('usd');

            // ----------------------------------
            // Customer info (snapshot)
            // ----------------------------------
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country')->nullable();
            $table->text('address')->nullable();

            // ----------------------------------
            // Meta / audit
            // ----------------------------------
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['payable_type', 'payable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
