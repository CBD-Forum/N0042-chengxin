<?php 

class Address_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function add($user_id, $address, $name, $phone)
    {
        $item = array(
            'user_id'=>$user_id,
            'address'=>$address, 
            'name'=>$name, 
            'phone'=>$phone
        );
        $this->db->insert('address', $item);
        return $this->db->insert_id();
    }

    public function all($user_id)
    {
        $sql = "SELECT * FROM mlq_address where user_id = ? order by id desc";
        $query = $this->db->query($sql, array($user_id));

        $ret = array();
        foreach($query->result() as $row) {
            array_push($ret, $row);
        }
        return $ret;
    }

    public function getByID($id)
    {
        $sql = "select * from mlq_address where id= ?";
        $query = $this->db->query($sql, array($id));
        return $query->row();

    }

}
