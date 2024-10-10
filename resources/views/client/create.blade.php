<x-admin.auth-layout>
    <x-slot:header>KYC FORM</x-slot:header>
    <div class="card mb-4">
        <div class="card-body">
            <form id="kyc-form" method="POST" action="{{ route('client.compliance.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="step-1" class="form-step">
                    <h5>Personal Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required />
                                <label for="first_name">First Name</label>
                                <x-admin.form-error name="first_name"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}"required />
                                <label for="last_name">Last Name</label>
                                <x-admin.form-error name="last_name"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"required />
                        <label for="phone_number">Phone Number</label>
                        <x-admin.form-error name="phone_number"></x-admin.form-error>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}"required />
                                <label for="birthday">Birthday</label>
                                <x-admin.form-error name="birthday"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" disabled {{ old('gender') === null ? 'selected' : '' }}>Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <label for="gender">Gender</label>
                                <x-admin.form-error name="gender"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="nationality" name="nationality" required>
                                    <option value="" disabled {{ old('nationality') == '' ? 'selected' : '' }}>Nationality</option>
                                    <option value="Filipino" {{ old('nationality') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                    <option value="Other" {{ old('nationality') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <label for="nationality">Nationality</label>
                                <x-admin.form-error name="nationality"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="marital_status" name="marital_status" required>
                                    <option value="" disabled {{ old('marital_status') == '' ? 'selected' : '' }}>Marital Status</option>
                                    <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Other" {{ old('marital_status') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <label for="marital_status">Marital Status</label>
                                <x-admin.form-error name="marital_status"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <h5>Proof of Identifaction</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="identification_proof" name="identification_proof" required>
                                    <option value="" disabled {{ old('identification_proof') == '' ? 'selected' : '' }}>Select Document Type</option>
                                    <option value="Proof of Identification" {{ old('identification_proof') == 'Passport' ? 'selected' : '' }}>Passport</option>
                                    <option value="Proof of Identification" {{ old('identification_proof') == 'National ID' ? 'selected' : '' }}>National ID</option>
                                    <option value="Proof of Identification" {{ old('identification_proof') == "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                                </select>
                                <label for="identification_proof">Document Type</label>
                                <x-admin.form-error name="identification_proof"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="identification_proof_upload" name="identification_proof_upload" required />
                                <label for="identification_proof_upload" class="custom-file-label">Upload Document</label>
                                <x-admin.form-error name="identification_proof_upload"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3"> <!-- Flexbox for right alignment -->
                        <button type="button" class="btn btn-primary me-2" onclick="nextStep(1)">Next</button>
                    </div>
                </div>
                <div id="step-2" class="form-step d-none">
                    <h5>Address</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="address_line_1" name="address_line_1" value="{{ old("address_line_1") }}" required />
                                <label for="address_line_1">Address Line 1</label>
                                <x-admin.form-error name="address_line_1"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="address_line_2" name="address_line_2" value="{{ old("address_line_2") }}" />
                                <label for="address_line_2">Address Line 2</label>
                                <x-admin.form-error name="address_line_2"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="city" name="city" required>
                                    <option value="" disabled {{ old('city') == '' ? 'selected' : '' }}>Select City</option>
                                    <option value="Caloocan City" {{ old('city') == 'Caloocan City' ? 'selected' : '' }}>Caloocan City</option>
                                    <option value="Quezon City" {{ old('city') == 'Quezon City' ? 'selected' : '' }}>Quezon City</option>
                                </select>
                                <label for="city">City</label>
                                <x-admin.form-error name="city"></x-admin.form-error>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="province" name="province" required>
                                    <option value="" disabled {{ old('province') == '' ? 'selected' : '' }}>Select Province</option>
                                    <option value="Metro Manila" {{ old('province') == 'Metro Manila' ? 'selected' : '' }}>Metro Manila</option>
                                </select>
                                <label for="province">Province</label>
                                <x-admin.form-error name="province"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-floating mb-3 col-md-6">
                        <select class="form-control" id="postal_code" name="postal_code" required>
                            <option value="" disabled {{ old('postal_code') == '' ? 'selected' : '' }}>Select Postal Code</option>
                            <option value="1001" {{ old('postal_code') == '1001' ? 'selected' : '' }}>1001</option>
                            <option value="1002" {{ old('postal_code') == '1002' ? 'selected' : '' }}>1002</option>
                        </select>
                        <label for="postal_code">Postal Code</label>
                        <x-admin.form-error name="postal_code"></x-admin.form-error>
                    </div>
                    <h5>Proof of address</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="address_proof" name="address_proof" required>
                                    <option value="" disabled {{ old('address_proof') == '' ? 'selected' : '' }}>Select Document Type</option>
                                    <option value="Proof of Address" {{ old('address_proof') == 'Proof of Address' ? 'selected' : '' }}>Utility Bills</option>
                                    <option value="Proof of Address" {{ old('address_proof') == 'Proof of Address' ? 'selected' : '' }}>Rental Agreement</option>
                                </select>
                                <label for="address_proof">Document Type</label>
                                <x-admin.form-error name="address_proof"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="address_proof_upload" name="address_proof_upload" required />
                                <label for="address_proof_upload" class="custom-file-label">Upload Document</label>
                                <x-admin.form-error name="address_proof_upload"></x-admin.form-error>
                            </div>
                        </div>
                    </div> 
                            
                    <div class="d-flex justify-content-end mt-3"> <!-- Flexbox for right alignment -->
                        <button type="button" class="btn btn-secondary me-2" onclick="prevStep(2)">Previous</button>
                        <button type="button" class="btn btn-primary me-2" onclick="nextStep(2)">Next</button>
                    </div>
                </div>
                <div id="step-3" class="form-step d-none">
                    <h5>Financial Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="source_of_income" name="source_of_income" required>
                                    <option value="" disabled {{ old('source_of_income') == '' ? 'selected' : '' }}>Select Source of Income</option>
                                    <option value="Employment Income" {{ old('source_of_income') == 'Employment Income' ? 'selected' : '' }}>Employment Income</option>
                                    <option value="Business Income" {{ old('source_of_income') == 'Business Income' ? 'selected' : '' }}>Business Income</option>
                                </select>
                                <label for="source_of_income">Source of Income</label>
                                <x-admin.form-error name="source_of_income"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="tin_number" name="tin_number" value="{{ old("tin_number") }}"required />
                                <label for="tin_number">TIN Number</label>
                                <x-admin.form-error name="tin_number"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <h5>Proof of Income</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="income_proof" name="income_proof" required>
                                    <option value="" disabled {{ old('income_proof') == '' ? 'selected' : '' }}>Select Document Type</option>
                                    <option value="Proof of Income" {{ old('income_proof') == 'Bank Statements' ? 'selected' : '' }}>Bank Statements</option>
                                    <option value="Proof of Income" {{ old('income_proof') == 'Employment Verification Letter' ? 'selected' : '' }}>Employment Verification Letter</option>
                                </select>
                                <label for="income_proof">Document Type</label>
                                <x-admin.form-error name="income_proof"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="income_proof_upload" name="income_proof_upload" required />
                                <label for="income_proof_upload" class="custom-file-label">Upload Document</label>
                                <x-admin.form-error name="income_proof_upload"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3"> <!-- Flexbox for right alignment -->
                        <button type="button" class="btn btn-secondary me-2" onclick="prevStep(3)">Previous</button>
                        <button type="button" class="btn btn-primary me-2" onclick="nextStep(3)">Next</button>
                    </div>
                </div>
                <div id="step-4" class="form-step d-none">
                    <h5>Confirmation</h5>
                    <p>Please review your information before submission.</p>
                    <div id="review-section">
                        <ul class="list-unstyled">
                            <!-- User inputs for review will be populated here -->
                        </ul>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="clientConsent" name="clientConsent" required>
                        <label class="form-check-label" for="clientConsent">
                            I confirm that the information I provided is true and accurate.
                        </label>
                        <x-admin.form-error name="clientConsent"></x-admin.form-error>
                    </div>
                
                    <div class="d-flex justify-content-end mt-3"> <!-- Flexbox for right alignment -->
                        <button type="button" class="btn btn-secondary me-2" onclick="prevStep(4)">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function showStep(step) {
            const steps = document.querySelectorAll('.form-step');
            steps.forEach((s) => s.classList.add('d-none'));
            document.getElementById(`step-${step}`).classList.remove('d-none');
        }

        function nextStep(step) {
            const inputs = document.querySelectorAll(`#step-${step} input, #step-${step} select`);
            let valid = true;

            inputs.forEach((input) => {
                if (!input.checkValidity()) {
                    valid = false;
                    input.reportValidity(); // Show validation message
                }
            });

            if (valid) {
                if (currentStep === 3) { // Assuming step 3 is the last step before confirmation
                    updateReviewSection(); // Update the review section before showing step 4
                }
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep(step) {
            currentStep--;
            showStep(currentStep);
        }

        function updateReviewSection() {
            const reviewSection = document.getElementById('review-section');
            reviewSection.innerHTML = ''; // Clear previous review
            const steps = document.querySelectorAll('.form-step');

            steps.forEach((s, index) => {
                if (index < currentStep) {
                    const inputs = s.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        const label = document.querySelector(`label[for="${input.id}"]`).innerText;
                        reviewSection.innerHTML += `<li><strong>${label}:</strong> <span>${input.value}</span></li>`;
                    });
                }
            });
        }

        // Initially show the first step
        showStep(currentStep);
    </script>

    <style>
        #review-section li {
    margin-bottom: 10px; /* Adjust the value as needed */
        }

        .d-none {
            display: none;
        }
    </style>
</x-admin.auth-layout>