@extends('frontend.layouts.master')
@section('main')
    
@include('frontend.partials.frontend._hero')

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <a href="{{route('product.details',$product->slug)}}">
              <img class="card-img-top" src="{{$product->getFirstMediaUrl('products')}}" alt="{{$product->title}}">
            </a>
            
            <div class="card-body">
              <p class="card-text">
                <a href="{{route('product.details',$product->slug)}}">{{$product->title}}</a>
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <form action="{{route('cart.add')}}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Add to Cart</button>
                  </form>
                </div>
                <small class="text-muted">
                  @if ($product->sale_price || $product->sale_price > 0)
                  <del>BDT {{$product->price}}</small></del> BDT {{$product->sale_price}}</small>
                  @else
                  BDT {{$product->price}}</small>
                  @endif
              </div>
            </div>
          </div>
        </div>
        @endforeach
        
      </div>
      {{$products->links()}}
    </div>
  </div>
    
@endsection