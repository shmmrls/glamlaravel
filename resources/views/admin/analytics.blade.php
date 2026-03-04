@extends('layouts.app')

@section('content')
<main class="analytics-page">
    <div class="analytics-container">
        <div class="analytics-header">
            <h1 class="analytics-title">Sales Analytics</h1>
            <p class="analytics-subtitle">Comprehensive sales data and insights</p>
        </div>

        <!-- Date Range Filter -->
        <div class="date-filter-section">
            <div class="filter-card">
                <h3>Date Range Filter</h3>
                <form method="GET" action="{{ route('admin.analytics') }}" class="date-filter-form">
                    <div class="date-inputs">
                        <div class="date-input-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" id="start_date" name="start_date" value="{{ $startDate }}" class="date-picker">
                        </div>
                        <div class="date-input-group">
                            <label for="end_date">End Date</label>
                            <input type="text" id="end_date" name="end_date" value="{{ $endDate }}" class="date-picker">
                        </div>
                        <button type="submit" class="filter-btn">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="charts-grid">
            <!-- Yearly Sales Chart (ConsoleTVs) -->
            <div class="chart-section">
                <h3 class="chart-title">Yearly Sales Trend</h3>
                <div class="chart-container">
                    {!! $yearlySalesChart->container() !!}
                </div>
            </div>

            <!-- Monthly Sales Chart (ConsoleTVs) -->
            <div class="chart-section">
                <h3 class="chart-title">Monthly Sales - Current Year</h3>
                <div class="chart-container">
                    {!! $monthlySalesChart->container() !!}
                </div>
            </div>

            <!-- Date Range Sales Bar Chart (ConsoleTVs) -->
            <div class="chart-section full-width">
                <h3 class="chart-title">Daily Sales - Selected Period</h3>
                <div class="chart-container">
                    {!! $dateRangeSalesChart->container() !!}
                </div>
            </div>

            <!-- Product Sales Pie Chart — vanilla Chart.js (bypasses ConsoleTVs array-color bug) -->
            <div class="chart-section pie-chart-centered">
                <h3 class="chart-title">Top Products by Sales Percentage</h3>
                <div class="chart-container">
                    <canvas id="productPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
{{--
    IMPORTANT: ConsoleTVs/Charts v6 generates Chart.js v2 syntax (xAxes/yAxes).
    Must use Chart.js v2, NOT v3. Using v3 causes "Invalid scale configuration" errors.
--}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

{{-- Flatpickr --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

{{-- ConsoleTVs chart scripts (line + bar) --}}
{!! $yearlySalesChart->script() !!}
{!! $monthlySalesChart->script() !!}
{!! $dateRangeSalesChart->script() !!}

{{-- Vanilla Chart.js v2 pie chart — bypasses ConsoleTVs array-color limitation --}}

<script>
    (function () {
        var ctx = document.getElementById('productPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($pieLabels) !!},
                datasets: [{
                    label: 'Sales %',
                    data: {!! json_encode($piePercentages) !!},
                    backgroundColor: [
                        'rgba(0, 0, 0, 0.85)',        // Deep Black
                        'rgba(34, 34, 34, 0.85)',     // Charcoal
                        'rgba(82, 76, 76, 0.85)',     // Dark Grey
                        'rgba(120, 110, 110, 0.85)',  // Medium Grey
                        'rgba(160, 150, 150, 0.85)',  // Light Grey
                        
                        'rgba(231, 70, 139, 0.85)',   // Strong Pink
                        'rgba(240, 110, 165, 0.85)',  // Medium Pink
                        'rgba(199, 130, 167, 0.85)',  // Dusty Pink
                        'rgba(255, 182, 193, 0.85)',  // Soft Pink
                        'rgba(252, 238, 242, 0.85)'   // Very Light Pink
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                legend: { position: 'right' },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index] || '';
                            var value = data.datasets[0].data[tooltipItem.index];
                            return label + ': ' + parseFloat(value).toFixed(2) + '%';
                        }
                    }
                }
            }
        });
    })();

    flatpickr(".date-picker", {
        dateFormat: "Y-m-d",
        maxDate: "today"
    });
</script>

