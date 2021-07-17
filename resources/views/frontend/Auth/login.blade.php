@extends('frontend.layouts.master')
@section('main')
 <div class="container">
     <h3 class="text-center  mt-5">
         Login
     </h3>
     <hr>
     

     <div class="row">
        <div class="col-md-8 offset-md-2 mb-5">
            @include('frontend.partials.frontend._message')
            <form method="POST" action="{{route('login')}}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"  value="{{old('email')}}">
                  
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                
                
                <button type="submit" class="btn btn-success">Submit</button>
              </form>
        
        </div>
    </div>
 </div>
     
    
@endsection