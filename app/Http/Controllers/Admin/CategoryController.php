<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Temp};
use App\Http\Requests\{StoreCategoryRequest, UpdateCategoryRequest};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\{Inertia, Response};

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Category/Index', [
            'categories' => Category::query()
            ->with('parentCategory')
            ->withCount('categories')
            ->withCount('products')
            ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Category/Create', [
            'categories' => Category::select('id', 'name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            Category::create(
                $request->safe(['name', 'category_id', 'description'])
            )->moveImage(Temp::find($request->image));
        });

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category): Response
    {
        return Inertia::render('Admin/Category/Show', [
            'category' => $category->load('category:id,name')
            ->load(['products' => fn ($product) => $product
                ->with('firstPicture')
                ->with('firstVariant')
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Category/Edit', [
            'categories' => Category::select('id', 'name')->get(),
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        DB::transaction(function () use ($request, $category) {
            $category
            ->moveImage(Temp::find($request->image))
            ->update($request->safe(['name', 'category_id', 'description']));
        });

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
