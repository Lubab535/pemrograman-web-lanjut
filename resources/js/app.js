

import Alpine from 'alpinejs';
import QRCode from 'qrcode';
import { Html5Qrcode } from 'html5-qrcode';

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll('[data-qr-code]').forEach((element) => {
    QRCode.toCanvas(element, element.dataset.qrCode, {
        width: 176,
        margin: 1,
        errorCorrectionLevel: 'M',
    });
});

const scannerElement = document.querySelector('#qr-reader');

if (scannerElement) {
    const statusElement = document.querySelector('#scanner-status');
    const form = document.querySelector('#attendance-form');
    const input = form.querySelector('[name="qr_token"]');
    const scanner = new Html5Qrcode(scannerElement.id);
    let submitted = false;

    scanner.start(
        { facingMode: 'environment' },
        { fps: 10, qrbox: { width: 240, height: 240 } },
        (decodedText) => {
            if (submitted) {
                return;
            }

            submitted = true;
            input.value = decodedText;
            statusElement.textContent = 'QR terbaca. Menyimpan absensi...';
            form.requestSubmit();
        },
        () => {},
    ).then(() => {
        statusElement.textContent = 'Kamera aktif. Arahkan ke QR pada KTS.';
    }).catch((error) => {
        statusElement.textContent = `Kamera tidak dapat digunakan: ${error}`;
    });
}
