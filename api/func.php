<?php

	//获取时间毫秒值
	function get_millisecond(){

        list($usec, $sec) = explode(" ", microtime());  
        $msec=round($usec*1000);  
        return $msec;  
               
    } 

    function err($str,$mess){

    	if(empty($str)){

    		die($mess);
    	}
    }

	function curl_link($url){

        $HTTP_Server=$url;

        $ch = curl_init();

        curl_setopt ($ch,CURLOPT_URL,$HTTP_Server);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");

        $res = curl_exec($ch);

        curl_close ($ch);

        return $res;
    }


