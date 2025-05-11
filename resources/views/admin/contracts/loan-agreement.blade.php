<p><strong>Loan Agreement</strong></p>

<p>This Loan Agreement ("Agreement") is made and entered into on {{ submitted_at }} by and between <strong>{{ client_name }}</strong> ("Borrower"), and <strong>Ascenders Business Services</strong> ("Lender").</p>

<p><strong>1. Loan Details</strong></p>
<ul>
    <li>Principal Amount: <strong>PHP {{ principal_amount }}</strong></li>
    <li>Interest Rate: <strong>{{ interest_rate }}%</strong></li>
    <li>Loan Term: <strong>{{ loan_term }} {{ term_type }}</strong></li>
    <li>Repayment Frequency: <strong>{{ payment_frequency_method }}</strong></li>
    <li>Installment Amount: <strong>PHP {{ installment }}</strong> per {{ payment_frequency_method }}</li>
    <li>End Date: <strong>{{ end_date }}</strong></li>
</ul>

<p><strong>2. Repayment</strong></p>
<p>The Borrower agrees to repay the loan in accordance with the repayment schedule stated above. Payments shall be made promptly and in full as per the specified frequency until the total loan amount and interest are fully paid.</p>

<p><strong>3. Default</strong></p>
<p>In the event of a default, the Lender reserves the right to take legal and financial actions in accordance with applicable laws to recover the remaining balance.</p>

<p><strong>4. Additional Terms</strong></p>
<p>{{ loan_description }}</p>

<p><strong>IN WITNESS WHEREOF</strong>, the parties have executed this Loan Agreement on the date first written above.</p>
<p>_________________________<br>Borrower: {{ client_name }}</p>
<p>_________________________<br>Lender: Ascenders Business Services</p>
