<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreProductRequest, UpdateProductRequest};
use App\Models\{Category, Picture, Product, Type};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\{Inertia, Response};

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category): Response
    {
        return Inertia::render('Admin/Product/Create', [
            'category' => $category->id,
            'types' => Type::query()->select('id', 'name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request, Category $category): RedirectResponse
    {
        DB::transaction(function () use ($request, $category) {

            $category->products()->create($request->safe(['name', 'description']))
            ->moveImages($request->images)
            ->activeVariants($request->variants);

        });

        return redirect()->route('categories.show', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Product $product): Response
    {
        return Inertia::render('Admin/Products/Show', [
            'product' => $product,
            'types' => Type::query()->select('id', 'name')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Product $product): Response
    {
        return Inertia::render('Admin/Product/Edit', [
            'product' => $product->load('variants:id,product_id,name,price,stock,type'),
            'types' => Type::query()->select('id', 'name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Category $category, Product $product): RedirectResponse
    {
        $product
        ->moveImages($request->images)
        ->activeVariants($request->variants)
        ->update($request->safe(['name', 'description']));

        if ($request->deleted) {
            Picture::query()
            ->whereIn('id', $request->deleted)
            ->delete();
        }

        return redirect()->route('categories.show', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('categories.show', $category);
    }
}
