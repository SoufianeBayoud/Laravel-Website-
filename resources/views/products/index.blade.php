@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($products as $product)
                        <h3><a href="{{route('products.show', $product->id)}}">{{ $product->naam }}</a></h3>
                        {{-- <p>{{ $product->beschrijving}}</p> --}}
                        <small>Gepost door <a href="{{ route('profile', $product->user->name)}}">{{$product->user->name}}</a> op {{$product->created_at}}</small>
                        @auth
                            @if($product->user_id == Auth::id())
                            {{-- J'ai mis  Auth::id() aulieu de Auth::user()->id --}}
                                <a href="{{ route('products.edit', $product->id)}}">Product wijzigen</a>
                            @else
                                <a href="{{ route('like', $product->id)}}">Like Product</a>
                            @endif 
                        @endauth
                        <br>
                        {{ $product->likes()->count()}} likes
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
