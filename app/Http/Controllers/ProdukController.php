<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function listData()
    {
        $data = Produk::query();
        return DataTables::of($data)
            ->order(function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<div class="btn-group"><a onclick="editForm(' . $row->id . ')" class="btn btn-primary">Edit</a><a onclick="deleteData(' . $row->id . ')" class="btn btn-danger">Hapus</a></div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        $data = [];
        $data['modals'] = ['produk._form'];
        $data['scripts'] = ['produk._script'];
        return view('produk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdukRequest $request)
    {
        Produk::create($request->validated());
        return response()->json(['message' => 'berhasil menyimpan data', 'status' => 'success']);
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
    public function edit(string $id)
    {
        $produk = Produk::find($id);
        return json_encode($produk);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukRequest $request, string $id)
    {
        $produk = Produk::find($id);
        $produk->update($request->validated());
        return response()->json(['message' => 'berhasil menyimpan data', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        return response()->json(['message' => 'berhasil menghapus data', 'status' => 'success']);
    }
}
