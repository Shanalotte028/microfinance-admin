<x-admin.header class="bg-dark-low sb-nav-fixed"/>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container pb-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-{{ $column_size ?? 6 }}">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
                                <div class="card-header"><h3 class="text-center font-weight-muted my-4 text-light">{{ $header }}</h3></div>
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <x-admin.footer/>
<x-admin.foot/>