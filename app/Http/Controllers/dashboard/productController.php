<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class productController extends Controller
{
    public function index(Request $request)
    {

        $products = product::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike("title", "%" . $request->search . "%");
        })->when($request->category_id, function ($q) use ($request) {
            $q->where("category_id", $request->category_id);
        })->latest()->get();
        return view("dashboard.products.index", ['products' => $products, 'categories' => Category::all()]);
    }
    public function create()
    {

        return view("dashboard.products.create", ['categories' => Category::all()]);
    }


    public function store(Request $request)
    {

        $data = $request->validate($this->validateProduct());

        if ($request->image) {

            \Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path("/uploads/product_image/" . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        product::create($data);
        $request->session()->flash("success", __("site.update_successfully"));
        return redirect()->route('dashboard.products.index');
    }


    public function edit(product $product)
    {


        $categories = Category::all();
        return view("dashboard.products.edit", ['categories' => $categories, 'product' => $product]);
    }



    public function update(Request $request, product $product)
    {


        $data = $request->validate($this->validateOnUpdateProduct($product));


        if ($request->image) {
            if ($request->image != "default.jpg") {
                \Storage::disk("public_uploads")->delete('/product_image/' . $product->image);
            }

            \Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path("/uploads/product_image/" . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        $product->update($data);
        $request->session()->flash("success", __("site.update_successfully"));
        return redirect()->route('dashboard.products.index');
    }



    public function destroy(Request $request, product $product)
    {
        if ($product->image !== "default.jpg") {
            \Storage::disk("public_uploads")->delete('/product_image/' . $product->image);
        }
        $product->delete();
        $request->session()->flash("success", __("site.add_successfully"));
        return redirect()->route('dashboard.products.index');
    }


    public function validateProduct()
    {
        $rules = [
            "category_id" => "required",

        ];
        foreach (config('translatable.locales') as $local) {
            $rules += [$local . '.title' => ["required", Rule::unique("product_translations", "title")]];
            $rules += [$local . '.description' => ["required", Rule::unique("product_translations", "description")]];
        }

        $rules += [
            "purchase_price" => "required",
            "sale_price" => "required",
            "stock" => "required",
        ];
        return $rules;
    }

    public function validateOnUpdateProduct($product)
    {
        $rules = [
            "category_id" => "required",

        ];
        foreach (config('translatable.locales') as $local) {
            $rules += [$local . '.title' => ["required", Rule::unique("product_translations", "title")->ignore($product->id, "product_id")]];
            $rules += [$local . '.description' => ["required"]];
        }

        $rules += [
            "purchase_price" => "required",
            "sale_price" => "required",
            "stock" => "required",
        ];
        return $rules;
    }
}
