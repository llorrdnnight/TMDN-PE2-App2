<?php
    // Database Table base class, voor objecten die gemaakt moeten worden uit een table
    class DatabaseTable
    {
        public function fetchRecords($table, $id)
        {
            return 0;
        }
    }

    class Employee
    {
        public function __construct($p_Id = 0, $p_Firstname = "", $p_Surname = "", $p_Address = "", $p_IsAdmin = 0)
        {
            $this->m_Id = $p_Id;
            $this->m_Firstname = $p_Firstname;
            $this->m_Surname = $p_Surname;
            $this->m_Address = $p_Address;
            $this->m_IsAdmin = $p_IsAdmin;
        }

        public function getFirstname() { return $this->m_Firstname; }
        public function setFirstname($p_Value) { $this->m_Firstname = $p_Value; }

        public function getSurname() { return $this->m_Surname; }
        public function setSurname($p_Value) { $this->m_Surname = $p_Value; }

        public function getAddress() { return $this->m_Address; }
        public function setAddress($p_Value) { $this->m_Address = $p_Value; }

        public function getIsAdmin() { return $this->m_IsAdmin; }
        public function setIsAdmin($p_Value) { $this->m_IsAdmin = $p_Value; }

        public function __tostring()
        {
            return $this->m_Firstname;
        }

        private $m_Id;
        private $m_Firstname;
        private $m_Surname;
        private $m_Address;
        private $m_IsAdmin;
    }

    class Complaint
    {

    }

    class Product
    {

    }
?>