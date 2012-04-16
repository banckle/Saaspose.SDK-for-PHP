<?php
/*
* Deals with PDF document level aspects
*/
class Document
{
        public $FileName = "";
		
		
		public function Document($fileName)
        {
            $this->FileName = $fileName;
        }

		/*
		* Gets the page count of the specified PDF document
		*/
        public function GetPageCount()
        {
			 //build URI
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages";
 
			//sign URI
			$signedURI = Utils::Sign($strURI);
 
			//get response stream
			$responseStream = Utils::ProcessCommand($signedURI, "GET", "");		
			
			$json = json_decode($responseStream);
			 
			 return count($json->Pages->List);  
        }
}
?> 
