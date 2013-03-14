<?php
include CLASS_PATH.'DcMysql.class.php';
final class model {
	private $db,$tablename='',$data='',$where='',$order='',$limit='';
	// 查询表达式参数
	protected $options=array();
	function __construct($tablename){
		$this->db=new DcMysql();
		$this->db->connect(C_DBHOST, C_DBUSER, C_DBPW, C_DBNAME);
		if (!empty($tablename))
			$this->tablename=PRE.$tablename;
	}

	function __destruct(){
		//$this->db->close();
		unset($this->db,$this->tablename,$this->data,$this->where,$this->order,$this->limit);
	}

	/**
	 * 增加一条记录
	 * @param unknown_type $data
	 */
	function add(){
		if (!is_array($this->data)){
			return false;
		}
		$arr_1=Common::keyArray($this->data);
		$arr_2=Common::valueArray($this->data);
		$sql='insert into '.$this->tablename.'';
		$sql.='('.implode(',', $arr_1).')';
		$sql.=' values('.implode(',', $arr_2).')';
		return $this->db->execute($sql);
	}

	/**
	 * 增加多条记录
	 * @param unknown_type $data
	 * @return boolean
	 */
	function addAll(){
		if (!is_array($this->data)){
			return false;
		}
		$sql='insert into '.$this->tablename.'';
		$sql.='('.implode(',', C::keyArray($this->data[0])).')';
		$sql.=' values '.C::addAllValue($this->data);
		$result=$this->db->execute($sql);
		return $result;
	}

	/**
	 * 更新记录
	 * @param unknown_type $data
	 * @param unknown_type $where
	 * @return number
	 */
	function save(){
		if (!is_array($this->data) || empty($this->tablename)){
			return false;
		}
		$sql='';
		$str=C::saveString($this->data);
		if (!empty($str)){
			$sql='update '.$this->tablename.' set ';
			$sql.=$str;
		}
		if (isset($this->where) && !empty($this->where)){
			$sql.=' where '.$this->where;
		}
		return $this->db->execute($sql);
	}
	
	/**
	 * 更新字段
	 * @param unknown_type $field
	 * @param unknown_type $value
	 * @param unknown_type $where
	 * @return number
	 */
	function setField($value){
		$sql='';
		if (isset($value) && isset($this->where)){
			$sql='update '.$this->tablename.' set ';
			$sql.=$value.' where '.$this->where;
		}
		return $this->db->execute($sql);
	}

	/**
	 * 字段增长
	 * @param unknown_type $field
	 * @param unknown_type $step
	 * @param unknown_type $where
	 */
	function setInc($field,$step){
		if (!isset($field) || !isset($step) || !isset($this->where)){
			return false;
		}
		$sql='update '.$this->tablename.' set ';
		$sql.=$field.'='.$field.'+'.$step.' where '.$this->where;
		$this->db->execute($sql);
	}

	/**
	 * 字段减少
	 * @param unknown_type $field
	 * @param unknown_type $step
	 * @param unknown_type $where
	 */
	function setDec($field,$step){
		if (!isset($field) || !isset($step) || !isset($this->where)){
			return false;
		}
		$sql='update '.$this->tablename.' set ';
		$sql.=$field.'='.$field.'-'.$step.' where '.$this->where;
		$this->db->execute($sql);
	}

	/**
	 * 删除
	 * @param unknown_type $where
	 * @return number
	 */
	function delete(){
		$sql='delete from '.$this->tablename.'';
		$sql.=' where '.$this->where;
		return $this->db->execute($sql);
	}

	/**
	 * 查询
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $limit
	 * @return Ambigous <boolean, multitype:multitype: >
	 */
	function select($field){
		$sql='select '.$field.' from '.$this->tablename.'';
		if (isset($this->where) && !empty($this->where)){
			$sql.=' where '.$this->where;
		}
		if (isset($this->order) && !empty($this->order)){
			$sql.=' order by '.$this->order;
		}
		if (isset($this->limit) && !empty($this->limit)){
			$sql.=' limit '.$this->limit;
		}
		//echo $sql;
		return $this->db->getAll($sql);
	}
	
	/**
	 * 多表查询
	 */
	function selectmulti(){
		
	}

	/**
	 * 返回一条记录
	 * @param unknown_type $where
	 * @return Ambigous <boolean, multitype:multitype: >
	 */
	function find($field){
		$sql='select '.$field.' from '.$this->tablename.'';
		$sql.=' where '.$this->where;
		return $this->db->fetch_row($sql);
	}

	/**
	 * 读取一个字段
	 * @param unknown_type $field
	 * @param unknown_type $where
	 */
	function getField($field,$where=''){
		if (!isset($field)){
			return false;
		}
		if (!empty($where))
		$this->where=$where;
		$sql='select '.$field.' from '.$this->tablename.'';
		if (!empty($this->where))
		$sql.=' where '.$this->where;
		return $this->db->getfield($sql);
	}
	
	function query($sql){
		return $this->db->getAll($sql);
	}
	
	function execute($sql){
		return $this->db->query($sql);
	}

	function data($data){
		if (is_array($data)){
			$this->data=$data;
			return $this;
		}else{
			return false;
		}
	}

	function where($str){
		if (isset($str)){
			$this->where=$str;
			return $this;
		}else {
			return false;
		}
	}

	function order($str){
		if (isset($str)){
			$this->order=$str;
			return $this;
		}else {
			return false;
		}
	}

	function limit($str){
		if (isset($str)){
			$this->limit=$str;
			return $this;
		}else {
			return false;
		}
	}

	/**
	 * 分页
	 * Enter description here ...
	 * @param $field
	 */
	function page($view,$options=array()){
		$field='id';
		$page_size=15;
		$sub_pages = 10;
		$a=C::get('action');
		$o=C::get('operation');
		$url='?action='.$a.'&operation='.$o.'&p=';
		if (!empty($options) && is_array($options)){
			$field=!empty($options[0])?$options[0]:'id';
			$page_size=!empty($options[1])?$options[1]:15;
			$sub_pages=!empty($options[2])?$options[2]:10;
			if (!empty($options[3])){
				$url=$options[3];
			}
		}
		$nums=$this->getField('count('.$field.')');
		$pageCurrent = 1;
		$offset = 0;
		if (isset ( $_GET ["p"] )) {
			$pageCurrent = $_GET ["p"];
			$offset = $page_size * ($pageCurrent - 1);
		}
		$this->limit="".$offset.",".$page_size."";
		$data=array($page_size, $nums, $pageCurrent, $sub_pages);
		$subPages = new SubPages($data, $url);
		$view->assign('paging',$subPages->subPageCss2());
		return $this;
	}
}

?>