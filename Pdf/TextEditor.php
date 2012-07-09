<?php
/*
* This class contains features to work with text
*/
class TextEditor
{
	public $FileName = "";
	
    public function TextEditor($fileName)
    {
        $this->FileName = $fileName;
    }


	/*
    * Gets raw text from the whole PDF file or a specific page 
	*/
	
	public function GetText()
	{
		$parameters = func_get_args();
		
		//set parameter values
		if(count($parameters)>0)
		{
			$pageNumber = $parameters[0];
		}
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . 
						((isset($parameters[0]))? "/pages/" . $pageNumber . "/TextItems" : "/TextItems");
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			$rawText = "";
			foreach ($json->TextItems->List as $textItem) { 
				$rawText .= $textItem->Text;
			}
			return $rawText;  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets text items from the whole PDF file or a specific page 
	*/
	
	public function GetTextItems()
	{
		$parameters = func_get_args();
		
		//set parameter values
		if(count($parameters)>0)
		{
			$pageNumber = $parameters[0];
		}
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . 
						((isset($parameters[0]))? "/pages/" . $pageNumber . "/TextItems" : "/TextItems");
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->TextItems->List;  	
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets count of the fragments from a particular page
	* $pageNumber
	*/
	
	public function GetFragmentCount($pageNumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/fragments";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return count($json->TextItems->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets TextFormat of a particular Fragment
	* $pageNumber
	* $fragmentNumber
	*/
	
	public function GetTextFormat($pageNumber, $fragmentNumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . 
						"/fragments/" . $fragmentNumber . "/textformat";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->TextFormat;  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Replaces all instances of old text with new text in a PDF file or a particular page
	* @param string $oldText
	* @param string $newText
	*/
	public function ReplaceText()
	{
		$parameters = func_get_args();
		
		//set parameter values
		if(count($parameters)==3)
		{
			$oldText = $parameters[0];
			$newText = $parameters[1];
			$isRegularExpression = $parameters[2];
		}
		else if(count($parameters)==4)
		{
			$oldText = $parameters[0];
			$newText = $parameters[1];
			$isRegularExpression = $parameters[2];
			$pageNumber = $parameters[3];
		}
		else
			throw new Exception("Invalid number of arguments");
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build JSON to post
			$fieldsArray = array('OldValue'=>$oldText, 'NewValue'=>$newText, 'Regex'=>$isRegularExpression);
			$json = json_encode($fieldsArray);
			
			//Build URI to replace text
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . ((isset($parameters[3]))? "/pages/" . $pageNumber: "") .
						"/replaceText";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "json", $json);
			
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