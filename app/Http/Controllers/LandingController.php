<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\{Inertia, Response};
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends Controller
{
    #[Route('/', methods: ['GET'])]
    public function index(): Response
    {
        return Inertia::render('Glance', [
            'categories' => Category::query()
            // ->whereNull('category_id')
            ->with([
                'products' => fn($query) => $query->limit(5)->with('firstPicture')
            ])->get()
        ]);
    }


    #[Route('/about', methods: ['GET'])]
    public function about(): Response
    {
        return Inertia::render('About');
    }

    #[Route('/carts', methods: ['GET'])]
    public function carts()
    {
        # code...
    }
}
