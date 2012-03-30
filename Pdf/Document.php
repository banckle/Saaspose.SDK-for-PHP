<?php
//require_once('../Common/Product.php');
//require_once('../Common/Utils.php');

/// <summary>
/// Deals with PDF document level aspects
/// </summary>
class Document
{
        /// <summary>
        /// PDF document name
        /// </summary>
        public $FileName = "";
		
		
		public function Document($fileName)
        {
            $this->FileName = $fileName;
        }

        /// <summary>
        /// Gets the page count of the specified PDF document
        /// </summary>
        /// <returns>page count</returns>
        public function GetPageCount()
        {
			 //build URI
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages";
 
			//sign URI
			$signedURI = Utils::Sign($strURI);
		    //echo $signedURI;
			//get response stream
			$responseStream = Utils::ProcessCommand($signedURI, "GET", "");		
			
			$json = json_decode($responseStream);
			
			/* echo $json->Code;
			echo $json->Status;
			echo count($json->Pages->List);
			var_d ump($json->Pages->List);*/
			 
			 return count($json->Pages->List);  
        }
}
?> 
