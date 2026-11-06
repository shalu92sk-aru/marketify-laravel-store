<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index(){ $categories=Category::withCount('products')->orderBy('name')->paginate(15);return view('admin.categories.index',compact('categories')); }
    public function create(){return view('admin.categories.form',['category'=>new Category()]);}
    public function store(Request $request){$data=$this->validateData($request);$data['slug']=$this->slug($data['name']);Category::create($data);return redirect()->route('admin.categories.index')->with('success','Category created.');}
    public function edit(Category $category){return view('admin.categories.form',compact('category'));}
    public function update(Request $request,Category $category){$data=$this->validateData($request);$data['slug']=$this->slug($data['name'],$category->id);$category->update($data);return redirect()->route('admin.categories.index')->with('success','Category updated.');}
    public function destroy(Category $category){if($category->products()->exists())return back()->withErrors(['category'=>'Remove or reassign products before deleting this category.']);$category->delete();return back()->with('success','Category deleted.');}
    private function validateData(Request $request):array{return $request->validate(['name'=>['required','string','max:100'],'description'=>['nullable','string','max:250']]);}
    private function slug(string $name,?int $ignore=null):string{$base=Str::slug($name)?:'category';$slug=$base;$i=2;while(Category::where('slug',$slug)->when($ignore,fn($q)=>$q->where('id','!=',$ignore))->exists())$slug=$base.'-'.$i++;return $slug;}
}
