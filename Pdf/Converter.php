<?php
/// <summary>
/// converts pages or document into different formats
/// </summary>
class PDFConverter
{
	public $FileName = "";
	
    public function PDFConverter($fileName)
    {
        $this->FileName = $fileName;
    }

    /// <summary>
    /// convert a particular page to image
    /// </summary>
    /// <param name="outputPath"></param>
    /// <param name="pageNumber"></param>
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
			
			Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $imageFormat);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
    } 

	/// <summary>
	/// convert a particular page to image with default size
	/// </summary>
	/// <param name="outputPath"></param>
	/// <param name="pageNumber"></param>
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

			Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $imageFormat);
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
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "?format=" . $this->saveformat;
			
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $this->saveformat);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}  
	}	
}
?>