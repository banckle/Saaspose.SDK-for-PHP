<?php
/*
* converts pages or document into different formats
*/
class CellConverter
{
	public $FileName = "";
	public $saveformat = "";
	
	public function CellConverter($fileName)
	{
		//set default values
		$this->FileName = $fileName;

		$this->saveformat =  "XLS";
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
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "?format=" . $this->saveformat;
			
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