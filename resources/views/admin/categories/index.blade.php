@extends('admin.layout')
@section('title','Categories')
@section('content')
<div class="admin-heading"><div><span class="kicker">PRODUCT ORGANISATION</span><h1>Categories.</h1></div><a class="dark-btn" href="{{ route('admin.categories.create') }}">＋ Add category</a></div><div class="admin-panel"><div class="table-wrap"><table><thead><tr><th>Name</th><th>Slug</th><th>Products</th><th>Actions</th></tr></thead><tbody>@forelse($categories as $category)<tr><td>{{ $category->name }}</td><td>{{ $category->slug }}</td><td>{{ $category->products_count }}</td><td class="table-actions"><a href="{{ route('admin.categories.edit',$category) }}">Edit</a><form method="POST" action="{{ route('admin.categories.destroy',$category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button>Delete</button></form></td></tr>@empty<tr><td colspan="4">No categories yet.</td></tr>@endforelse</tbody></table></div>{{ $categories->links() }}</div>
@endsection
