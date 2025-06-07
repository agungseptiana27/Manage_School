<div class="flex flex-col items-start mt-4">
    <div class="text-sm font-medium text-gray-700 mb-2">
        QR Code
    </div>
    <div id="qrcode" class="rounded-lg border border-gray-300 p-2 shadow-md w-[120px] h-[120px] bg-white flex items-center justify-center">
        <!-- QR Code will be injected here -->
    </div>
</div>

<script src="{{ asset('qrcode.js') }}"></script>
<script>
    const qrContainer = document.getElementById("qrcode");
    qrContainer.innerHTML = ""; // Clear jika ada QR lama

    const qrcode = new QRCode(qrContainer, {
        width: 100,
        height: 100,
        correctLevel: QRCode.CorrectLevel.H
    });

    function makeCode() {
        const elText = "{{ $getRecord()->nis }}";
        qrcode.clear();
        qrcode.makeCode(elText);
    }

    makeCode();
</script>
