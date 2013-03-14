<?php
/**
 * PHP mysql数据库操作类
 */
final class DcMysql{
	/**
	 * 连接数据库的方法
	 */
	private $link;

	/**
	 * 连接并选择数据库
	 */
	public function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE)
	{
		$func = empty($pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		if(!$this->link = @$func($dbhost, $dbuser, $dbpw)) {
			$halt && $this->halt('Can not connect to MySQL server');
		} else {
			if($this->version() > '4.1') {
				global $charset, $dbcharset;
				$dbcharset = !$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8')) ? str_replace('-', '', $charset) : $dbcharset;
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET names utf8", $this->link);
			}
			$dbname && @mysql_select_db($dbname, $this->link);
		}
	}

	function select_database($dbname)
	{
		mysql_select_db($dbname, $this->link);
		mysql_query("set names utf8");
	}

	/**
	 *执行语句,成功时返回 TRUE，出错时返回 FALSE
	 *对 SELECT，SHOW，EXPLAIN 或 DESCRIBE 语句返回一个资源标识符
	 */
	public function query($sql)
	{
		return mysql_query($sql,$this->link);
	}


	/**
	 * 执行SQL语句返回记录数
	 * Enter description here ...
	 * @param unknown_type $str
	 */
	public function num_rows($query)
	{
		return mysql_num_rows($query);
	}


	/**
	 *返回数据库版本
	 */
	public function version()
	{
		return mysql_get_server_info($this->link);
	}

	/**
	 *
	 * 以数组方式返回查询数据MYSQL_ASSOC--关联MYSQL_NUM--以数字索引返回MYSQL_BOTH--以以上两个方式返回
	 * @param unknown_type $str
	 */
	public function fetch_array($result,$result_type=MYSQL_BOTH)
	{
		return mysql_fetch_array($result,$result_type);
	}

	/**
	 *
	 * 返回从结果集中取出行的对象
	 * @param $result
	 */
	public function fetch_object($sql)
	{
		$query = $this->query($sql);
		return mysql_fetch_object($query);
	}

	/**
	 * 函数从结果集中取得一行，做为数字数组
	 * @param unknown_type $sql
	 * @return multitype:
	 */
	public function fetch_row($sql){
		$query = $this->query($sql);
		return mysql_fetch_row($query);
	}

	/**
	 *关闭数据库连接
	 */
	public function close()
	{
		mysql_close($this->link);
	}

	/**
	 * 返回结果集中一个字段的值，失败返回false
	 * Enter description here ...
	 * @param $query
	 * @param $row
	 */
	function result($query, $row) {
		$value = @mysql_result($query, $row);
		return $value;
	}

	public function insert_id(){
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	/**
	 *
	 * mysql_fetch_assoc--以关联数组的方式返回记录
	 * @param unknown_type $sql
	 */
	public function getAll($sql)
	{
		$query = $this->query($sql);
		if ($query !== false)
		{
			$arr = array();
			while ($row = mysql_fetch_assoc($query))
			{
				$arr[] = $row;
			}
			return $arr;
		}
		else
		{
			return false;
		}
	}
	
    /**
     * 取得数据库的表信息
     * @access public
     * @return array
     */
    public function getTables($dbName='') {
        if(!empty($dbName)) {
           $sql    = 'SHOW TABLES FROM '.$dbName;
        }else{
           $sql    = 'SHOW TABLES ';
        }
        $result =   $this->query($sql);
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }

	/**
	 *
	 * 执行sql语句，返回影响的记录数
	 * @param unknown_type $sql
	 */
	public function execute($sql)
	{		
		$query = $this->query($sql);		
		return $query?$this->insert_id():0;
	}

	/**
	 * 返回一个字段
	 * @param string $sql
	 * @return unknown
	 */
	public function getfield($sql)
	{
		$query=$this->query($sql);
		$field=$this->result($query, 0);
		return $field;
	}

	/**
	 *
	 * 执行数据库事务
	 * @param unknown_type $arr--以数组形式查询数据
	 */
	public function ExecuteSqlTran($arr){
		if (isset($arr) && is_array($arr)){
			$total=count($arr);
			for($i=0;$i<total;$i++){
				if (!$this->execute($arr[$i])){
					$this->execute('ROLLBACK') or exit(mysql_error());
				}
			}
		}
		$this->query('COMMIT') or exit(mysql_error());
		$this->close();
	}

	/**
	 * 执行存储过程
	 */
	public function RunProcedure($proName){
		$this->query("call $proName");
	}

	function halt($message = '', $sql = '') {
		echo 'SQL Error:<br />'.$message.'<br />'.$sql;
	}
}
?>