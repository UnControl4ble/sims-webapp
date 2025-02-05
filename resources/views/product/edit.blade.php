<x-layout.app>

    <div class="container p-4 rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#" class="h2 text-decoration-none"
                            style="color: rgba(199, 199, 199, 0.6);">Daftar Produk</a></li>
                    <li class="breadcrumb-item active text-dark h2" aria-current="page">Edit Produk</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select id="kategori" class="form-select" name="kategori" required>
                        <option value="" selected>Pilih kategori</option>
                        @foreach ($category as $categoryData)
                            <option value="{{ $categoryData->id }}"
                                {{ old('kategori', $product->product_category) == $categoryData->id ? 'selected' : '' }}>
                                {{ $categoryData->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <x-input class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukan nama barang"
                        value="{{ old('nama_barang', $product->product_name) }}" required />
                    @error('nama_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <x-input class="form-control" id="harga_beli" name="harga_beli" placeholder="Masukan harga beli"
                        value="{{ old('harga_beli', $product->product_buying_price) }}" required
                        oninput="formatRupiah(this, 'Rp. ')" />
                    @error('harga_beli')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <x-input class="form-control" id="harga_jual" name="harga_jual" placeholder="Masukan harga jual"
                        value="{{ old('harga_jual', $product->product_selling_price) }}" required readonly />
                    @error('harga_jual')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="stok_barang" class="form-label">Stok Barang</label>
                    <x-input class="form-control" id="stok_barang" name="stok_barang"
                        placeholder="Masukan jumlah stok barang"
                        value="{{ old('stok_barang', $product->product_quantity) }}" required />
                    @error('stok_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="upload-image" class="form-label">Upload Image</label>
                <label for="file-upload"
                    class="border-primary border-2 border-dashed text-center rounded d-block {{ $errors->has('gambar') ? 'border-danger' : '' }}"
                    style="cursor: pointer; position: relative; padding: 100px;">

                    <img id="preview-image"
                        src="{{ $product->product_image ? asset('storage/images/product/' . $product->product_image) : '' }}"
                        alt="Preview Image"
                        style="max-width: 80px; height: 80px; display: {{ $product->product_image ? 'block' : 'none' }}; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />

                    <i id="upload-icon" class="fas fa-image mb-2"
                        style="font-size: 70px; color: blue; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            display: {{ $product->product_image ? 'none' : 'block' }};"></i>

                    <div id="file-name" class="text-primary mt-3"
                        style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);">
                        {{ $product->product_image ? $product->product_image : 'Upload gambar disini' }}
                    </div>

                    <input type="file" class="form-control d-none" id="file-upload" name="gambar"
                        onchange="previewImage(event)">
                </label>
                @error('gambar')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>


            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('product.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    @push('script')
        <script>
            function previewImage(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        var output = document.getElementById('preview-image');
                        output.src = reader.result;
                        output.style.display = 'block';
                        document.getElementById('upload-icon').style.display = 'none';

                        // Ganti teks dengan nama file yang baru
                        document.getElementById('file-name').textContent = file.name;
                    }
                    reader.readAsDataURL(file);
                }
            }

            function formatRupiah(angka, prefix) {
                var number_string = angka.value.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                angka.value = prefix === undefined ? rupiah : (rupiah ? '' + rupiah : '');
            }

            document.getElementById('harga_beli').addEventListener('input', function() {
                var hargaBeli = this.value.replace(/[^0-9]/g, '');
                var hargaJualField = document.getElementById('harga_jual');

                if (hargaBeli) {
                    var hargaJual = parseInt(hargaBeli) * 1.3;
                    hargaJualField.value = '' + formatNumber(hargaJual);
                } else {
                    hargaJualField.value = '';
                }
            });

            function formatNumber(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        </script>
    @endpush
</x-layout.app>
