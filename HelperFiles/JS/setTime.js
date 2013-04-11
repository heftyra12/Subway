function startTime(select_name){
     
    if(select_name == "start_request"){
        var start_time_selected = document.getElementById("start_request").value;
        var start_time_list = document.getElementById("start_request");
        var end_time_list = document.getElementById("end_request");
    }
        
    if(select_name == "monday_start"){
        var start_time_selected = document.getElementById("monday_start").value;
        var start_time_list = document.getElementById("monday_start");
        var end_time_list = document.getElementById("monday_end");
    }
        
    if(select_name == "tuesday_start"){
        var start_time_selected = document.getElementById("tuesday_start").value;
        var start_time_list = document.getElementById("tuesday_start");
        var end_time_list = document.getElementById("tuesday_end");
    }
    if(select_name == "wednesday_start"){
        var start_time_selected = document.getElementById("wednesday_start").value;
        var start_time_list = document.getElementById("wednesday_start");
        var end_time_list = document.getElementById("wednesday_end");
    }
    if(select_name == "thursday_start"){
        var start_time_selected = document.getElementById("thursday_start").value;
        var start_time_list = document.getElementById("thursday_start");
        var end_time_list = document.getElementById("thursday_end");
    }
    if(select_name == "friday_start"){
        var start_time_selected = document.getElementById("friday_start").value;
        var start_time_list = document.getElementById("friday_start");
        var end_time_list = document.getElementById("friday_end");
    }
    if(select_name == "saturday_start"){
        var start_time_selected = document.getElementById("saturday_start").value;
        var start_time_list = document.getElementById("saturday_start");
        var end_time_list = document.getElementById("saturday_end");
    }
    if(select_name == "sunday_start"){
        var start_time_selected = document.getElementById("sunday_start").value;
        var start_time_list = document.getElementById("sunday_start");
        var end_time_list = document.getElementById("sunday_end");
    }
       
    //Get index location of the selected start time.
    for(var x =0; x < start_time_list.options.length;x++){
        if(start_time_list.options[x].value == start_time_selected){
            var index;
            index = x;
        }
    }
        
    var slots_to_add = start_time_list.options.length - index;
       
    end_time_list.options.length=0;
        
    for(var i =0; i < slots_to_add; i++){
            
        var option = document.createElement("Option");
        option.text = start_time_list.options[index].text;
        option.value = start_time_list.options[index].value;
        end_time_list.options[i] = option;
        index++;   
    }        
}

