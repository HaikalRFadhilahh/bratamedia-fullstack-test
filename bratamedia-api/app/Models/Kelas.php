<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    /** @use HasFactory<\Database\Factories\KelasFactory> */
    use HasFactory;

    // Select table Name
    protected $table = 'kelas';


    // protect field id
    protected $guarded = [
        'id'
    ];



    // Relation (Table Kelas)
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'id');
    }

    public function guruKelas(): HasMany
    {
        return $this->hasMany(GuruKelas::class, 'kelas_id', 'id');
    }
}
