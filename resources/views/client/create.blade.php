<x-admin.auth-layout>
    <x-slot:header>KYC FORM</x-slot:header>
    <div class="card mb-4">
        <div class="card-body">
            <form id="kyc-form" method="POST" action="{{ route('client.register.post') }}">
                @csrf
                <div id="step-1" class="form-step">
                    <h5>Personal Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="first_name" name="first_name" required />
                                <label for="first_name">First Name</label>
                                <x-admin.form-error name="first_name"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="last_name" name="last_name" required />
                                <label for="last_name">Last Name</label>
                                <x-admin.form-error name="last_name"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone_number" name="phone_number" required />
                        <label for="phone_number">Phone Number</label>
                        <x-admin.form-error name="phone_number"></x-admin.form-error>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="birthday" name="birthday" required />
                                <label for="birthday">Birthday</label>
                                <x-admin.form-error name="birthday"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
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
                                    <option value="" disabled selected>Nationality</option>
                                    <option value="Filipino">Filipino</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label for="nationality">Nationality</label>
                                <x-admin.form-error name="nationality"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="marital_status" name="marital_status" required>
                                    <option value="" disabled selected>Marital Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Other">Other</option>
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
                                    <option value="" disabled selected>Select Document Type</option>
                                    <option value="Proof of Identification">Passport</option>
                                    <option value="Proof of Identification">National ID</option>
                                    <option value="Proof of Identification">Driver's License</option>
                                </select>
                                <label for="identification_proof">Document Type</label>
                                <x-admin.form-error name="identification_proof"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="identifcation_proof_upload" name="identifcation_proof_upload" required />
                                <label for="identifcation_proof_upload" class="custom-file-label">Upload Document</label>
                                <x-admin.form-error name="identifcation_proof_upload"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
                </div>
                <div id="step-2" class="form-step d-none">
                    <h5>Address</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="address_line_1" name="address_line_1" required />
                                <label for="address_line_1">Address Line 1</label>
                                <x-admin.form-error name="address_line_1"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="address_line_2" name="address_line_2" />
                                <label for="address_line_2">Address Line 2</label>
                                <x-admin.form-error name="address_line_2"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="city" name="city" required />
                                <label for="city">City</label>
                                <x-admin.form-error name="city"></x-admin.form-error>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="province" name="province" required />
                                <label for="province">Province</label>
                                <x-admin.form-error name="province"></x-admin.form-error>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="postal_code" name="postal_code" required />
                        <label for="postal_code">Postal Code</label>
                        <x-admin.form-error name="postal_code"></x-admin.form-error>
                    </div>
                    <h5>Proof of address</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="address_proof" name="address_proof" required>
                                    <option value="" disabled selected>Select Document Type</option>
                                    <option value="Proof of Address">Utility Bills</option>
                                    <option value="Proof of Address">Rental Agreement</option>
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
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Back</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
                </div>
                <div id="step-3" class="form-step d-none">
                    <h5>Financial Information</h5>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="source_of_income" name="source_of_income" required />
                        <label for="source_of_income">Source of Income</label>
                        <x-admin.form-error name="source_of_income"></x-admin.form-error>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="tin_number" name="tin_number" required />
                        <label for="tin_number">TIN Number</label>
                        <x-admin.form-error name="tin_number"></x-admin.form-error>
                    </div>
                    <h5>Proof of Income</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-control" id="income_proof" name="income_proof" required>
                                    <option value="" disabled selected>Select Document Type</option>
                                    <option value="Proof of Income">Bank Statements</option>
                                    <option value="Proof of Income">Employment Verification Letter</option>
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
                    <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
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
            const inputs = document.querySelectorAll(`#step-${step} input`);
            let valid = true;

            inputs.forEach((input) => {
                if (!input.checkValidity()) {
                    valid = false;
                    input.reportValidity(); // Show validation message
                }
            });

            if (valid) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep(step) {
            currentStep--;
            showStep(currentStep);
        }

        // Initially show the first step
        showStep(currentStep);
    </script>

    <style>
        .d-none {
            display: none;
        }
    </style>
</x-admin.auth-layout>
