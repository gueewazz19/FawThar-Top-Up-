<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'provider',
        'provider_id',
        'role',
        'password',
        'last_login_at',
        'last_login_ip',
    ];

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }
            return asset($this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D8ABC&color=fff&bold=true';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getLoyaltyTierAttribute(): array
    {
        $ordersCount = $this->orders()->where('status', \App\Enums\OrderStatus::SUCCESS)->count();

        if ($ordersCount >= 30) {
            return ['name' => 'Diamond Legend', 'badge' => 'bg-cyan-500/15 text-cyan-400 border-cyan-500/30', 'icon' => '💎'];
        } elseif ($ordersCount >= 15) {
            return ['name' => 'Gold Pro', 'badge' => 'bg-amber-500/15 text-amber-400 border-amber-500/30', 'icon' => '👑'];
        } elseif ($ordersCount >= 5) {
            return ['name' => 'Silver Gamer', 'badge' => 'bg-slate-400/15 text-slate-300 border-slate-400/30', 'icon' => '⭐'];
        } else {
            return ['name' => 'Bronze Rookie', 'badge' => 'bg-orange-500/15 text-orange-400 border-orange-500/30', 'icon' => '🥉'];
        }
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function voucherUsages(): HasMany
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
