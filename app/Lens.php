<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lens extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lense';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status'];

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
        return $this->belongsTo('App\InventoryStatus', 'status');
    }

    /**
     * Get the product's diopter formatted with one decimal.
     *
     * @param  string  $diopter
     * @return string
     */
    public function getSphCorrectedAttribute($diopter)
    {
        return number_format($diopter, 1, '.', ',');
    }
}
