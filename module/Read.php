<?php 
class Read{
    //DB properties 
    private $conn;
    private $table='cities_extended';

    //cities_extended Properties
    public $city;
    public $state_code;
    public $zip;
    public $latitude;
    public $longitude;
    public $county;
    // other properties
    public $cores; 
    public $request;

    //Constructor wuith DB
    public function __construct($db){
        $this->conn=$db;
    }
//Get citis

    public function read($request){ //i  added a param for search, there can more: laitude,longitude but many wouldn't know longitude&lititude of a city
//query
    $query="SELECT * FROM
        ".$this->table."
        WHERE city LIKE '%".$request."%' 
        ORDER BY '%".$request."%'
        
        ";
//prepare statement
    $statement=$this->conn->prepare($query);
//execute query
    $statement->execute();
    return $statement;
}
}