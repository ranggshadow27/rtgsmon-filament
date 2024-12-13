<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteMonitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'terminal_id', 'sitecode', 'modem', 'mikrotik', 'ap1', 'ap2',
        'modem_last_up', 'mikrotik_last_up', 'ap1_last_up', 'ap2_last_up', 'status'
    ];

    protected $casts = [
        'modem_last_up' => 'datetime',
        'mikrotik_last_up' => 'datetime',
        'ap1_last_up' => 'datetime',
        'ap2_last_up' => 'datetime',
    ];
}
