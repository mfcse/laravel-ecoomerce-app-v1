@extends('frontend.layouts.master')
@section('main')
 <div class="container mb-5">
    <h3 class="text-center mt-5 mb-5">
        Order Details
    </h3>
    <hr>

    {{-- <h4 style="margin-top: 50px; margin-bottom:20px;">
        Order ID: {{$order->id}} 
    </h4>--}}
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                @foreach ($order->toArray() as $column=>$value)
                @if (is_string($value))
                    @if ($column==='user_id')
                        @continue
                    @endif
                    <li class="list-group-item"><strong>{{ucwords(str_replace('_',' ',$column))}}:</strong> {{$value}}</li>
                @endif   
                @endforeach
                
                {{-- <li class="list-group-item">Customer Name: {{$order->customer_name}}</li>
                <li class="list-group-item">Customer Phone Number: {{$order->customer_phone_number}}</li>
                <li class="list-group-item">Address: {{$order->address}}</li>
                <li class="list-group-item">City: {{$order->city}}</li>
                <li class="list-group-item">Postal Code: {{$order->postal_code}}</li> --}}
              </ul>
        </div>
        <div class="col-md-6">
            <h3>Ordered Products</h3>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Product Title</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{dd($order->products)}} --}}
                    @foreach ($order->products as $product)
                    <tr>
                        {{-- {{dd($product->order)}} --}}
                        <td>{{$product->product->title}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>{{number_format($product->price,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
 </div>
    
@endsection