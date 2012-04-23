<?php
/*
* Extract various types of information from the document
*/
class WordExtractor
{
	public $FileName = "";
	
    public function WordExtractor($fileName)
    {
        $this->FileName = $fileName;
    }


	/*
    * Gets Text items list from document
	*/
	
	public function GetText()
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/words/" . $this->FileName . "/textItems";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->TextItems->List;
			//echo $json->TextItems->List[0]->Text;
			//return count($json->Images->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Get the OLE drawing object from document
	* @param int $index
	* @param string $OLEFormat
	*/

    public function GetoleData($index, $OLEFormat)
    {
       try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/words/" . $this->FileName . "/drawingObjects/" . $index . "/oleData";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
		
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "_" . $index . "." . $OLEFormat);
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
    * Get the Image drawing object from document
	* @param int $index
	* @param string $renderformat
	*/

    public function GetimageData($index, $renderformat)
    {
       try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/words/" . $this->FileName . "/drawingObjects/" . $index . "/ImageData";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
		
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "_" . $index . "." . $renderformat);
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
    * Convert drawing object to image
	* @param int $index
	* @param string $renderformat
	*/

    public function ConvertDrawingObject($index, $renderformat)
    {
       try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/words/" . $this->FileName . "/drawingObjects/" . $index . "?format=" . $renderformat;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
		
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "_" . $index . "." . $renderformat);
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