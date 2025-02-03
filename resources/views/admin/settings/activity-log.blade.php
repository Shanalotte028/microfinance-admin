<x-admin.dashboard-layout>
    <x-slot:heading>
        Activity Log
    </x-slot:heading>
            <x-admin.table-data>
                <x-slot:heading>
                    Users
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Old Data</th>
                        <th>New Data</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>                              
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user_id ?? 'System' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->module }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td>
                            <pre title="{{ json_encode($log->old_data, JSON_PRETTY_PRINT) }}">
                                {{ Str::limit(json_encode($log->old_data, JSON_PRETTY_PRINT), 50) }} <!-- Show only the first 50 characters -->
                            </pre>
                        </td>
                        <td>
                            <pre style="white-space: pre-wrap; word-wrap: break-word; max-width: 200px; overflow: auto; margin: 0;" title="{{ json_encode($log->new_data, JSON_PRETTY_PRINT) }}">
                                {{ Str::limit(json_encode($log->new_data, JSON_PRETTY_PRINT), 50) }} <!-- Show only the first 50 characters -->
                            </pre>
                        </td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
            <x-client.success-popup/>
</x-admin.dashboard-layout>