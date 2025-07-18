@extends('layouts.admin')
@section('content')
<div class="row p-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Ubah Tugas</h6>
                </div>
            </div>
            <div class="card-body p-4 mt-4">
                <form id="editTugas">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static my-3">
                                <label class="form-label">Nama Karyawan</label>
                                <select class="form-control" id="karyawan_id" name="karyawan_id" style="width: 100%; height: 100%" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static my-3">
                                <input type="text" name="nama_tugas" value="{{ $tugas->nama_tugas }}" placeholder="Nama Tugas" id="nama_tugas" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group input-group-dynamic">
                                <textarea class="form-control" rows="5" name="deskripsi" id="deskripsi" value="{{ $tugas->deskripsi }}" placeholder="Berikan deskripsi terhadap tugas yang diberikan." spellcheck="false"></textarea>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.manajemen-tugas.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @include('layouts.partials.admin.footer')
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        let formSelector = '#editTugas';
        let actionUrl = "{{ route('admin.manajemen-tugas.update', ':id') }}".replace(':id', '{{ $tugas->id}}');
        let successMessage = 'Data berhasil disimpan!';
        let redirectUrl = "{{ route('admin.manajemen-tugas.index') }}";

        submitFormAjax(formSelector, actionUrl, successMessage, redirectUrl);

        $('#karyawan_id').select2({
            placeholder: 'Pilih Karyawan',
            allowClear: true,
            width: 'resolve',
            data: [{
                id: '{{ $tugas->karyawan->id }}',
                text: '{{ $tugas->karyawan->nama }}'
            }],
            ajax: {
                url: route('search.karyawan'),
                dataType: 'json',
                processResults: data => {
                    return {
                        results: data.map(res => {
                            return {
                                text: res.nama,
                                id: res.id,
                            }
                        })
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection