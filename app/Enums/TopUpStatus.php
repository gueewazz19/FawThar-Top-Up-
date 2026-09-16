<?php

namespace App\Enums;

enum TopUpStatus: string
{
    case PENDING = 'PENDING';
    case PROCESSING = 'PROCESSING';
    case SUCCESS = 'SUCCESS';
    case FAILED = 'FAILED';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Menunggu Provider',
            self::PROCESSING => 'Sedang Diproses Game',
            self::SUCCESS => 'Item Terkirim',
            self::FAILED => 'Gagal Terkirim',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'bg-amber-500/15 text-amber-400 border border-amber-500/30',
            self::PROCESSING => 'bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 animate-pulse',
            self::SUCCESS => 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30',
            self::FAILED => 'bg-rose-500/15 text-rose-400 border border-rose-500/30',
        };
    }
}
