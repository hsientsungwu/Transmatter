<?php

$string = "武志 qqwe qwer asdf";

echo preg_replace('/\P{Han}+/', '', $string);


var_dump($string);