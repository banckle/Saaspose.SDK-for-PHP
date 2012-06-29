<?php
/*
* Deals with Word document level aspects
*/
class WordDocument
{
        public $FileName = "";
		
		
		public function Document($fileName)
        {
            $this->FileName = $fileName;
        }

		
	/*
    * Appends a list of documents to this one.
	* @param string $appendDocs (List of documents to append)
	* @param string $importFormatModes
	* @param string $sourceFolder (name of the folder where documents are present)
	*/
	public function AppendDocument($appendDocs, $importFormatModes, $sourceFolder) {
       try {
			//check whether files are set or not
			if ($this->FileName == "")
				throw new Exception("Base file not specified");
			//check whether required information is complete
			if (count($appendDocs) != count($importFormatModes))
				throw new Exception("Please specify complete documents and import format modes");
			
			//Build JSON to post
			$json = '{ "DocumentEntries": [';
 
			for ($i = 0; $i < count($appendDocs); $i++) {
				$json .= '{ "Href": "' . $sourceFolder . $appendDocs[$i] . 
					'", "ImportFormatMode": "' . $importFormatModes[$i] . '" }' . 
					(($i < (count($appendDocs) - 1)) ? ',' : '');
			}
			
            $json .= '  ] }';

			//build URI to merge Docs
			$strURI = Product::$BaseProductUri . "/words/" . $this->FileName . "/appendDocument";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "json", $json);

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save merged docs on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($sourceFolder . (($sourceFolder == '') ? '' : '/') . $this->FileName);
				$outputPath = SaasposeApp::$OutPutLocation . $this->FileName;
				Utils::saveFile($outputStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
    }
	
}
?> 
