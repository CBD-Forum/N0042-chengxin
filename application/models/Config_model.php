<?php 

class Config_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_name($name)
    {
        $sql = "select * from mlq_config where name = ?";
        $query = $this->db->query($sql, array($name));
        return $query->row();
    }

}
