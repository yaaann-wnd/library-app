@extends('navbar')

@section('content')
<div class="buku">
    <div class="text-capitalize">
        <h3>{{ $d->judul }}</h3>
    </div>
    <div class="text-capitalize mb-3">
        Kategori : <span class="fw-semibold">{{ $d->kategori->kategori }}</span>
    </div>
    <div>
        {{ $d->sinopsis }}
    </div>
</div>
    
@endsection