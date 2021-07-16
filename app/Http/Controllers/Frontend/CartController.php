<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function showCart()
    {
        //session()->flush();
        $data = [];
        $data['cart'] = session()->has('cart') ? session()->get('cart') : [];
        $data['total'] = array_sum(array_column($data['cart'], 'price'));

        return view('frontend.cart', $data);
    }
    public function addToCart(Request $request)
    {
        try {
            $this->validate($request, [
                'product_id' => 'required',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back();
        }
        $product = Product::findOrFail($request->product_id);
        $unit_price = ($product->sale_price || $product->sale_price > 0) ? $product->sale_price : $product->price;

        $cart = session()->has('cart') ? session()->get('cart') : [];

        // if (session()->has('cart')) {
        //     $cart = session('cart');

        if (array_key_exists($product->id, $cart)) {
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['total_price'] = $cart[$product->id]['quantity'] *  $cart[$product->id]['unit_price'];
            //dd($cart['products']);
        } else {
            $cart[$product->id] = [
                'title' => $product->title,
                'quantity' => 1,
                'unit_price' => $unit_price,
                'total_price' => $unit_price
            ];
        }

        //dd(session()->get('cart'));

        session()->flash('message', $product->title . ' Added to Cart');

        session(['cart' => $cart]);

        return redirect()->route('cart.show');
    }

    public function removeFromCart(Request $request)
    {

        try {
            $this->validate($request, [
                'product_id' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back();
        }

        $cart = session()->has('cart') ? session()->get('cart') : [];

        unset($cart[$request->product_id]);
        session(['cart' => $cart]);

        session()->flash('message', 'Product removed from your Cart');
        return redirect()->back();
    }
    public function clearCart()
    {
        session(['cart' => []]);
        return redirect()->back();
    }
}