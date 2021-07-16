@extends('frontend.layouts.master')
@section('main')
    
  <div class="py-5 bg-light">
    <div class="container">

      <div class="row" style="padding-top: 30px">
        <div class="col-md-6">
          <img src="{{$product->getFirstMediaUrl('products')}}" alt="{{$product->title}}" width="100%">
        </p>
        </div>  
        <div class="col-md-6 pl-5 py-5">
            <h2 style="font-size: 30px">{{$product->title}}</h2>
            <p class="font-weight-bolder text-primary pb-3" style="font-size: 20px;">
              <small class="text-muted">
                @if ($product->sale_price || $product->sale_price > 0)
                <del>BDT {{$product->price}}</small></del> BDT {{$product->sale_price}}</small>
                @else
                BDT {{$product->price}}</small>
                @endif
            
            </p>

            <p  class="font-weight-bold text-secondary"  style="font-size: 18px;">Description:</p>
            <p>{{$product->description}}</p>

            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <form action="{{route('cart.add')}}" method="POST">
                  @csrf
                  <input type="hidden" name="product_id" value="{{$product->id}}">
                  <button type="submit" class="btn btn-sm btn-outline-secondary">Add to Cart</button>
                </form>
              </div>
            </div>
          </div>        
        </div>       
      </div>
    </div>
  </div>
    
@endsection