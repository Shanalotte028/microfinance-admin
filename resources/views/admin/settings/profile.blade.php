<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('dashboard') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>Profile</x-slot:heading>
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <x-admin.card-table-info> {{-- Profile Info Card --}}
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>First Name</x-slot:heading>
                            <div class="col-sm-8">
                           <input type="text" class="form-control" name="first_name" value="{{ Auth::user()->first_name ?? '' }}">
                            </div>
                            <x-admin.form-error name="first_name"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Last Name</x-slot:heading>
                            <div class="col-sm-8">
                           <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name ?? '' }}">
                            </div>
                            <x-admin.form-error name="first_name"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Email</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" value="{{ Auth::user()->email ?? ''  }}">
                            </div>
                            <x-admin.form-error name="email"></x-admin.form-error>

                            <div class="text-end mt-4 pe-4">
                                <button class="btn btn-success" type="submit"> Edit Information</button>
                            </div>
                            {{-- <div class="text-end mt-4 pe-4">
                                <a class="btn btn-success" href="{{ route('password.request') }}">Reset Password</a>
                            </div> --}}
                        </x-admin.card-table-info-tr>
                        </form>                                 
                </x-admin.card-table-info>     
            </div>
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>