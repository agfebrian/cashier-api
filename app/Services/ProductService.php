<?php

namespace App\Services;

use Exception;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function findById($id)
    {
        $product = $this->product::findOrFail($id);
        return $product;
    }

    public function getProductByCategory($category)
    {
        $products = $this->product::with('category')->where(function ($query) use ($category) {
            $query->when($category, function ($query) use ($category) {
                $query->whereHas('category', function ($query) use ($category) {
                    $query->where('category_name', $category);
                });
            });
        })->get();

        foreach ($products as $key => $value) {
            $products[$key] = Arr::prepend($products[$key]->toArray(), $value->image, 'image');
        }

        return $products;
    }

    public function uploadImage($file)
    {
        dd($file->image);
    }

    public function create($request)
    {
        $validator = Validator::make($request, [
            'product_name' => 'required',
            'product_price' => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $product = $this->product::create($request);
        
        return $product;
    }

    public function update($id, $request)
    {
        $product = $this->findById($id);
        $validator = Validator::make($request, [
            'product_name' => 'required',
            'product_price' => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $product->update($request);
        
        return $product;
    }

    public function destroy($id)
    {
        $product = $this->findById($id);
        $product->delete();
        return $product;
    }
}