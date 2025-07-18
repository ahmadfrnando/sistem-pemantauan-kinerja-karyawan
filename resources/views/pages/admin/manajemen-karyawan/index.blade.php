@extends('layouts.admin')
@section('content')
<div class="row p-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize ps-3">Data Master Karyawan</h6>
                        <button type="button" id="tambah" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form">Tambah Karyawan</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table data-table">
                        <thead class="text-sm">
                            <tr>
                                <th class="text-center text-uppercase text-secondary font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Nama</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Posisi</th>
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
    @include('pages.admin.manajemen-karyawan.modal-form', ['title' => 'Tambah Karyawan', 'button' => 'Tambah Karyawan'] )
</div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var route = 'admin.manajemen-karyawan.index';
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama',
                name: 'nama',
            },
            {
                data: 'posisi',
                name: 'posisi',
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

        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var route = "{{ route('admin.manajemen-karyawan.destroy', ':id') }}";
            route = route.replace(':id', id);
            deleteDataAjax(route, table);
        });

        $(document).on('click', '#edit', function() {
            var id = $(this).data('id');
            $.ajax({
                url: `{{ route('admin.manajemen-karyawan.edit', ':id') }}`.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $('#nama').val(response.data.nama);
                    $('#posisi').val(response.data.posisi);
                    $('#id').val(response.data.id);
                    $('#formSubmit').attr('method', 'PUT');
                    $('#title').text('Ubah Data Karyawan');
                    $('#button-submit').text('Simpan Perubahan Data Karyawan');
                }
            });
        });

        $(document).on('click', '#tambah', function() {
            $('#formSubmit').attr('method', 'POST');
            $('#title').text('Tambah Data Karyawan');
            $('#button-submit').text('Tambah Data Karyawan');

        });

        let formSelector = '#formSubmit';
        let actionUrl = "{{ route('admin.manajemen-karyawan.store') }}";
        let successMessage = 'Data berhasil disimpan!';
        let redirectUrl = "{{ route('admin.manajemen-karyawan.index') }}";
        submitFormAjaxModal(formSelector, actionUrl, successMessage, redirectUrl);
    });
</script>
@endpush
@endsection