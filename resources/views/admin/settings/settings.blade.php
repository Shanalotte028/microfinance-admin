<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('dashboard') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>Settings</x-slot:heading>
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <x-admin.card-table-info> {{-- Profile Info Card --}}
                    <h1 class="text-light">Appearance</h5>
                    <hr/>
                    <h5 class="text-light">Theme</h5>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="themeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Choose Theme
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="themeDropdown" style="z-index: 1050;">
                            <li><a class="dropdown-item" href="#" id="lightMode">Light Mode</a></li>
                            <li><a class="dropdown-item" href="#" id="darkMode">Dark Mode</a></li>
                        </ul>
                    </div>
                    <button class="mt-4 btn btn-success" id="applyTheme">Apply</button>
                </x-admin.card-table-info>     
            </div>
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lightModeBtn = document.getElementById('lightMode');
        const darkModeBtn = document.getElementById('darkMode');
        const applyBtn = document.getElementById('applyTheme');
        const body = document.body;

        let selectedTheme = localStorage.getItem('theme') || 'light';

        // Function to apply the selected theme
        function applyTheme(theme) {
            if (theme === 'dark') {
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            }
        }

        // Apply the stored theme on page load
        applyTheme(selectedTheme);

        // Set the selected theme when dropdown item is clicked
        lightModeBtn.addEventListener('click', function() {
            selectedTheme = 'light';
        });

        darkModeBtn.addEventListener('click', function() {
            selectedTheme = 'dark';
        });

        // Apply theme when 'Apply' button is clicked
        applyBtn.addEventListener('click', function() {
            applyTheme(selectedTheme);
        });
    });
</script>