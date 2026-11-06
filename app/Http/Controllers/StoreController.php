<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
class StoreController extends Controller
{
    public function home()
    {
        $featured = Product::where('is_active', true)->where('is_featured', true)->latest()->take(8)->get();
        $latest = Product::where('is_active', true)->latest()->take(8)->get();
        $categories = Category::withCount(['products'=>fn($q)=>$q->where('is_active',true)])->orderBy('name')->get();
        return view('store.home', compact('featured','latest','categories'));
    }
    public function index(Request $request)
    {
        $products = Product::with('category')->where('is_active',true)
            ->when($request->filled('category'), fn($q)=>$q->whereHas('category',fn($c)=>$c->where('slug',$request->category)))
            ->when($request->get('sort')==='price_low',fn($q)=>$q->orderBy('price'))
            ->when($request->get('sort')==='price_high',fn($q)=>$q->orderByDesc('price'))
            ->when(!$request->get('sort') || $request->get('sort')==='newest',fn($q)=>$q->latest())
            ->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('store.listing', ['products'=>$products,'categories'=>$categories,'heading'=>'Shop all products']);
    }
    public function category(Category $category)
    {
        $products = Product::with('category')->where('is_active',true)->where('category_id',$category->id)->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();
        return view('store.listing', ['products'=>$products,'categories'=>$categories,'heading'=>$category->name]);
    }
    public function show(Product $product)
    {
        abort_unless($product->is_active,404);
        $related = Product::where('is_active',true)->where('category_id',$product->category_id)->whereKeyNot($product->id)->take(4)->get();
        return view('store.show', compact('product','related'));
    }
    public function search(Request $request)
    {
        $term = trim((string)$request->query('q',''));
        $products = Product::with('category')->where('is_active',true)->when($term,fn($q)=>$q->where(fn($s)=>$s->where('name','like',"%{$term}%")->orWhere('description','like',"%{$term}%")))->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('store.listing', ['products'=>$products,'categories'=>$categories,'heading'=>'Search results','searchTerm'=>$term]);
    }
}
