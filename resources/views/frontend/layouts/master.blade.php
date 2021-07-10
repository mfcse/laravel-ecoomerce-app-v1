<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">

        
    </head>
    <body>
       
   @include('frontend.partials.frontend.header')
  
      <main role="main">

        @yield('main')
  
      </main>
  
      @include('frontend.partials.frontend.footer')
        <script src="{{asset('js/app.js')}}"></script>
        <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>
    </body>
</html>
