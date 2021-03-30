function getColorGradient(arr)
{
    StepSize = 255 / arr.length;
    Colors = [];

    for (i in arr)
        Colors.push("rgba(" + (i * StepSize) + ", " + (255 - i * StepSize) + ", 96, 0.9)");

    return Colors;
}

function setPieChartData(id, category)
{
    DataUrl = "";
    Labels = ["< 7 days", "> 7 days", "> 30 days", "> 90 days", "> 6 months", "> 1 year"];

    if (category == "Open")
        DataUrl = "?Category=Open&t=" + Math.random();
    else
        DataUrl = "?Category=Closed&t=" + Math.random();

    $.ajax(
    {
        url: "/Management/scripts/php/getChartData.php" + DataUrl,
        dataType: "json",
        success: function(Result)
        {
            var ctx = id.getContext('2d');
            
            new Chart(ctx, 
            {
                type: 'pie',
                data: 
                {
                    labels: Labels,
                    datasets: [
                    {
                        label: "# of " + category + " Complaints",
                        data: Result,
                        backgroundColor: getColorGradient(Labels),
                        borderColor: getColorGradient(Labels),
                        hoverBackgroundColor: getColorGradient(Labels),
                        borderWidth: 1
                    }]
                },

                options: { legend: { position: "right" }, scales: { yAxes: [ { ticks: { beginAtZero: true } }] } }
            });
        }
    });
}

function getBackgroundColor(arr, color)
{
    var Colors = [];

    if (color)
        arr.forEach(element => { Colors.push("rgba(99, 255, 132, 0.9)"); });
    else
        arr.forEach(element => { Colors.push("rgba(255, 99, 132, 0.9)"); });

    return Colors;
}

function setBarChartData(id)
{
    DataUrl = "?StartDate=2020-03-13&EndDate=2021-03-1&t=" + Math.random();

    $.ajax(
    {
        url: "/Management/scripts/php/getChartData.php" + DataUrl,
        dataType: "json",
        success: function(Result)
        {
            var ctx = id.getContext("2d");

            new Chart(ctx,
            {
                type: "bar",
                data:
                {
                    labels: Result["Labels"],
                    datasets:
                    [
                        {
                            label: "Closed",
                            data: Result["ClosedMonths"],
                            fill: false,
                            backgroundColor: getBackgroundColor(Result["OpenMonths"], true),
                            borderColor: getBackgroundColor(Result["OpenMonths"], true),
                            borderWidth: 1
                        },
                        {
                            label: "Open",
                            data: Result["OpenMonths"],
                            fill: false,
                            backgroundColor: getBackgroundColor(Result["ClosedMonths"], false),
                            borderColor: getBackgroundColor(Result["ClosedMonths"], false),
                            borderWidth: 1
                        }
                    ]
                },
                options:
                {
                    title: { display: true, text: "Open and closed complaints grouped by month" },
                    scales:{ yAxes: [{ ticks: { beginAtZero:true }}]}
                }
            });
        }
    });
}

$(document).ready(function()
{
    setPieChartData(document.getElementById("OpenComplaintsGraph"), "Open");
    setPieChartData(document.getElementById("ClosedComplaintsGraph"), "Closed");
    setBarChartData(document.getElementById("MonthlyComplaintsGraph"));
});