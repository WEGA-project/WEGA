<?php
$ns=$_GET['ns'];


if (empty($_GET['days'])){$_GET['days']="-0 days";}
if (empty($_GET['wsdt'])){$_GET['wsdt']=date("Y-m-d",strtotime($_GET['days']))." 00:00:00";}
if (empty($_GET['wpdt'])){$_GET['wpdt']=date("Y-m-d")." 23:59:59";}
if (empty($_GET['limit'])){$_GET['limit']="100000";}

include "../config/".$ns.".conf.php";
include version.php;
$version="123";
$version=date("d M Y H:i:s", filemtime('../../.git/index'));

$wsdt=$_GET['wsdt'];
$wpdt=$_GET['wpdt'];
$limit=$_GET['limit'];

$stfind="?ns=".$ns."&wsdt=".$wsdt."&wpdt=".$wpdt;


echo '
<!DOCTYPE html>
<html>
  <head>
    <title>WEGA '.$namesys.'</title>    
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href="css/menu.css" rel="stylesheet" media="screen">		
  </head>
  <body>

<nav role="navigation">

		<ul>
			<li>
                        <img src="wega-mini.png" width="34" height="34"></img>
                        <span style="vertical-align: 0.7em">
                         '.strtoupper($namesys).'
                        </span>
                <ul>';
                         foreach (glob("../config/*.conf.php") as $filename) {
    				include $filename;
    				$fl=explode("/", $filename);
    				$nm=explode(".", $fl[2]);
    				$cname=$nm[0];
    				echo "<li><a href=".$_SERVER['PHP_SELF']."?ns=".$cname.">". $namesys ."</a></li>";

			 }

echo '
                </ul>
                        </li>

			<li><a href="#">Анализ</a><ul>
					<li><a href="rep.php'.$stfind.'">Сводный анализ</a></li>
					<li><a href="helperprev.php'.$stfind.'">Помощник</a></li>
					<li><a href="temp.php'.$stfind.'">Температура</a></li>
					<li><a href="ph.php'.$stfind.'">pH</a></li>
					<li><a href="level.php'.$stfind.'">Уровень</a></li>
					<li><a href="owm.php'.$stfind.'">Погода</a></li>
				</ul>

			<li><a href="#">Параметры</a><ul>
					<li><a href="srctbl.php'.$stfind.'">База</a></li>
					<li><a href="conformity.php'.$stfind.'">Сопоставление полей</a></li>
					<li><a href="createlev.php'.$stfind.'">Калибровка уровня</a></li>
					<li><a href="CalibrateEC.php'.$stfind.'">Калибровка EC</a></li>
					<li><a href="subnet-timeout.php">Уведомления</a></li>
				</ul>
			</li>


			<li><a href="owm.php'.$stfind.'">Погода</a><ul>
					<li><a href="#">Настройка</a></li>
				</ul>
			</li>


                        <li><a href="#">О проекте</a><ul>
                                        <li><h6>Версия от: '.$version.'</h6></li>
                                        <li><a href="https://github.com/siv237/wega/commits/master">Обновления GIT</a></li>
                                        <li><a href="https://t.me/WEGA_project">Группа поддержки</a></li>
                                        <li><a href="https://github.com/siv237/WEGA/wiki">WiKI проекта</a></li>
                                </ul>
                        </li>



		</ul>
</nav> 


<br><br>
';


?>

