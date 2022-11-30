@extends('layouts.navbar')

@section('content')
<div class="text-center">
    <h3>Buku</h3>
</div>
<div class="mb-2">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
</div>
<table class="table table-hover text-center">
    <thead class="bg-primary text-white">
        <tr>
            <td>ISBN</td>
            <td>Judul</td>
            <td>Sinopsis</td>
            <td>Penerbit</td>
            <td>Kategori</td>
            <td>Petugas</td>
            <td>Cover</td>
            @if(Auth::user()->role == 'admin')
            <td>Status</td>                
            @endif
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->isbn }}</td>
            <td>{{ $d->judul }}</td>
            <td>{{ $d->sinopsis }}</td>
            <td>{{ $d->penerbit }}</td>
            <td>{{ $d->kategori->kategori }}</td>
            <td><span class="text-uppercase">{{ $d->info }}</span></td>
            <td><img src="{{ asset('storage/'.$d->cover) }}" class="rounded-2" width="75px" alt=""></td>
            @if(Auth::user()->role == 'admin')
            <td>
                @if($d->tampil == 1)
                <span class="text-primary fw-semibold">Ditampilkan</span>
                @else
                <span class="text-danger fw-semibold">Tidak ditampilkan</span>                    
                @endif
            </td>
            @endif
            <td>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $d->id }}">Edit</button>
                <form action="{{ route('buku.destroy', $d->id) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('delete')
                    <a href="#" onclick="return confirm('Yakin hapus Data ?')"> <button class="btn btn-danger">Delete</button> </a>
                </form>
            </td>
        </tr>
        {{-- Modal edit start --}}
        <div class="modal fade" id="exampleModal{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit buku</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('buku.update',$d->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="isbn" value="{{ $d->isbn }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="judul" value="{{ $d->judul }}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Sinopsis</label>
                                <textarea name="sinopsis" id="" cols="30" rows="10" class="form-control">{{ $d->sinopsis }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Penerbit</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="penerbit" value="{{ $d->penerbit }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Ditambahkan oleh</label>
                                <input type="text" class="form-control text-capitalize" id="exampleFormControlInput1" name="info" readonly value="{{ $d->info }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Cover</label>
                                <input type="file" class="form-control" id="exampleFormControlInput1" name="cover">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Cover sebelumnya</label>
                                <img src="{{ asset('storage/'.$d->cover) }}" width="75px" class="rounded d-block" alt="">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">kategori</label>
                                <select name="kategori_id" id="" class="form-select">
                                    @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" {{ $k->id == $d->kategori_id? 'selected' : '' }}>{{ $k->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 {{ Auth::user()->role == 'editor'? 'd-none':'' }}">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" {{ $d->tampil == 1 ? 'checked':'' }} name="tampil" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Tampilkan buku</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" {{ $d->tampil == 0 ? 'checked':'' }} name="tampil" id="inlineRadio2" value="0">
                                    <label class="form-check-label" for="inlineRadio2">Sembunyikan buku</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal edit end --}}
        @endforeach
    </tbody>
</table>

{{-- modal add --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah buku</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="isbn">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="judul">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Sinopsis</label>
                        <textarea name="sinopsis" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="penerbit">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Ditambahkan oleh</label>
                        <input type="text" class="form-control text-capitalize" id="exampleFormControlInput1" name="info" readonly value="{{ Auth::user()->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Cover</label>
                        <input type="file" class="form-control" id="exampleFormControlInput1" name="cover">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">kategori</label>
                        <select name="kategori_id" id="" class="form-select">
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- modal add --}}
@endsection
