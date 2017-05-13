<?php 

class Order_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function add($order)
    {
        $this->db->insert('order', $order);
    }

    public function getByUserID($user_id)
    {
        $sql = "select * from mlq_order where user_id= ? order by id desc";
        $query = $this->db->query($sql, array($user_id));

        return $query->result();
    }

}
