<?php

$code = $_GET['code'];$uinfo = $_GET['userInfo'];

if(empty($code) || empty($uinfo)){

        return false;
}

$host = '';$dbname = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname","root","");

$pdo->query("set names utf8");

$json = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=&secret=&js_code=".$_GET['code']."&grant_type=authorization_code");

$userInfo = json_decode($json,true);

if(empty($userInfo['openid'])){

        return false;
}

$user = $pdo->query("select id from user where openid='{$userInfo['openid']}'");

$id = $user->fetchColumn();

if(empty($id)){

	$exec = $pdo->prepare("insert into user(`openid`,`userinfo`) values(?,?)");

	$exec->execute(array($userInfo['openid'],$uinfo));
}

echo json_encode(array_merge($userInfo,json_decode($uinfo,true)));
