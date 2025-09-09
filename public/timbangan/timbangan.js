let port;
let textEncoder;
let writableStreamClosed;
let writer;
let historyIndex = -1;
let type_timbangan = "AND";
let weight = 0;
const lineHistory = [];
async function connectSerial() {
    try {
        const ports = await navigator.serial.getPorts();

        // Prompt user to select any serial port.
        port = await navigator.serial.requestPort();

        // if (!port) {
        //     port = ports[0];
        // }

        await port.open({
            baudRate: 9600,
        });

        textEncoder = new TextEncoderStream();
        writableStreamClosed = textEncoder.readable.pipeTo(port.writable);
        writer = textEncoder.writable.getWriter();

        var conscale = document.getElementById("conscale");
        conscale.classList.add("disabled");
        conscale.innerHTML = "<i class='fa-solid fa-scale-balanced'></i> : Terhubung";


        await listenToPort();
    } catch (e) {
        alert(
            " Harap Close Halaman Lain yang Terkoneksi ke Timbangan \n Pesan " +
                e
        );
    }
}

async function sendSerialLine() {
    // dataToSend = "S";
    if (type_timbangan == "AND") {
        dataToSend = "S";
    } else {
        dataToSend = "O9";
    }
    lineHistory.unshift(dataToSend);
    historyIndex = -1; // No history entry selected
    dataToSend = dataToSend + "\n";

    console.log("sendSerialLine");
    await writer.write(dataToSend);
    return dataToSend;
}
async function listenToPort() {
    console.log("listenToPort");
    const textDecoder = new TextDecoderStream();
    const readableStreamClosed = port.readable.pipeTo(textDecoder.writable);
    const reader = textDecoder.readable.getReader();

    // Listen to data coming from the serial device.
    while (true) {
        const { value, done } = await reader.read();
        if (done) {
            // Allow the serial port to be closed later.
            console.log("[readLoop] DONE", done);
            reader.releaseLock();
            break;
        }
        appendToTerminal(value);
    }
}

async function appendToTerminal(newStuff) {
    // TEST OK
    // newStuff = newStuff.replace(/[^.\d]/g, ''); //almas
    newStuff = newStuff.replace(/[^\d.-]+/g, ""); //arik
    newStuff = Number(newStuff).toFixed(2);
    weight = parseFloat(newStuff);
}

async function kliktimbang() {
    const sentValue = await sendSerialLine();
    return weight;
}
