<?php
function p($array)
{
	dump($array, true, 'pre', 0);
}

//导入EXCEL用
function GetInt4d($data, $pos) {
	$value = ord ( $data [$pos] ) | (ord ( $data [$pos + 1] ) << 8) | (ord ( $data [$pos + 2] ) << 16) | (ord ( $data [$pos + 3] ) << 24);
	if ($value >= 4294967294) {
		$value = - 2;
	}
	return $value;
}
?>