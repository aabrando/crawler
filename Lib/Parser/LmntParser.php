<?php
App::uses("Crawler","Lib" .DS. "Curl");

class LmntParser {
	private $domObj;

	function __construct(Object $dom){
		$this->domObj = $dom;  
	}

	public function parseElement($rows){ 
		$results = array();  
		foreach ($rows['Dom'] as $part){   
			foreach ($this->domObj->find($part['dom2find']) as $dom){  //debug($part['output']); debug($dom->outertext);

                if (!empty($part['strneedle']) && $part['strneedle'] !== '(NULL)'  ){ 
                    $needle = trim(html_entity_decode($dom->{$part['output']}));
                    if (strstr($needle,$part['strneedle'])) {
                        $results[$part['Part']['name']][] = $needle;   
                    }
                }
				else $results[$part['Part']['name']][] = trim(html_entity_decode($dom->{$part['output']}));   
			}
		}

		//die(debug($results));
		return $results;
	}

}