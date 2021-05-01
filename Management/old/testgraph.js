function getColorGradient(arr)
{
    StepSize = 255 / arr.length;
    Colors = [];

    for (i in arr)
        Colors.push("rgba(" + (i * StepSize) + ", " + (255 - i * StepSize) + ", 96, 0.6)");

    return Colors;
}

$(document).ready(function()
{
    Labels = ["< 7 days", "> 7 days", "> 30 days", "> 90 days", "> 6 months", "> 1 year"];

    $.ajax(
    {
        url : "getChartData.php",
        dataType : "json",
        success : function(Result)
        {
            var ctx = document.getElementById('OpenComplaintsPieGraph').getContext('2d');
            var OpenComplaintsChart = new Chart(ctx, 
            {
                type: 'pie',
                data: 
                {
                    labels: Labels,
                    datasets: [
                    {
                        label: '# of open complaints',
                        data: Result,
                        backgroundColor: getColorGradient(Labels),
                        borderColor: getColorGradient(Labels),
                        hoverBackgroundColor: getColorGradient(Labels),
                        borderWidth: 1
                    }]
                },

                options: { scales: { yAxes: [ { ticks: { beginAtZero: true } }] } }
            });
        }
    });
});