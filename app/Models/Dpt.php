<?php

namespace App\Models;

use App\Models\Dpt;
// use App\Models\Pendukung;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dpt extends Model
{
    use HasFactory;
    protected $table = 'dpts';
    protected $guarded = ['id'];

    public function pendukung()
    {
        return $this->hasMany(Pendukung::class, 'dpt_id', 'id');
    }

}
