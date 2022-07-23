@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $product->naam }}</div>

                <div class="card-body">


                        <small>Gepost door <a href="{{ route('profile', $product->user->name)}}">{{$product->user->name}}</a> op {{$product->created_at}}</small>
                        <br>
                        
                        <p>{{ $product->beschrijving}}</p>  

                        <br><br>

                        @auth
                            @if($product->user_id == Auth::id())
                            {{-- J'ai mis  Auth::id() aulieu de Auth::user()->id --}}
                                <a href="{{ route('products.edit', $product->id)}}">Product wijzigen</a>
                            @else
                                <a href="{{ route('like', $product->id)}}">Like Product</a>
                            @endif 
                        <br>
                        @endauth
                        {{ $product->likes()->count()}} likes

                        @auth
                        @if(Auth::user()->is_admin)
{{--                       
                        <h4 style="color: red;"><a href="{{ route('products.destroy', $product-> id)}}">
                            Delete</a><h4> --}}

                        <form method="post" action="{{ route('products.destroy', $product-> id)}}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="DELETE_PRODUCT" onclick="return confirm(Are you sure you want to delete this product?);">
                        
                            @endif
                        @endauth
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection