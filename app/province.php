<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name_quanhuyen', 'type','matp'
    ];
    protected $primaryKey = 'maqh';
    protected $table = 'tbl_quanhuyen';
}
