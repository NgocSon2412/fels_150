<?php

class Word_Model extends CI_Model 
{
    const TABLE = 'words';

    public function get_word($param_where = NULL) {
        $this->db->select('*')->from(self::TABLE);
        if(isset($param_where) && count($param_where)) {
            $this->db->where($param_where);
        }
        return $this->db->get()->row_array();
    }

    public function total() 
    {
        return $this->db->from(self::TABLE)->count_all_results();
    }
    
    public function view($start, $limit) 
    {
        return $this->db->select('*')->from(self::TABLE)->order_by('id DESC')->limit($limit, $start)->get()->result_array();   
    }

    public function insert($param_data = NULL) 
    {
        $this->db->insert(self::TABLE, $param_data);
        $fag = array(
            'affected_rows' => $this->db->affected_rows(),
            'insert_id' => $this->db->insert_id(),
        );
        return $fag;
    }

    public function update($id, $param_data = NULL) 
    {            
        $id = (int)$id;
        $this->db->where('id', $id);
        $this->db->update(self::TABLE, $param_data);
        return $this->db->affected_rows();
    }

    public function delete($param_data = NULL) 
    {            
        $this->db->where_in('id', $param_data)->delete(self::TABLE); 
        return $this->db->affected_rows();
    } 
}
