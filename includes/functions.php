<?php
function year($date){
    $year=" ";
    for($i=0;$date[$i] != '-';$i++){
        $year.=$date[$i];
    }
    return $year;
}
function month($date){
    $month=" ";
    for($i=5;$date[$i] != '-';$i++){
        $month.=$date[$i];
    }
    if($month == '01'){
        return "Jan";
    }
    else if($month == '02'){
        return "Feb";        
    }
    else if($month == '03'){
        return "March";        
    }
    else if($month == '04'){
        return "April";        
    }
    else if($month == '05'){
        return "May";        
    }
    else if($month == '06'){
        return "June";        
    }
    else if($month == '07'){
        return "July";        
    }
    else if($month == '08'){
        return "August";        
    }
    else if($month == '09'){
        return "Sept";        
    }
    else if($month == '10'){
        return "Oct";        
    }
    else if($month == '11'){
        return "Nov";        
    }
    else{
        return "Dec";        
    }
}
function day($date){
    $day=" ";
    for($i=8;$i<10;$i++){
        $day.=$date[$i];
    }
    if($date[8] != '1' && $date[9]== '1'){
        return $day."st";
    }
    else if($date[8] != '1' && $date[9] == '2'){
        return $day."nd";
    }
    else if($date[8] != '1' && $date[9] == '3'){
        return $day."rd";
    }
    else{
        return $day."th";
    }
}
function GetImageExtension($imagetype){
    if(empty($imagetype)) {
        return false;
    }
    switch ($imagetype){
        case 'image/bmp': return '.bmp';
        case 'image/gif': return '.gif';
        case 'image/jpeg': return '.jpeg';
        case 'image/png': return '.png';
        default : return false;
    }
}