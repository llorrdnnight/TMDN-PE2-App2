<?php
class Order {
    //Primary & Foreign Keys
    private $id;
    private $customerId;
    private $flightId;

    //Properties
    private $sourceAdd;
    private $destAdd;
    private $departDate;
    private $arrivalDate;
    private $status;
    private $price;
    private $payed;

    //Constructor
    function __construct($id, $cId, $fId, $source, $dest, $departure, $arrival, $status, $price, $payed)
    {
        $this->id = $id;
        $this->customerId = $cId;
        $this->flightId = $fId;

        $this->sourceAdd = $source;
        $this->destAdd = $dest;
        $this->departDate = $departure;
        $this->arrivalDate = $arrival;
        $this->status = $status;
        $this->price = $price;
        $this->payed = $payed;
    }

    //Get & Set Methods
    function set_id($id) {
        $this->id = $id;
    }
    function get_id() {
        return $this->id;
    }

    function set_cutomerId($cId) {
        $this->customerId = $cId;
    }
    function get_customerId() {
        return $this->customerId;
    }

    function set_flightId($fId) {
        $this->flightId = $fId;
    }
    function get_flightId() {
        return $this->flightId;
    }


    function set_sourceAdd($source) {
        $this->sourceAdd = $source;
    }
    function get_sourceAdd() {
        return $this->sourceAdd;
    }

    function set_destAdd($dest) {
        $this->destAdd = $dest;
    }
    function get_destAdd() {
        return $this->destAdd;
    }

    function set_departDate($departure) {
        $this->departDate = $departure;
    }
    function get_departDate() {
        return $this->departDate;
    }

    function set_arrivalDate($arrival) {
        $this->arrivalDate = $arrival;
    }
    function get_arrivalDate() {
        return $this->arrivalDate;
    }

    function set_status($status) {
        $this->status = $status;
    }
    function get_status() {
        return $this->status;
    }

    function set_price($price) {
        $this->price = $price;
    }
    function get_price() {
        return $this->price;
    }

    function set_payed($payed) {
        $this->payed = $payed;
    }
    function get_payed() {
        return $this->payed;
    }
}

class Customer {
    private $id;
    private $fName;
    private $lName;
    private $dateOB;
    private $email;
    private $phone;
    private $type;

    function __construct($id, $fN, $lN, $dOB, $ema, $ph, $ty)
    {
        $this->id = $id;
        $this->fName = $fN;
        $this->lName = $lN;
        $this->dateOB = $dOB;
        $this->email = $ema;
        $this->phone = $ph;
        $this->type = $ty;
    }

    function set_id($id) {
        $this->id = $id;
    }
    function get_id() {
        return $this->id;
    }

    function set_fName($fName) {
        $this->fName = $fName;
    }
    function get_fName() {
        return $this->fName;
    }

    function set_lName($lName) {
        $this->lName = $lName;
    }
    function get_lName() {
        return $this->lName;
    }

    function set_dateOB($dateOB) {
        $this->dateOB = $dateOB;
    }
    function get_dateOB() {
        return $this->dateOB;
    }

    function set_email($email) {
        $this->email = $email;
    }
    function get_email() {
        return $this->email;
    }

    function set_phone($phone) {
        $this->phone = $phone;
    }
    function get_phone() {
        return $this->phone;
    }

    function set_type($type) {
        $this->type = $type;
    }
    function get_type() {
        return $this->type;
    }
}

class Product{
    private $id;
    private $name;
    private $quantity;
    private $weight; // in Kilograms

    function __construct($id, $name, $quantity, $weight)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->weight = $weight;
    }

    function set_id($id) {
        $this->id = $id;
    }
    function get_id() {
        return $this->id;
    }

    function set_name($name) {
        $this->name = $name;
    }
    function get_name() {
        return $this->name;
    }

    function set_quantity($quantity) {
        $this->quantity = $quantity;
    }
    function get_quantity() {
        return $this->quantity;
    }

    function set_weight($weight) {
        $this->weight = $weight;
    }
    function get_weight() {
        return $this->weight;
    }
}
?>