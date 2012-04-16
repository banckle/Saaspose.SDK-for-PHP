<?php
/*
* converts pages or document into different formats
*/
class PDFConverter
{
	public $FileName = "";
	
    public function PDFConverter($fileName)
    {
        $this->FileName = $fileName;
    }

	/*
    * convert a particular page to image with specified size
	* @param string $pageNumber
	* @param string $imageFormat
	* @param string $width
	* @param string $height
	*/
	
    public function ConvertToImagebySize($pageNumber, $imageFormat, $width, $height)
    {
       try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "?format=" . $imageFormat . "&width=" . $width . "&height=" . $height;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
		
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "_" . $pageNumber . "." . $imageFormat);
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

	/*
    * convert a particular page to image with default size
	* @param string $pageNumber
	* @param string $imageFormat
	*/
	public function ConvertToImage($pageNumber, $imageFormat)
	{ 
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "?format=" . $imageFormat;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "_" . $pageNumber . "." . $imageFormat);
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
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "?format=" . $this->saveformat;
			
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