<?php

	function generateCode($length){
		$chars = 'vwyzABC01256';
		$code = '';
		$clean = strlen($chars) - 1;
		while(strlen($code) < $length){
			$code .= $chars[mt_rand(0, $clean)];
		}
		return $code;
	}
?>