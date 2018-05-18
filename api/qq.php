<?php
	
	require(dirname(__FILE__) ."/func.php");

	/**
	 * @param  $w 搜索文字	
	 * @param  $p 分页
	 */

	// function lists($w,$p){

	// 	$html = curl_link("https://c.y.qq.com/soso/fcgi-bin/client_search_cp?ct=24&qqmusic_ver=1298&new_json=1&remoteplace=txt.yqq.top&searchid=28732875976556824&t=0&aggr=1&cr=1&catZhida=1&lossless=0&flag_qc=0&p=1&n=10&w=".$_GET['w']."&g_tk=".time()."&jsonpCallback=json&loginUin=0&hostUin=0&format=json&inCharset=utf8&outCharset=utf-8&notice=0&platform=yqq&needNewCode=0");

	// 	if(empty($html['data']['song']['totalnum'])){

	// 		return false;
	// 	}


	// }

function qq($w){
	
	$html = curl_link("https://c.y.qq.com/soso/fcgi-bin/client_search_cp?ct=24&qqmusic_ver=1298&new_json=1&remoteplace=txt.yqq.top&searchid=28732875976556824&t=0&aggr=1&cr=1&catZhida=1&lossless=0&flag_qc=0&p=1&n=10&w=".$w."&g_tk=".time()."&jsonpCallback=json&loginUin=0&hostUin=0&format=json&inCharset=utf8&outCharset=utf-8&notice=0&platform=yqq&needNewCode=0");

	$josn = json_decode($html,true);

	if(empty($josn['data']['song']['list'])){

		die("no");
	}
	
	foreach ($josn['data']['song']['list'] as $v) {
	//	print_r($v);
		$downUrl = muiscUrl("https://y.qq.com/n/yqq/song/".$v['mid'].".html");

		if($downUrl === false){

			//echo '歌曲名：'.$v['name'].' -- 作者：'.$v['singer'][0]['name'].'未获取';
			$array[] = array('name'=>$v['name'],"author"=>$v['singer'][0]['name'],"downurl"=>false);
		}else{

			//echo '歌曲名：'.$v['name'].' -- 作者：'.$v['singer'][0]['name'].'<a href="' .$downUrl. '">下载</a><br />';
			$array[] = array('name'=>$v['name'],"author"=>$v['singer'][0]['name'],"downurl"=>$downUrl);
		}
	}
	return $array;

}

	function muiscUrl($url){

		$html = curl_link($url);

		preg_match('/"songmid":"(.*?)",/is', $html ,$song);

		if(empty($song[1])){ return false; }

		$songmid = 'C400' . $song[1] . '.m4a';

		$t = get_millisecond();//获取时间毫秒值

		$guid = round((mt_rand()/mt_getrandmax())*2147483647) * $t % 10000000000;

	    $url = "https://c.y.qq.com/base/fcgi-bin/fcg_music_express_mobile3.fcg?g_tk=580106347&jsonpCallback=MusicJsonCallback8674357943813937&loginUin=0&hostUin=0&format=json&inCharset=utf8&outCharset=utf-8&notice=0&platform=yqq&needNewCode=0&cid=205361747&callback=MusicJsonCallback8674357943813937&uin=0&songmid=".$song[1]."&filename=".$songmid."&guid=".$guid;

	    $json = curl_link($url);

	    preg_match('/"vkey":"(.*?)"\}\]/is', $json, $vkey);

	    if(empty($vkey[1])){ return false; }

		$musicurl = "http://dl.stream.qqmusic.qq.com/".$songmid."?vkey=".$vkey[1]."&guid=".$guid."&uin=0&fromtag=66";

		//echo "<a href='{$musicurl}'>下载</a>";
		return $musicurl;
	}

