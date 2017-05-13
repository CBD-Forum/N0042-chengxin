<?php 

class Cash_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function records($user_id)
    {
        $sql = "select * from mlq_cash_record where user_id=? order by id desc";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }

    public function add_record($record)
    {
        $this->db->insert('cash_record', $record);
        return $this->db->insert_id();
    }
}
