<?php
class orders {
	protected $where='',$order='';
	private $pay_ment=array("支付宝"=>"支付宝","银行汇款"=>"银行汇款","线下交易"=>"线下交易");
	function __construct(){
	}

	/**
	 * 添加
	 */
	public function add($m_uid,$order_num,$addr_array){
		$data=array(
				"order_num"=>$order_num,
				"uid"=>$m_uid,
				"pay_ment"=>C::LeftStr(C::get('txt_pay_ment'),10),
				"order_ship"=>C::LeftStr(C::get('txt_order_ship'),20),
				"time1"=>time(),
				"total_money"=>$this->get_money(),
				"user_name"=>$addr_array[0],
				"user_mobile"=>$addr_array[7],
				"user_tel"=>$addr_array[5].'-'.$addr_array[6],
				"province"=>$addr_array[1],
				"city"=>$addr_array[2],
				"county"=>$addr_array[3],
				"user_address"=>$addr_array[4],
				"zip_code"=>C::isint($addr_array[9]),
				"remark"=>C::LeftStr(C::get('txt_remark'),200),
		);
		$order=new model('orders');
		return $order->data($data)->add();
	}

	public function additem($order_num,$order_item){
		foreach ($order_item as $row){
			$data=array(
					'order_num'=>$order_num,
					'product_id'=>C::isint($row["id"]),
					'product_name'=>$row["Prod_name"],
					'product_num'=>$row["product_num"],
					'product_price'=>C::isint($row["prod_price1"]),
					'total_price'=>C::isint($row["total_price"]),
					'photo'=>$row["small_photo"],
					'property'=>$row["property"],
			);
			$oitem=new model('order_item');
			$oitem->data($data)->add();
		}
	}

	/**
	 *批量删除
	 */
	public function delete(){
		$order=new model('orders');
		$idarr=C::get('check_id');
		if (is_array($idarr)){
			$idarr=implode(",", $idarr);
		}
		//删除订单
		$order->where('order_num in ('.$idarr.')')->delete();
		//删除订单详细
		$oitem=new model('order_item');
		$oitem->where('order_num in ('.$idarr.')')->delete();
		
		C::msg('', '/source/redirect.php?msg=操作成功&url='.urlencode($_SERVER['HTTP_REFERER']));
	}

	/**
	 *查找
	 */
	public function getlist($smarty=''){
		$order=new model('orders');
		if (empty($smarty))
			$smarty=new Smarty();
		if (isset($_GET['st'])){
			$st=C::get('st');
			$this->where="order_stauts='$st'";
		}
		$field='id,order_num,uid,pay_ment,order_ship,order_stauts,time1,time2,time3,time4,total_money,user_name,user_mobile,user_tel,user_address,order_freight,remark,zip_code,province,city,county';
		$url='';
		$arr=$order->where($this->where)->order($this->order)->page($smarty, array('id','','',$url))->select($field);
		$data=array(
				'tab'=>'?action=orders&operation=delete',
				'list'=>$arr);
		$smarty->assign($data);
		$smarty->display(DEFAUTL_PATH.'orders_list.htm');
	}


	/**
	 *修改视图
	 */
	public function view($smarty=''){
		if (empty($smarty))
			$smarty=new Smarty();
		$e_id=C::get('id');
		if (!empty($e_id)){			
			$order=new model('orders');
			$field='id,order_num,uid,pay_ment,order_ship,order_stauts,time1,time2,time3,time4,total_money,user_name,user_mobile,user_tel,user_address,order_freight,remark,zip_code,province,city,county';
			$olist=$order->where("order_num='$e_id'")->select($field);
			$smarty->assign($olist[0]);
			$oitem=new model('order_item');			
			$field='id,order_num,product_id,photo,product_name,product_num,product_price,total_price,order_stauts,special_price,property';
			$ilist=$oitem->where("order_num='$e_id'")->select($field);
			$smarty->assign('goods',$ilist);
			$smarty->display(DEFAUTL_PATH.'orders_detail.htm');
		}
	}

	/**
	 *更新某值
	 */
	public function asy(){
		$id=C::get('oid');
		$s=C::get('s');//值
		$oitem=new model('orders');
		$data=array('order_stauts'=>$s);
		$oitem->data($data)->where('id='.$id)->save();
		C::msg('', $_SERVER['HTTP_REFERER']);
	}
	
	public function ajaxup(){
		$arc=new model('order_item');
		$id=$_POST['id'];
		$fd=$_POST['fd'];//字段
		$val=$_POST['val'];//值
		$data=array($fd=>$val);
		$arc->data($data)->where('id='.$id)->save();
	}

	/**
	 * 添加新订单记录ID和数量
	 */
	public function addorder($product_id,$product_num,$property){
		if (empty($_SESSION['order_item'])){
			$_SESSION['order_item']=array();
			$_SESSION['order_item'][$product_id]=array($product_num,$property);
		}else{
			$order=$_SESSION['order_item'];
			foreach ($order as $key=>$value){
				if ($key!=$product_id){//订单中不存在此商品
					$_SESSION['order_item'][$product_id]=array($product_num,$property);
				}
			}
		}
	}

	/**
	 * 删除订单
	 * Enter description here ...
	 */
	public function delete_order($id){
		$id=C::isint($id);
		if (!empty($_SESSION['order_item'])){
			unset($_SESSION['order_item'][$id]);
			return count($_SESSION['order_item']);
		}else {
			return -1;
		}
	}

	/**
	 * 修改数量
	 */
	public function edit_order_num($pid,$num){
		if (!empty($_SESSION['order_item'])){
			foreach($_SESSION['order_item'] as $key=>$value){
				if ($pid==$key){
					$_SESSION['order_item'][$pid][0]=$num;
				}
			}
		}
	}

	/**
	 * 返回总金额
	 */
	public function get_money(){
		$goods=new model('goods');
		$field='pid,title,price1,amount,point,photo,bianma';
		$result=0;
		if (!empty($_SESSION['order_item'])){
			foreach($_SESSION['order_item'] as $key=>$value){
				$item=$goods->where("pid=".$key)->find($field);
				$result=$result+$item[2]*$value[0];
			}
		}
		return $result;
	}

	/**
	 * 订单列表
	 */
	public function orderitem(){
		$goods=new model('goods');
		$result=array();
		$field='pid,title,price1,amount,point,photo,bianma';
		if (!empty($_SESSION['order_item'])){
			foreach($_SESSION['order_item'] as $key=>$value){
				$item=$goods->where('pid='.$key)->find($field);
				$result[]=array(
						"id"=>$key,
						"product_num"=>$value[0],
						"property"=>$value[1],
						"Prod_name"=>$item[1],
						"prod_price1"=>$item[2],
						"small_photo"=>$item[5],
						"total_price"=>number_format(($item[2]*$value[0]),2));
			}
		}
		return $result;
	}
	


}

?>