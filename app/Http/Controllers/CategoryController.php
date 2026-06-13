<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET /categories
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'data'   => $categories
        ]);
    }

    // POST /categories
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
        ]);

        $category = Category::create($request->all());

        return redirect('/categories')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // GET /categories/{id}
    public function show($id)
    {
        $category = Category::with('menus')->find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $category
        ]);
    }

    // PUT /categories/{id}
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect('/categories')->with('error', 'Kategori tidak ditemukan');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:50',
        ]);

        $category->update($request->all());

        return redirect('/categories')->with('success', 'Kategori berhasil diupdate!');
    }

    // DELETE /categories/{id}
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect('/categories')->with('error', 'Kategori tidak ditemukan');
        }

        $category->delete();

        return redirect('/categories')->with('success', 'Kategori berhasil dihapus!');
    }
}