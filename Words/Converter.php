<?php
/*
* converts pages or document into different formats
*/   
class WordConverter
{
	public $FileName = "";
	public $saveformat = "";
	
	public function WordConverter($fileName)
	{
		//set default values
		$this->FileName = $fileName;

		$this->saveformat =  "Doc";
	}
	
	    /*
        * convert a document to SaveFormat
		*/
        public function Convert()
        {
            try
            {
                //check whether file is set or not
                if ($this->FileName == "")
                   throw new Exception("No file name specified");

                //build URI
                $strURI = Product::$BaseProductUri . "/words/" . $this->FileName . "?format=" . $this->saveformat;

                //sign URI
                $signedURI = Utils::Sign($strURI);

				$responseStream = Utils::processCommand($signedURI, "GET", "", "");
				
				$v_output = Utils::ValidateOutput($responseStream);
	 
				if ($v_output === "") 
				{
					Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $this->saveformat);
					return "";
				} 
				else 
					return $v_output;
				
            }
            catch (Exception $e)
            {
                throw new Exception($e->getMessage());
            }
        }
}
?> 