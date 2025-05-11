<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Contract: {{ $contract->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">

    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Sign Contract: {{ $contract->title }}</h1>
        
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-8">
            <div class="prose prose-invert max-w-none">
                {!! $contract->content !!}
            </div>
        </div>
        
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Your Signature</h2>
            
            <div class="border-2 border-dashed border-gray-600 p-4 mb-4 rounded-lg bg-gray-700">
                <canvas id="signaturePad" width="500" height="200" class="w-full border border-gray-500 rounded bg-white"></canvas>
            </div>
            
            <form method="POST" action="{{ route('contracts.process-signature', $contract) }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="signature_data" id="signatureData">
                
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 hover:bg-green-500 text-white rounded w-full">
                    Submit Signature
                </button>
            </form>

            <button id="clearSignature" type="button" 
                class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded mt-4">
                Clear Signature
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.getElementById('signaturePad');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });

        document.getElementById('clearSignature').addEventListener('click', () => {
            signaturePad.clear();
        });

        document.querySelector('form').addEventListener('submit', (e) => {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                alert('Please provide your signature');
            } else {
                document.getElementById('signatureData').value = 
                    signaturePad.toDataURL('image/svg+xml');
            }
        });

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
    </script>
</body>
</html>
