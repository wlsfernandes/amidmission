<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * ----------------------------------
     * Mass assignable fields
     * ----------------------------------
     */
    protected $fillable = [
        // Polymorphic target
        'payable_type',
        'payable_id',

        // Stripe references
        'stripe_session_id',
        'stripe_payment_intent_id',
        'stripe_subscription_id',
        'stripe_customer_id',

                        // Payment info
        'payment_type', // one_time | subscription
        'status',       // pending | completed | failed | refunded | canceled
        'amount',       // stored in cents
        'currency',

        // Customer snapshot
        'email',
        'first_name',
        'last_name',
        'country',
        'address',

        // Meta / audit
        'metadata',
        'paid_at',

        'order_id',
    ];

    /**
     * ----------------------------------
     * Casts
     * ----------------------------------
     */
    protected $casts = [
        'metadata' => 'array',
        'paid_at'  => 'datetime',
    ];

    /**
     * ----------------------------------
     * Relationships
     * ----------------------------------
     */
    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * ----------------------------------
     * Helpers / Accessors
     * ----------------------------------
     */

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isSubscription(): bool
    {
        return $this->payment_type === 'subscription';
    }

    public function getAmountFormattedAttribute(): string
    {
        return strtoupper($this->currency) . ' ' . number_format($this->amount / 100, 2);
    }

    public function getCustomerNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    // 🔑 THIS IS THE IMPORTANT ONE
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
