
function insertEmployeeRequest(first, last, id){
    document.getElementById("first_name").value = first; 
    document.getElementById("last_name").value =last;
    document.getElementById("employee_id").value = id;
} 

function insertEmployee(index,id,first,last,email,emp_minor,emp_type,
                        mon_start,mon_end,tues_start,tues_end,wed_start,wed_end,
                        thurs_start,thurs_end,fri_start,fri_end,sat_start,sat_end,sun_start,sun_end){
           
    document.getElementById('first_name').value = first;
    document.getElementById('last_name').value = last;
    document.getElementById('email').value = email;
    document.getElementById('emp_minor').value = emp_minor;
    document.getElementById('emp_type').value = emp_type;
       
    if(mon_start != ''){
        document.getElementById('monday_start').value = mon_start;
        loadTime("monday_end",mon_end);
    }   
    else{
        document.getElementById('monday_start').value = "default";
        document.getElementById('monday_end').options.length = 0;
    }
    if(tues_start != ''){
        document.getElementById('tuesday_start').value = tues_start;
        loadTime("tuesday_end",tues_end);
    }
    else{
        document.getElementById('tuesday_start').value = "default";
        document.getElementById('tuesday_end').options.length = 0;
    }
    if(wed_start != ''){
         document.getElementById('wednesday_start').value = wed_start;
         loadTime("wednesday_end",wed_end);
    }
    else{
        document.getElementById('wednesday_start').value = "default";
        document.getElementById('wednesday_end').options.length = 0;
    }
    if(thurs_start != ''){
        document.getElementById('thursday_start').value = thurs_start;
        loadTime("thursday_end",thurs_end);
    }
    else{
        document.getElementById('thursday_start').value = "default";
        document.getElementById('thursday_end').options.length = 0;
    }
    if(fri_start != ''){
        document.getElementById('friday_start').value = fri_start;
        loadTime("friday_end",fri_end);
    }
    else{
        document.getElementById('friday_start').value = "default";
        document.getElementById('friday_end').options.length = 0;
    }
    if(sat_start != ''){
        document.getElementById('saturday_start').value = sat_start;
        loadTime("saturday_end",sat_end);
    }
    else{
        document.getElementById('saturday_start').value = "default";
        document.getElementById('saturday_end').options.length = 0;
    }
    if(sun_start != ''){
        document.getElementById('sunday_start').value = sun_start;
        loadTime("sunday_end",sun_end);
    }
    else{
        document.getElementById('sunday_start').value = "default";
        document.getElementById('sunday_end').options.length =0;
    }
         
    document.getElementById('array_index').value = index;
    document.getElementById('employee_id').value = id;   
}

function loadTime(table,end){
   
   var end_time = end;
   var time_list;
   var end_time_list;
   
    if(table == "monday_end"){
         time_list = document.getElementById("monday_start");
         end_time_list = document.getElementById("monday_end");
    }
    if(table == "tuesday_end"){
         time_list = document.getElementById("tuesday_start");
         end_time_list = document.getElementById("tuesday_end");
    }
    if(table == "wednesday_end"){
        time_list = document.getElementById("wednesday_start");
        end_time_list = document.getElementById("wednesday_end");
    }
    if(table == "thursday_end"){
       time_list = document.getElementById("thursday_start");
       end_time_list = document.getElementById("thursday_end");
    }
    if(table == "friday_end"){
        time_list = document.getElementById("friday_start");
        end_time_list = document.getElementById("friday_end");
    }
    if(table == "saturday_end"){
        time_list = document.getElementById("saturday_start");
        end_time_list = document.getElementById("saturday_end");
    }
    if(table == "sunday_end"){
        time_list = document.getElementById("sunday_start");
        end_time_list = document.getElementById("sunday_end"); 
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

function insertRequests(request_id, employee_id, first_name,last_name, start_month, start_day,end_month,end_day,start_time,end_time){
    
    var start_month_list = document.getElementById("start_request_month");
    var end_month_list = document.getElementById("end_request_month");
    var end_month_value = end_month;
    document.getElementById("first_name").value = first_name;
    document.getElementById("last_name").value = last_name;
    document.getElementById("start_request").value = start_time;
    document.getElementById("start_request_month").value = start_month;
    
    startDate();
    end_month_list.options.length=0;
    document.getElementById("start_request_day").value = parseInt(start_day);
    
    for(var x = 0; x < start_month_list.length;x++){
        
        if(start_month_list[x].value == end_month_value){
            var index; 
            index = x;
        }
    }
    
    var months_to_add = start_month_list.options.length - index;
    
    for(var x =0; x < months_to_add;x++){
        
        var option = document.createElement("Option");
        option.value = start_month_list[index].value;
        option.text = start_month_list[index].text;
        end_month_list.options[x] = option;
        index++;
    }
    endDate();
    document.getElementById("end_request_day").value = end_day;
    startTime("end_request",end_time);
}

function startTime(select_name,end_value){
     
     var start_time_selected;
     var start_time_list;
     var end_time_list;
     
    if(select_name == "start_request"){
        start_time_selected = document.getElementById("start_request").value;
        start_time_list = document.getElementById("start_request");
        end_time_list = document.getElementById("end_request");
    }
    
    if(select_name == "end_request"){
        start_time_selected = end_value;
        start_time_list = document.getElementById("start_request");
        end_time_list = document.getElementById("end_request");   
    }
        
    if(select_name == "monday_start"){
        start_time_selected = document.getElementById("monday_start").value;
        start_time_list = document.getElementById("monday_start");
        end_time_list = document.getElementById("monday_end");
    }
        
    if(select_name == "tuesday_start"){
        start_time_selected = document.getElementById("tuesday_start").value;
        start_time_list = document.getElementById("tuesday_start");
        end_time_list = document.getElementById("tuesday_end");
    }
    if(select_name == "wednesday_start"){
        start_time_selected = document.getElementById("wednesday_start").value;
        start_time_list = document.getElementById("wednesday_start");
        end_time_list = document.getElementById("wednesday_end");
    }
    if(select_name == "thursday_start"){
        start_time_selected = document.getElementById("thursday_start").value;
        start_time_list = document.getElementById("thursday_start");
        end_time_list = document.getElementById("thursday_end");
    }
    if(select_name == "friday_start"){
        start_time_selected = document.getElementById("friday_start").value;
        start_time_list = document.getElementById("friday_start");
        end_time_list = document.getElementById("friday_end");
    }
    if(select_name == "saturday_start"){
        start_time_selected = document.getElementById("saturday_start").value;
        start_time_list = document.getElementById("saturday_start");
        end_time_list = document.getElementById("saturday_end");
    }
    if(select_name == "sunday_start"){
        start_time_selected = document.getElementById("sunday_start").value;
        start_time_list = document.getElementById("sunday_start");
        end_time_list = document.getElementById("sunday_end");
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
   
function startDay(){
        
    var start_month_selected = document.getElementById("start_request_month").value;
    var end_month_selected = document.getElementById("end_request_month").value;
    var start_day_selected = document.getElementById("start_request_day").value;
        
    var start_day_list = document.getElementById("start_request_day");        
    var day_list = document.getElementById("end_request_day");
     
    var days_to_add = start_day_list.options.length - start_month_selected +1;
    var index = start_day_selected -1;
        
    if(start_month_selected == end_month_selected){
       
        day_list.options.length = 0; 
            
        var option = document.createElement("Option");
            
        for(var x = 0; x < days_to_add; x++){
                
            var option = document.createElement("Option");
            option.text = start_day_list[index+1].text;
            option.value = start_day_list[index+1].value;
            day_list.options[x] = option;
            index++;  
        }
    }
}
    
function startDate(){
        
    //Variable the value of the month selected by the user
    var month_selected = document.getElementById("start_request_month").value;
        
    //These variables will hold the entire select object instead of the selected option.
    var end_month_list = document.getElementById("end_request_month");
    var end_day_list = document.getElementById("end_request_day");
    var total_months = document.getElementById("start_request_month");
    var day_list = document.getElementById("start_request_day");
        
    //Variable to determine how many months need to be added to the end request 
    //date month drop down list. 
    var months_to_add = 12 - month_selected +1;
    
    var index = parseInt(month_selected);
     
    end_day_list.options.length=0;
    end_month_list.options.length = 0; 
       
    for(var i = 0; i < months_to_add;i++){
        var option = document.createElement("Option");
        option.text = total_months.options[index].text;
        option.value = total_months.options[index].value;
        end_month_list.options[i] = option;         
        index++;  
    }
        
    day_list.options.length = 0;
        
    var option = document.createElement("Option");
    option.text = "---";
    day_list.options[0]=option;
        
    if(month_selected == "01" || month_selected == "12" || month_selected == "03" ||
        month_selected == "05" || month_selected == "07" || month_selected == "08" || month_selected == "10"){
             
        for(var i = 1; i < 32; i++){
            var option = document.createElement("Option");
            option.text = i;
            option.value = i;
            day_list.options[i] = option;   
        }
    }
    if(month_selected == "02"){
             
        for(var i = 1; i < 29; i++){
            var option = document.createElement("Option");
            option.text = i;
            option.value = i;
            day_list.options[i] = option;
        }
    }
    if(month_selected == "04" || month_selected == "06" || month_selected == "11"){
           
        for(var i = 1; i < 31; i++){
            var option = document.createElement("Option");
            option.text = i;
            option.value = i;
            day_list.options[i] = option;
        }
    }
    if(month_selected == "09"){
            
        for(var i = 1; i < 30; i++){
            var option = document.createElement("Option");
            option.text = i;
            option.value = i;
            day_list.options[i] = option;    
        }
    }
}
function endDate(){
        
    var start_month = document.getElementById("start_request_month").value;
    var end_month = document.getElementById("end_request_month").value;
    var end_day_list = document.getElementById("end_request_day");
        
    if(start_month == end_month){
        startDay();
            
    }
    else{
            
        var month_selected = document.getElementById("end_request_month").value;
           
        end_day_list.options.length = 0;
             
        var option = document.createElement("Option");
        option.text = "---";
        end_day_list.options[0] = option;
            
        if(month_selected == "01" || month_selected == "12" || month_selected == "03" ||
            month_selected == "05" || month_selected == "07" || month_selected == "08" || month_selected == "10"){
   
            for(var i = 1; i < 32; i++){
                
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                end_day_list.options[i] =option;    
            }
        }
        if(month_selected == "02"){
                
            for(var i = 1; i < 29; i++){
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                end_day_list.options[i] = option; 
            }
        }
        if(month_selected == "04" || month_selected == "06" || month_selected == "11"){
             
            for(var i = 1; i < 31; i++){
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                end_day_list.options[i] = option;
            }
        }
        if(month_selected == "09"){
           
            for(var i = 1; i < 30; i++){
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                end_day_list.options[i] = option;
            }
        }
    }
}