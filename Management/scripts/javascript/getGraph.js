function getColorGradient(arr)
{
    StepSize = 255 / arr.length;
    Colors = [];

    for (i in arr)
        Colors.push("rgba(" + (i * StepSize) + ", " + (255 - i * StepSize) + ", 96, 0.8)");

    return Colors;
}

function setPieChartData(id, category)
{
    DataUrl = "";
    Labels = ["< 7 days", "> 7 days", "> 30 days", "> 90 days", "> 6 months", "> 1 year"];

    if (category == "Open")
        DataUrl = "?Category=Open";
    else
        DataUrl = "?Category=Closed";

    $.ajax(
    {
        url : "getChartData.php" + DataUrl,
        dataType : "json",
        success : function(Result)
        {
            var ctx = document.getElementById(id).getContext('2d');
            
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

function setBarChartData(id)
{
    var ctx = document.getElementById("test").getContext("2d");

    new Chart(ctx,
    {
        type: "bar",
        data:
        {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar"],
            datasets:
            [
                {
                    label: "Closed",
                    data: [12, 14, 7, 12, 20, 6, 18, 16, 7, 12, 4, 2],
                    fill: false,
                    backgroundColor:
                    [
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)",
                        "rgba(99, 255, 132, 0.8)"
                    ],
                    borderColor:
                    [
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)",
                        "rgb(99, 255, 132)"
                    ],
                    borderWidth: 1
                },
                {
                    label: "Open",
                    data: [0, 0, 0, 0, 1, 2, 1, 4, 6, 6, 9, 10],
                    fill: false,
                    backgroundColor:
                    [
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)",
                        "rgba(255, 99, 132, 0.8)"
                    ],
                    borderColor:
                    [
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)",
                        "rgb(255, 99, 132)"
                    ],
                    borderWidth: 1
                }
            ]
        },
        options:
        {
            // responsive: true,
            title: { display: true, text: "Open and closed complaints grouped by month" },
            scales:{ yAxes: [{ ticks: { beginAtZero:true }}]}
        }
    });
}

$(document).ready(function()
{
    var Canvases = document.getElementsByClassName("graph");
    setPieChartData(Canvases[0].id, "Open");
    setPieChartData(Canvases[1].id, "Closed");
    setBarChartData("test");
});

