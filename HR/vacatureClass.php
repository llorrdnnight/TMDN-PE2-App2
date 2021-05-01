<?php
class Vacature {
    //Primary & Foreign Keys
    private $id;
    private $department;
    private $description;

    //Properties
    private $name;
    private $available;
    

    //Constructor
    function __construct($id, $name, $department, $available, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->department = $department;
        $this->available = $available;
        $this->description = $description;
        
    }

    //Get & Set Methods
    function set_id($id) {
        $this->id = $id;
    }

    function get_id() {
        return $this->id;
    }

    function set_name($name){
        $this->name = $name;
    }

    function get_name(){
        return $this->name;
    }

    function set_department($department){
        $this->department = $department;
    }

    function get_department(){
        return $this->department;
    }

    function set_available($available){
        $this->available = $available;
    }

    function get_available(){
        return $this->available;
    }

    function set_description($description){
        $this->description = $description;
    }

    function get_description(){
        return $this->description;
    }
}
