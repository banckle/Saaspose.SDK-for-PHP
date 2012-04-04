<?php
/// <summary>
/// converts pages or document into different formats
/// </summary>
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
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "?format=" . $this->saveformat;
			
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			$string = (string)$responseStream;
			$pos = strpos($string, "Unable to read beyond the end of the stream");
			$pos2 = strpos($string, "Index was out of range");
			$pos3 = strpos($string, "Unknown file format.");
			$pos4 = strpos($string, "Cannot read that as a ZipFile");
			
			if ($pos === false && $pos2 == false && $pos3 == false && $pos4 == false) 
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