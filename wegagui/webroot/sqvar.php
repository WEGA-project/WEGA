<?php
include_once "func.php";
include "../config/".$ns.".conf.php";

$p_AirTemp=dbval("AirTemp",$ns);
$p_AirHum=dbval("AirHum",$ns);
$p_RootTemp=dbval("RootTemp",$ns);
$p_RootTemp="if(".$p_RootTemp." != -127 and ".$p_RootTemp." != 85,".$p_RootTemp.",null)";

$p_ECtempRAW=dbval("ECtempRAW",$ns);

$p_pHraw=dbval("pHraw",$ns);
$p_IntTempRaw=dbval("IntTempRaw",$ns);
$p_VddRaw=dbval("VddRaw",$ns);
$p_LightRaw=dbval("LightRaw",$ns);
$p_Dst=dbval("Dst",$ns);

// Блок ЕС
$P_A1=dbval("A1",$ns);
$P_A2=dbval("A2",$ns);

$R1=floatval(dbval("EC_R1",$ns));
$Rx1=floatval(dbval("EC_Rx1",$ns));
$Rx2=floatval(dbval("EC_Rx2",$ns));
$Dr=floatval(dbval("Dr",$ns));

$P_R2p="(-(-(".$P_A1.")*".$R1."-".$P_A1."*".$Rx2."+".$Rx2."*".$Dr.")/(-".$P_A1."+".$Dr."))";
$P_R2n="(((-".$P_A2."*".$R1."-".$P_A2."*".$Rx1."+".$R1."*".$Dr."+".$Rx1."*".$Dr.")/".$P_A2."))";
$P_R2="(".$P_R2p."+".$P_R2n.")/2";
$P_R2_polarity=$P_R2p."-".$P_R2n;

$R2p=round( sensval($P_R2p,$ns), 1);
$R2n=round( sensval($P_R2n,$ns), 1);
$R2=($R2p+$R2n)/2;
$R2_polarity=round( sensval($P_R2_polarity,$ns), 2);

$p_ECtemp="ftr(".$p_ECtempRAW.")";


$p_Lux="fpr(".$p_LightRaw.")";
$p_pH="pH(".$p_pHraw.")";

//$p_EC="EC(".$P_A1.",".$P_A2.",".$p_ECtemp.")";

$p_EC="if ( ".$p_ECtemp." is null, null,EC(".$P_A1.",".$P_A2.",".$p_ECtemp."))";

$p_lev="intpl(levmin(".$p_Dst."))";
$p_Pa="Pa(".$p_AirTemp.",".$p_AirHum.")";

 $namesys=dbval("namesys",$ns);
 $comment=dbcomment("namesys",$ns);
 $LevelFull=dbval("LevelFull",$ns);
 $LevelAdd=dbval("LevelAdd",$ns);
 $Max_Level=$LevelFull-$La;
 $La=dbval("La",$ns);
 $ECPlan=dbval("ECPlan",$ns);
 $sEC=dbval("sEC",$ns);
 $rEC=dbval("rEC",$ns);
 $Slk=($sEC/$rEC);
 $konc=dbval("konc",$ns);

$dt=sensval("dt",$ns);
$A1=sensval($P_A1,$ns);
$A2=sensval($P_A2,$ns);
$AirHum=sensval($p_AirHum,$ns);
$AirTemp=sensval($p_AirTemp,$ns);
$RootTemp=sensval($p_RootTemp,$ns);
$ECtempRAW=sensval($p_ECtempRAW,$ns);
$DstRAW=sensval($p_Dst,$ns);
$tempEC=sensval("ftR(".$ECtempRAW.")",$ns);
 $WaterTemp=$tempEC;
$Lux=sensval("fpR(".dbval("LightRAW",$ns).")",$ns);
$ec=sensval("EC($P_A1,$P_A2,".$tempEC.")",$ns);
$ph=sensval("ph(".dbval("pHraw",$ns).")",$ns);
$lev=sensval("intpl(levmin(".$p_Dst."))",$ns);
//$Pa=sensval("Pa($p_AirTemp,$p_AirHum)",$ns);
$Pa=sensval("$p_Pa",$ns);

$L1=$lev+$LevelAdd;
$L2=$LevelFull-$lev-$La;
$ECn=(-($ec*$L1 - $ECPlan*$L1 - $ECPlan*$L2 )/$L2);
$Soiln=$ECn*$Slk*($L2);
$p_soil="($p_lev+".$L1.")*$p_EC*$Slk";

// Пределы
$Max_OutDate=floatval(dbval("Ev_Max_Dt",$ns));
$OutDate = strtotime("now")-strtotime($dt);
$Max_AirTemp=floatval(dbval("Ev_Max_AirTemp",$ns));
$Min_AirTemp=floatval(dbval("Ev_Min_AirTemp",$ns));
$Max_RootTemp=floatval(dbval("Ev_Max_RootTemp",$ns));
$Min_RootTemp=floatval(dbval("Ev_Min_RootTemp",$ns));
$Max_WaterTemp=floatval(dbval("Ev_Max_WaterTemp",$ns));
$Min_WaterTemp=floatval(dbval("Ev_Min_WaterTemp",$ns));
$Max_AirHum=floatval(dbval("Ev_Max_AirHum",$ns));
$Min_AirHum=floatval(dbval("Ev_Min_AirHum",$ns));
$Min_Level=floatval(dbval("Ev_Min_Level",$ns));
$Crit_Level=floatval(dbval("Ev_Crit_Level",$ns));
$Max_EC=floatval(dbval("Ev_Max_EC",$ns));
$Min_EC=floatval(dbval("Ev_Min_EC",$ns));
$Max_pH=floatval(dbval("Ev_Max_pH",$ns));
$Min_pH=floatval(dbval("Ev_Min_pH",$ns));

$csv="tmp/s.".$ns.".csv";
$gnups="tmp/s.".$ns.".gnuplot";
$img="tmp/s.".$ns.".png";
$gimg=$img;



?>
