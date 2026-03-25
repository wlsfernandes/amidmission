<?php

namespace App\Enums;

enum SocialPlatform: string
{
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case X = 'x';
    case LinkedIn = 'linkedin';
    case YouTube = 'youtube';
    case TikTok = 'tiktok';
    case Threads = 'threads';

    /**
     * Label for admin UI
     */
    public function label(): string
    {
        return match ($this) {
            self::Facebook => 'Facebook',
            self::Instagram => 'Instagram',
            self::X => 'X (Twitter)',
            self::LinkedIn => 'LinkedIn',
            self::YouTube => 'YouTube',
            self::TikTok => 'TikTok',
            self::Threads => 'Threads',
        };
    }

    /**
     * FontAwesome icon class
     */
    public function icon(): string
    {
        return match ($this) {
            self::Facebook => 'fab fa-facebook',
            self::Instagram => 'fab fa-instagram',
            self::X => 'fab fa-x-twitter',
            self::LinkedIn => 'fab fa-linkedin',
            self::YouTube => 'fab fa-youtube',
            self::TikTok => 'fab fa-tiktok',
            self::Threads => 'fab fa-threads',
        };
    }
}
