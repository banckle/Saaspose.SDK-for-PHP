<?php
/*
* converts pages or document into different formats
*/
class CellsExtractor
{
	public $FileName = "";
		
	public function CellsExtractor($fileName)
	{
		//set default values
		$this->FileName = $fileName;
	}

	/*
    * saves a specific picture from a specific sheet as image
	* @param $worksheetName
	* @param $pictureIndex
	* @param $imageFormat
	*/
	public function GetPicture($worksheetName, $pictureIndex, $imageFormat){
		try{
			//check whether file and sheet is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "/worksheets/" . 
			          $worksheetName . "/pictures/" . $pictureIndex . "?format=" . $imageFormat;
			
			//Sign URI
			$signedURI = Utils::Sign($strURI);

			//Send request and receive response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			//Validate output
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save ouput file
				$outputPath = SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). 
				"_" . $worksheetName . "." . $imageFormat;
				Utils::saveFile($responseStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		} catch (Exception $e){
			throw new Exception($e->getMessage());
		}  
	}

	/*
    * saves a specific OleObject from a specific sheet as image
	* @param $worksheetName
	* @param $objectIndex
	* @param $imageFormat
	*/
	public function GetOleObject($worksheetName, $objectIndex, $imageFormat){
		try{
			//check whether file and sheet is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "/worksheets/" . 
			          $worksheetName . "/oleobjects/" . $objectIndex . "?format=" . $imageFormat;
			
			//Sign URI
			$signedURI = Utils::Sign($strURI);

			//Send request and receive response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			//Validate output
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save ouput file
				$outputPath = SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). 
				"_" . $worksheetName . "." . $imageFormat;
				Utils::saveFile($responseStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		} catch (Exception $e){
			throw new Exception($e->getMessage());
		}  
	}	
	
	/*
    * saves a specific chart from a specific sheet as image
	* @param $worksheetName
	* @param $chartIndex
	* @param $imageFormat
	*/
	public function GetChart($worksheetName, $chartIndex, $imageFormat){
		try{
			//check whether file and sheet is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "/worksheets/" . 
			          $worksheetName . "/charts/" . $chartIndex . "?format=" . $imageFormat;
			
			//Sign URI
			$signedURI = Utils::Sign($strURI);

			//Send request and receive response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			//Validate output
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save ouput file
				$outputPath = SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). 
				"_" . $worksheetName . "." . $imageFormat;
				Utils::saveFile($responseStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		} catch (Exception $e){
			throw new Exception($e->getMessage());
		}  
	}
	
	/*
    * saves a specific auto-shape from a specific sheet as image
	* @param $worksheetName
	* @param $shapeIndex
	* @param $imageFormat
	*/
	public function GetAutoShape($worksheetName, $shapeIndex, $imageFormat){
		try{
			//check whether file and sheet is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "/worksheets/" . 
			          $worksheetName . "/autoshapes/" . $shapeIndex . "?format=" . $imageFormat;
			
			//Sign URI
			$signedURI = Utils::Sign($strURI);

			//Send request and receive response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			//Validate output
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save ouput file
				$outputPath = SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). 
				"_" . $worksheetName . "." . $imageFormat;
				Utils::saveFile($responseStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		} catch (Exception $e){
			throw new Exception($e->getMessage());
		}  
	}
}
?>