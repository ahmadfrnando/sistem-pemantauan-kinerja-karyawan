<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h5 id="title" class=""></h5>
                    </div>
                    <div class="card-body">
                        <form id="formSubmit" role="form text-left">
                            @csrf
                            <input type="number" id="id" name="id" hidden readonly>
                            <div class="input-group input-group-static mb-4">
                                <label>Nama Evaluasi</label>
                                <input type="text" id="nama_evaluasi" name="nama_evaluasi" class="form-control" oninput="capitalizeWords(this)" placeholder="Masukkan Nama Evaluasi">
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label for="bulan" class="ms-0">Pilih Bulan</label>
                                <select class="form-control" id="bulan" name="bulan">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label for="tahun" class="ms-0">Pilih Tahun</label>
                                <select class="form-control" id="tahun" name="tahun">
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" id="button-submit" class="btn btn-primary btn-lg w-100 mt-4 mb-0"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>