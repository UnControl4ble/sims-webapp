<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != 'Semua') {
            $query->where('product_category', $request->category);
        }

        $product = $query->paginate(10);

        $category = Category::all();
        return view('product.index', compact('product', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return view('product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'kategori' => 'required',
                'nama_barang' => 'required|unique:product,product_name',
                'harga_beli' => 'required|numeric',
                'stok_barang' => 'required|numeric',
                'gambar' => 'required|image|mimes:jpg,png|max:100',
            ],
            [
                'kategori.required' => 'Kategori harus diisi',
                'nama_barang.required' => 'Nama barang harus diisi',
                'nama_barang.unique' => 'Nama barang sudah ada',
                'harga_beli.required' => 'Harga beli harus diisi',
                'harga_beli.numeric' => 'Harga beli harus berupa angka',
                'stok_barang.required' => 'Stok barang harus diisi',
                'stok_barang.numeric' => 'Stok barang harus berupa angka',
                'gambar.required' => 'Gambar harus diisi',
                'gambar.image' => 'Gambar harus berupa file gambar',
                'gambar.only' => 'Gambar harus berupa file gambar dengan ekstensi jpg atau png',
                'gambar.max' => 'Gambar maksimal berukuran 100 KB',
            ]
        );

        $hargaBeli = str_replace('.', '', $request->harga_beli);
        $hargaJual = str_replace('.', '', $request->harga_jual);

        $image = $request->file('gambar');
        $imageName = str_replace(' ', '_', strtolower($request->nama_barang)) . '.' . $image->getClientOriginalExtension();
        // $image->move(public_path('images/product'), $imageName);
        Storage::disk('public')->putFileAs('images/product', $image, $imageName);
        Product::create([
            'product_category' => $request->kategori,
            'product_name' => $request->nama_barang,
            'product_buying_price' => $hargaBeli,
            'product_selling_price' => $hargaJual,
            'product_quantity' => $request->stok_barang,
            'product_image' => $imageName,
        ]);


        return redirect()->route('product.index')->with('success', 'Produk berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $category = Category::all();
        return view('product.edit', compact('product', 'category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'kategori' => 'required',
                'nama_barang' => 'required|unique:product,product_name,' . $id,
                'harga_beli' => 'required|numeric',
                'stok_barang' => 'required|numeric',
                'gambar' => 'image|mimes:jpg,png|max:100',
            ],
            [
                'kategori.required' => 'Kategori harus diisi',
                'nama_barang.required' => 'Nama barang harus diisi',
                'nama_barang.unique' => 'Nama barang sudah ada',
                'harga_beli.required' => 'Harga beli harus diisi',
                'harga_beli.numeric' => 'Harga beli harus berupa angka',
                'stok_barang.required' => 'Stok barang harus diisi',
                'stok_barang.numeric' => 'Stok barang harus berupa angka',
                'gambar.image' => 'Gambar harus berupa file gambar',
                'gambar.mimes' => 'Gambar harus berupa file gambar dengan ekstensi jpg atau png',
                'gambar.max' => 'Gambar maksimal berukuran 100 KB',
            ]
        );

        $product = Product::findOrFail($id);
        $product->product_category = $request->kategori;
        $product->product_name = $request->nama_barang;
        $product->product_buying_price = str_replace('.', '', $request->harga_beli);
        $product->product_selling_price = str_replace('.', '', $request->harga_jual);
        $product->product_quantity = $request->stok_barang;

        if ($request->hasFile('gambar')) {
            $oldImagePath = public_path('storage/images/product/' . $product->product_image); // Adjust path to storage
            if (file_exists($oldImagePath) && $product->product_image) {
                unlink($oldImagePath); // Delete old image
            }

            $image = $request->file('gambar');
            $imageName = str_replace(' ', '_', strtolower($request->nama_barang)) . '.' . $image->getClientOriginalExtension();

            // Store the new image using Storage facade
            Storage::disk('public')->putFileAs('images/product', $image, $imageName);
            $product->product_image = $imageName;
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->product_image) {
            $imagePath = public_path('assets/images/product/' . $product->product_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return redirect()->route('product.index')->with('error', 'Produk berhasil dihapus.');
    }
    public function export(Request $request)
    {
        $query = Product::query();

        $hasSearch = $request->filled('search');
        $hasCategory = $request->filled('category') && $request->category !== 'Semua';

        if ($hasSearch) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($hasCategory) {
            $query->where('product_category', $request->category);
        }

        $products = $query->with('category')->get();

        if (($hasSearch || $hasCategory) && $products->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->mergeCells('B2:G2');
        $sheet->setCellValue('B2', 'DATA PRODUK');
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $headers = ['No', 'Nama Produk', 'Kategori Produk', 'Harga Barang', 'Harga Jual', 'Stok'];
        $column = 'B';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '4', $header);
            $column++;
        }

        $sheet->getStyle('B4:G4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FF0000'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $row = 5;
        $no = 1;
        foreach ($products as $product) {
            $sheet->setCellValue('B' . $row, $no);
            $sheet->setCellValue('C' . $row, $product->product_name);
            $sheet->setCellValue('D' . $row, $product->category->category_name ?? 'Tidak Ada');
            $sheet->setCellValue('E' . $row, $product->product_buying_price);
            $sheet->setCellValue('F' . $row, $product->product_selling_price);
            $sheet->setCellValue('G' . $row, $product->product_quantity);

            $sheet->getStyle("B{$row}:G{$row}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

            $row++;
            $no++;
        }

        $sheet->getStyle('E5:F' . ($row - 1))->getNumberFormat()->setFormatCode('#,##0');

        foreach (range('B', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'Data_Produk.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/' . $fileName);
        $writer->save($filePath);

        return Response::download($filePath, $fileName)->deleteFileAfterSend(true);
    }
}
