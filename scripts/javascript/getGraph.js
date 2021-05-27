function getColorGradient(arr)
{
    stepSizeA = 192 / arr.length; //For every element in the array, assign a gradient color
    stepSizeB = 64 / arr.length;
    Colors = [];

    for (i = 0; i < arr.length; i++)
        Colors.push("rgba(" + (i * stepSizeA) + ", " + (192 - i * stepSizeA) + ", " + (128 - i * stepSizeB) + ", 1)");

    return Colors;
}

function setPieChartData(id, category)
{
    DataUrl = "";
    Labels = ["< 7 days", "> 7 days", "> 30 days", "> 90 days", "> 6 months", "> 1 year"];

    if (category == "Open")
        DataUrl = "?category=Open&t=" + Math.random();
    else
        DataUrl = "?category=Closed&t=" + Math.random();

    $.ajax(
    {
        url: "/app2/scripts/php/getChartData.php" + DataUrl,
        dataType: "json",
        success: function(Result)
        {    
            var ctx = id.getContext('2d');
            
            new Chart(ctx, 
            {
                type: 'doughnut',
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
                        borderWidth: 1,
                        hoverOffset: 8
                    }],
                },
                options:
                {
                    legend: { position: "right" }
                }
            });
        }
    });
}

function getBackgroundColor(arr, color)
{
    var Colors = [];

    if (color)
        arr.forEach(() => { Colors.push("rgba(0, 192, 128, 1)"); });
    else
        arr.forEach(() => { Colors.push("rgba(192, 0, 64, 1)"); });

    return Colors;
}

function setBarChartData(id)
{
    let today = new Date(Date.now());
    let year = today.getUTCFullYear();
    let month = today.getUTCMonth() + 1; //months from 1-12
    let day = today.getUTCDate();

    let startDate = year - 1 + "/" + month + "/" + day; //1 year ago formatted
    let endDate = year + "/" + month + "/" + (day + 1); //today formatted

    DataUrl = "?startDate=" + startDate + "&endDate=" + endDate + "&t=" + Math.random();
    $.ajax(
    {
        url: "/app2/scripts/php/getChartData.php" + DataUrl,
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
                    scales: { yAxes: [{ gridLines: { drawBorder: false, }, ticks: { beginAtZero:true }}]},
                    legend: { position: "bottom" },
                    responsive: true,
                    maintainAspectRatio: false
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