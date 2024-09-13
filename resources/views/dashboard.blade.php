<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                        <x-cards></x-cards>
                        <x-charts></x-charts>
                        <x-table-data>
                            <x-slot:heading>
                                Example
                            </x-slot:heading>
                        </x-table-data>
                </div>
            </main>
            <x-footer/>
        </div>
    </div>
<x-foot/>