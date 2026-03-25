<?php

namespace App\Services;

use App\Models\DeveloperSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class RuntimeConfigService
{
    /* ==========================================================
     | AWS / S3
     ========================================================== */
    public static function applyS3Config(): void
    {
        try {
            if (!Schema::hasTable('developer_settings'))
                return;

            $s = DeveloperSetting::current();

            if (!$s->aws_enabled)
                return;

            Config::set('filesystems.disks.s3.key', $s->aws_access_key_id);
            Config::set('filesystems.disks.s3.secret', $s->aws_secret_access_key);
            Config::set('filesystems.disks.s3.region', $s->aws_default_region);
            Config::set('filesystems.disks.s3.bucket', $s->aws_bucket);
            Config::set('filesystems.disks.s3.throw', (bool) $s->aws_debug);

        } catch (\Throwable $e) {
        }
    }

    /* ==========================================================
     | Stripe
     ========================================================== */
    public static function applyStripeConfig(): void
    {
        try {
            if (!Schema::hasTable('developer_settings')) {
                return;
            }

            $s = DeveloperSetting::current();

            // ✅ Enable Stripe if secret exists
            if (empty($s->stripe_secret)) {
                return;
            }

            Config::set('services.stripe.key', $s->stripe_key);
            Config::set('services.stripe.secret', $s->stripe_secret);
            Config::set('services.stripe.currency', $s->stripe_currency ?? 'usd');

        } catch (\Throwable $e) {
            // never crash boot
        }
    }

    /* ==========================================================
     | PayPal
     ========================================================== */
    public static function applyPaypalConfig(): void
    {
        try {
            if (!Schema::hasTable('developer_settings'))
                return;

            $s = DeveloperSetting::current();

            if (!$s->paypal_enabled)
                return;

            Config::set('services.paypal.client_id', $s->paypal_live_client_id);
            Config::set('services.paypal.secret', $s->paypal_live_client_secret);
            Config::set('services.paypal.currency', $s->paypal_live_currency);

        } catch (\Throwable $e) {
        }
    }

    /* ==========================================================
     | Mail
     ========================================================== */
    public static function applyMailConfig(): void
    {
        try {
            if (!Schema::hasTable('developer_settings'))
                return;

            $s = DeveloperSetting::current();

            if (!$s->mail_enabled)
                return;

            Config::set('mail.default', $s->mail_mailer);
            Config::set('mail.mailers.smtp.host', $s->mail_host);
            Config::set('mail.mailers.smtp.port', $s->mail_port);
            Config::set('mail.mailers.smtp.username', $s->mail_username);
            Config::set('mail.mailers.smtp.password', $s->mail_password);
            Config::set('mail.mailers.smtp.encryption', $s->mail_encryption);

            Config::set('mail.from.address', $s->mail_from_address);
            Config::set('mail.from.name', $s->mail_from_name);

        } catch (\Throwable $e) {
        }
    }

    /* ==========================================================
     | Queue
     ========================================================== */
    public static function applyQueueConfig(): void
    {
        try {
            if (!Schema::hasTable('developer_settings'))
                return;

            $s = DeveloperSetting::current();

            if (!$s->queue_enabled)
                return;

            Config::set('queue.default', $s->queue_connection);

        } catch (\Throwable $e) {
        }
    }
}
