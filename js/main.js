google.charts.load('current', {'packages':['corechart']});
getStartingGraphData();

function getStartingGraphData(){
    google.charts.setOnLoadCallback(drawDailySalesGraph);
    google.charts.setOnLoadCallback(drawProdCategoriesChart);
    google.charts.setOnLoadCallback(drawSalesByCustomerChart);
    google.charts.setOnLoadCallback(drawSalesByEmployeesChart);
}

function drawDailySalesGraph() {
  // Some raw data (not necessarily accurate)
  var data = google.visualization.arrayToDataTable(dailySales);

  var options = {
    title : 'Daily Sales',
    vAxis: {title: 'Total Sales'},
    hAxis: {title: 'Days'},
    seriesType: 'bars',
    series: {1: {type: 'line'}}
  };

  var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}

function drawProdCategoriesChart() {
        var data = google.visualization.arrayToDataTable(salesByProductCategories);

        var options = {
          pieHole: 0.4
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
}

function drawSalesByCustomerChart() {

    var data = google.visualization.arrayToDataTable(salesByCustomers);

    var options = {
      chartArea: {width: '50%'},
      hAxis: {
        title: 'Total Sales',
        minValue: 0
      },
      vAxis: {
        title: 'Customer ID'
      }
    };

    var chart = new google.visualization.BarChart(document.getElementById('sales_by_customers'));

    chart.draw(data, options);
}

function drawSalesByEmployeesChart() {

    var data = google.visualization.arrayToDataTable(salesByEmployees);

    var options = {
      chartArea: {width: '50%'},
      hAxis: {
        title: 'Total Sales',
        minValue: 0
      },
      vAxis: {
        title: 'Employee ID'
      }
    };

    var chart = new google.visualization.BarChart(document.getElementById('sales_by_employees'));

    chart.draw(data, options);
}

function changeData(date){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        data = JSON.parse(this.responseText);
        // console.log(data.totalSalesAndOrder[0].totalSales);
        // console.log(data.salesByProductCategories);

        document.getElementById("totalSales").innerHTML = data.totalSalesAndOrder[0].totalSales;
        document.getElementById("totalOrder").innerHTML = data.totalSalesAndOrder[0].totalOrders;

        changeDailySalesGraph(data.dailySales);
        changeProdCategoriesChart(data.salesByProductCategories);
        changeSalesByCustomerChart(data.salesByCustomers);
        changeSalesByEmployeesChart(data.salesByEmployees);
        

        // console.log(data.dailySales);
        // console.log(data.salesByProductCategories);
      }
    };
    xmlhttp.open("GET", url+"api/main.php?month-year="+date, true);
    xmlhttp.send();

}

function changeDailySalesGraph(newdata) {

    var dailySales = [['Days','Total Sales','Average'],];
        var num = n = 1;
        for (let i = 0; i <= 30; i++) {
             n = num.toString();
            dailySales.push([n,newdata.arrDaily[i],newdata.arrAvgSales[i]],);
            num++
        }

    
    var data = google.visualization.arrayToDataTable(dailySales);
  
    var options = {
      title : 'Daily Sales',
      vAxis: {title: 'Total Sales'},
      hAxis: {title: 'Days'},
      seriesType: 'bars',
      series: {1: {type: 'line'}}
    };
  
    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

function changeProdCategoriesChart(newdata) {

    var salesByProductCategories = [['Categories', 'Total Sales'],];
        
    for (let i = 0; i < newdata.length; i++) {
        salesByProductCategories.push([newdata[i][0],newdata[i][1]],);       
    }

    var data = google.visualization.arrayToDataTable(salesByProductCategories);

    var options = {
      pieHole: 0.4
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
    chart.draw(data, options);
}

function changeSalesByCustomerChart(newdata) {

    var salesByCustomers = [['Categories', 'Total Sales'],];
        
    for (let i = 0; i < newdata.length; i++) {
        salesByCustomers.push([newdata[i][0],newdata[i][1]],);       
    }

    var data = google.visualization.arrayToDataTable(salesByCustomers);

    var options = {
      chartArea: {width: '50%'},
      hAxis: {
        title: 'Total Sales',
        minValue: 0
      },
      vAxis: {
        title: 'Customer ID'
      }
    };

    var chart = new google.visualization.BarChart(document.getElementById('sales_by_customers'));

    chart.draw(data, options);
}

function changeSalesByEmployeesChart(newdata) {

    var salesByEmployees = [['Categories', 'Total Sales'],];
        
    for (let i = 0; i < newdata.length; i++) {
        salesByEmployees.push([newdata[i][0],newdata[i][1]],);       
    }

    var data = google.visualization.arrayToDataTable(salesByEmployees);

    var options = {
      chartArea: {width: '50%'},
      hAxis: {
        title: 'Total Sales',
        minValue: 0
      },
      vAxis: {
        title: 'Employee ID'
      }
    };

    var chart = new google.visualization.BarChart(document.getElementById('sales_by_employees'));

    chart.draw(data, options);
}