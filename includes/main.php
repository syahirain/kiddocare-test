<?php
include 'includes/webfunction.php';
include 'includes/urllist.php';

$url = "api/main.php?month-year=05-1995";
$response = getRequestAPI($url);
// var_dump($response['salesByCustomers'][0][1]);
$dailySales = $salesByProductCategories = $salesByCustomers = $salesByEmployees = "";

$num = 1;
for ($x = 0; $x <= 30; $x++) {
    $dailySales .= "['".$num."',".$response['dailySales']['arrDaily'][$x].",".$response['dailySales']['arrAvgSales'][$x]."],";
    $num++;
}

for ($x = 0; $x < count($response['salesByProductCategories']); $x++) {
    $salesByProductCategories .= "['".$response['salesByProductCategories'][$x][0]."',".$response['salesByProductCategories'][$x][1]."],";
}

for ($x = 0; $x < count($response['salesByCustomers']); $x++) {
    $salesByCustomers .= "['".$response['salesByCustomers'][$x][0]."',".$response['salesByCustomers'][$x][1]."],";
}

for ($x = 0; $x < count($response['salesByEmployees']); $x++) {
    $salesByEmployees .= "['".$response['salesByEmployees'][$x][0]."',".$response['salesByEmployees'][$x][1]."],";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <style>
    .card{
        padding: 10px;
        padding-top: 0px;
        border: 1px solid #4CAF50;
    }    
  </style>
 </head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Dashboard</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="includes/logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
    <h3>Sales Dashboard</h3>
  
    <div class="row">
      <div class='col-sm-4'>
         <div class="form-group">
                <input type="text" class="form-control col-sm-8" id="datepicker" placeholder="Select a Date" onchange="changeData(this.value)" value="05-1995">    
         </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker({
                format: "mm-yyyy",
                startView: "months", 
                minViewMode: "months"
            });
        });
      </script>
    </div>

    <br>

    <div id="graph-div"></div>

    <div class="row">
    <div class="col-sm-6">
        <div class="card text-center">
        <div class="card-body">
            <h2 class="card-title">Total Sales</h2>
            <h3 class="card-text">RM <span id="totalSales"><?php echo number_format($response['totalSalesAndOrder'][0]['totalSales'],2); ?></span></h3>
        </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card text-center">
        <div class="card-body">
            <h2 class="card-title">Total Orders</h2>
            <h3 class="card-text"><span id="totalOrder"><?php echo $response['totalSalesAndOrder'][0]['totalOrders']; ?></span></h3>
        </div>
        </div>
    </div>
    </div>
    
    <br><br><br>

    <div id="chart_div"></div>

    <br><br><br>

    <div class="row">
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
            <h3 class="card-title">Sales by Product Categories</h3>
            <div id="donutchart" style="width: 100%; height: 100%;"></div>
        </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
            <h3 class="card-title">Sales by Customers</h3>
            <div id="sales_by_customers"></div>
        </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
            <h3 class="card-title">Sales by Employees</h3>
            <div id="sales_by_employees"></div>
        </div>
        </div>
    </div>
    </div>
    
</div>
<script>
   var dailySales = [['Days','Total Sales','Average'] ,
   <?php echo $dailySales; ?>]

   var salesByProductCategories = [['Categories', 'Total Sales'],
    <?php echo $salesByProductCategories; ?>]

   var salesByCustomers = [['Customer ID', 'Total Sales'],
    <?php echo $salesByCustomers; ?>]
   
   var salesByEmployees = [['Employee ID', 'Total Sales'],
    <?php echo $salesByEmployees; ?>]

   const url = "<?php echo $mainURL; ?>";
</script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>