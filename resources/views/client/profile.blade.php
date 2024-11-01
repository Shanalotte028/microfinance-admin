<x-client.layout>
    <x-client.header/>
    <main class="main">
      <x-client.page-title>Compliance</x-client.page-title>
  
    <!-- Compliance Section Section -->
      <section class="contact section dark-background">
        <div class="container section-title" data-aos="fade-up">
            <h2>Profile</h2>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-7 bg">
            <form action="{{ route('client.profile.update', ['client'=>$client->id]) }}" method="POST" class="php-email-form" onsubmit="return confirm('Are you sure you want to update your Profile?');">
                @csrf
                @method('PATCH')
                <div class="row gy-4">
                    <!-- Name -->
                    <div class="col-md-6">
                        <label for="first_name" class="pb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $client->first_name ?? '' }}" required>
                        <x-admin.form-error name="first_name"></x-admin.form-error>
                    </div>
        
                    <div class="col-md-6">
                        <label for="last_name" class="pb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $client->last_name ?? '' }}" required>
                        <x-admin.form-error name="last_name"></x-admin.form-error>
                    </div>
        
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="pb-2">Your Email</label>
                        <input type="email" class="form-control" name="email" id="email-field" value="{{ $client->email ?? '' }}" required>
                        <x-admin.form-error name="email"></x-admin.form-error>
                    </div>
        
                    <!-- Phone Number -->
                    <div class="col-md-6">
                        <label for="phone_number" class="pb-2">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number-field" value="{{ $client->phone_number ?? '' }}" required>
                        <x-admin.form-error name="phone_number"></x-admin.form-error>
                    </div>
        
                    <!-- Gender -->
                    <div class="col-md-6">
                        <label for="gender" class="pb-2">Gender</label>
                        <select class="form-select" name="gender" id="gender-field" required>
                            <option value="{{ $client->gender }}" selected>{{ $client->gender ?? 'Select Gender' }}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <x-admin.form-error name="gender"></x-admin.form-error>
                    </div>
        
                    <!-- Client Status -->
                    <div class="col-md-6">
                        <label for="client_status" class="pb-2">Client Status</label>
                        <select class="form-select" name="client_status" id="client_status-field" required>
                            <option value="{{ $client->client_status }}" selected>{{ $client->client_status ?? 'Select Client Status' }}</option>
                            <option value="Verified">Verified</option>
                            <option value="Unverified">Unverified</option>
                        </select>
                        <x-admin.form-error name="client_status"></x-admin.form-error>
                    </div>
        
                    <!-- Address -->
                    <div class="col-md-12">
                        <label for="address_line_1" class="pb-2">Address Line 1</label>
                        <input type="text" class="form-control" name="address_line_1" id="address_line_1-field" value="{{ $client->addresses->first()->address_line_1 ?? '' }}" required>
                        <x-admin.form-error name="address_line_1"></x-admin.form-error>
                    </div>
        
                    <div class="col-md-12">
                        <label for="address_line_2" class="pb-2">Address Line 2</label>
                        <input type="text" class="form-control" name="address_line_2" id="address_line_2-field" value="{{ $client->addresses->first()->address_line_2 ?? '' }}">
                        <x-admin.form-error name="address_line_2"></x-admin.form-error>
                    </div>
        
                    <!-- City and Province -->
                    <div class="col-md-6">
                        <label for="city" class="pb-2">City</label>
                        <input type="text" class="form-control" name="city" id="city-field" value="{{ $client->addresses->first()->city ?? '' }}" required>
                        <x-admin.form-error name="city"></x-admin.form-error>
                    </div>
        
                    <div class="col-md-6">
                        <label for="province" class="pb-2">Province</label>
                        <input type="text" class="form-control" name="province" id="province-field" value="{{ $client->addresses->first()->province ?? '' }}" required>
                        <x-admin.form-error name="province"></x-admin.form-error>
                    </div>
        
                    <!-- Postal Code -->
                    <div class="col-md-6">
                        <label for="postal_code" class="pb-2">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code" id="postal_code-field" value="{{ $client->addresses->first()->postal_code ?? '' }}" required>
                        <x-admin.form-error name="postal_code"></x-admin.form-error>
                    </div>
        
                    <!-- Update Button: Display only if client is Verified -->
                    @if($client->client_status === 'Verified')
                        <div class="col-md-12 text-end">
                            <button type="submit">Update Client</button>
                        </div>
                    @endif
        
                </div>
            </form>
        </div>
        </div>
        </section>
      <!-- /Compliance Section Section -->
      <!-- Include the success pop-up component -->
      <x-client.success-popup/>
    </main>
  
   
  </x-client.layout>