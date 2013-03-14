<?php
class Html{
	
	public static function beginform(){
		
	}
	
	public static function text($name,$value=''){
		$text='<input type="text" name="'.$name.'" value="'.$value.'">';
		echo $text;
	}
	
	public static function hidden(){
		
	}
	
	public static function textarea($name,$value='',$row='',$col=''){
		$text='<textarea name="'.$name.'" row="'.$row.'" col="'.$col.'">'.$value.'</textarea>';
		echo $text;
	}
	
	public static function checkbox(){
		
	}
	
	public static function radio(){
		
	}
	
	public static function select(){
		
	}
	
	public static function file(){
		
	}
}