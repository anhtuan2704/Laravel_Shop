<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fee_matp', 'fee_maqh', 'fee_xaid', 'fee_feeship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship';

    public function city(){
        return $this->belongsTo('App\city','fee_matp');
    }
    public function province(){
        return $this->belongsTo('App\province','fee_maqh');
    }
    public function wards(){
        return $this->belongsTo('App\wards','fee_xaid');
    }
}
