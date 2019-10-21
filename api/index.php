<?php 
//Headers
header('Access-Control-Allow-Origin');
header('Content-Type: application/json');
//DB  & Module files
include_once('../config/Database.php');
include_once('../module/Read.php');

//Instantiate DB & connect
$database=new Database();
$db=$database->connect();

//Instantiate city read object
$city=new Read($db);

//city query
$request=$_GET['q'];
$time_start = microtime(true); 
$result=$city->read($request);
$numRows=$result->rowCount();

//check for record  !=0
if($numRows>0){
//city array
$city_arr=array();
$city_arr['suggestion']=array();
//
$time_ended = microtime(true);
$time=($time_ended - $time_start);
number_format($time, 2);
//
$start=1;
while($row=$result->fetch(PDO::FETCH_ASSOC)){

 ($start)==1?$scores='Most Accurate': $scores='Matched';// 1, 0, ---
    extract($row);
    
    //cities_extended Properties: city, state_code, zip, latitude, longitude, county 
    $city_list=array(
        'state_code'=>$state_code,
        //'county'=>$county,
        'city'=>$city,
        'latitude'=>$latitude,
        'longitude'=>$longitude,
        'score'=>$scores.'@No:'.$start++.'!'
    );

    //Push to data
    array_push($city_arr['suggestion'], $city_list);
}
//convert to JSON & output
    echo json_encode($city_arr);
}else{
    echo json_decode(array('Message:'=>'No City Found'));
}
