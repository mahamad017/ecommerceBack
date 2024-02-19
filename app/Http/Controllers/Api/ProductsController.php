<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

        if(empty($name) && empty($category) ){
        $proudcts = Product::all();
            return response()->json([
            'message' => 'products has been retreived successfully',
            'data' => $proudcts,
        ], 200);

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

   public function createCategories(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id' => ['integer','unique:categories'],
        'name' => ['required', 'string'],
        'description' => ['nullable', 'string'],
        // Adjust the validation rules as per your requirements
    ]);
    //print to name and desc to check



    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    try {
        $category = Category::create([
            'name' => $request->input('name'),
            'desc' => $request->input('description'),
            // Adjust the field names as per your database schema
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    } catch (\Exception $e) {
    Log::error('Exception occurred: ' . $e->getMessage());
    // Optionally, you can return a more specific error message
    return response()->json(['error' => 'An error occurred while creating categories'], 500);
}
}

public function destroyCategory($categoryId)
    {
        try {
            // Check if the category exists
            $category = Category::find($categoryId);
            if (!$category) {
                return response()->json(['message' => 'Category not found'], 404);
            }

            // Begin a database transaction
            DB::beginTransaction();
            //
            $products = Product::where('category', $categoryId)->get();
        foreach ($products as $product) {
            $product->delete();
        }
            // Delete the category
            $category->delete();

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Category deleted successfully'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction in case of any exception
            DB::rollBack();

            return response()->json(['message' => 'Failed to delete category', 'error' => $e->getMessage()], 500);
        }
    }
    public function statistics()
    {


        try {
            $data ['category'] = Category::count();
            $data ['product'] = Product::count();
            $data['user'] = User::count();
           // $data ['order'] = Order::count();
            return response()->json([ 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed'], 500);
        }
    }
}
