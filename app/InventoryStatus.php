<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class InventoryStatus extends Model
{
    use Sluggable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_statuses';
    /**
     * Timestamps field activition.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'unique' => true,
                'onUpdate' => true,
                ],
        ];
    }

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->slug;
    }
}
