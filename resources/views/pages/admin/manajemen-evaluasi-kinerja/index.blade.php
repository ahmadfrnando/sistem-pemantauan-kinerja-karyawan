@extends('layouts.admin')
@section('content')
<div class="row p-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize ps-3">Data Master Evaluasi Kinerja</h6>
                        <button type="button" id="tambah" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form">Tambah Evaluasi Kinerja</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table">
                        <thead class="text-sm">
                            <tr>
                                <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Nama Evaluasi</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Bulan</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Tahun</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7"></th>
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
    @include('pages.admin.manajemen-evaluasi-kinerja.modal-form', ['title' => 'Tambah Karyawan', 'button' => 'Tambah Karyawan'] )

</div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var route = 'admin.manajemen-evaluasi-kinerja.index';
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama_evaluasi',
                name: 'nama_evaluasi',
            },
            {
                data: 'bulan',
                name: 'bulan',
            },
            {
                data: 'tahun',
                name: 'tahun',
            },
            {
                data: 'action',
                name: 'action',
                className: 'text-center',
                orderable: false,
                searchable: false
            }
        ];
        var table = initializeDataTable(selector, route, columns);

        $(document).on('click', '#tambah', function() {
            $('#formSubmit').attr('method', 'POST');
            $('#title').text('Tambah Data Evaluasi');
            $('#button-submit').text('Tambah Data Evaluasi');

        });

        let formSelector = '#formSubmit';
        let actionUrl = "{{ route('admin.manajemen-evaluasi-kinerja.store') }}";
        let successMessage = 'Data berhasil disimpan!';
        let redirectUrl = "{{ route('admin.manajemen-evaluasi-kinerja.index') }}";
        submitFormAjaxModal(formSelector, actionUrl, successMessage, redirectUrl);
    });
</script>
@endpush
@endsection