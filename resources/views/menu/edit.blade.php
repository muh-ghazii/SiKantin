@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')

<div class="page-header">
    <div>
        <h2>Edit Menu</h2>
        <p>Ubah informasi menu</p>
    </div>
    <a href="/menus" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-3">

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Informasi Menu</div>
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="/menus/{{ $menu->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control"
                                   value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ (old('category_id', $menu->category_id) == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control"
                                   value="{{ old('harga', $menu->harga) }}" min="0" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control"
                                   value="{{ old('stok', $menu->stok) }}" min="0" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Gambar Menu</label>
                            @if($menu->gambar_url)
                                <div class="mb-3">
                                    <img src="{{ filter_var($menu->gambar_url, FILTER_VALIDATE_URL) ? $menu->gambar_url : asset('images/' . $menu->gambar_url) }}"
                                         id="imagePreview"
                                         style="width:120px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0;">
                                </div>
                            @else
                                <div class="mb-2" id="imagePreviewWrapper" style="display:none;">
                                    <img id="imagePreview" src=""
                                         style="width:120px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0;">
                                </div>
                            @endif
                            <input type="file" name="gambar" class="form-control"
                                   accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                        <a href="/menus" class="btn btn-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Tips</div>
            <div class="card-body">
                <ul style="padding-left:16px; font-size:0.835rem; color:#64748b; line-height:2;">
                    <li>Kosongkan gambar jika tidak ingin mengubah</li>
                    <li>Harga dalam Rupiah tanpa titik</li>
                    <li>Gambar maksimal 2MB</li>
                    <li>Format gambar: JPG, PNG, WEBP</li>
                    <li>Stok 0 = menu tidak tersedia</li>
                </ul>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const wrapper = document.getElementById('imagePreviewWrapper');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                if (wrapper) wrapper.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection