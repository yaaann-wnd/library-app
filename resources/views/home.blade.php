@extends('navbar')

@section('content')
<div class="mb-4">
    <div class="mb-3 text-center">
        <h3>Buku</h3>
    </div>
    @foreach($data as $d)
    <div class="card mb-3 p-3">
        <div class="d-flex align-items-center">
            <div class="me-3">
                <img src="{{ asset('storage/'.$d->cover) }}" class="rounded" width="85px" alt="">
            </div>
            <div>
                <div class="row">
                    <span class="fw-semibold text-capitalize fs-3">{{ $d->judul }}</span>
                </div>
                <div class="row">
                    <span>Penerbit : <span class="text-capitalize fw-semibold">{{ $d->penerbit }}</span></span>
                </div>
                <div class="row">
                    <span>Kategori : <span class="text-capitalize fw-semibold">{{ $d->kategori->kategori }}</span></span>
                </div>
            </div>
            <div class="ms-auto">
                <span><a href="{{ route('beranda.show', $d->id) }}" class="btn btn-outline-primary">Baca Buku</a></span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
