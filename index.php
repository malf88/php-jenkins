<?php
require('./vendor/autoload.php');


$jenkins = new \src\Jenkins("URL", "USER", "TOKEN");

print '<pre>';
$jenkins->getLastBuild('JOB')->promotion('PROMOTION');

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'http://db01.malf88.xyz:8080/job/SGC4/20/promotion/forcePromotion?name=Teste');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
// curl_setopt($ch,CURLOPT_USERPWD,"marco:1194faa1db5d326d1ed13ad0187b3fc088");
// curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
// curl_setopt($ch, CURLINFO_HEADER_OUT, true);
// curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
// curl_exec($ch);
// $info = curl_getinfo($ch);
// print_r($info);
// curl_close($ch);
?>