<x-layout.app>
    <div class="container p-4 rounded">
        <h1 class="h4 mb-4">Daftar Produk</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <form action="{{ route('product.index') }}" method="GET" class="d-flex align-items-center">
                        <div class="position-relative w-100" style="max-width: 550px;">
                            <i
                                class="fas fa-search position-absolute top-50 start-0 translate-middle-y text-muted ms-3"></i>
                            <x-input name="search" placeholder="Cari barang" value="{{ request('search') }}"
                                class="custom-class" style="padding-left:35px;" />
                        </div>
                </div>
                <div class="col-auto">
                    <div class="position-relative" style="max-width: 150px;">
                        <select name="category" class="form-select ps-5" style="font-size: 0.9rem;">
                            <option value="Semua">Semua</option>
                            @foreach ($category as $categoryData)
                                <option value="{{ $categoryData->id }}"
                                    {{ request('category') == $categoryData->id ? 'selected' : '' }}>
                                    {{ $categoryData->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-box position-absolute top-50 start-0 translate-middle-y text-muted ms-3"></i>
                    </div>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" style="font-size: 0.9rem;">Cari</button>
                </div>
                </form>
            </div>


            <div class="d-flex">
                <form action="{{ route('export') }}" method="GET" class="d-inline me-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <button type="submit" class="btn btn-success ms-2">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                </form>
                <a href="{{ route('product.create') }}" class="btn btn-danger">
                    <i class="fas fa-plus me-2"></i>Tambah Produk
                </a>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Image</th>
                    <th>Nama Produk</th>
                    <th>Kategori Produk</th>
                    <th class="text-end">Harga Beli (Rp)</th>
                    <th class="text-end">Harga Jual (Rp)</th>
                    <th class="text-center">Stok Produk</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product as $productData)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <img src="{{ asset('assets/images/product') }}/{{ $productData->product_image }}"
                                alt="{{ $productData->name }}" width="50" height="50">
                        </td>
                        <td>{{ $productData->product_name }}</td>
                        <td>{{ $productData->category->category_name }}</td>
                        <td class="text-end">{{ number_format($productData->product_buying_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($productData->product_selling_price, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $productData->product_quantity }}</td>
                        <td class="text-center">
                            <a href="{{ route('product.edit', $productData->id) }}" class="text-decoration-none">
                                <i class="fas fa-pen text-primary cursor-pointer mx-2"></i>
                            </a>

                            <form action="{{ route('product.destroy', $productData->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <div class=" d-inline-block" style="cursor: pointer;"
                                    onclick="if(confirm('Apakah anda ingin menghapus data ini?')) this.closest('form').submit();">
                                    <i class="fas fa-trash text-danger"></i>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $product->links('pagination::bootstrap-5') }}
    </div>
</x-layout.app>
