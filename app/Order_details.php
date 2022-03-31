<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_code', 'product_id', 'product_name','product_price',
        'product_sale_quantity','product_coupon','product_feeship'
    ];
    protected $primaryKey = 'order_details_id  ';
    protected $table = 'tbl_order_details';
}