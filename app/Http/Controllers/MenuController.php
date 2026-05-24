<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // GET /menus
    public function index()
    {
        $menus = Menu::with('category')->get();
        return response()->json([
            'status' => 'success',
            'data'   => $menus
        ]);
    }

    // POST /menus
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama_menu'   => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar_url'  => 'nullable|string',
        ]);

        $menu = Menu::create($request->all());

        return response()->json([
            'status'  => 'success',
            'message' => 'Menu berhasil ditambahkan',
            'data'    => $menu
        ], 201);
    }

    // GET /menus/{id}
    public function show($id)
    {
        $menu = Menu::with('category')->find($id);

        if (!$menu) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $menu
        ]);
    }

    // PUT /menus/{id}
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'nama_menu'   => 'sometimes|string|max:100',
            'harga'       => 'sometimes|numeric|min:0',
            'stok'        => 'sometimes|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar_url'  => 'nullable|string',
        ]);

        $menu->update($request->all());

        return response()->json([
            'status'  => 'success',
            'message' => 'Menu berhasil diupdate',
            'data'    => $menu
        ]);
    }

    // DELETE /menus/{id}
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        $menu->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Menu berhasil dihapus'
        ]);
    }
}