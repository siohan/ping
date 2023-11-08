<?php
$eq = 'PLOEMEUR 56 TT (14)';
$n_eq = str_replace ('(', '', $eq);
$n_eq = str_replace (')', '', $n_eq);
echo $n_eq.'<br />';
//$nn_eq = preg_replace('#[A-Z]#','',$n_eq);

$nnn_eq = preg_match('#[0-9]{1,2}$#',$n_eq, $matches);
print_r($matches);
