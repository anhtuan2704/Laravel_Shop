<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'slider_name', 'slider_status', 'slider_image',
        'slider_desc'
    ];
    protected $primaryKey = 'slider_id ';
    protected $table = 'tbl_slider';
}
