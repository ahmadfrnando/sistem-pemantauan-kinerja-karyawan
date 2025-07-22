@extends('layouts.karyawan')
@section('content')
<div class="row p-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">Daftar Tugas Baru</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    @if($tugas['tugasBelum']->isEmpty())
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex justify-content-center w-100 text-center align-items-center">
                            <figure class="figure">
                                <img src="{{ asset('assets/img/ill_no_data.svg') }}" width="100" height="100" alt="">
                                <figcaption class="figure-caption">Tidak Ada Tugas Baru</figcaption>
                            </figure>
                        </div>
                    </li>
                    @else
                    @foreach ($tugas['tugasBelum'] as $item)
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="row w-100 ">
                            <div class="col-md-8 d-flex flex-column">
                                <h6 class="mb-3 text-sm">{{ $item->nama_tugas }}</h6>
                                <span class="mb-2 text-xs">Dibuat pada: <span class="badge badge-pill bg-gradient-secondary">{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') ?? 'Belum Ditentukan' }}</span></span>
                                <span class="text-xs">Deskripsi: <span class="text-dark ms-sm-2 font-weight-bold">{{ $item->deskripsi ?? 'Tidak Ada Deskripsi' }}</span></span>
                            </div>
                            <div class="col-md-4 d-flex text-end ms-auto justify-content-end">
                                <button type="button" data-id="{{ $item->id }}" id="btn-assigned" class="btn btn-link text-info text-gradient px-3 mb-0 text-nowrap"><i class="material-symbols-rounded text-sm me-2">assignment</i>Assigned</button>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-12 d-flex align-items-center">
                        <h6 class="mb-0">Tugas Yang Sedang Dikerjakan</h6>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 pb-0">
                <ul class="list-group">
                    @if($tugas['tugasSudah']->isEmpty())
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex justify-content-center w-100 text-center align-items-center">
                            <figure class="figure">
                                <img src="{{ asset('assets/img/ill_no_data.svg') }}" width="100" height="100" alt="">
                                <figcaption class="figure-caption">Tidak Ada Tugas Yang Selesai</figcaption>
                            </figure>
                        </div>
                    </li>
                    @else
                    @foreach($tugas['tugasSudah'] as $item)
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') ?? 'Belum Ditentukan' }}</h6>
                            <span class="text-xs">{{ $item->nama_tugas }}</span>
                        </div>
                        <div class="d-flex align-items-center text-sm">
                            <button type="button" data-id="{{ $item->id }}" class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" data-bs-toggle="modal" data-bs-target="#modalUpload"><i class="material-symbols-rounded text-lg position-relative me-1">upload</i> Upload</button>
                        </div>
                    </li>
                    @include('pages.karyawan.daftar-tugas.modal-upload')
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.karyawan.footer')
@push('scripts')
<script type="text/javascript">
    $(function() {
        $('#btn-assigned').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = `{{ route('karyawan.daftar-tugas.update-tugas', ['jenis' => 'assigned', 'id' => ':id']) }}`;
            var redirectUrl = "{{ route('karyawan.daftar-tugas.index') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'PUT',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            confirmButtonText: 'Oke',
                            confirmButtonColor: '#5e72e4'
                        }).then((result) => {
                            if (result.isConfirmed && redirectUrl) {
                                window.location.href = redirectUrl;
                            }
                        });
                    } else {
                        Swal.fire('Gagal', response.message || 'Terjadi kesalahan.', 'error');
                    }
                }
            });
        });

        $('#uploadTugas').on('submit', function(e) {
            $('#modalUpload').modal('hide');
            e.preventDefault();
            var formData = new FormData(this);
            var redirectUrl = "{{ route('karyawan.daftar-tugas.index') }}";

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            confirmButtonText: 'Oke',
                            confirmButtonColor: '#5e72e4'
                        }).then((result) => {
                            if (result.isConfirmed && redirectUrl) {
                                window.location.href = redirectUrl;
                            }
                        });
                    } else {
                        Swal.fire('Gagal', response.message || 'Terjadi kesalahan.', 'error').then(() => {
                            $('#modalUpload').modal('show');
                        });
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection