<?php
header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With");
	$typesJson = require(dirname(__FILE__)."/config.php");

	$w = $_GET['w'];$type = $_GET['types'];
	
	if($w == "" || $type == ""){
	        
		return false;
	}

	$www = $typesJson['types'][$type];

	switch ($www['id']) {
		case '1':
			
			require(dirname(__FILE__)."/163.php");

			$music = new MusicAPI();

			$ids = $music->search($w);

			$id = json_decode($ids,true);
//print_r($ids);
			foreach ($id['result']['songs'] as  $v) {

			    $jsons = $music->url($v['id']);

			    $json = json_decode($jsons,true);//print_r($json);

			    //echo '歌曲名：'.$v['name'].' 作者：'.$v['ar'][0]['name'].'<a href="' . $json['data'][0]['url'] . '">下载</a> <br />';

			    $array[] = array('name'=>$v['name'],'picurl'=>$v['al']['picUrl'],"author"=>$v['ar'][0]['name'],"downurl"=>$json['data'][0]['url']);
			}
			echo json_encode($array);	
			break;
		case "2":

			require(dirname(__FILE__) ."/qq.php");

			$array = qq($w);

			echo json_encode($array);
			
			break;

		case "3":

			require(dirname(__FILE__) ."/kugou.php");

			$array = KuGou($w);

			echo json_encode($array);
			
			break;	
		case "4":
			require(dirname(__FILE__) . "/kuwo.php");
			
			$array = KuWo($w);
			
			echo json_encode($array);
			
			break;
		default:
			# code...
			break;
	}
