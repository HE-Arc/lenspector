<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryStatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_status';
    /**
     * Timestamps field activition.
     * @var bool
     */
    public $timestamps = false;
}
