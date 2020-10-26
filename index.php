<?php
require('./vendor/autoload.php');


$jenkins = new \src\Jenkins("xxxx", "xxxx", "xxxx");

print_r($jenkins->getBuildList('SGC4')->find(17)->promotion('Teste'));

?>