(function () {
    let port;
    let textEncoder;
    let writer;
    let weight = 0;
    let type_timbangan = "AND";

    async function connectSerial(auto = false) {
        try {
            const savedPortInfo = JSON.parse(localStorage.getItem("savedPort"));
            const ports = await navigator.serial.getPorts();

            if (auto && savedPortInfo) {
                port = ports.find((p) => {
                    const info = p.getInfo();
                    return (
                        info.usbVendorId === savedPortInfo.usbVendorId &&
                        info.usbProductId === savedPortInfo.usbProductId
                    );
                });

                if (!port) {
                    console.log("Auto connect gagal: port tidak ditemukan.");
                    return;
                }
            }

            if (!port) {
                port = await navigator.serial.requestPort();
                const info = port.getInfo();
                localStorage.setItem("savedPort", JSON.stringify(info));
            }

            await port.open({ baudRate: 9600 });

            textEncoder = new TextEncoderStream();
            textEncoder.readable.pipeTo(port.writable);
            writer = textEncoder.writable.getWriter();

            const conscale = document.getElementById("conscale");
            if (conscale) {
                conscale.classList.add("disabled");
                conscale.innerHTML =
                    "<i class='fa-solid fa-scale-balanced'></i> : Terhubung";
            }

            await listenToPort();
        } catch (e) {
            if (!auto) {
                alert(
                    "Harap tutup halaman lain yang pakai timbangan.\nPesan: " +
                        e
                );
            } else {
                console.warn("Auto reconnect gagal:", e);
            }
        }
    }

    async function sendSerialLine() {
        let dataToSend = type_timbangan === "AND" ? "S" : "O9";
        await writer.write(dataToSend + "\n");
    }

    async function listenToPort() {
        const textDecoder = new TextDecoderStream();
        port.readable.pipeTo(textDecoder.writable);
        const reader = textDecoder.readable.getReader();

        while (true) {
            const { value, done } = await reader.read();
            if (done) {
                reader.releaseLock();
                break;
            }
            appendToTerminal(value);
        }
    }

    function appendToTerminal(newStuff) {
        newStuff = newStuff.replace(/[^\d.-]+/g, "");
        newStuff = Number(newStuff).toFixed(2);
        weight = parseFloat(newStuff);
    }

    async function kliktimbang() {
        await sendSerialLine();
        return weight;
    }

    // Expose ke global window
    window.connectSerial = connectSerial;
    window.kliktimbang = kliktimbang;
})();
