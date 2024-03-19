<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <?php include('includes/includedcss.php'); ?>
</head>

<body>
    <div class="wrapper">
        <?php include('includes/sidebarnav.php');?>
        <div id="body" class="active">
            <?php include('includes/topnavigation.php');?>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Dashboard</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Overall Progress</div>
                            
                                <div class="card-body">
                                  <div class="canvas-wrapper">
                                      <canvas id="myChart"></canvas>
                                  </div>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Payment Status</div>
                                <div class="card-body">
                                    <div class="canvas-wrapper">
                                        <canvas class="chart" id="barchart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/includedjs.php');?>
    <script>
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Group1', 'Group2', 'Group3', 'Group4', 'Group5', 'Group6'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


  var chart2 = document.getElementById('barchart');
  var myChart2 = new Chart(chart2, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
                label: 'Paid',
                backgroundColor: "rgba(54, 162, 235, 0.5)",
                borderColor: "rgb(54, 162, 235)",
                borderWidth: 1,
                data: ["20", "30", "40", "50", "60", "70", "80"],
            }, {
                label: 'Unpaid',
                backgroundColor: "rgba(244, 67, 54, 0.5)",
                borderColor: "rgb(255, 99, 132)",
                borderWidth: 1,
                data: ["5", "15", "25", "35", "45", "35", "25"],
        }]
    },
    options: {
        animation: {
            duration: 2000,
            easing: 'easeOutQuart',
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            title: {
                display: true,
                text: 'Revenue',
                position: 'left',
            },
        },
    }
    });

</script>
</body>

</html>
