<?php

    require(dirname(__FILE__) ."/func.php");

	function KuWo($w){
        $list = curl_link("http://search.kuwo.cn/r.s?all=".$w."&ft=music&itemset=web_2013&client=kt&pn=0&rn=10&rformat=json&encoding=utf8");

        $lists = json_decode(str_replace("'", '"', $list),true);

        err($lists['abslist'],"列表未找到");
//print_r($lists['data']);
        foreach ($lists['abslist'] as $k => $v) {

                $hash = curl_link("http://antiserver.kuwo.cn/anti.s?type=convert_url&rid=".$v['MUSICRID']."&format=aac&response=url");

                //$hash = json_decode($hashs,true);
//print_r($hash);
                if(empty($hash)){

                        //echo $v['SongName'] . ' ---- 下载链接未找到 <br />';
                    $array[] = array('name'=>$v['SONGNAME'],"picurl"=>'../image/defind.png',"author"=>$v['ARTIST'],"downurl"=>false);

                }else{

                    $array[] = array('name'=>$v['SONGNAME'],"picurl"=>'../image/defind.png',"author"=>$v['ARTIST'],"downurl"=>$hash);

                }

        }
        return $array;

}

