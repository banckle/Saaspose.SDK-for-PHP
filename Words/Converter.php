<?php
/// <summary>
/// Class to convert file to different formats
/// </summary>     
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
	
	    /// <summary>
        /// convert a document to SaveFormat
        /// </summary>
        /// <param name="output">the location of the output file</param>
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
				
				$string = (string)$responseStream;
				$pos = strpos($string, "Unknown file format.");
				
				if ($pos === false) 
				{
					Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $this->saveformat);
					return "";
				} 
				else 
					return "Unknown file format.";
				
            }
            catch (Exception $e)
            {
                throw new Exception($e->getMessage());
            }
        }
}
?> 