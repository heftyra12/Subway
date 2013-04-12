function insertEmployee(index,id,first,last,email,emp_minor,emp_type,mon_start,mon_end,tues_start,tues_end,wed_start,wed_end,
                                thurs_start,thurs_end,fri_start,fri_end,sat_start,sat_end,sun_start,sun_end){
       
        var first_name = first;
        var last_name = last; 
        var email = email;
        var emp_minor = emp_minor;
        var emp_type = emp_type;
        var array_index = index; 
        var employee_id = id;
        
        var mon_start = mon_start;
        var mon_end = mon_end;
        var tues_start = tues_start;
        var tues_end = tues_end;
        var wed_start = wed_start;
        var wed_end = wed_end;
        var thurs_start = thurs_start;
        var thurs_end = thurs_end;
        var fri_start = fri_start;
        var fri_end = fri_end;
        var sat_start = sat_start;
        var sat_end = sat_end;
        var sun_start = sun_start;
        var sun_end = sun_end;
        
        document.getElementById('first_name').value = first_name;
        document.getElementById('last_name').value = last_name;
        document.getElementById('email').value = email;
        document.getElementById('emp_minor').value = emp_minor;
        document.getElementById('emp_type').value = emp_type;
       
        document.getElementById('monday_start').value = mon_start;
        document.getElementById('tuesday_start').value = tues_start;
        document.getElementById('wednesday_start').value = wed_start;
        document.getElementById('thursday_start').value = thurs_start;
        document.getElementById('friday_start').value = fri_start;
        document.getElementById('saturday_start').value = sat_start;
        document.getElementById('sunday_start').value = sun_start;
        
        loadTime("monday_end",mon_end);
        loadTime("tuesday_end",tues_end);
        loadTime("wednesday_end",wed_end);
        loadTime("thursday_end",thurs_end);
        loadTime("friday_end",fri_end);
        loadTime("saturday_end",sat_end);
        loadTime("sunday_end",sun_end);
        
        document.getElementById('array_index').value = array_index;
        document.getElementById('employee_id').value = employee_id;   
    }

function loadTime(table,end_time){
   
   if(table == "monday_end"){
       var end_time = end_time;
       var time_list = document.getElementById("monday_start");
       var end_time_list = document.getElementById("monday_end");
   }
    if(table == "tuesday_end"){
       var end_time = end_time;
       var time_list = document.getElementById("tuesday_start");
       var end_time_list = document.getElementById("tuesday_end");
   }
   if(table == "wednesday_end"){
       var end_time = end_time;
       var time_list = document.getElementById("wednesday_start");
       var end_time_list = document.getElementById("wednesday_end");
   }
   if(table == "thursday_end"){
       var end_time = end_time;
       var time_list = document.getElementById("thursday_start");
       var end_time_list = document.getElementById("thursday_end");
   }
   if(table == "friday_end"){
       var end_time = end_time;
       var time_list = document.getElementById("friday_start");
       var end_time_list = document.getElementById("friday_end");
   }
   if(table == "saturday_end"){
       var end_time = end_time;
       var time_list = document.getElementById("saturday_start");
       var end_time_list = document.getElementById("saturday_end");
   }
   if(table == "sunday_end"){
      var end_time = end_time;
       var time_list = document.getElementById("sunday_start");
       var end_time_list = document.getElementById("sunday_end"); 
   }
   
    for(var x =0; x < time_list.options.length;x++){
        if(end_time == time_list.options[x].value){
            var index;
            index = x;
        }
    }
  
   var times_to_add = time_list.options.length - index;
   end_time_list.options.length = 0; 
   
   for(var i = 0; i < times_to_add;i++){
       var option = document.createElement("Option");
       option.text = time_list.options[index].text;
       option.value = time_list.options[index].value;
       end_time_list.options[i] = option;
       index++;      
   }  
}

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

