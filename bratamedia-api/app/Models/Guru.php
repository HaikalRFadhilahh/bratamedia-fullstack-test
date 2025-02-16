<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    /** @use HasFactory<\Database\Factories\GuruFactory> */
    use HasFactory;

    // Select table Name
    protected $table = 'guru';


    // protect field id
    protected $guarded = [
        'id'
    ];

    // Relation (Table Guru)
    public function mataPelajaran(): HasMany
    {
        return $this->hasMany(MataPelajaran::class, 'guru_id', 'id');
    }

    public function guruKelas(): HasMany
    {
        return $this->hasMany(GuruKelas::class, 'guru_id', 'id');
    }
}
