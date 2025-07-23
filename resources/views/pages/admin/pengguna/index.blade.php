@extends('layouts.admin')
@section('content')
<div class="row p-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <h6 class="text-white text-capitalize ps-3">Data Master Pengguna</h6>
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
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Username</th>
                                <th class="text-uppercase text-secondary font-weight-bolder opacity-7">Status</th>
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
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var route = 'admin.manajemen-pengguna.index';
        var selector = ".data-table";
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                className: 'w-8 text-center',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'username',
                name: 'username',
            },
            {
                data: 'is_online',
                name: 'is_online',
                orderable: false,
                searchable: false,
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
            var route = "{{ route('admin.manajemen-pengguna.destroy', ':id') }}";
            route = route.replace(':id', id);
            deleteDataAjax(route, table);
        });
    });

    $(document).on('click', '#edit', function() {
        let id = $(this).data('id');
        // $('#user_id').val(id);
        let actionUrl = "{{ route('admin.manajemen-pengguna.update', ':id') }}".replace(':id', id);
        // $('#ubahSandi').attr('action', actionUrl);
        let successMessage = 'Data berhasil diubah!';
        let redirectUrl = "{{ route('admin.manajemen-pengguna.index') }}";
        submitFormAjaxModal(actionUrl, successMessage, redirectUrl);
    });

    // $(document).on('click', '#savePassword', function() {
    //     let formSelector = '#ubahSandi';
    //     let actionUrl = $(formSelector).attr('action');
    //     let successMessage = 'Data berhasil diubah!';
    //     let redirectUrl = "{{ route('admin.manajemen-pengguna.index') }}";
    //     submitFormAjaxModal(formSelector, actionUrl, successMessage, redirectUrl);
    // });

    function submitFormAjaxModal(actionUrl, successMessage, redirectUrl) {
        Swal.fire({
            title: "Ubah Password",
            html: `
                <form>
                    <input id="password" name="password" class="swal2-input" type="password" placeholder="New Password">
                    <input id="password_confirmation" name="password_confirmation" class="swal2-input" type="password" placeholder="Confirm Password">
                </form>
                `,
            focusConfirm: false,
            preConfirm: () => {
                const password = document.getElementById("password").value;
                const passwordConfirmation = document.getElementById("password_confirmation").value;
                if (password !== passwordConfirmation) {
                    Swal.showValidationMessage('Passwords do not match');
                    return false;
                }
                return {
                    password: password,
                    password_confirmation: passwordConfirmation
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: actionUrl,
                    method: 'PUT',
                    data: result.value,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: successMessage || `${response.message}`,
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

                            Swal.fire('Validasi Gagal', errorMessages, 'error').then(() => {
                                submitFormAjaxModal(actionUrl, successMessage, redirectUrl);
                            });
                        } else {
                            Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                        }
                    }
                });
            }
        });
    }
</script>
@endpush
@endsection