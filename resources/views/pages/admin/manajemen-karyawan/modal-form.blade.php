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
                                <label>Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control">
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label>Posisi</label>
                                <input type="text" id="posisi" name="posisi" class="form-control">
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