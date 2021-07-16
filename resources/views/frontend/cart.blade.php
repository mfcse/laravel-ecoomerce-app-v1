@extends('frontend.layouts.master')
@section('main')
 <div class="container">
     <div class="row">
         <div class="col-md-12">
            <h3 class="text-center mt-5">Cart</h3>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{session()->get('message')}}
                </div>
            @endif

            @if (empty($cart))
            <div class="alert alert-info">
                Add Some Products on the Cart
            </div>
            @else
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Serial</th>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($cart as $key=>$product)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$product['title']}}</td>
                        <td>BDT {{$product['unit_price']}}</td>
                        <td><input type="number" name="quantity" value="{{$product['quantity']}}"></td>
                        <td>BDT {{$product['total_price']}}</td>
                        <td>
                            <form action="{{route('cart.remove')}}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$key}}">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Delete</button>
                              </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td>BDT {{number_format($total,2)}}</td>
                        <td></td>
                    </tr>
                </tbody>
            
            </table>

            <a href="{{route('cart.clear')}}" class="alert alert-danger">Clear</a>
            @endif
           
        </div>
         </div>
     </div>
     
    
@endsection