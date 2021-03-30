let offset = 5;
let start = $("#startValue");
let numberOfRecords = $("#numberOfRecords");



$("#loadMore").click(function() {

    let startValue = parseInt(start.val());
    let numberOfRecordsValue = parseInt(numberOfRecords.val());
    let date = $("#date").val();
    let state = $("#state").val();
    let employee = $("#employee").val();
    let search = $("#search").val();



    $.get(
        "../includes/ajax_php/getAbsences.php", {start: startValue, date: date, state: state, employee: employee, search:search }, function(response){
    
            // do something with the data
            console.log(response);
            let parsedResponse = JSON.parse(response);
            for(obj of parsedResponse){

                if(obj.state == 1){
                    obj.state = "<i class='fa fa-check'></i>";
                }
                else{

                    let getParameters = "?";

                    if(date !== ""){
                        getParameters = getParameters+"date="+date;
                    }

                    if(state !== ""){
                        getParameters = getParameters+"state="+state;
                    }

                    if(employee !== ""){
                        getParameters = getParameters+"employee="+employee;
                    }

                    

                     obj.state = "<form action='overview.php"+getParameters+"' method=POST> <button type='submit'>Verify</button><input type='hidden' name='id' value='"+obj.id+"'></form>";

                }
                
                let row = "<tr><td><a href='overview.php?employee="+obj.employee+"'><i class='fa fa-user'></i>"+obj.name+"</a></td><td>"+obj.startDate+"</td><td>"+obj.endDate+"</td><td>"+obj.days+"</td><td class='icons'>"+obj.state+"</td></tr>"
                $('table tr:last').after(row);
            }

            start.val(startValue + offset);
            startValue = start.val();

            if(startValue >= numberOfRecordsValue){
                $("#loadMore").fadeOut(0);
            }

           
            
        }
    )

});
