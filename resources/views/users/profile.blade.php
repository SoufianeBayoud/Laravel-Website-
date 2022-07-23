@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profiel van {{ $user->name }}</div>

                <div class="card-body">
                    
                    <h2>Gemaakte products</h2>
                    @foreach($user->products as $product)
                        <a href="{{route('products.show', $product->id)}}"> {{$product->naam}}</a><br>

                    @endforeach
<hr>
                    <h2>Gelikte products</h2>
                    @foreach($user->likes as $like)
                    {{-- 1h58 --}}
                        <a href="{{route('products.show', $like->product_id)}}"> {{$like->product->naam}}</a><br>

                    @endforeach
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
