<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $guarded = ['id'];


    public function kategori(){
        return $this->belongsTo(kategori::class);
    }
}
