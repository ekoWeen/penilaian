<?php

namespace Sastrawi\StopWordRemover2;

use Sastrawi\Dictionary\ArrayDictionary;

class StopWordRemoverFactory2
{
    public function createStopWordRemover2()
    {
        $stopWords = $this->getStopWords2();

        $dictionary = new ArrayDictionary($stopWords);
        $stopWordRemover = new StopWordRemover2($dictionary);

        return $stopWordRemover;
    }

    public function getStopWords2()
    {
        return array(
            'guna', 'buah', 'tentu', 'punya', 'mungkin', 'makin',
        );
    }
}
