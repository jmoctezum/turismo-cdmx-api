<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Obtiene los lugares asociados a esta categoría
     */
    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
