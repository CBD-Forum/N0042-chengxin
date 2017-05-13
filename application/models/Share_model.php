<?php 

class Share_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function add($share)
    {
        $this->db->insert("share", $share);
        return $this->db->insert_id();
    }

    public function get_by_status($status=0)
    {
        $sql = "select * from mlq_share where status = ?";
        $query = $this->db->query($sql, array($status));
        return $query->result();
    }

    public function share_update($share)
    {
        $this->db->update('share', $share, "id=".$share->id);

    }

    public function share_record($share_record)
    {
        $this->db->insert("share_record", $share_record);
        return $this->db->insert_id();
    }

    public function get_record_by_user_id($user_id)
    {
        $sql = "select * from mlq_share_record where user_id = ? order by id desc";
        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }

}
