<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaca Timbangan Lanjutan</title>
    <!-- Bootstrap CSS untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        /* Styling tambahan */
        .weight-display {
            font-size: 3rem;
            font-weight: bold;
        }

        #logContainer {
            max-height: 200px;
            overflow-y: auto;
            font-size: 0.8rem;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4"><i class="fas fa-weight"></i> Pembaca Timbangan Lanjutan</h1>
        <!-- Kartu untuk menampilkan status koneksi dan berat -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title" id="status">Status: Tidak Terhubung</h5>
                <p class="card-text" id="portInfo">Port: -</p>
                <div class="weight-display text-center my-4" id="weight">0.00 kg</div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" id="connectButton">
                        <i class="fas fa-plug"></i> Hubungkan Timbangan
                    </button>
                    <button class="btn btn-secondary" id="readButton" disabled>
                        <i class="fas fa-sync"></i> Baca Berat
                    </button>
                </div>
            </div>
        </div>

        <!-- Kartu untuk menampilkan riwayat pembacaan -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-history"></i> Riwayat Pembacaan</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Berat</th>
                        </tr>
                    </thead>
                    <tbody id="weightHistory">
                        <!-- Riwayat pembacaan akan ditampilkan di sini -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kartu untuk menampilkan log -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-terminal"></i> Log</h5>
                <div id="logContainer" class="bg-dark text-light p-2 rounded">
                    <!-- Log akan ditampilkan di sini -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- <script src="{!! asset('timbangan/utils.js') !!}"></script> --}}
    <script src="{!! asset('timbangan/scale-connection.js') !!}"></script>
    <script type="module">
        // Variabel global
        let scaleConnection = new ScaleConnection();
        let weightHistory = JSON.parse(localStorage.getItem('weightHistory')) || [];
        let isInitialized = false;
        let lastWeight = null;


        // Fungsi untuk menambahkan pesan ke log
        function log(message) {
            const logContainer = document.getElementById('logContainer');
            const logEntry = document.createElement('div');
            logEntry.textContent = `${new Date().toLocaleTimeString()} - ${message}`;
            logContainer.insertBefore(logEntry, logContainer.firstChild);
            console.log(message);
        }

        scaleConnection.startReading((weight) => {
            console.log('first')
            lastWeight = weight;
            document.getElementById('weight').textContent = weight + ' kg';
            console.log("Berat terbaca:", weight);
        });

        function ambilBerat() {
            if (lastWeight) {
                // Simpan ke history lokal
                weightHistory.push(lastWeight);
                localStorage.setItem('weightHistory', JSON.stringify(weightHistory));

                // Misalnya tampilkan di log atau inputan
                log(`Berat diambil: ${lastWeight} kg`);

                // Kalau ada input form, bisa isi otomatis
                // document.getElementById('inputBerat').value = lastWeight;
            } else {
                log("Belum ada berat yang terbaca dari timbangan.");
            }
        }



        async function initializeScale() {
            if (isInitialized) {
                log('Timbangan sudah diinisialisasi');
                return;
            }

            log('Memulai inisialisasi timbangan');
            if (!scaleConnection) {
                scaleConnection = new ScaleConnection();
            }
            try {
                await scaleConnection.connect();
                updateUI(true);
                // log('Koneksi berhasil, memulai pembacaan');
                // isInitialized = true;
                // scaleConnection.startReading((weight) => {
                //     document.getElementById('weight').textContent = weight + ' kg';
                //     console.log(weight)
                // });
            } catch (error) {
                log(`Error saat menghubungkan: ${error.message}`);
                updateUI(false);
                isInitialized = false;
            }
        }

        function updateUI(connected) {
            document.getElementById('status').textContent = connected ? 'Status: Terhubung' : 'Status: Tidak Terhubung';
            document.getElementById('readButton').disabled = !connected;
            const portInfo = scaleConnection ? scaleConnection.getPortInfo() : null;
            document.getElementById('portInfo').textContent = portInfo ?
                `Port: VendorID: ${portInfo.usbVendorId}, ProductID: ${portInfo.usbProductId}` :
                'Port: -';
        }

        document.getElementById('readButton').addEventListener('click', () => {
            log('Membaca berat (fungsi manual)');
            ambilBerat();
        });

        // Event listener saat halaman dimuat
        window.addEventListener('load', () => {
            log('Halaman dimuat');
           // updateWeightHistoryDisplay();
            initializeScale(); // Mencoba koneksi otomatis saat halaman dimuat
        });

        // Event listener saat tab menjadi aktif
        window.addEventListener('focus', async () => {
            log('Tab aktif kembali');
            if (!isInitialized || (scaleConnection && !scaleConnection.isConnected)) {
                await initializeScale(); // Mencoba menghubungkan kembali jika tidak terhubung
            }
        });

        // Event listener saat tab menjadi tidak aktif
        window.addEventListener('blur', () => {
            log('Tab tidak aktif');
            // if (scaleConnection && scaleConnection.isConnected) {
            //     scaleConnection.close(); // Menutup koneksi saat tab tidak aktif
            //     isInitialized = false;
            // }
        });
    </script>
</body>

</html>
