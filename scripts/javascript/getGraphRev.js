function getBackgroundColor(arr, color)
{
    var Colors = [];

    if (color == 0)
        arr.forEach(element => { Colors.push("rgba(99, 255, 132, 0.9)"); });
    else if (color == 1)
        arr.forEach(element => { Colors.push("rgba(255, 99, 132, 0.9)"); });
    else
        arr.forEach(element => { Colors.push("rgba(99, 132, 255, 0.9)"); });

    return Colors;
}

function setBarChartDataRevYear(id, date) 
{

    DataUrl = "?date=" + date;

    $.ajax(
        {
            url: "/app2/scripts/php/getChartDataRev.php" + DataUrl,
            dataType: "json",
            success: function(Result)
            {
                var ctx = id.getContext("2d");
    
                new Chart(ctx,
                {
                    type: "bar",
                    data:
                    {
                        labels: Result["LabelsY"],
                        datasets:
                        [
                            {
                                label: "Profits",
                                data: Result["ProfitsY"],
                                fill: false,
                                backgroundColor: getBackgroundColor(Result["ProfitsY"], 0),
                                borderColor: getBackgroundColor(Result["ProfitsY"], 0),
                                borderWidth: 1
                            },
                            {
                                label: "Expenses",
                                data: Result["ExpensesY"],
                                fill: false,
                                backgroundColor: getBackgroundColor(Result["ExpensesY"], 1),
                                borderColor: getBackgroundColor(Result["ExpensesY"], 1),
                                borderWidth: 1
                            },
                            {
                                label: "Revenue",
                                data: Result["RevenueY"],
                                fill: false,
                                backgroundColor: getBackgroundColor(Result["RevenueY"], 2),
                                borderColor: getBackgroundColor(Result["RevenueY"], 2),
                                borderWidth: 1
                            }
                        ]
                    },
                    options:
                    {
                        title: { display: true, text: "Yearly Revenue: " + date },
                        scales:{ yAxes: [{ ticks: { beginAtZero:true }}]}
                    }
                });
            }
        });
}

function setBarChartDataRevMonth(id, date) 
{

    DataUrl = "?date=" + date;

    $.ajax(
        {
            url: "/app2/scripts/php/getChartDataRev.php" + DataUrl,
            dataType: "json",
            success: function(Result)
            {
                var ctx = id.getContext("2d");
    
                new Chart(ctx,
                {
                    type: "bar",
                    data:
                    {
                        labels: Result["LabelsM"],
                        datasets:
                        [
                            {
                                label: "Profits",
                                data: Result["ProfitsM"],
                                fill: false,
                                backgroundColor: getBackgroundColor(Result["ProfitsM"], 0),
                                borderColor: getBackgroundColor(Result["ProfitsM"], 0),
                                borderWidth: 1
                            },
                            {
                                label: "Expenses",
                                data: Result["ExpensesM"],
                                fill: false,
                                backgroundColor: getBackgroundColor(Result["ExpensesM"], 1),
                                borderColor: getBackgroundColor(Result["ExpensesM"], 1),
                                borderWidth: 1
                            },
                            {
                                label: "Revenue",
                                data: Result["RevenueM"],
                                fill: false,
                                backgroundColor: getBackgroundColor(Result["RevenueM"], 2),
                                borderColor: getBackgroundColor(Result["RevenueM"], 2),
                                borderWidth: 1
                            }
                        ]
                    },
                    options:
                    {
                        title: { display: true, text: "Monthly Revenue: " + date },
                        scales:{ yAxes: [{ ticks: { beginAtZero:true }}]}
                    }
                });
            }
        });
}