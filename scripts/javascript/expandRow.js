$(document).ready(function()
{
    selected = null;

    $(".expandrow").click(function()
    {
        if (selected == this)
        {
            $(this).nextUntil(".expandrow").toggle();
        }
        else
        {
            $(selected).nextUntil(".expandrow").hide();
            $(this).nextUntil(".expandrow").show();
            selected = this;
        }
    })
});