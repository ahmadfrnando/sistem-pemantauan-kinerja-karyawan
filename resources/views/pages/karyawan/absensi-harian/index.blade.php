@extends('layouts.karyawan')
@section('content')
<div class="row p-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">Absensi Harian</h6>
            </div>
            <div class="card-body pt-4 p-3">
                @if($absen->where('tanggal', date('Y-m-d'))->count() > 0)
                <div>
                    <figure class="figure">
                        <img src="{{ asset('storage/absensi-harian/' . $absen->where('tanggal', date('Y-m-d'))->first()->bukti_absen) }}" class="figure-img img-fluid rounded" width="300" alt="Absensi Hari Ini">
                        <figcaption class="figure-caption">Anda sudah melakukan absensi hari ini. Terimakasih.</figcaption>
                    </figure>
                </div>
                @else
                <div>
                    <form id="absensi-form" method="POST" action="{{ route('karyawan.absensi-harian.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label class="ms-0">Silahkan ambil foto</label>
                                    <div id="my_camera"></div>
                                </div>

                                <button type="button" id="btn-open" class="btn btn-primary" onClick="load_snapshot()">Buka Camera</button>
                                <button type="button" id="btn-close" class="btn btn-primary" onClick="close_snapshot()">Tutup Camera</button>
                                <button type=button class="btn btn-info" onClick="take_snapshot()"><i class="material-symbols-rounded">camera</i></button>
                                <input type="hidden" name="bukti_absen" id="bukti_absen" class="image-tag">
                                <div class="input-group input-group-static mb-4">
                                    <div id="results">Foto anda akan muncul disini</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-12 d-flex align-items-center">
                        <h6 class="mb-0">Riwayat Absensi</h6>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 pb-0">
                <ul class="list-group">
                    @if($absen->count() > 0)
                    @foreach($absen as $data)
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Tanggal Absen</h6>
                            <span class="text-xs">{{ $data->tanggal }}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Jam Absen</h6>
                            <span class="text-xs">{{ $data->jam_absen }}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Jenis Absen</h6>
                            <span class="text-xs">{{ $data->jenis_absen }}</span>
                        </div>
                    </li>
                    @endforeach
                    @else
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex justify-content-center w-100 text-center align-items-center">
                            <figure class="figure">
                                <img src="{{ asset('assets/img/ill_no_data.svg') }}" width="100" height="100" alt="">
                                <figcaption class="figure-caption">Tidak Ada Absensi</figcaption>
                            </figure>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.karyawan.footer')
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script type="text/javascript">
    Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    $('#btn-close').hide();

    function load_snapshot() {
        Webcam.attach('#my_camera');
        $('#btn-open').hide();
        $('#btn-close').show();
    }

    function close_snapshot() {
        Webcam.reset();
        $('#btn-open').show();
        $('#btn-close').hide();
    }

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '" class="object-fit-sm-contain border rounded" width="490" height="350"/>';
            $('#btn-reset').show();
        });
    }

    $(document).ready(function() {
        $('#absensi-form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#absensi-form')[0]);
            var redirectUrl = "{{ route('karyawan.absensi-harian.index') }}";
            $.ajax({
                url: $('#absensi-form').attr('action'),
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                processData: false,
                contentType: false,
                success: function(response) {
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
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let res = xhr.responseJSON;
                        let errorMessages = Object.values(res.errors).flat().join('\n');
                        Swal.fire('Validasi Gagal', errorMessages, 'error');
                    } else {
                        Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection