<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/19
 * Time: 14:06
 */
class MY_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $table
     * @param array $search
     * @param string $select
     * @return mixed
     */
    public function _info($table, $search=array(), $select = '*')
    {
        if ($search){
            self::_search($search);
        }
        $this->db->select($select,false);
        $this->db->limit(1);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    public function _info2($table, $search=array(), $select = '*')
    {
        if ($search){
            self::_search($search);
        }
        $this->db->select($select,false);
        //$this->db->limit(1);
        $query = $this->db->get($table);
        foreach ($query->result_array() as $value)
        {
           foreach ($value as $v)
           {
               $str[]=$v;
           }
        }
        
        return $str;
    }
    
    
    /**
     * @param $table
     * @param $data
     * @return mixed
     */
    public function _add($table, $data)
    {
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    /**
     * @param $table
     * @param array $search
     * @param $data
     * @return mixed
     */
    public function _edit($table, $search=array(), $data)
    {
        if($search){
            self::_search($search);
        }
        return $this->db->update($table,$data);
    }

    /**
     * @param $table
     * @param array $search
     * @return mixed
     */
    public function _count($table, $search=array())
    {
        if ($search){
            self::_search($search);
        }
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    /**
     * @param $table
     * @param array $search
     * @return mixed
     */
    public function _delete($table, $search=array())
    {
        if ($search){
            self::_search($search);
        }
        return $this->db->delete($table);
    }

    /**
     * @param $table
     * @param array $search
     * @param string $orderby
     * @param string $field
     * @param array $limit
     * @return mixed
     */
    public function _list($table,$search=array(),$orderby= array(),$field='*',$limit=array())
    {
        if($search){
            self::_search($search);
        }
        if($limit){
            $this->db->limit($limit[1], $limit[0]);
        }
        $this->db->select($field,false);
        
        if($orderby){
            foreach($orderby as $key=>$value){
                $this->db->order_by($key,$value);
                break;
            }
        }else{
            $this->db->order_by('id','desc');
        }
        $query=$this->db->get($table);
        return $query->result_array();
    }

    public function _join($table = array(),$search=array(),$orderby=array(),$field='*',$limit=array())
    {
        if($search){
            self::_search($search);
        }
        if($limit){
            $this->db->limit($limit[1], $limit[0]);
        }
        $this->db->select($field,false);
        
        if($orderby){
            foreach($orderby as $key=>$value){
                $this->db->order_by($key,$value);
                break;
            }
        }else{
            $this->db->order_by('id','desc');
        }
        $this->db->from($table[0]);
        if (isset($table[3]))
        {
            $this->db->join($table[1],$table[2],$table[3]);
        }
        else
        {
            $this->db->join($table[1],$table[2]);
        }
        
        if (isset($table[4]))
        {
            $this->db->group_by($table[4]);
        }
            
        $query=$this->db->get();
        return $query->result_array();
    }

    
    public function _join2($table = array(),$search=array(),$orderby=array(),$field='*',$limit=array())
    {
        if($search){
            self::_search2($search,false);
        }
        if($limit){
            $this->db->limit($limit[1], $limit[0]);
        }
        $this->db->select($field,false);
    
        if($orderby){
            foreach($orderby as $key=>$value){
                $this->db->order_by($key,$value);
                break;
            }
        }else{
            $this->db->order_by('id','desc');
        }
        $this->db->from($table[0]);
        if (isset($table[3]))
        {
            $this->db->join($table[1],$table[2],$table[3]);
        }
        else
        {
            $this->db->join($table[1],$table[2]);
        }
    
        if (isset($table[4]))
        {
            $this->db->group_by($table[4]);
        }
        $query=$this->db->get();
        return $query->result_array();
    }
    
   
    /**
     * @param array $search
     */
    protected function _search($search = array())
    {
        foreach($search as $key=>$value){
            $this->db->where($key,$value);
        }
    }
    
    protected function _search2($search = array())
    {
        foreach($search as $key=>$value){
            $this->db->or_where($key,$value);
        }
    }
    public function _my_query($search)
    {
       $sql=$search;
       $query = $this->db->query($sql);
       
        return $query->result_array();
    }
    

    
}