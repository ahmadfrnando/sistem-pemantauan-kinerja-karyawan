function submitFormAjax(formSelector, actionUrl, successMessage, redirectUrl) {
    $(formSelector).on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: form.serialize(),
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
                    Swal.fire('Validasi Gagal', errorMessages, 'error');
                } else {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }
        })
    });
}

function submitFormAjaxModal(formSelector, actionUrl, successMessage, redirectUrl) {
    $(formSelector).on('submit', function(e) {
        $('#modal-form').modal('hide');
        e.preventDefault();
        
        let form = $(this);
        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: form.serialize(),
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
                    if ((result.isConfirmed && redirectUrl)) {
                        window.location.href = redirectUrl;
                    }
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    let errorMessages = Object.values(res.errors).flat().join('\n');
                    Swal.fire('Validasi Gagal', errorMessages, 'error').then(() => {
                        $('#modal-form').modal('show');
                    });
                } else {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error').then(() => {
                        $('#modal-form').modal('show');
                    });
                }
            }
        })
    });
}


function deleteDataAjax(url, table) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }).always(function() {
                $.ajaxSetup({
                    headers: {}
                });
            });
        }
    }).catch(function(e) {
        e.preventDefault();
    });
}

function initializeDataTable(tableSelector, ajaxRoute, columnsConfig) {
  var table = $(tableSelector).DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: route(ajaxRoute),
    columns: columnsConfig,
    initComplete: function () {
                this.api().columns([3]).every(function () {
                    var column = this;
                    var select = $('<select class="form-control"><option value="">Filter by Role</option></select>')
                        .appendTo($(column.header()).empty())
                        .on('change', function () {
                            var val = $(this).val();
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column.data().unique().sort().each(function (d) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                });
            },
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json', // CDN Bahasa Indonesia
    }
  });

  // Custom pagination icons
  table.on('draw', function() {
    $('#DataTables_Table_0_previous a').html('<i class="fas fa-solid fa-chevron-left"></i>');
    $('#DataTables_Table_0_next a').html('<i class="fas fa-solid fa-chevron-right"></i>');
  });

  return table;
}

function updateStatusAjax(url, table, status) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Status data akan diubah menjadi "+status+"!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Saya Yakin!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                url: url,
                method: 'POST',
                success: function(response) {
                    Swal.fire('Berhasil', response.message, 'success');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            }).always(function() {
                $.ajaxSetup({
                    headers: {}
                });
            });
        }
    }).catch(function(e) {
        e.preventDefault();
    });
}
