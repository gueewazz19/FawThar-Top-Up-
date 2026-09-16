<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING_PAYMENT = 'PENDING_PAYMENT';
    case PAID = 'PAID';
    case PROCESSING = 'PROCESSING';
    case SUCCESS = 'SUCCESS';
    case FAILED = 'FAILED';
    case CANCELLED = 'CANCELLED';
    case REFUNDED = 'REFUNDED';
    case TOPUP_FAILED = 'TOPUP_FAILED';

    public function label(): string
    {
        return match($this) {
            self::PENDING_PAYMENT => 'Menunggu Pembayaran',
            self::PAID => 'Pembayaran Berhasil',
            self::PROCESSING => 'Sedang Diproses',
            self::SUCCESS => 'Selesai / Berhasil',
            self::FAILED => 'Gagal',
            self::CANCELLED => 'Dibatalkan',
            self::REFUNDED => 'Dikembalikan (Refund)',
            self::TOPUP_FAILED => 'Top-up Gagal (Review)',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING_PAYMENT => 'bg-amber-500/15 text-amber-400 border border-amber-500/30',
            self::PAID => 'bg-blue-500/15 text-blue-400 border border-blue-500/30',
            self::PROCESSING => 'bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 animate-pulse',
            self::SUCCESS => 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30',
            self::FAILED, self::CANCELLED => 'bg-rose-500/15 text-rose-400 border border-rose-500/30',
            self::REFUNDED => 'bg-purple-500/15 text-purple-400 border border-purple-500/30',
            self::TOPUP_FAILED => 'bg-orange-500/15 text-orange-400 border border-orange-500/30',
        };
    }
}
