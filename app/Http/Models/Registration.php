<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
 protected $fillable = [
    'user_id',
    'registration_number',
    // --- Tambahan Baru ---
    'full_name',
    'nickname',
    'child_order',
    'siblings_count',
    'kip_number',
    'previous_school_name',
    'previous_school_address',
    'nisn',
    'nomor_ijazah',
    // ---------------------
    'level',
    'place_of_birth',
    'date_of_birth',
    'gender',
    'status',
    'snap_token',
    'admin_note', // --- Tambahan Baru ---
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Tambahkan ini di dalam class Registration
    public function parentDetail()
    {
    return $this->hasOne(ParentDetail::class);
    }

    public function documents()
    {
    return $this->hasMany(Document::class);
    }
}