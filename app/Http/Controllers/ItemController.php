<?php

namespace App\Http\Controllers;

use App\Models\Item; // import model Item
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all(); // mengambil semua data dari tabel items
        return view('items.index', compact('items')); // mengirim data ke view
    }

    public function create()
    {
        return view('items.create'); // menampilkan view create
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]); // validasi inputan

        //Item::create($request->all());
        //return redirect()->route('items.index');

        // Hanya masukkan atribut yang diizinkan
        Item::create($request->only(['name', 'description'])); // membuat record baru pada tabel items dengan atribut name dan description
        return redirect()->route('items.index')->with('success', 'Item added successfully.'); // redirect ke route items.index dengan pesan sukses
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item')); // menampilkan view show
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item')); // menampilkan view edit
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]); // validasi inputan

        //$item->update($request->all());
        //return redirect()->route('items.index');
        // Hanya masukkan atribut yang diizinkan
        $item->update($request->only(['name', 'description'])); // mengupdate data pada tabel items dengan atribut name dan description
        return redirect()->route('items.index')->with('success', 'Item updated successfully.'); // redirect ke route items.index dengan pesan sukses
    }

    public function destroy(Item $item)
    {

        // return redirect()->route('items.index');
        $item->delete(); // menghapus data pada tabel items
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); // redirect ke route items.index dengan pesan sukses
    }
}
