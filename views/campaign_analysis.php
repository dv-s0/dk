<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mt-4">Campaign Analysis</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Overall Performance</h3>
            <canvas id="performanceChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Budget Usage</h3>
            <canvas id="budgetChart"></canvas>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Detailed Analysis</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Impressions</td>
                        <td>15,000</td>
                    </tr>
                    <tr>
                        <td>Clicks</td>
                        <td>1,200</td>
                    </tr>
                    <tr>
                        <td>Conversions</td>
                        <td>150</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // مخطط الأداء
    var ctx1 = document.getElementById('performanceChart').getContext('2d');
    var performanceChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
            datasets: [{
                label: 'Impressions',
                data: [5000, 7000, 8000, 10000, 12000],
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        }
    });

    // مخطط الميزانية
    var ctx2 = document.getElementById('budgetChart').getContext('2d');
    var budgetChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Spent', 'Remaining'],
            datasets: [{
                data: [300, 700],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)']
            }]
        }
    });
</script>

<?php include 'footer.php'; ?>
