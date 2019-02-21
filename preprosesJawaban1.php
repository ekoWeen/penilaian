<?php 
	//membangun koneksi ke db
	session_start();
		include "koneksi.php";

	//menggunakan composer
	require 'vendor/autoload.php';

	//library Sastrawi
	$tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
	$tokenizer = $tokenizerFactory->createDefaultTokenizer();

	$stopWord_Remover = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
	$remover = $stopWord_Remover->createStopWordRemover();

	$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
	$stemmer = $stemmerFactory->createStemmer();

	//library TFIDF
	use Phpml\FeatureExtraction\TokenCountVectorizer;
	use Phpml\Tokenization\WhitespaceTokenizer;
	$vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());

	use Phpml\FeatureExtraction\TfIdfTransformer;

	//ambil data dari DB
	$sql = "SELECT nama, NIM, jawaban1, jawaban2, jawaban3, jawaban4, jawaban5, jawaban6 FROM skripsi WHERE NIM = 44083";
	$result = mysqli_query($koneksi, $sql);

	if ($result->num_rows > 0) {
		while ( $row = $result->fetch_assoc()) {
			$teks = $row["jawaban1"];
			$teks2 = $row["jawaban2"];
			$teks3 = $row["jawaban3"];
			$teks4 = $row["jawaban4"];
			$teks5 = $row["jawaban5"];
			$teks6 = $row["jawaban6"];
		}
	}
	else {
		echo "tidak ada data ditemukan";
	}

	//menghapus kata sambung, kosakata umum
	$hapuskata = $remover->remove($teks);
	$hapuskata2 = $remover->remove($teks2);
	$hapuskata3 = $remover->remove($teks3);
	$hapuskata4 = $remover->remove($teks4);
	$hapuskata5 = $remover->remove($teks5);
	$hapuskata6 = $remover->remove($teks6);


	//membuat semua kata menjadi kata dasar
	$katadasar = $stemmer->stem($hapuskata);
	$katadasar2 = $stemmer->stem($hapuskata2);
	$katadasar3 = $stemmer->stem($hapuskata3);
	$katadasar4 = $stemmer->stem($hapuskata4);
	$katadasar5 = $stemmer->stem($hapuskata5);
	$katadasar6 = $stemmer->stem($hapuskata6);


	echo "<pre>";
	//melakukan tokenisasi
	$token = array($katadasar, $katadasar2, $katadasar3, $katadasar4, $katadasar5, $katadasar6);
	print_r($token);
	
	echo "<br>";
	echo "<br>";

	$vectorizer->fit($token);
	$vectorizer->transform($token);
	//print_r($token);
	$kosakata = $vectorizer->getVocabulary();
	print_r($kosakata);

	echo "<br>";
	echo "<br>";

	//tfidf
	$transformer = new TfIdfTransformer($token);
	$transformer->transform($token);
	//print_r($token);
	//$tokenbaru = array_diff($value, [0]);

	echo "<br>";
	echo "<br>";


	function hapusNol($array)
	{
		$token = $array;
		foreach ($token as $key) {
			# code...
			//print_r($key);
			$tokenbaru[] = array_diff($key, [0]);
			//print_r($tokenbaru);
		}
		return $tokenbaru;
	

	}
	$arrayTFIDF = hapusNol($token);
	//print_r($arrayTFIDF);

	echo "<br>";
	echo "<br>";
/*
	$indexArray = count($arrayTFIDF);
	//print_r($indexArray);

	for ($i=0; $i < $indexArray; $i++) { 
		# code...
		echo "<pre>";
		$indexKey1 = array_keys($arrayTFIDF[$i]);
		//print_r($indexKey1);
		$counter_index_bertingkat = count($indexKey1);
		//print_r($counter_index_bertingkat);
		for ($j=0; $j < $counter_index_bertingkat; $j++) { 
			# code...
			$indexKey2 = $arrayTFIDF[$i][$indexKey1[$j]];
			echo "<br>";
			//print_r($indexKey2);
		}
	}
*/

	function ambil_nilai_arraybertingkat($array)
	{
		$isiArray = $array;
		$indexArray = count($isiArray);

		for ($i=0; $i < $indexArray; $i++) { 
			# code...
			echo "<pre>";
			$indexKey1 = array_keys($isiArray[$i]);
			//print_r($indexKey1);
			$counter_index_bertingkat = count($indexKey1);
			for ($j=0; $j < $counter_index_bertingkat; $j++) { 
				# code...
				$indexKey2[$indexKey1[$j]] = $isiArray[$i][$indexKey1[$j]];
				//echo "<br>";
				//print_r($indexKey2);	
			}
		}
		return $indexKey2;
	}
	
	$nilaiTFIDF = ambil_nilai_arraybertingkat($arrayTFIDF);
	print_r($nilaiTFIDF);

	function kombinasi_array($array1, $array2)
	{
		$content1 = $array1;
		$content2 = $array2;

		$count = count($content1);

		for ($i=0; $i < $count; $i++) { 
			#menggabungkan array
			//$array_baru[] = $content1[$i].','.$content2[$i];
			$array_baru[] = [$content1[$i]];
			array_push($array_baru[$i], $content2[$i]);
		}
		return $array_baru;
	}

	print_r(kombinasi_array($kosakata, $nilaiTFIDF));
?>