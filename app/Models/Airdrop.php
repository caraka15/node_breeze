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

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });
            }
        });

        $query->when($filters['selesai'] ?? false, function ($query, $selesai) {
            if ($selesai !== null) {
                $query->where('selesai', $selesai);
            }
        });
    }
}
