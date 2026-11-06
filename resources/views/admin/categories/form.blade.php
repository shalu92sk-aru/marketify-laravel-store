@extends('admin.layout')
@section('title',$category->exists?'Edit category':'Add category')
@section('content')
<div class="admin-heading"><div><span class="kicker">PRODUCT ORGANISATION</span><h1>{{ $category->exists?'Edit category.':'Add category.' }}</h1></div><a class="outline-link" href="{{ route('admin.categories.index') }}">← Categories</a></div><form class="admin-panel category-admin-form" method="POST" action="{{ $category->exists?route('admin.categories.update',$category):route('admin.categories.store') }}">@csrf @if($category->exists)@method('PUT')@endif<label>Category name<input name="name" value="{{ old('name',$category->name) }}" required></label><label>Description<textarea name="description" rows="4">{{ old('description',$category->description) }}</textarea></label><button class="dark-btn">Save category →</button></form>
@endsection
