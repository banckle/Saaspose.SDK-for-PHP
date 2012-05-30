<?php
/*
* converts pages or document into different formats
*/
class CellsConverter
{
	public $FileName = "";
	public $saveformat = "";
		
	public function CellsConverter($fileName)
	{
		//set default values
		$this->FileName = $fileName;
		$this->saveformat =  "xls";
	}
	
	/*
    * converts a document to saveformat
	*/
	public function Convert(){
		try{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "?format=" . $this->saveformat;
			
			//Sign URI
			$signedURI = Utils::Sign($strURI);

			//Send request and receive response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			//Validate output
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save ouput file
				$outputPath = SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $this->saveformat;
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
    * converts a sheet to image
	* @param string $worksheetName
	* @param string $imageFormat
	*/
	public function ConvertToImage($imageFormat, $worksheetName){
		try{
			//check whether file and sheet is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "/worksheets/" . 
			          $worksheetName . "?format=" . $imageFormat;
			
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
    * converts a document to outputFormat
	* @param string $outputFormat
	*/
	public function Save($outputFormat){
		try{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			
			//Build URI
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "?format=" . $outputFormat;
			
			//Sign URI
			$signedURI = Utils::Sign($strURI);

			//Send request and receive response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			//Validate output
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save ouput file
				$outputPath = SaasposeApp::$OutPutLocation . Utils::getFileName($this->FileName). "." . $outputFormat;
				Utils::saveFile($responseStream, $outputPath);
				return $outputPath;
			} 
			else 
				return $v_output;
		} catch (Exception $e){
			throw new Exception($e->getMessage());
		}  
	}
}
?>