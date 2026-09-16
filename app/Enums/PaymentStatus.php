<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case UNPAID = 'UNPAID';
    case PAID = 'PAID';
    case EXPIRED = 'EXPIRED';
    case FAILED = 'FAILED';

    public function label(): string
    {
        return match($this) {
            self::UNPAID => 'Belum Dibayar',
            self::PAID => 'Lunas',
            self::EXPIRED => 'Kadaluarsa',
            self::FAILED => 'Gagal',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::UNPAID => 'bg-amber-500/15 text-amber-400 border border-amber-500/30',
            self::PAID => 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30',
            self::EXPIRED => 'bg-slate-500/15 text-slate-400 border border-slate-500/30',
            self::FAILED => 'bg-rose-500/15 text-rose-400 border border-rose-500/30',
        };
    }
}
