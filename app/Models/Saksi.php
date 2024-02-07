<?php

namespace App\Models;

use App\Models\Tps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saksi extends Model
{
    use HasFactory;

    protected $table = "saksis";
    protected $guarded = ['id'];

    public function saksi()
    {
        return $this->belongsTo(Tps::class, 'tps_id', 'id');
    }
}
