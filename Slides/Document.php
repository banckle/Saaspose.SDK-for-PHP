<?php
/*
* Deals with PowerPoint document level aspects
*/
class SlideDocument
{
	public $FileName = "";
	
	public function SlideDocument($fileName)
	{
		//set default values
		$this->FileName = $fileName;
	}

	/*
    * Finds the slide count of the specified PowerPoint document
	*/
	 
	public function GetSlideCount()
	{
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI to get a list of slides
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			$json = json_decode($responseStream);
	
			return count($json->Slides->SlideList);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}  	
	}  
	
	/*
    * Replaces all instances of old text with new text in a presentation or a particular slide
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
			$oldText = $parameters[0];
			$newText = $parameters[1];
			$slideNumber = $parameters[2];
		}
		else
			throw new Exception("Invalid number of arguments");
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI to replace text
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . ((isset($parameters[2]))? "/slides/" . $slideNumber: "") .
						"/replaceText?oldValue=" . $oldText . "&newValue=" . $newText . "&ignoreCase=true";
			 
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

	/*
    * Gets all the text items in a slide or presentation
	*/ 
	public function GetAllTextItems()
	{
		$parameters = func_get_args();
		
		//set parameter values
		if(count($parameters)>0)
		{
			$slideNumber = $parameters[0];
			$withEmpty = $parameters[1];
		}
		
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI to get all text items
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . 
						((isset($parameters[0]))? "/slides/" . $slideNumber . "/textItems?withEmpty=" . $withEmpty: "/textItems");
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			$json = json_decode($responseStream);
	
			return $json->TextItems->Items;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}  	
	}
	
	/*
    * Deletes all slides from a presentation
	*/
	public function DeleteAllSlides()
	{
		try
		{  
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI to replace text
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "DELETE", "", "");
			
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