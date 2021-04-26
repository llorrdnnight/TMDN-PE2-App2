$(document).ready(function()
{
    $("#employee").change(function()
    {
        var str = this.value;

        $.ajax(
        {
            url : "/HR/php/searchemployees.php?query=" + str,
            dataType : "json",
            success : function(result)
            {
                console.log(result[0]["Firstname"]);
                this.value = result[0]["Firstname"];
            }
        });
    })

    $("#branch").change(function()
    {
        $("#employee").prop("disabled", false);
    })
});