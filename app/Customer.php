<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Customer extends Model
{
    use Sluggable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'department',
        'street_name',
        'building_number',
        'post_code',
        'city',
        'country_id',
        'phone_number',
        'fax_number',
        'email',
        'vat',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'company_name',
                'unique' => true,
                'onUpdate' => true,
                ],
        ];
    }

    /*
     * Get the country associated with the customer.
     */
    public function country()
    {
        return $this->hasOne('App\Country');
    }
}
