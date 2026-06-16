<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class MenuController extends Controller
{
    // GET /menus
    public function index(Request $request)
    {
        $query = Menu::with('category');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_menu', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $perPage = $request->get('per_page', 10);
        $menus = $query->paginate($perPage);

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
            'gambar'      => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['gambar']);

        // Handle image upload
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            Configuration::instance(env('CLOUDINARY_URL'));
            $upload = (new UploadApi())->upload($request->file('gambar')->getRealPath(), [
                'folder' => 'sikantin_menus'
            ]);
            $data['gambar_url'] = $upload['secure_url'];
        }

        $menu = Menu::create($data);

        return redirect('/menus')->with('success', 'Menu berhasil ditambahkan!');
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
            return redirect('/menus')->with('error', 'Menu tidak ditemukan');
        }

        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'nama_menu'   => 'sometimes|string|max:100',
            'harga'       => 'sometimes|numeric|min:0',
            'stok'        => 'sometimes|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['gambar']);

        // Handle image upload
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            Configuration::instance(env('CLOUDINARY_URL'));
            $upload = (new UploadApi())->upload($request->file('gambar')->getRealPath(), [
                'folder' => 'sikantin_menus'
            ]);
            $data['gambar_url'] = $upload['secure_url'];
        }

        $menu->update($data);

        return redirect('/menus')->with('success', 'Menu berhasil diupdate!');
    }

    // DELETE /menus/{id}
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return redirect('/menus')->with('error', 'Menu tidak ditemukan');
        }

        $hasOrders = \App\Models\OrderItem::where('menu_id', $menu->id)->exists();
        if ($hasOrders) {
            return redirect('/menus')->with('error', 'Menu tidak bisa dihapus karena sudah ada dalam riwayat pesanan. Ubah stok menjadi 0 jika tidak ingin dijual.');
        }

        $menu->delete();

        return redirect('/menus')->with('success', 'Menu berhasil dihapus!');
    }
}