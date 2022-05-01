<?php

namespace App\Http\Controllers;

use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FilePondController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image'
        ]);

        return DB::transaction(function () use ($request) {
            return Temp::create([
                'name' => $request->file('file')->getClientOriginalName(),
                'path' => $request->file->store('temp')
            ])->id;
            
        });
    }

    public function show(Temp $pond): BinaryFileResponse
    {
        if (Storage::exists($pond->path)) {
            return response()->file(storage_path('app/'.$pond->path));
        }

        abort(404);
    }
}
