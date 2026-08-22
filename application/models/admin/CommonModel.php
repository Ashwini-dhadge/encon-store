<?php
/**
 * 
 */
class CommonModel extends CI_Model
{
	protected $Product_Column = array(
									'p.id',
									'p.products',
									'p.quantity',
									'p.price',
									''
							);
	protected $Category_Column = array(
									'c.id',
									'c.category',
									'c.path',
									''
							);

	public function getData($table, $where='',$fields='',$group_by='',$return='')
	{
		if ($fields) {
			$this->db->select($fields);
		}
		if ($where) {
			$this->db->where($where);
		}
		if ($group_by) {
			$this->db->group_by($group_by);
		}
		$query = $this->db->get($table);
		
		if($return == 'row'){
			$result = $query->row();
		}else if($return == 'row_array'){
			$result = $query->row_array();
		}else if($return == 'result'){
			$result = $query->result();
		}else if($return == 'num_rows'){
			$result = $query->num_rows();
		}else{
			$result = $query->result_array();
		}
		return $result;
	}

	public function iudAction($table='',$data = array(), $action='', $where =array())
	{
		switch ($action) {
			case 'insert':
				$this->db->insert($table, $data);
				return $this->db->insert_id();
				break;
			case 'update':
				$this->db->where($where);
				$this->db->set($data);
				$this->db->update($table); 
				return ($this->db->affected_rows() > 0)? true : false ;
				break;
			case 'delete':
				$this->db->where($where);
				$this->db->delete($table); 
				return ($this->db->affected_rows() > 0)? true : false ;
				break;

			case 'batch_insert':
				$this->db->insert_batch($table, $data);
				return ($this->db->affected_rows() > 0)? true : false ;
				break;
			case 'batch_update':
				$this->db->update_batch($table, $data);
				return ($this->db->affected_rows() > 0)? true : false ;
				break;

			default:
				return false;
				break;
		}
	}
	
	public function getDataWhereIn($table,$where='',$fields='',$group_by='',$return='', $where_in_key='',$where_arry=array())
	{
		if ($fields) {
			$this->db->select($fields);
		}
		if ($where) {
			$this->db->where($where);
		}
		if ($where_in_key && $where_arry) {
			$this->db->where_in($where_in_key,$where_arry);
		}
		if ($group_by) {
			$this->db->group_by($group_by);
		}
		$query = $this->db->get($table);
		
		if($return == 'row'){
			$result = $query->row();
		}else if($return == 'row_array'){
			$result = $query->row_array();
		}else if($return == 'result'){
			$result = $query->result();
		}else if($return == 'num_rows'){
			$result = $query->num_rows();
		}else{
			$result = $query->result_array();
		}
		return $result;
	}
	
	  public function getLastYearRate($where=''){
        $this->db->select('*');        
        $this->db->from('tbl_items_inventory_details');         
        

        if($where) {
              $this->db->where($where);
        } 
        $where_arry=array(1,3,4);
        $this->db->where_in('type',$where_arry);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $result = $this->db->get()
                           ->row_array();
      
          return $result;
    }

}
?>