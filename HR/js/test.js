$(document).ready(() => 
{
    $("#calendar").change(() =>
    {
        $.ajax(
            {
                url: "test.php",
                type: "get",
                dataType: "json",
                success: function(Result)
                {
                    console.log(Result);
                }
            }
        );
    });
})