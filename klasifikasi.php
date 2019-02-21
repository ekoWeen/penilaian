<?php 
	require 'vendor/autoload.php';

	use Phpml\Classification\NaiveBayes;

	$samples = [[5, 1, 1], [1, 5, 1], [1, 1, 5]];
	$labels = ['a', 'b', 'c'];
	print_r($samples);
	echo "<br>";

	$classifier = new NaiveBayes();
	$classifier->train($samples, $labels);

	print_r($classifier->predict([[3, 1, 1], [1, 4, 1]]));

	echo "<br>";
	echo "<br>";

	$contoh = [['hitam', 'kaki empat', 'kecil'], ['putih', 'kaki empat', 'besar'], ['kecil', 'kaki dua', 'merah']];
	//print_r($contoh);
	$label = ['kucing', 'sapi', 'ayam'];

	$classifier = new NaiveBayes();
	$classifier->train($contoh, $label);


	print_r($classifier->predict(['putih', 'kaki dua', 'kecil']));


?>