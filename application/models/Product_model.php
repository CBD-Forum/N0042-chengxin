<?php 

class Product_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $query = $this->db->get("product");
        $ret = array();
        foreach($query->result() as $row) {
            array_push($ret, $row);
        }
        return $ret;
    }

}
