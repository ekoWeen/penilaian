<?php
	
/*
	$ex = array();
	$string = array("tembok");
	$int = array(7);


	echo "<br>";
	echo "<br>";



	$asd = "tembok";
	$azx = 44;
	$temp = $asd.','.$azx;
	print_r($temp);

	array_push($ex, $string[0], $int[0]);
	print_r($ex);
*/

	echo "<br>";
	echo "<br>";

	$a1=array("a", "b", "c","d");
	$a2=array("Cat","Dog","Horse","Cow");
	
	$temp1 = $a1[0];
	$temp2 = $a2[0];
	$combine = array($temp1.','.$temp2);
	//print_r($combine);

	echo "<br>";
	echo "<br>";

	$count = count($a1);
	//print_r($count);

	echo "<br>";
	echo "<br>";

	for ($i=0; $i < $count; $i++) { 
		# code...
		$simpan_array = array();
		$array_depan = $a1[$i];
		$array_belakang= $a2[$i];
		$kombinasi = $array_depan.','.$array_belakang;
		//array_push($simpan_array, $kombinasi);
		//print_r($simpan_array);
		$simpan_array[$i] = $kombinasi;
	}

	function kombinasi_array($array1, $array2)
	{
		$content1 = $array1;
		$content2 = $array2;

		$count = count($content1);

		for ($i=0; $i < $count; $i++) { 
			#menggabungkan array
			$array_baru[] = $content1[$i].','.$content2[$i];
		}
		return $array_baru;
	}

	print_r(kombinasi_array($a1, $a2));
?>