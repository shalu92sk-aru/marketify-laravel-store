@extends('layouts.store')
@section('title','Your bag — Marketify')
@section('content')
<section class="container simple-page"><span class="kicker">YOUR MARKETIFY BAG</span><h1>Your bag.</h1>
@if(empty($cart) || $products->isEmpty())<div class="empty-cart"><h2>It's looking a little empty.</h2><p>Find something good for your everyday.</p><a class="dark-btn" href="{{ route('shop') }}">Explore the shop ↗</a></div>
@else
<div class="cart-layout"><div class="cart-items">@foreach($cart as $id=>$item)@if(isset($products[$id]))@php($product=$products[$id])<div class="cart-row"><div class="cart-thumb">@if($product->image)<img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">@else<div class="product-placeholder"><span>{{ strtoupper(substr($product->name,0,1)) }}</span></div>@endif</div><div class="cart-product"><a href="{{ route('product.show',$product) }}"><b>{{ $product->name }}</b></a><small>{{ $product->category->name }}</small><span>₹{{ number_format($product->price,2) }}</span></div><form class="quantity-form" method="POST" action="{{ route('cart.update',$product) }}">@csrf @method('PATCH')<input type="number" name="quantity" min="1" max="{{ min(20,$product->stock) }}" value="{{ $item['quantity'] }}"><button>Update</button></form><b class="line-price">₹{{ number_format($product->price*$item['quantity'],2) }}</b><form method="POST" action="{{ route('cart.remove',$product) }}">@csrf @method('DELETE')<button class="remove-btn">×</button></form></div>@endif @endforeach</div>
<aside class="cart-summary"><h2>Order summary</h2><div><span>Subtotal</span><b>₹{{ number_format($subtotal,2) }}</b></div><div><span>Shipping</span><b>{{ $subtotal >= 1500 ? 'FREE' : '₹99.00' }}</b></div><p>{{ $subtotal >= 1500 ? 'You unlocked free shipping!' : 'Add ₹'.number_format(max(0,1500-$subtotal),2).' more for free shipping.' }}</p><div class="summary-total"><span>Total</span><strong>₹{{ number_format($subtotal+($subtotal>=1500?0:99),2) }}</strong></div><a class="dark-btn full-dark" href="{{ route('checkout.index') }}">Continue to checkout →</a><a class="continue-link" href="{{ route('shop') }}">Continue shopping</a></aside></div>
@endif
</section>
@endsection
