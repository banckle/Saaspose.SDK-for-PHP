<?php
 
/*
* Extract various types of information from the document
*/
class SlideExtractor
{
	public $FileName = "";
	
    public function SlideExtractor($fileName)
    {
        $this->FileName = $fileName;
    }


	/*
    * Gets total number of images in a presentation
	* @param $pageNumber
	*/
	
	public function GetImageCount()
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/images";
			 
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
    * Gets number of images in the specified slide
	* @param $slidenumber
	*/
	
	public function GetSlideImageCount($slidenumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slidenumber . "/images";
			 
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
    * Gets all shapes from the specified slide
	* @param $slidenumber
	*/
	
	public function GetShapes($slidenumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slidenumber . "/shapes";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			$shapes = array();
			 
			foreach ($json->ShapeList->Links as $shape) {
				 
				$signedURI = Utils::Sign($shape->Uri->Href);
				
				$responseStream = Utils::processCommand($signedURI, "GET", "", "");
				
				$json = json_decode($responseStream);
				
				$shapes[] = $json;
			}
 
			return $shapes;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
}
?>