$(document).ready(function()
{
    $("#deliveryfilter").submit(function()
    {
        $("input").each(function()
        {
            if ($(this).val() == "")
            {
                $(this).remove();
            }
        });

        $("select").each(function()
        {
            if ($(this).val() == "")
            {
                $(this).remove();
            }
        });
    });
});