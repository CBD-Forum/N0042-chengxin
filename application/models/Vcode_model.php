<?php 

class Vcode_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function create($phone, $vcode)
    {
        $item = array(
            'phone'=>$phone, 
            'vcode'=>$vcode, 
            'created_at'=>time()
        );
        return $this->db->insert('vcode', $item);
    }

    //取出对应手机号的最后一条记录
    public function last($phone)
    {
        $sql = "SELECT * FROM mlq_vcode WHERE phone = ? order by id desc";
        $query = $this->db->query($sql, array($phone));
        return $query->row();
    }

    public function check($phone, $vcode)
    {
        $sql = "SELECT * FROM mlq_vcode WHERE phone = ? and vcode = ? order by id desc";
        $query = $this->db->query($sql, array($phone, $vcode));
        return $query->row();
    }

    public function unsent_one()
    {
        $sql = "SELECT * FROM mlq_vcode WHERE status=0";
        $query = $this->db->query($sql);
        return $query->row();
    }

}
