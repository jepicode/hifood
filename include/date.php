<?php

	date_default_timezone_set("Asia/Bangkok");
	function datedif($start,$end){
		$ddiff = $start->diff(new DateTime($end));
		if($ddiff->i == 0 && $ddiff->h ==0 && $ddiff->d == 0 && $ddiff->m == 0 && $ddiff->y == 0) {
			$time = $ddiff->s." detik yang lalu";
		}
		else if($ddiff->h ==0 && $ddiff->d == 0 && $ddiff->m == 0 && $ddiff->y == 0) {
			$time = $ddiff->i." menit yang lalu";
		}
		else if($ddiff->d == 0 && $ddiff->m == 0 && $ddiff->y == 0) {
			$time = $ddiff->h." jam yang lalu";
		}
		else if($ddiff->m == 0 && $ddiff->y == 0) {
			$time = $ddiff->d." hari yang lalu";
		}
		else if($ddiff->y == 0) {
			$time = $ddiff->m." bulan yang lalu";
		}
		else if($ddiff->y > 0) {
			$time = $ddiff->y." tahun yang lalu";
		}
		echo $time;
	}
?>