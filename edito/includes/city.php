<?php
	include '../init.php';
	include MODEL_PATH.'Common_districtModel.php';
	include MODEL_PATH.'Yellowyages_classifyModel.php';
	$area=new Common_districtModel();
	$yellow_classify=new Yellowyages_classifyModel();
	if (isset($_GET['type'])){
		$type=$_GET['type'];
		switch ($type){
			case "province":
				$prov="";
				$prov.="<option value=\"\">请选择省...</option>";
				$prov_arr=$area->select("upid=0","id asc",0);
				foreach ($prov_arr as $row){
					$prov.="<option value=\"".$row['id']."\">".$row['name']."</option>";
				}
				echo $prov;
				exit(0);
				break;
			case "city":
				$city="";
				if (isset($_GET['id']) && !empty($_GET['id'])){
					$id=Common::isint($_GET['id']);
					$city.="<option value=\"\">请选择市...</option>";
					$city_arr=$area->select("upid=".$id,"id asc",0);
					foreach ($city_arr as $row){
						$city.="<option value=\"".$row['id']."\">".$row['name']."</option>";
					}
					echo $city;
					exit(0);
				}
				break;
			case "county":
				$county="";
				if (isset($_GET['id']) && !empty($_GET['id'])){
					$id=Common::isint($_GET['id']);
					$county.="<option value=\"\">请选择区/县...</option>";
					$county_arr=$area->select("upid=".$id,"id asc",0);
					foreach ($county_arr as $row){
						$county.="<option value=\"".$row['id']."\">".$row['name']."</option>";
					}
					echo $county;
					exit(0);
				}
				break;
		}
	}
	
	if (isset($_GET['act'])){
		$act=$_GET['act'];
		$result="";
		if (isset($_GET['id'])){
			$id=Common::isint($_GET['id']);
			$result.="<option value=\"\">请选择分类...</option>";
			$result_arr=$yellow_classify->select("level_id=".$id,"sort asc,id asc",0);
			foreach ($result_arr as $row){
				$result.="<option value=\"".$row['id']."\">".$row['yellow_title']."</option>";
			}
			echo $result;
			exit(0);
		}
	}