@extends('layouts.karyawan')

@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="ms-3">
            <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
        </div>
        <div class="row">
            @if($tugas->count() > 0)
            @foreach($tugas as $t)
            <div class="col-md-6 col-6">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-dark shadow text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10">assignment</i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">{{ $t->nama-tugas }}</h6>
                        <span class="text-xs">{{ $t->deskripsi }}</span>
                        <span class="text-xs">. Dibuat pada:</span>
                        <span class="text-xs">{{ \Carbon\Carbon::parse($t->created_at)->format('d F Y') }}</span>
                        <hr class="horizontal dark my-3">
                        <a href="{{ route('karyawan.daftar-tugas.index') }}" class="btn btn-dark w-100 mt-2 mb-0">Lihat</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                        <div class="icon icon-shape icon-lg bg-gradient-dark shadow text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10">cancel</i>
                        </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                        <h6 class="text-center mb-0">Belum ada tugas</h6>
                        <a href="{{ route('karyawan.riwayat-tugas.index') }}" class="btn btn-dark w-100 mt-2 mb-0">Lihat Riwayat Tugas</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection