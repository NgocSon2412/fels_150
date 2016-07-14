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
    
    public function view($start, $limit, $param_where = NULL) 
    {
        $this->db->select(self::TABLE. '.id as word_id ,'.self::TABLE. '.content, category_id, categories.name as 
            category_name,' .self::TABLE. '.created_at,' .self::TABLE. '.updated_at')
            ->from(self::TABLE)->join('categories', self::TABLE. ' . category_id = categories.id')
            ->order_by(self::TABLE. '.id DESC')
            ->limit($limit, $start);

        if(isset($param_where) && count($param_where)) {
            $this->db->where($param_where);
        }
        $arrayName = $this->db->get()->result_array();
        for ($i=0; $i < count($arrayName) ; $i++) { 
            $arrayName[$i]['word_answer'] = $this->Word_Answer_Model->get_word_answer(['word_id' => $arrayName[$i]['word_id'], 'correct' => '1']);
        }
        return $arrayName;
    }

    public function search($param_where = NULL) 
    {
        $this->db->select(self::TABLE. '.id as word_id ,'.self::TABLE. '.content, category_id, categories.name as 
            category_name,' .self::TABLE. '.created_at,' .self::TABLE. '.updated_at')
            ->from(self::TABLE)->join('categories', self::TABLE. ' . category_id = categories.id')
            ->order_by(self::TABLE. '.id DESC');

        if(isset($param_where) && count($param_where)) {
            $this->db->like($param_where);
        }
        $arrayName = $this->db->get()->result_array();
        for ($i=0; $i < count($arrayName) ; $i++) { 
            $arrayName[$i]['word_answer'] = $this->Word_Answer_Model->get_word_answer(['word_id' => $arrayName[$i]['word_id'], 'correct' => '1']);
        }
        return $arrayName;
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

    public function word_learn($list_word)
    {
        $word_learn = [];
        $word_learned = [];

        if(isset($list_word) && count($list_word)) {
            foreach ($list_word as $key => $value) {
                
                if ($this->Learned_Word_Model->total(['user_id' => $this->authentication['id'], 'word_id' => $value['word_id']]) == 0) {
                    $word_learn[] = $value;
                } else {
                    $word_learned[] = $value;
                }
            }
        }
        return ['word_learn' => $word_learn, 'word_learned' => $word_learned];
    }
}
