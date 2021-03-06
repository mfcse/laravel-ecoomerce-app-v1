<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\EmailOrderNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function showCart()
    {
        //session()->flush();
        $data = [];
        $data['cart'] = session()->has('cart') ? session()->get('cart') : [];
        $data['total'] = array_sum(array_column($data['cart'], 'total_price'));

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

    public function checkout()
    {
        $data = [];
        $data['cart'] = session()->has('cart') ? session()->get('cart') : [];
        $data['total'] = array_sum(array_column($data['cart'], 'total_price'));

        // dd($data);

        return view('frontend.checkout', $data);
    }
    public function processOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_phone_number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cart = session()->has('cart') ? session()->get('cart') : [];
        $total = array_sum(array_column($cart, 'total_price'));

        $data = [
            'user_id' => auth()->user()->id,
            'customer_name' => $request->customer_name,
            'customer_phone_number' => $request->customer_phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'total_amount' => $total,
            'paid_amount' => $total,
            'payment_details' => 'Cash On Delievery'

        ];

        try {
            $order = Order::create($data);

            //creating one to many relations on products()

            foreach ($cart as $product_id => $product) {
                $order->products()->create([
                    'product_id' => $product_id,
                    'quantity' => $product['quantity'],
                    'price' => $product['total_price'],
                ]);
            }

            auth()->user()->notify(new EmailOrderNotification($order));

            session()->forget(['total', 'cart']);

            $this->setSuccess('Order placed successfully');

            return redirect()->route('order.details', $order->id);
        } catch (Exception $e) {

            $this->setDanger($e->getMessage());

            return redirect()->back();
        }
    }
    public function showOrder($id)
    {
        $data = [];
        $data['order'] = Order::with('products', 'products.product')->findOrFail($id);
        return view('frontend.orders.details', $data);
    }
}