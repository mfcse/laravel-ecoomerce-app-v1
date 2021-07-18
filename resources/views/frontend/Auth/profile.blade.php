@extends('frontend.layouts.master')
@section('main')
 <div class="container mb-5">
    <h3 class="text-center mt-5 mb-5">
        My Profile
    </h3>
    <hr>

    <h4 style="margin-top: 50px; margin-bottom:20px;">My Orders</h4>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Customer Phone Number</th>
            <th>Total Amount</th>
            <th>Paid Amount</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->customer_phone_number}}</td>
                    <td>{{$order->total_amount}}</td>
                    <td>{{$order->paid_amount}}</td>
                    <td>
                        <a href="{{route('order.details',$order->id)}}">Order Details</a>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
 </div>
    
@endsection