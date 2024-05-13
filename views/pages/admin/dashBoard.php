<link rel="stylesheet"  href="./assets/css/sweetalert2.min.css">
<link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<style>
    .canvasContainer {
        width: 30%; /* Đặt độ rộng của mỗi phần tử canvasContainer */
        display: inline-block; /* Hiển thị các phần tử theo chiều ngang */
        margin: 15px; /* Khoảng cách giữa các phần tử */
    }

    /* Để đảm bảo rằng canvas không bị co lại, hãy đặt chiều rộng và chiều cao của nó */
    canvas {
        width: 100%;
        height: auto; /* Đảm bảo chiều cao tự động theo tỷ lệ */
    }

    #myChart4 {
    width: 100%; /* Thiết lập chiều rộng của canvas là 100% */
    height: 400px; /* Thiết lập chiều cao của canvas là 400px (hoặc bất kỳ giá trị nào bạn muốn) */
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

        <!-- <div style="width: 100%; margin-top: 50px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('http://localhost:8008/PHP/index.php?controller=admin&action=dashBoard')
        
            .then(response => response.json())
            .then(response => response) 
            .then(data => {
                console.log(data);
                alert("ss"); 
                var monthLabels = data.map(item => item.Month);
                var revenueData = data.map(item => item.Scale);

                var ctx = document.getElementById('revenueChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Tăng giảm doanh thu',
                            data: revenueData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            })
            // .catch(console.error('Error:', error));
            .catch(error => console.error('Error:', error));
    });
    </script> -->
    <div>
    <body>
    <form action="http://localhost:8008/PHP/index.php?controller=admin&action=dashBoard" method="POST">
        <label for="start_date">Từ ngày:</label>
        <input type="date" id="start_date" name="start_date" required>
        
        <label for="end_date">Đến ngày:</label>
        <input type="date" id="end_date" name="end_date" required>
        
        <button type="submit">Submit</button>
    </form>
    </div>

    <div class="thongkeloai">
            <div class="canvasContainer">
                <canvas id="myChart1"></canvas>
            </div>


            <div class="canvasContainer">
                <canvas id="myChart3"></canvas>
            </div>
            
    </div>


            <div class="canvasContainer">
                <canvas id="myChart2"></canvas>
            </div>
            <div class="canvasContainer">
                <canvas id="myChart4" style="height: 300px;"></canvas>
            </div>
            


    <script>

        window.onload=function(){
            addThongKe();
        }

    function copyObject(obj) {
    return JSON.parse(JSON.stringify(obj));
}
    function addChart(id, chartOption) {
    var ctx = document.getElementById(id).getContext('2d');
    var chart = new Chart(ctx, chartOption);
}
    function addThongKe() {
    var dataChart = {
        type: 'bar',
        data: {
            labels: [
                <?php foreach($datapurchase['datapurchase'] as $title): ?>
                    <?php echo '"'. $title['nameCategory']. '"'.',' ?>
                    <?php endforeach ?>
            ],
            datasets: [{
                label: 'Số lượng bán ra',
                data: [
                <?php foreach($datapurchase['datapurchase'] as $purchase): ?>
                    <?php echo  $purchase['purchases'].',' ?>
                    <?php endforeach ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            title: {
                fontColor: '#fff',
                fontSize: 25,
                display: true,
                text: 'Sản phẩm bán ra'
            }
        }
    };


    var dataChart_2 = {
        type: 'bar',
        data: {
            labels: [
                <?php foreach($datapurchase_product['datapurchase_product'] as $title): ?>
                    <?php echo '"'. $title['nameProduct']. '"'.',' ?>
                    <?php endforeach ?>
            ],
            datasets: [{
                label: 'Số lượng bán ra',
                data: [
                <?php foreach($datapurchase_product['datapurchase_product'] as $purchase): ?>
                    <?php echo  $purchase['purchases'].',' ?>
                    <?php endforeach ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            title: {
                fontColor: '#fff',
                fontSize: 25,
                display: true,
                text: 'Sản phẩm bán ra'
            }
        }
    };

    // Thêm thống kê
    var barChart = copyObject(dataChart);
    barChart.type = 'bar';
    addChart('myChart1', barChart);

    var barChart = copyObject(dataChart);
    barChart.type = 'doughnut';
    addChart('myChart2', barChart);

    var barChart = copyObject(dataChart_2);
    barChart.type = 'doughnut';
    addChart('myChart3', barChart);

    var barChart = copyObject(dataChart_2);
    barChart.type = 'bar';
    addChart('myChart4', barChart);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
