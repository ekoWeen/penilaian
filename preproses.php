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
	$sql = "SELECT nama, NIM, jawaban1, jawaban2, jawaban3, jawaban4, jawaban5, jawaban6 FROM skripsi WHERE NIM = 44072";
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

	foreach ($token as $key) {
		# code...
		//print_r($key);
		$tokenbaru = array_diff($key, [0]);
		//print_r($tokenbaru);
	}

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
	print_r(hapusNol($token));
?>