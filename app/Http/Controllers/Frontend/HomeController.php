<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        $data['products'] = Product::select(['id', 'title', 'slug', 'price'])->where('active', 1)->paginate(9);

        //dd($data['products']);

        return view('frontend.home', $data);
    }
}