<?php
$s=$argv[1];
$l=strlen($s);
$e=$l%2?0:1;
echo substr($s,floor($l/2)-$e,$e+1);
