<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'type'
    ];

    public function scopeSearch($query, $data)
    {
        $query = $this->newQuery();
        $query->from('products as p');

        if (!empty($data['id'])) {
            $query->where('p.id', '=', $data['id']);
        }
        if (!empty($data['name'])) {
            $query->where('p.name', 'LIKE', '%' . $data['name'] . '%');
        }
        if (!empty($data['description'])) {
            $query->where('p.description', 'LIKE', '%' . $data['description'] . '%');
        }
        if (!empty($data['price'])) {
            $query->where('p.price', '=', $data['price']);
        }
        if (!empty($data['type'])) {
            $query->where('p.type', '=', $data['type']);
        }
        return $query;
    }
}
