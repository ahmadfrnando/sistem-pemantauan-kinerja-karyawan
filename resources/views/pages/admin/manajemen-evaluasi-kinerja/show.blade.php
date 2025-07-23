@extends('layouts.admin')
@section('content')
<div class="row p-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize ps-3">Detail Evaluasi {{ $evaluasi->nama_evaluasi }}</h6>
                        <button type="button" id="regenerate" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form">Regenerate</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table">
                        <thead class="text-sm">
                            <tr>
                                <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Nama Karyawan</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Kehadiran</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Penyelesaian Tugas</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Total</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.admin.footer')
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var route = '{{ route("admin.manajemen-evaluasi-kinerja.show", $evaluasi->id) }}';
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'karyawan',
                name: 'karyawan',
            },
            {
                data: 'skor_kehadiran',
                name: 'skor_kehadiran',
                render: function(data, type, row) {
                    return (data ?? 0) + '%';
                }
            },
            {
                data: 'skor_tugas',
                name: 'skor_tugas',
                render: function(data, type, row) {
                    return (data ?? 0) + '%';
                }
            },
            {
                data: 'total_skor',
                name: 'total_skor',
                render: function(data, type, row) {
                    return (data ?? 0) + '%';
                }
            },
            {
                data: 'status_hasil',
                name: 'status_hasil',
            }
        ];
        var table = initializeDataTableParams(selector, route, columns);

        $(document).on('click', '#regenerate', function() {
            var route = '{{ route("admin.manajemen-evaluasi-kinerja.regenerate", $evaluasi->id) }}';
            regenerateAjax(route, table);
        });
    });
</script>
@endpush
@endsection