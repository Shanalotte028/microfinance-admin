<x-admin.dashboard-layout>
    <x-slot:heading>Dashboard</x-slot:heading>
    <div class="row">
        @can('compliances.index')
        <x-admin.cards 
        icon="bi bi-hourglass-split"
        value="{{ $pendingCompliance }}"
        heading="Pending Compliances"
        route="{{ route('admin.compliances', ['status' => 'pending']) }}" 
        />
        @endcan
        @can('legal.index')
        @if(Auth::user()->role === "Lawyer")
        <x-admin.cards 
        icon="bi bi-folder-check"
        value="{{ $assignedCases }}"
        heading="Assigned cases"
        route="{{ route('admin.legal.index') }}" 
        />
        @else
        <x-admin.cards 
        icon="bi bi-journal-text"
        value="{{ $openCase }}"
        heading="Open Cases"
        route="{{ route('admin.legal.index', ['status' => 'open']) }}" 
        />
        @endif
        @endcan
        @can('investigation.credit_investigations')
        @if(Auth::user()->role === "Field Officer")
        <x-admin.cards 
        icon="bi bi-folder-check"
        value="{{ $assignedInvestigations }}"
        heading="Investigations"
        route="{{ route('admin.investigation.credit_investigations') }}" 
        />
        @endif
        @endcan
    </div>
    <div>
        <!-- Top Section - Quick Insights -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">Loan Approval vs. Rejection Rate</div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="loanChart" height="400px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-dark text-light"> <!-- Dark background, light text -->
                    <div class="card-header">Risk Assessment Trends</div>
                    <div class="card-body">
                        <canvas id="riskTrendsChart" height="400"></canvas> <!-- Increased height -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Section - Risk & Loan Insights -->
        <div class="row mt-4 mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">Late Payments & Defaults</div>
                    <div class="card-body">
                        <canvas id="latePaymentsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">Risk vs. Credit Score</div>
                    <div class="card-body">
                        <canvas id="riskVsCreditChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section - High-Risk Clients -->
        {{-- <div class="row mt-4 mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">High-Risk Clients</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Client ID</th>
                                    <th>Risk Level</th>
                                    <th>Credit Score</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($highRiskClients as $client)
                                <tr>
                                    <td>{{ $client->client_id }}</td>
                                    <td class="text-danger">{{ $client->risk_level }}</td>
                                    <td>{{ $client->credit_score }}</td>
                                    <td>
                                        <a href="{{ route('admin.client.show', $client) }}" class="btn btn-sm btn-success">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Loan Approval vs. Rejection Rate (Doughnut)
        new Chart(document.getElementById('loanChart'), {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Rejected'],
            datasets: [{
                data: [{{ $approvedLoans }}, {{ $rejectedLoans }}],
                backgroundColor: ['#28a745', '#dc3545'],
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            cutout: '70%', // Adjust the inner circle
            plugins: {
                legend: {
                    labels: {
                        color: "#ffffff",
                        font: { size: 14 }
                    }
                }
            }
        }
    });

        // Risk Trends
        let riskTrends = @json($riskTrends);

        let months = riskTrends.map(item => item.month);
        let lowRisk = riskTrends.map(item => item.low_risk);
        let mediumRisk = riskTrends.map(item => item.medium_risk);
        let highRisk = riskTrends.map(item => item.high_risk);

        new Chart(document.getElementById("riskTrendsChart"), {
            type: "line",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Low Risk",
                        data: lowRisk,
                        backgroundColor: "rgba(40, 167, 69, 0.2)",
                        borderColor: "green",
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: "Medium Risk",
                        data: mediumRisk,
                        backgroundColor: "rgba(255, 193, 7, 0.2)",
                        borderColor: "orange",
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: "High Risk",
                        data: highRisk,
                        backgroundColor: "rgba(220, 53, 69, 0.2)",
                        borderColor: "red",
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: "white" // Light text color
                        }
                    },
                    x: {
                        ticks: {
                            color: "white" // Light text color
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: "white" // Lighten legend text
                        }
                    }
                }
            }
        });
        
        // Late Payments & Defaults (Stacked Bar Chart)
        new Chart(document.getElementById('latePaymentsChart'), {
            type: 'bar',
            data: {
                labels: ['Late Payments', 'Defaults'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $financialStats->total_late_payments }}, {{ $financialStats->total_loan_defaults }}],
                    backgroundColor: ['#17a2b8', '#fd7e14']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: "#ffffff", // Make text color white
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#ffffff" // Make X-axis labels white
                        }
                    },
                    y: {
                        ticks: {
                            color: "#ffffff" // Make Y-axis labels white
                        }
                    }
                }
            }
        });

        // Risk vs. Credit Score (Scatter Plot)
        new Chart(document.getElementById('riskVsCreditChart'), {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Risk vs Credit Score',
                    data: {!! json_encode($riskData->map(fn($r) => ['x' => $r->credit_score, 'y' => ['Low Risk' => 1, 'Medium Risk' => 2, 'High Risk' => 3][$r->risk_level]])) !!},
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: "#ffffff", // Make text color white
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#ffffff" // Make X-axis labels white
                        }
                    },
                    y: {
                        ticks: {
                            color: "#ffffff" // Make Y-axis labels white
                        }
                    }
                }
            }
        });
    </script>
    <x-client.success-popup/>
</x-admin.dashboard-layout>