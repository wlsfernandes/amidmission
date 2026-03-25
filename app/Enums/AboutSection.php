<?php

namespace App\Enums;

enum AboutSection: string
{
  case VISION = 'vision';
  case MISSION = 'mission';
  case VALUES = 'values';
  case WHO_WE_ARE = 'who_we_are';
  case PROBLEM = 'problem';
  case APPROACH = 'approach';
  case LEGACY = 'legacy';

  case HEADER = 'header';

  case NEW_WAY = 'new_way';

  public function label(): string
  {
    return match ($this) {
      self::VISION => 'Our Vision',
      self::MISSION => 'Our Mission',
      self::VALUES => 'Our Values',
      self::WHO_WE_ARE => 'Who We Are',
      self::PROBLEM => 'The Problem We Address',
      self::APPROACH => 'Our Approach',
      self::LEGACY => 'Our Legacy',
      self::HEADER => 'Header Section',
      self::NEW_WAY => 'A New Way',
    };
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }
}
