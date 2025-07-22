@extends('layouts.karyawan')
@section('content')
<div class="row p-4">
    <div class="col-12">
        <div class="card mt-6">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize ps-3">Data Riwayat Tugas</h6>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table">
                        <thead class="text-sm">
                            <tr>
                                <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Nama Tugas</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Tanggal Mulai</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Tanggal Selesai</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Capaian</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.karyawan.footer')
</div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var route = 'karyawan.riwayat-tugas.index';
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama_tugas',
                name: 'nama_tugas',
            },
            {
                data: 'tanggal_mulai',
                name: 'tanggal_mulai',
                format: 'raw',
                render: function(data, type, row) {
                    return moment(data).format('DD-MM-YYYY') ?? '-';
                }
            },
            {
                data: 'tanggal_selesai',
                name: 'tanggal_selesai',
                format: 'DD-MM-YYYY',
                render: function(data, type, row) {
                    return (moment(data).format('DD-MM-YYYY') ?? '-');
                }
            },
            {
                data: 'capaian',
                name: 'capaian',
            }
        ];
        var table = initializeDataTable(selector, route, columns);
    });
</script>
@endpush
@endsection