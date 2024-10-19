<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Record
    </x-slot:heading>
    
    <div class="row">
        {{-- compliance file column --}} 
        <div class="col-md-6 p-4">
            @if(is_null($compliance))
                <p>No KYC documents available.</p>
            @else           
            <x-admin.card-table-info>
                <x-slot:heading>{{ $compliance->document_type }}</x-slot:heading>
                @php
                    $fileExtension = pathinfo($compliance->document_path, PATHINFO_EXTENSION); // Get the file extension
                @endphp
                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ Storage::url($compliance->document_path) }}" class="img-fluid" loading="lazy">
                @elseif($fileExtension === 'pdf')
                    <div id="pdf-viewer" style="width: 100%; height: 600px; overflow: auto;"></div>
                @else
                    <a href="{{ Storage::url($compliance->document_path) }}" download>Download {{ ucfirst($compliance->document_type) }}</a>
                @endif
            </x-admin.card-table-info>
            @endif
        </div>

        {{-- compliance info column --}} 
        <div class="col-md-6 p-4">
            @if(is_null($compliance))
                <p>No KYC documents available.</p>
            @else
                <form action="{{ route('admin.compliance.approve', ['client' => $client->id, 'compliance' => $compliance->id]) }}" method="POST" onsubmit="return confirmApproval();">
                    @csrf
                    @method('PATCH')
        
                    <x-admin.card-table-info>
                        <x-slot:heading>{{ $compliance->compliance_type }}</x-slot:heading>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Compliance Record ID</x-slot:heading>
                            {{ $compliance->id }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client ID</x-slot:heading>
                            {{ $compliance->client_id }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client Email</x-slot:heading>
                            {{ $compliance->client->email }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Compliance Type</x-slot:heading>
                            {{ $compliance->compliance_type }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Document Type</x-slot:heading>
                            {{ $compliance->document_type }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Document Status</x-slot:heading>
                            {{ $compliance->document_status }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Submission Date</x-slot:heading>
                            {{ $compliance->submission_date }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Approval Date</x-slot:heading>
                            {{ $compliance->approval_date ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Remarks</x-slot:heading>
                            {{ $compliance->remarks ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        @if ($compliance->document_status !=='approved')
                            <x-slot:button>
                                <button class="btn btn-success" type="submit">Approve</button>
                            </x-slot:button>
                        @endif
                    </x-admin.card-table-info>
                </form>
            @endif          
        </div>        
    </div>
    <script>
        
        function confirmApproval() {
            return confirm('Are you sure you want to approve this compliance document?');
        }
        document.addEventListener("DOMContentLoaded", function () {
            // Check if the document type is PDF
            @if($fileExtension === 'pdf')
                const url = '{{ Storage::url($compliance->document_path) }}';
                const pdfViewer = document.getElementById('pdf-viewer');
    
                // Asynchronously download PDF
                pdfjsLib.getDocument(url).promise.then(pdf => {
                    const scale = 1; // Adjust scale to your preference
                    pdf.getPage(1).then(page => {
                        const viewport = page.getViewport({ scale });
    
                        // Prepare canvas using PDF page dimensions
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        pdfViewer.appendChild(canvas);
    
                        // Render PDF page into canvas context
                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport,
                        };
                        page.render(renderContext);
                    });
                }).catch(function(error) {
                    console.error("Error loading PDF: ", error);
                });
            @endif
        });
    </script>
</x-admin.dashboard-layout>
