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
    public function store(Request $request) : JsonResponse {
        if(empty($request)) {
            return response()->json(
                [
                    'message' => 'there is no data for add',
                ],
                400
            );
        }
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
