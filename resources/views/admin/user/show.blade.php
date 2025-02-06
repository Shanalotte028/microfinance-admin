<x-admin.dashboard-layout>
    <x-slot:heading>
        User: {{$user->id}}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>User: {{"$user->first_name $user->last_name ($user->email)"}} <a href="{{route('admin.user.edit', $user)}}" class="btn btn-success d-none d-md-inline-block">Update user</a></x-slot:heading>
                    <x-slot:heading_child> <a href="{{route('admin.user.edit', $user)}}" class="btn btn-success d-md-none">Update user</a></x-slot:heading>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>User ID</x-slot:heading>
                            {{ $user->id }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>First Name</x-slot:heading>
                            {{ $user->first_name }} 
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Last Name</x-slot:heading>
                            {{ $user->last_name }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Role</x-slot:heading>
                            {{$user->role}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Email</x-slot:heading>
                            {{ $user->email }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Created At</x-slot:heading>
                            {{ $user->created_at }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr >
                            <x-slot:heading>Updated At</x-slot:heading>
                        <div>
                            <p>{{ $user->updated_at }}</p>
                        </div>
                        </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>