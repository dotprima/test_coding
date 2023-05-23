<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Panggil API untuk mengambil data produk
        $products = Product::all();

        // Mengonversi data produk ke dalam format ProductResource
        $productsResource = ProductResource::collection($products);

        // Mengembalikan respons JSON dengan data produk yang diformat menggunakan ProductResource
        return response()->json($productsResource);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'category' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image',
        ]);

        // Simpan data produk ke dalam database
        $product = new Product;
        $product->category_id = 3;
        $product->name = $request->name;
        $product->price = $request->price;
        
        
        // Upload gambar produk ke direktori yang ditentukan
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        
        $product->image = $imageName;
        $product->save();

        // Mengembalikan respons atau redirect ke halaman terkait
        return response()->json(['message' => 'Product created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         // Temukan kategori berdasarkan ID
        $Product = Product::findOrFail($id);

        // Mengembalikan respons JSON dengan data kategori
        return response()->json($Product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // Validasi input
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'image',
            'category' => 'required',
        ]);

        // Temukan produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Update data produk
        $product->name = $request->name;
        $product->price = $request->price;
        
        // Periksa apakah ada gambar yang diunggah
        if ($request->hasFile('image')) {
            // Upload gambar produk ke direktori yang ditentukan
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }
        
        $product->save();

        // Mengembalikan respons atau redirect ke halaman terkait
        return response()->json(['message' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Temukan kategori berdasarkan ID
        $Product = Product::findOrFail($id);

        // Hapus kategori
        $Product->delete();

        // Mengembalikan respons atau redirect ke halaman terkait
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
