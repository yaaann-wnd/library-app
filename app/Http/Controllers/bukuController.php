<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class bukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // menampilkan buku
        $data = buku::all();
        $kategori = kategori::all();

        return view('buku.tampil', compact('data', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // tambah buku
        $validator = $request->validate([
            'cover' => 'required|image|max:10000',

        ]);

        $file = $request->file('cover')->store('img');

        buku::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'sinopsis' => $request->sinopsis,
            'penerbit' => $request->penerbit,
            'cover' => $file,
            'kategori_id' => $request->kategori_id,
            'info' => $request->info,
        ]);

        return redirect('buku');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // update buku
        $data = buku::findOrFail($id);

        $validator = $request->validate([
            'isbn'=>'required',
            'judul'=>'required',
            'penerbit'=>'required',
            'sinopsis'=>'required',
            'kategori_id'=>'required',
            'info'=>'required',
            'tampil'=>'required',
        ]);

        $data->update($validator);

        if ($request->file('cover')) {
            $cover = $request->file('cover')->store('img');

            Storage::delete($data->cover);

            $data->update([
                'cover'=>$cover
            ]);
        } else {
            $data->update([
                'cover'=>$data->cover
            ]);

            return redirect('buku');
        }

        return redirect('buku');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // hapus buku
        $data = buku::findOrFail($id);

        if ($data->cover) {
            Storage::delete($data->cover);
        }

        $data->delete();
        
        return redirect('buku');
    }
}
