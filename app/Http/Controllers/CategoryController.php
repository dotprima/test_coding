<?php

namespace App\Http\Controllers;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Panggil API untuk mengambil data produk
        $category = Category::all();

        // Mengonversi data produk ke dalam format ProductResource
        $categoryResource = CategoryResource::collection($category);

        // Mengembalikan respons JSON dengan data produk yang diformat menggunakan ProductResource
        return response()->json($categoryResource);
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
            'name' => 'required',
        ]);

        // Buat kategori baru
        $category = new Category;
        $category->name = $request->name;
        $category->save();

        // Mengembalikan respons atau redirect ke halaman terkait
        return response()->json(['message' => 'Category created successfully'], 201);
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
        $category = Category::findOrFail($id);

        // Mengembalikan respons JSON dengan data kategori
        return response()->json($category);
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
        ]);

        // Temukan kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Update data kategori
        $category->name = $request->name;
        $category->save();

        // Mengembalikan respons atau redirect ke halaman terkait
        return response()->json(['message' => 'Category updated successfully']);
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
        $category = Category::findOrFail($id);

        // Hapus kategori
        $category->delete();

        // Mengembalikan respons atau redirect ke halaman terkait
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
