<?php

    require(dirname(__FILE__) ."/func.php");

	function KuGou($w){
        $list = curl_link("http://songsearch.kugou.com/song_search_v2?keyword=".$w."&page=1&pagesize=10&userid=-1&clientver=&platform=WebFilter&tag=em&filter=2&iscorrection=1&privilege_filter=0&_=1489023388641");

        $lists = json_decode($list,true);//var_dump( $lists);

        err($lists['data']['lists'],"列表未找到");
//print_r($lists['data']);
        foreach ($lists['data']['lists'] as $k => $v) {

                $hashs = curl_link("http://www.kugou.com/yy/index.php?r=play/getdata&hash=".$v['FileHash']);

                $hash = json_decode($hashs,true);
//print_r($hash);
                if(empty($hash['data']['play_url'])){

                        //echo $v['SongName'] . ' ---- 下载链接未找到 <br />';
                    $array[] = array('name'=>strip_tags($v['SongName']),"picurl"=>$hash['data']['img'],"author"=>$hash['data']['author_name'],"downurl"=>false);

                }else{

                    $array[] = array('name'=>strip_tags($v['SongName']),"picurl"=>$hash['data']['img'],"author"=>$hash['data']['author_name'],"downurl"=>$hash['data']['play_url']);

                }

        }
        return $array;

}
