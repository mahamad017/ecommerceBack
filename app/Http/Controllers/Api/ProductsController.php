<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    /**
     * @param name
     * @param category
     * 
     * @return Array<Product>
     */
    public function show (Product $product) : JsonResponse {
        $res = Product::where('id', $product->id)->get();
        return response()->json(
            [
                'message' => 'retreived product succesfully',
                'data' => $res,
            ],
            200
        );
    }
    public function store(Request $request) : JsonResponse {
        if(empty($request)) {
            return response()->json(
                [
                    'message' => 'there is no data for add',
                ],
                400
            );
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'category' => 'required',
        ]);
        Product::create(
            [
            'name' => $request['name'],
            'description' => $request['description'],
            'image' => $request['image'],
            'price' => $request['price'],
            'category' => $request['category'],
            ]
        );
        return response()->json([
            'message' => 'product has been added successfully',
        ], 200);
    }
    public function update(Request $request, Product $product) : JsonResponse{
        if(empty($request)) {
            return response()->json(
                [
                    'message' => 'there is no data for add',
                ],
                400
            );
        }
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'category' => 'required',
        ]);
        $newProduct = Product::where('id',$product->id)->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'image' => $request['image'],
            'price' => $request['price'],
            'category' => $request['category'],
            ]
        );
        return response()->json([
            'message' => 'product has been updated successfully',
        ], 200);
    }

    public function destroy(Product $product) : JsonResponse {
        $product = Product::findOrFail($product->id);
        $product->delete();
        return response()->json([
            'message' => 'product has been deleted succesfully',
        ], 200);
    }
    public function GetProducts(Request $request): JsonResponse
    {
        // init request parameters
        $name = $request->name;
        $category = $request->category;

        $proudcts = Product::get();

        // filter by name
        if (!empty($name)) {
            $proudcts = $proudcts->where('name', $name);
        }

        // filter by category
        if (!empty($category)) {
            $proudcts = $proudcts->where('category', $category);
        }

        return response()->json([
            'message' => 'products has been retreived successfully',
            'data' => $proudcts,
        ], 200);
    }

    /**
     * @return List of Category
     * 
     */
    public function  GetCategories(): JsonResponse
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'Categroies has been retreived successfully',
            'data' => $categories,
        ], 200);
    }
}
