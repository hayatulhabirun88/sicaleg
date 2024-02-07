<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendukung extends Model
{
    use HasFactory;
    protected $table = 'pendukungs';
    protected $guarded = ['id'];

    public function caleg(){
        return $this->belongsTo(Caleg::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function dpts(){
        return $this->belongsTo(Dpt::class, 'dpt_id', 'id');
    }


}
