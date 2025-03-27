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
                            <x-slot:heading>Status</x-slot:heading>
                            {{ $user->status }}
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
            @if($user->role === "Field Officer")
                @if($investigations->isEmpty())
                <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>No investigations assigned.</x-slot:heading>
                </x-admin.card-table-info>
                </div>
                @else
                    <div class="col-md-6">
                        <x-admin.card-table-list>
                            <x-slot:heading>Assigned investigations</x-slot:heading>
                            <x-slot:table_row>
                                <th class="col-3">ID</th>
                                <th class="col-3">Client ID</th>
                                <th class="col-3">Officer ID</th>
                                <th class="col-3">Verified</th>
                                <th class="col-3">Created At</th>
                                <th class="col-2">Updated At</th>
                            </x-slot:table_row>
                            @foreach ($investigations as $investigation)
                                <tr>
                                    <td>{{ $investigation->id ?? 'n/a' }}</td>
                                    <td>{{ $investigation->client_id ?? 'n/a' }}</td>
                                    <td>{{ $investigation->officer_id ?? 'n/a' }}</td>
                                    <td>{{ $investigation->verified ? 'Yes' : 'No' }}</td>
                                    <td>{{ $investigation->created_at ?? 'n/a' }}</td>
                                    <td>{{ $investigation->uploaded_at ?? 'n/a' }}</td>
                                </tr>
                            @endforeach
                        </x-admin.card-table-list>
                    </div>
                @endif
            @endif
            @if($user->role === "Lawyer")
                @if($cases->isEmpty())
                <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>No cases assigned.</x-slot:heading>
                </x-admin.card-table-info>
                </div>
                @else
                    <div class="col-md-6">
                        <x-admin.card-table-list>
                            <x-slot:heading>Assigned Cases</x-slot:heading>
                            <x-slot:table_row>
                                <th class="col-3">Case Number</th>
                                <th class="col-3">Title</th>
                                <th class="col-3">Client Name</th>
                                <th class="col-3">Case Status</th>
                                <th class="col-2">Filing Date</th>
                            </x-slot:table_row>
                            @foreach ($cases as $case)
                                <tr>
                                    <td>{{ $case->case_number ?? 'n/a' }}</td>
                                    <td>{{ $case->title ?? 'n/a' }}</td>
                                    <td>{{$case->client->first_name.' '. $case->client->last_name}}</td>
                                    <td>{{ ucfirst($case->status) ?? 'n/a' }}</td>
                                    <td>{{ $case->filing_date ?? 'n/a' }}</td>
                                </tr>
                            @endforeach
                        </x-admin.card-table-list>
                    </div>
                @endif
            @endif
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>