<?php

namespace App\Models\Post\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use App\Enums\HasValues;

enum Status: string implements HasLabel, HasColor, HasIcon
{
    use HasValues;

    case Draft     = 'draft';
    case Published = 'published';
    case Scheduled = 'scheduled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft     => '草稿',
            self::Published => '公開',
            self::Scheduled => '排程',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft     => 'gray',
            self::Published => 'success',
            self::Scheduled => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'heroicon-m-pencil',
            self::Published => 'heroicon-m-eye',
            self::Scheduled => 'heroicon-m-clock',
        };
    }

    public static function parse(self | string $value): self
    {
        if ($value instanceof self) return $value;
        return self::from($value);
    }

    public static function isDraft(self | string $value): bool
    {
        return self::parse($value) === self::Draft;
    }

    public static function isPublished(self | string $value): bool
    {
        return self::parse($value) === self::Published;
    }

    public static function isScheduled(self | string $value): bool
    {
        return self::parse($value) === self::Scheduled;
    }
}
