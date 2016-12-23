<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderElement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_elements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_type_id',
        'requested_diopter',
        'lens_id',
    ];

    /*
     * Get the order associated with the order element.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /*
     * Get the product type associated with the order element.
     */
    public function productType()
    {
        return $this->belongsTo('App\ProductType');
    }

    /*
     * Get the lens associated with the order element.
     */
    public function lens()
    {
        return $this->belongsTo('App\Lens');
    }
}
