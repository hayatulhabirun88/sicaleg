<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caleg extends Model
{
    use HasFactory;
    protected $table = 'calegs';
    protected $guarded = ['id'];

    public function pendukung()
    {
        return $this->hasMany(Pendukung::class, 'caleg_id', 'id');
    }

    public function partai()
    {
        return $this->belongsTo(Partai::class, 'partai_id', 'id');
    }
}
