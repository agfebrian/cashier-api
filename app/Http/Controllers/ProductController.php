<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductService $productService, $category = null)
    {
        $result = ['status' => 200];
        try {
            $result['products'] = $productService->getProductByCategory($category);
        } catch (Exception $e) {
            $result = [
                'products' => [],
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductService $productService)
    {
        $result = ['status' => 200];
        try {
            $result['products'] = $productService->create($request->all());
            $result['success'] = 'Data product was stored';
        } catch (Exception $e) {
            $result = [
                'products' => [],
                'status' => 500, 
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductService $productService, $id)
    {
        $result = ['status' => 200];
        try {
            $result['products'] = $productService->update($id, $request->all());
            $result['success'] = 'Data product was updated';
        } catch (Exception $e) {
            $result = [
                'products' => [],
                'status' => 500, 
                'error' => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductService $productService, $id)
    {
        $result = ['status' => 200];
        try {
            $result['products'] = $productService->destroy($id);
            $result['success'] = 'Data product was deleted';
        } catch (Exception $e) {
            $result = [
                'products' => [],
                'status' => 500, 
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
