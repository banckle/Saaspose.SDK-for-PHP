<?php
/*
* This class contains features to work with text
*/
class CellsTextEditor
{
	public $FileName = "";
	
    public function CellsTextEditor($fileName)
    {
        $this->FileName = $fileName;
    }


	/*
    * Finds a speicif text from Excel document or a worksheet 
	*/
	
	public function FindText()
	{
		$parameters = func_get_args();
		
		//set parameter values
		if(count($parameters)==1)
		{
			$text = $parameters[0];
		}
		else if(count($parameters)==2)
		{
			$WorkSheetName = $parameters[0];
			$text = $parameters[1];
		}
		else
		{
			throw new Exception("Invalid number of arguments");
		}
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						((count($parameters)==2)? "/worksheets/" . $WorkSheetName : "") . 
						"/findText?text=" . $text;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "", "");

			$json = json_decode($responseStream);
			
			return $json->TextItems->TextItemList;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets text items from the whole Excel file or a specific worksheet 
	*/
	
	public function GetTextItems()
	{
		$parameters = func_get_args();
		
		//set parameter values
		if(count($parameters)>0)
		{
			$worksheetName = $parameters[0];
		}
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						((isset($parameters[0]))? "/worksheets/" . $worksheetName . "/textItems" : "/textItems");
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->TextItems->TextItemList;  	
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Replaces all instances of old text with new text in the Excel document or a particular worksheet
	* @param string $oldText
	* @param string $newText
	*/
	public function ReplaceText()
	{
		$parameters = func_get_args();
		
		//set parameter values
		if(count($parameters)==2)
		{
			$oldText = $parameters[0];
			$newText = $parameters[1];
		}
		else if(count($parameters)==3)
		{
			$oldText = $parameters[1];
			$newText = $parameters[2];
			$worksheetName = $parameters[0];
		}
		else
			throw new Exception("Invalid number of arguments");
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI to replace text
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						((count($parameters)==3)? "/worksheets/" . $worksheetName : "") . 
						"/replaceText?oldValue=" . $oldText . "&newValue=" . $newText;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "", "");
			
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save doc on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($this->FileName);
				$outputPath = SaasposeApp::$OutPutLocation . $this->FileName;
				Utils::saveFile($outputStream, $outputPath);
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