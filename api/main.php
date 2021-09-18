<?php
include 'conn/connectivity.php';

if(isset($_GET['month-year'])){

    if (strpos($_GET['month-year'], '-') !== false) {
        $dates = (explode("-",$_GET['month-year']));
        $month = $dates[0];
        $year = $dates[1];

        $totalSalesAndOrder = getTotalSalesAndOrder($conn,$month,$year);
        // var_dump($totalSalesAndOrder);

        $dailySales = getDailySales($conn,$month,$year);
        // var_dump($dailySales);

        $salesByProductCategories = getSalesByProductCategories($conn,$month,$year);
        // var_dump($salesByProductCategories);

        $salesByCustomers = getSalesByCustomers($conn,$month,$year);
        // var_dump($salesByCustomers);

        $salesByEmployees = getSalesByEmployees($conn,$month,$year);

        echo json_encode(
            array(
                'totalSalesAndOrder' => array($totalSalesAndOrder), 
                'dailySales' => $dailySales, 
                'salesByProductCategories' => $salesByProductCategories, 
                'salesByCustomers' => $salesByCustomers,
                'salesByEmployees' => $salesByEmployees
            )
        );

    }else{
        echo 'HEHE';
    }

}else{
    echo 'ERROR 404';
}

function getTotalSalesAndOrder($conn,$month,$year){
    $query = $conn->prepare("SELECT * FROM `orders` JOIN `order_details` ON `orders`.`OrderID` = `order_details`.`OrderID` WHERE MONTH(`OrderDate`) = :months AND YEAR(`OrderDate`) = :years");
    // $query->bindParam(':email', $emailAdd);
    $query->execute(
        array(
            'months' => $month,
            'years' => $year
        )
    );
    $row = $query->fetchAll();

    $totalSales = $totalOrders = 0;

    foreach ($row as $x){
        $totalSales += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        $totalOrders += 1;
    }

    return array('totalSales' => $totalSales, 'totalOrders' => $totalOrders);
}

function getDailySales($conn,$month,$year){
    
    $arrDaily = $arrAvgSales = array();

    $avg = 1;
    $averageSales = 0;

    for ($x = 1; $x <= 31; $x++) {
        $query = $conn->prepare("SELECT * FROM `orders` JOIN `order_details` ON `orders`.`OrderID` = `order_details`.`OrderID` WHERE DAY(`OrderDate`) = :days AND MONTH(`OrderDate`) = :months AND YEAR(`OrderDate`) = :years");
        $query->execute(
            array(
                'days' => $x,
                'months' => $month,
                'years' => $year
            )
        );
        $row = $query->fetchAll();

        $dailySales = 0;

        if($row != false){

            foreach ($row as $y){
                $dailySales += ($y['UnitPrice'] * $y['Quantity']) * (1 - $y['Discount']); 
            }
        
        }

        $averageSales += $dailySales;

        $averageSales = $averageSales / $avg;
        $avg++;

        array_push($arrDaily,$dailySales);
        array_push($arrAvgSales,$averageSales);

    }

    return array('arrDaily' => $arrDaily , 'arrAvgSales' => $arrAvgSales);
}

function getSalesByProductCategories($conn,$month,$year){
    $query = $conn->prepare("SELECT * FROM `orders` JOIN `order_details` ON `orders`.`OrderID` = `order_details`.`OrderID` JOIN `products` ON `order_details`.`ProductID` = `products`.`ProductID` WHERE MONTH(`OrderDate`) = :months AND YEAR(`OrderDate`) = :years");
    $query->execute(
            array(
                'months' => $month,
                'years' => $year
            )
    );
    $row = $query->fetchAll();

    $beverages = $condiments = $confections = $dairy_products = $grains_cereals = $meat_poultry = $produce = $seafood = 0;

    foreach ($row as $x){
        if ($x['CategoryID'] == 1){
            $beverages += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }

        if ($x['CategoryID'] == 2){
            $condiments += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }
        
        if ($x['CategoryID'] == 3){
            $confections += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }

        if ($x['CategoryID'] == 4){
            $dairy_products += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }

        if ($x['CategoryID'] == 5){
            $grains_cereals += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }

        if ($x['CategoryID'] == 6){
            $meat_poultry += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }

        if ($x['CategoryID'] == 7){
            $produce += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }

        if ($x['CategoryID'] == 8){
            $seafood += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }
    }

    $str = array(
        array('Beverages',$beverages),
        array('Condiments',$condiments),
        array('Confections',$confections),
        array('Dairy Products',$dairy_products),
        array('Grains/Cereals',$grains_cereals),
        array('Meat/Poultry',$meat_poultry),
        array('Produce',$produce),
        array('Seafood',$seafood)
    );   

    return $str;
}

function getSalesByCustomers($conn,$month,$year){
    $query = $conn->prepare("SELECT * FROM `orders` JOIN `order_details` ON `orders`.`OrderID` = `order_details`.`OrderID` JOIN `customers` ON `orders`.`CustomerID` = `customers`.`CustomerID` WHERE MONTH(`OrderDate`) = :months AND YEAR(`OrderDate`) = :years");
    $query->execute(
            array(
                'months' => $month,
                'years' => $year
            )
    );
    $row = $query->fetchAll();
    $data = $dataName = array();

    foreach ($row as $x){
        if(isset($data[$x['CustomerID']])){
            $data[$x['CustomerID']] += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }else{
            $data += [$x['CustomerID'] => ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount'])];
            array_push($dataName,$x['CustomerID']);
        }
    }

    $str = array();
    $num = 0;
    foreach ($dataName as $y){
        $str += [ $num => array($y,$data[$y]) ];
        $num++;
    }

    return $str;
}

function getSalesByEmployees($conn,$month,$year){
    $query = $conn->prepare("SELECT * FROM `orders` JOIN `order_details` ON `orders`.`OrderID` = `order_details`.`OrderID` JOIN `employees` ON `orders`.`EmployeeID` = `employees`.`EmployeeID` WHERE MONTH(`OrderDate`) = :months AND YEAR(`OrderDate`) = :years");
    $query->execute(
            array(
                'months' => $month,
                'years' => $year
            )
    );
    $row = $query->fetchAll();
    $data = $dataName = array();

    foreach ($row as $x){
        if(isset($data[$x['EmployeeID']])){
            $data[$x['EmployeeID']] += ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount']);
        }else{
            $data += [$x['EmployeeID'] => ($x['UnitPrice'] * $x['Quantity']) * (1 - $x['Discount'])];
            array_push($dataName,$x['EmployeeID']);
        }
    }

    $str = array();
    $num = 0;
    foreach ($dataName as $y){
        $str += [ $num => array($y,$data[$y]) ];
        $num++;
    }

    return $str;
}