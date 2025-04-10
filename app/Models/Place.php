<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'district', // Alcaldía
        'city',
        'state',
        'latitude',
        'longitude',
        'image_url',
        'category_id'
    ];

    /**
     * Obtiene la categoría asociada al lugar
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
