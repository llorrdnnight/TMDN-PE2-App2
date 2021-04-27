$(document).ready(function()
{
    var tbody = document.getElementById("table-leave-tbody");
    var periods = document.getElementById("Periods");
    
    $("#button-addcolumn").click(function()
    {
        // TODO: add unique name and number to each new row
        var rownum = "<td>" + (tbody.childElementCount + 1) + "</td>";
        tbody.insertRow(-1).innerHTML = 
            rownum +
            `<td>
                <select name="soort1">
                    <option selected>Verlof</option>
                    <option>Ziekte</option>
                    <option>Andere?</option>
                </select>
            </td>
            <td><input type="date"></td>
            <td><input type="date"></td>
            <td><input type="text" disabled placeholder="0"></td>
            <td><input type="text"></td>`;

        periods.value = Number(periods.value) + 1;
    });

    $("#button-removecolumn").click(function()
    {
        tbody.deleteRow(-1);

        if (Number(periods.value))
        {
            periods.value = Number(periods.value) - 1;
        }
    });
});