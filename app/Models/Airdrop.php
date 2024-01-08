<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airdrop extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'sudah_dikerjakan' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
