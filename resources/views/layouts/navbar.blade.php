<div class="card-header bg-white border-1 pb-2">
    <div class="d-flex gap-2 justify-content-between">
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-warning btn-sm buttonForm" id="btnSubmitCreate"><i
                    class="fa-solid fa-floppy-disk"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-sm" id="btnBatal"><i
                    class="fa-regular fa-circle-xmark"></i> Batal</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnTambah"><i
                    class="fa-solid fa-plus"></i> Baru</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnEdit"><i
                    class="fa-regular fa-pen-to-square"></i> Ubah</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnCari"><i
                    class="fa-solid fa-list"></i> Lihat</button>
            <button type="button" class="btn btn-info btn-sm" id="btnCetak"><i
                    class="fa-solid fa-print"></i>
                Nota
            </button>
            <button type="button" class="btn btn-info btn-sm" id="btnCetakBarcode">
                <i class="fa-solid fa-print"></i> QR Code
            </button>
            <button type="button" class="btn btn-primary" id="conscale" onclick="connectSerial(false)">
                <i class="fa-solid fa-scale-balanced"></i> : Hubungkan</button>
        </div>
        <div>
            <div class="d-flex gap-2 ">
                <div class="position-relative" style="max-width:400px;">
                    <input type="search" class="form-control" id="cariDataNota" autocomplete="off"
                        placeholder="Cari Nota">
                    <ul id="notaSuggestions" class="list-group position-absolute w-100"
                        style="z-index:1000; max-height:200px; overflow-y:auto; display:none;">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>