<div class="card-header bg-white border-1 pb-2">
    <div class="d-flex gap-2 justify-content-between">
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-warning btn-sm buttonForm" id="btnSubmitCreate"><i
                    class="fa-solid fa-floppy-disk"></i> Simpan</button>
            <button type="button" class="btn btn-danger btn-sm" id="btnBatal"><i class="fa-regular fa-circle-xmark"></i>
                Batal</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnTambah"><i class="fa-solid fa-plus"></i>
                Baru</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnEdit"><i
                    class="fa-regular fa-pen-to-square"></i> Ubah</button>
            <button type="button" class="btn btn-primary btn-sm" id="btnCari"><i class="fa-solid fa-list"></i>
                Lihat</button>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" id="btnCetakParent"
                    aria-expanded="false">
                    <i class="fa-solid fa-print"></i> Nota
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <li><button class="dropdown-item" id="btnCetak">Cetak dgn harga</button></li>
                    <li><button class="dropdown-item" id="btnCetakCust">Cetak dgn harga customer</button>
                    </li>
                    <li><button class="dropdown-item" id="btnCetakKosong">Cetak tanpa harga</button></li>
                </ul>
            </div>
            <button type="button" class="btn btn-info btn-sm" id="btnCetakBarcode">
                <i class="fa-solid fa-print"></i> QR Code
            </button>
            <button type="button" class="btn btn-primary" id="conscale" onclick="connectSerial(false)">
                <i class="fa-solid fa-scale-balanced"></i> : Hubungkan</button>
        </div>
        <div>
            <div class="d-flex gap-2 ">
                <div class="position-relative" style="max-width:400px;">
                    <input id="cariDataNota" autocomplete="off"
                   >
                </div>
            </div>
        </div>
    </div>
</div>
