<?php

namespace App\Http\Controllers;

use App\Http\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    public function index(Request $request)
    {
        $carts = Carts::where(['user_id' => Auth::user()->id])->paginate(10)->appends($request->only('Carts'));

        return view('carts.index', compact('carts'));
    }

    public function create(Request $request)
    {
        $cart = Carts::where(['product_id' => $request->get('product_id'), 'user_id' => Auth::user()->id])->first();
        if (empty($cart)) {
            $cart = new Carts();
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $request->get('product_id');
            $cart->cantity = $request->get('cantity');
        } else {
            $cart->cantity += $request->get('cantity');
        }

        if ($cart->save()) {
            return json_encode(['Cart' => $cart, 'total' => Carts::getTotal(), 'count' => Carts::getProductsInCartCount()]);
        } else {
            return json_encode(false);
        }
    }

    public function update($id, Request $request)
    {
        /** @var Carts $cart */
        $cart = Carts::find($id);
        if (!empty($cart)) {
            $cart->cantity = $request->get('cantity');
            $cart->save();

            return json_encode(['Cart' => $cart, 'total' => Carts::getTotal(), 'count' => Carts::getProductsInCartCount()]);
        } else {
            return json_encode(false);
        }
    }

    public function delete($id)
    {
        $model = new Carts();
        $cart = $model->find($id);
        if (!empty($cart)) {
            $cart->delete();
            return json_encode(['Cart' => $cart, 'total' => Carts::getTotal(), 'count' => Carts::getProductsInCartCount()]);
        } else {
            return json_encode(false);
        }
    }
}
