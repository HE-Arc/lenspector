<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requested_at',
        'shipped_at',
        'awb',
        'note',
    ];

    /*
     * Get the order elements associated with the order.
     */
    public function orderElements()
    {
        return $this->hasMany('App\OrderElement');
    }

    /*
     * Get the type associated with the order.
     */
    public function orderType()
    {
        return $this->belongsTo('App\OrderType');
    }

    /*
     * Get the status associated with the order.
     */
    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus');
    }

    /*
     * Get the customer associated with the orders.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
