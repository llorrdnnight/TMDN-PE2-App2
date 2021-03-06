function getColorGradient(arr)
{
    StepSize = 255 / arr.length;
    Colors = [];

    for (i in arr)
        Colors.push("rgba(" + (i * StepSize) + ", " + (255 - i * StepSize) + ", 96, 0.6)");

    return Colors;
}

function setChartData(id, category)
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

$(document).ready(function()
{
    var Canvases = document.getElementsByClassName("graph");
    setChartData(Canvases[0].id, "Open");
    setChartData(Canvases[1].id, "Closed");
});

