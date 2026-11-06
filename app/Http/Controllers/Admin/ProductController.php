<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index(){ $products=Product::with('category')->latest()->paginate(15); return view('admin.products.index',compact('products')); }
    public function create(){ $categories=Category::orderBy('name')->get(); return view('admin.products.form',['product'=>new Product(),'categories'=>$categories]); }
    public function store(Request $request)
    {
        $data=$this->validated($request);$data['slug']=$this->slug($data['name']);$data['sku']=$data['sku'] ?: strtoupper(Str::random(8));
        if($request->hasFile('image'))$data['image']=$request->file('image')->store('products','public');
        Product::create($data);return redirect()->route('admin.products.index')->with('success','Product created.');
    }
    public function edit(Product $product){$categories=Category::orderBy('name')->get();return view('admin.products.form',compact('product','categories'));}
    public function update(Request $request,Product $product)
    {
        $data=$this->validated($request);$data['slug']=$this->slug($data['name'],$product->id);$data['sku']=$data['sku'] ?: $product->sku;
        if($request->hasFile('image')){$data['image']=$request->file('image')->store('products','public');}
        $product->update($data);return redirect()->route('admin.products.index')->with('success','Product updated.');
    }
    public function destroy(Product $product)
    {
        if($product->image)Storage::disk('public')->delete($product->image);
        $product->delete();return back()->with('success','Product deleted.');
    }
    private function validated(Request $request):array
    {
        return $request->validate([
            'name'=>['required','string','max:180'],
            'category_id'=>['required','exists:categories,id'],
            'sku'=>['nullable','string','max:60'],
            'description'=>['nullable','string','max:5000'],
            'price'=>['required','numeric','min:0','max:9999999'],
            'compare_price'=>['nullable','numeric','gt:price','max:9999999'],
            'stock'=>['required','integer','min:0','max:999999'],
            'image'=>['nullable','image','max:4096'],
            'is_featured'=>['nullable','boolean'],
            'is_active'=>['nullable','boolean']
        ]);
    }
    private function slug(string $name,?int $ignore=null):string
    {
        $base=Str::slug($name) ?: 'product';$slug=$base;$i=2;
        while(Product::where('slug',$slug)->when($ignore,fn($q)=>$q->where('id','!=',$ignore))->exists())$slug=$base.'-'.$i++;
        return $slug;
    }
}
