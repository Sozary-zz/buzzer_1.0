<?php
/*
 * Controler
 */

class mainController
{
	public static function welcome($request,$context)
	{
		return context::SUCCESS;
	}
	public static function create($request,$context){
		return context::SUCCESS;
	}
	public static function joinPool($request,$context){
		return context::SUCCESS;
	}
	public static function about($request,$context){
		return context::SUCCESS;
	}
	public static function releaseAccess($request,$context){
		if(isset($request["name"],$request["time"])){
			mkdir($request["name"]);
			file_put_contents($request["name"].'/'.$request["name"].'.teacher', time() + 60 * intval($request["time"]));
			echo "0x1";
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}
	public static function gatherData($request,$context){
		if(isset($request["name"])){
			shell_exec('php gather.php '.$request["name"]);
			$data = explode(" ",file_get_contents($request["name"].'/'.$request["name"].'.res'));
			array_shift($data);
			echo json_encode($data);
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}

	public static function teacherReleased($request,$context){
		if(isset($request["name"])){
			if(file_exists($request["name"].'/'.$request["name"].'.teacher')){

				echo "0x1";
				return context::NONE;
			}
		}
		echo "0x0";
		return context::NONE;
	}
	public static function resetSession($request,$context){
		if(isset($request['name'])){
			shell_exec('rm -rf '.$request["name"].'/');
			echo "0x1";
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}
	public static function timeLeft($request,$context){
		if(isset($request["name"])){
			if(file_exists($request["name"].'/'.$request["name"].'.teacher')){
				$t  = intval(file_get_contents($request["name"].'/'.$request["name"].'.teacher'));
				echo $t-time();
				return context::NONE;
			}
		}
		echo "0x0";
		return context::NONE;
	}
	public static function isReleasedAccess($request,$context){
		if(isset($request["name"],$request["player"])){
			if(file_exists($request["name"].'/'.$request["player"].'.buzz'))
			{
				echo "0x2";
				return context::NONE;
			}
			if(file_exists($request["name"].'/'.$request["name"].'.teacher')){
				if(file_get_contents($request["name"].'/'.$request["name"].'.teacher')>microtime(true)){
					echo "0x1";
					return context::NONE;
				}else{
					echo "0x3";
					return context::NONE;
				}
			}
		}
		echo "0x0";
		return context::NONE;
	}
	public static function buzz($request,$context){
		if(isset($request["player"],$request["user"])){
			if(!file_exists($request["user"].'/'.$request["player"].'-'.$request["user"].'.buzz')){
				file_put_contents($request["user"].'/'.$request["player"].'-'.$request["user"].'.buzz',microtime(true));
				file_put_contents($request["user"].'/'.$request["player"].'.buzz',"");
				echo "0x1";

				return context::NONE;
			}
		}
		echo "0x0";
		return context::NONE;
	}
	public static function createProfile($request,$context){

			$handle = fopen("data.dat", "r");
			$contents = fread($handle, filesize("data.dat"));
			$contents = json_decode($contents);
			fclose($handle);

			if(count($contents) == 0)
				$contents = array();
			else
				foreach ($contents as &$value)
				   if($value[0] == $request["name"]){
						 echo "0x1";
						 return context::NONE;
					 }
			array_push($contents,array($request["name"],$request["pass"],false));
			$handle = fopen('data.dat', 'w');

			fwrite($handle, json_encode($contents));
			fclose($handle);
			echo "0x0";


		return context::NONE;
	}
	public static function connecProfile($request,$context){

			$handle = fopen("data.dat", "r");
			$contents = fread($handle, filesize("data.dat"));
			$contents = json_decode($contents);
			fclose($handle);

			if(count($contents) == 0)
				$contents = array();
			else
				foreach ($contents as &$value)
				   if($value[0] == $request["name"]){
						 if($value[1] == $request["pass"]){
							 echo "0x1";
							 return context::NONE;
						 }
					 }
	 	echo "0x0";
		return context::NONE;
	}
	public static function accessBuzz($request,$context){
		if(isset($request["user"])){
			$handle = fopen("data.dat", "r");
			$contents = fread($handle, filesize("data.dat"));
			$contents = json_decode($contents);
			fclose($handle);
			if(count($contents) != 0)
				foreach ($contents as &$value)
					 if($value[0] == $request["user"]){
						 echo json_encode($value);
						 return context::NONE;
					 }
		}
		echo "0x1";
		return context::NONE;
	}
}
