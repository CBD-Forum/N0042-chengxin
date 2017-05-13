<?php 

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id)
    {
        $sql = "SELECT * FROM mlq_user WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }


    public function create($phone, $password, $parent)
    {
        $user = array(
            'phone' => $phone,
            'password' => $password,
            'parent' => $parent,
            'created_at' => time()
        );
        $this->db->insert('user', $user);
        $user_detail = array(
            'user_id' => $this->db->insert_id()
        );
        return $this->db->insert('user_detail', $user_detail);
    }

    public function check($phone, $password)
    {
        $sql = "select * from mlq_user where phone = ? and password = ?";
        $query = $this->db->query($sql, array($phone, $password));
        return $query->row();
    }

    public function exist($phone)
    {
        $sql = "SELECT * FROM mlq_user WHERE phone = ?";
        $query = $this->db->query($sql, array($phone));
        return $query->row();
    }

    public function detail($user_id)
    {
        $sql = "SELECT * FROM mlq_user_detail WHERE user_id=?";
        $query = $this->db->query($sql, array($user_id));
        return $query->row();
    }

    public function detail_update($detail)
    {
        return $this->db->update('user_detail', $detail, "id=".$detail->id);

    }

    public function is_child($parent_id, $child_id)
    {
        $sql = "select * from mlq_user where id = ? and p_id = ?";

        $query = $this->db->query($sql, array($child_id, $parent_id));

        return $query->num_rows() > 0 ? true : false;
    }

    public function childs($user_id)
    {
        $sql = "select * from mlq_user where p_id= ? order by id desc";

        $query = $this->db->query($sql, array($user_id));

        return $query->result();
    }

}
