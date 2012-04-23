<?php
/*
* Extract various types of information from the document
*/
class PDFExtractor
{
	public $FileName = "";
	
    public function PDFExtractor($fileName)
    {
        $this->FileName = $fileName;
    }


	/*
    * Gets number of images in a specified page
	* @param $pageNumber
	*/
	
	public function GetImageCount($pageNumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/images";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return count($json->Images->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Get the particular image from the specified page with the default image size
	* @param int $pageNumber
	* @param int $imageIndex
	* @param string $imageFormat
	*/

    public function GetImageDefaultSize($pageNumber, $imageIndex, $imageFormat)
    {
       try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/images/" . $imageIndex . "?format=" . $imageFormat;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
		
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "_" . $imageIndex . "." . $imageFormat);
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
    * Get the particular image from the specified page with the default image size
	* @param int $pageNumber
	* @param int $imageIndex
	* @param string $imageFormat
	* @param int $imageWidth
	* @param int $imageHeight
	*/

    public function GetImageCustomSize($pageNumber, $imageIndex, $imageFormat, $imageWidth, $imageHeight)
    {
       try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/images/" . $imageIndex . "?format=" . $imageFormat . "&width=" . $imageWidth . "&height=" . $imageHeight;
			 
			$signedURI = Utils::Sign($strURI);
 
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
		
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "_" . $imageIndex . "." . $imageFormat);
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