<!-- resources/views/emails/kyc_confirmation.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>KYC Document Submission Confirmation</title>
</head>
<body>
    <div class="container">
        <h1>Confirmation of Document Submission for KYC Verification</h1>
        <p>Dear {{ $client->first_name }},</p>
        <p>We have successfully received your document submissions for <strong>KYC verification</strong>.</p>

        <h3>Submitted Documents:</h3>
        <ul>
            <li><strong>Identification Proof:</strong> {{ $documentTypes['identification_proof'] }}</li>
            <li><strong>Address Proof:</strong> {{ $documentTypes['address_proof'] }}</li>
            <li><strong>Income Proof:</strong> {{ $documentTypes['income_proof'] }}</li>
        </ul>

        <p>These documents are now under review, and the verification process will be completed as soon as possible. You will receive another notification once your documents have been reviewed and approved.</p>

        <p>If you have any questions or need further assistance, please do not hesitate to contact us.</p>
        <p>Thank you for your cooperation.</p>

        <p>Best regards,<br>Microfinance Solution<br>Customer Support Team</p>
    </div>
</body>
</html>
