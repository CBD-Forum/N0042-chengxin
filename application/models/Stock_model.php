<?php 

class Stock_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function stock_buy($stock_buy)
    {
        return $this->db->insert('stock_buy', $stock_buy);
    }

    public function buy_list($user_id)
    {
        $sql = "select * from mlq_stock_buy where user_id = ? order by id desc";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }


}
