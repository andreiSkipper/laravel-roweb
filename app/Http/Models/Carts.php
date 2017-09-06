<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Carts extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'cantity'
    ];

    public function user()
    {
        return $this->belongsTo('App\Http\Models\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Http\Models\Products');
    }


    public function scopeSearch($query, $data)
    {
        $query = $this->newQuery();
        $query->from('carts as c');

        if (!empty($data['id'])) {
            $query->where('c.id', '=', $data['id']);
        }
        if (!empty($data['user_id'])) {
            $query->where('c.user_id', '=', $data['user_id']);
        }
        if (!empty($data['product_id'])) {
            $query->where('c.product_id', '=', $data['product_id']);
        }
        if (!empty($data['cantity'])) {
            $query->where('c.cantity', '=', $data['cantity']);
        }
        return $query;
    }

    public static function getTotal()
    {
        $carts = Carts::where(['user_id' => Auth::user()->id])->get();
        $total = 0;
        foreach ($carts as $cart){
            $total += $cart->cantity * $cart->product->price;
        }

        return $total;
    }

    public static function getProductsInCartCount()
    {
        $carts = Carts::where(['user_id' => Auth::user()->id])->get();

        return count($carts);
    }
}
