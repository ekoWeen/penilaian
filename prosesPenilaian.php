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

	use Phpml\FeatureExtraction\TokenCountVectorizer;
	use Phpml\Tokenization\WhitespaceTokenizer;
	$vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());

	use Phpml\FeatureExtraction\TfIdfTransformer;


	//ambil data dari DB
	//$jawaban = 'Teori graph adalah teori yang digunakan untuk mengukur keefektifan sebuah algoritma, dan mempunyai fungsi menentukan algoritma yang bekerja seefektif mungkin. macam-macam graph ada graph bolak balik, graph satu arah, graph melingkar. Dengan komponen edge merupakan garis yang berarah untuk menghubungkan vertex. Vertex adalah bobot dari graph';

	//$jawaban = 'Teori graph adalah teori yang digunakan untuk mengukur keefektifan sebuah algoritma, dan mempunyai fungsi menentukan algoritma yang bekerja seefektif mungkin. Macam-macam graph adalah graph bolak balik, graph satu arah, graph melingkar. Komponen dari graph adalah vertex dan edge. edge merupakan garis yang berarah untuk menghubungkan vertex. Vertex adalah bobot dari graph, dimana semakin kecil bobotnya maka sebuah algoritma akan dikatakan semakin efektif.';
	
	//$jawaban = 'Graph adalah struktur data yang terdiri dari vertex dan garis yang menghubungkan antar vertex. ada beberapa jenis graph yaitu graph tertutup, graph berarah dan graph tak berarah';

	//$jawaban = 'Graph adalah sebuah struktur data yang terdiri dari komponen node atau vertex dan edges. Node dihubungkan dengan edges.  Verteks yaitu node atau titik yang nantinya akan dihubungkan. Edges, yaitu garis penghubung. loop yaitu edge yang menghubungkan verteks dengan dirinya sendiri. Vertex yaitu data dari graph yang berupa node. Macam-macam graph adalah simple graph yaitu graph graph yang tak berarah yang tak memiliki loop dan hubungan ganda, multi graph adalah graph tak berarah yang tak punya loop, graph berarah adalah graph yang punya arah, graph semu memiliki loop.  Bobot adalah berapa banyak garis yang berhubungan dengan satu vertex.';

	$jawaban = 'teori yang digunakan untuk memudahkan manusia mencari solusi atau jalan pikiran yang tepat dan tepat memberikan solusi yang efektif dan efisien. komponen dari graph vertex, edge dan loop. vertex adalah titik-titik yang berada pada graph. Edge adalah garis yang menghubungkan antar titik';

	echo "jawaban:";
	echo "$jawaban";

	$katakunci = 'vertex verteks edge lintasan path pohon minimum sederhana simple unsimple limited unlimeted directed undirected';

	echo "<br>";
	echo "<br>";


	$kunciJawaban_hi = 'Graph adalah sebuah struktur data yang terdiri dari komponen node atau vertex dan edges. Node dihubungkan dengan edges.  Verteks yaitu node atau titik yang nantinya akan dihubungkan. Edges, yaitu garis penghubung. loop yaitu edge yang menghubungkan verteks dengan dirinya sendiri. Vertex yaitu data dari graph yang berupa node. Macam-macam graph adalah simple graph yaitu graph graph yang tak berarah yang tak memiliki loop dan hubungan ganda, multi graph adalah graph tak berarah yang tak punya loop, graph berarah adalah graph yang punya arah, graph semu memiliki loop.  Bobot adalah berapa banyak garis yang berhubungan dengan satu vertex.';
	echo "kunci jawaban:";
	echo "$kunciJawaban_hi";

	echo "<br>";
	echo "<br>";

	$hapus = $remover->remove($jawaban);
	//echo "$hapus";
	$hapusHI = $remover->remove($kunciJawaban_hi);

	echo "<br>";
	echo "<br>";

	$katadasar = $stemmer->stem($hapus);
	echo "ekstraksi jawaban siswa:";
	echo "$katadasar";
	$dsrHI = $stemmer->stem($hapusHI);

	echo "<br>";
	echo "<br>";
	echo "ekstraksi kunci jawaban:";
	echo "$dsrHI";
	echo "<pre>";
	//print_r($array_ktdsr);

	$gabunganHI = array($katadasar, $dsrHI);

	$vectorizer->fit($gabunganHI);
	$vectorizer->transform($gabunganHI);
	//print_r($gabunganHI);
	//$kosakata = $vectorizer->getVocabulary();
	//print_r($kosakata);

	echo "<br>";
	echo "<br>";

	//tfidf
	$transformer = new TfIdfTransformer($gabunganHI);
	$transformer->transform($gabunganHI);
	//print_r($gabunganHI);

	$tfidf1 = $gabunganHI[0];
	$tfidf2 = $gabunganHI[1];

	echo "<br>";
	echo "<br>";

	require 'CosineSimilarity.php';
	$cs = new CosineSimilarity();
	$result1 = $cs->similarity($tfidf1, $tfidf2);
	
	//var_dump($result1);

	$kc = explode(' ', $katadasar);
	$kcj = explode(' ', $dsrHI);

	$katasama = array_intersect($kc, $kcj);
	//print_r($katasama);
	$ktj = count($katasama);
	$ktkc = count($kc);

	$cocok = $ktj/$ktkc;

	$finalscore = ($result1+$cocok)/2;
	echo "nilai similarity:";
	echo "$finalscore";



?>