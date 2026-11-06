@extends('layouts.store')
@section('title',$heading.' — Marketify')
@section('content')
<section class="listing-head container"><span class="kicker">THE MARKETIFY COLLECTION</span><h1>{{ $heading }}</h1><p>Useful finds. Everyday favourites. A little something for you.</p></section>
<section class="container shop-layout"><aside class="shop-sidebar"><b>Browse</b><a class="filter-link" href="{{ route('shop') }}">All products</a>@foreach($categories as $category)<a class="filter-link" href="{{ route('category.show',$category) }}">{{ $category->name }}</a>@endforeach</aside><div class="shop-results"><div class="results-bar"><span>{{ $products->total() }} products</span><form method="GET" action="{{ url()->current() }}"><select name="sort" onchange="this.form.submit()"><option value="newest" @selected(request('sort','newest')==='newest')>Newest</option><option value="price_low" @selected(request('sort')==='price_low')>Price: low to high</option><option value="price_high" @selected(request('sort')==='price_high')>Price: high to low</option></select></form></div>
@if(isset($searchTerm) && $searchTerm)<p class="search-result-label">Search: “{{ $searchTerm }}”</p>@endif
<div class="product-grid">@forelse($products as $product)@include('partials.product-card',['product'=>$product])@empty<div class="empty-products"><h3>No products found</h3><p>Try another category or browse all products.</p><a class="dark-btn" href="{{ route('shop') }}">Shop all</a></div>@endforelse</div><div class="pagination-wrap">{{ $products->links() }}</div></div></section>
@endsection
