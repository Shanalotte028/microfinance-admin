<!-- resources/views/contracts/already-signed.blade.php -->
<!DOCTYPE html>
<html lang="en" class="bg-gray-900 text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Already Signed</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-900">

    <div class="max-w-2xl mx-auto py-12 px-6 text-center bg-gray-800 rounded-lg shadow-lg">
        <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>

        <h2 class="mt-4 text-3xl font-extrabold text-white">
            Contract Already Signed
        </h2>

        <p class="mt-4 text-gray-300">
            This contract was signed on
            <strong class="text-white">{{ \Carbon\Carbon::parse($contract->party_signed_at)->format('M j, Y g:i A') }}</strong>.
        </p>

        <div class="mt-6">
            <a href="{{ route('admin.contracts.download', $contract) }}" 
               class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-blue-700 text-white font-semibold rounded transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download Signed Copy
            </a>
        </div>
    </div>

</body>
</html>
