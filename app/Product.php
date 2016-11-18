<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lense';

    /*
     * Get the product type associated with the product.
     */
    public function type()
    {
        return $this->belongsTo('App\ProductType', 'productId');
    }

    /*
     * Get the status associated with the product.
     */
    public function status()
    {
        return $this->hasOne('App\InventoryStatus', 'status');
    }
}
