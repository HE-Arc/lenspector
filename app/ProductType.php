<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product';

    /*
     * Get the products associated with the product type.
     */
    public function product()
    {
        return $this->hasMany('App\Product', 'productId');
    }
}
