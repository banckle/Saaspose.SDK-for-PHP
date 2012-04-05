<?php
/// <summary>
/// converts pages or document into different formats
/// </summary>
class SlideConverter
{
	public $FileName = "";
	public $saveformat = "";
	
	public function SlideConverter($fileName)
	{
		//set default values
		$this->FileName = $fileName;

		$this->saveformat =  "PPT";
	}

	/// <summary>
	/// Saves a particular slide into various formats with specified width and height
	/// </summary>
	/// <param name="outputPath"></param>
	/// <param name="slideNumber"></param>
	/// <param name="imageFormat"></param>
	public function ConvertToImage($slideNumber, $imageFormat)
	{
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slideNumber . "?format=" . $imageFormat;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $this->saveformat);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}  	
	}  

	/// <summary>
	/// Saves a particular slide into various formats with specified width and height
	/// </summary>
	/// <param name="outputPath"></param>
	/// <param name="slideNumber"></param>
	/// <param name="imageFormat"></param>
	/// <param name="width"></param>
	/// <param name="height"></param>
	public function ConvertToImagebySize($slideNumber, $imageFormat, $width, $height)
	{
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slideNumber . "?format=" . $imageFormat . "&width=" . $width . "&height=" . $height;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . "output." . $imageFormat);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}  	
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
				   
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "?format=" . $this->saveformat;
			
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