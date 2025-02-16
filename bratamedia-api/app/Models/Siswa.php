<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    /** @use HasFactory<\Database\Factories\SiswaFactory> */
    use HasFactory;

    // Select table Name
    protected $table = 'siswa';


    // protect field id
    protected $guarded = [
        'id'
    ];

    // Relation (Table Siswa)
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(kelas::class, 'kelas_id', 'id');
    }
}
