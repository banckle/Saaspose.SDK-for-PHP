<?php
/*
* Deals with Word document builder aspects
*/
class WordMailMerge
{
       
	/*
    * Executes mail merge without regions.
	* @param string $fileName 
	* @param string $strXML
	*/
	public function ExecuteMailMerege($fileName, $strXML) {
       try {
			//check whether files are set or not
			if ($fileName == "")
				throw new Exception("File not specified");
			
			//build URI to execute mail merge without regions
			$strURI = Product::$BaseProductUri . "/words/" . $fileName . "/executeMailMerge";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "", $strXML);

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save docs on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($fileName);
				$outputPath = SaasposeApp::$OutPutLocation . $fileName;
				Utils::saveFile($outputStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
    }
	
	/*
    * Executes mail merge with regions.
	* @param string $fileName 
	* @param string $strXML
	*/
	public function ExecuteMailMerege($fileName, $strXML) {
       try {
			//check whether files are set or not
			if ($fileName == "")
				throw new Exception("File not specified");
			
			//build URI to execute mail merge with regions
			$strURI = Product::$BaseProductUri . "/words/" . $fileName . "/executeMailMerge?withRegions=true";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "", $strXML);

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save docs on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($fileName);
				$outputPath = SaasposeApp::$OutPutLocation . $fileName;
				Utils::saveFile($outputStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
    }
	
	/*
    * Executes mail merge template.
	* @param string $fileName 
	* @param string $strXML
	*/
	public function ExecuteTemplate($fileName, $strXML) {
       try {
			//check whether files are set or not
			if ($fileName == "")
				throw new Exception("File not specified");
			
			//build URI to execute mail merge template
			$strURI = Product::$BaseProductUri . "/words/" . $fileName . "/executeTemplate";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "", $strXML);

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save docs on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($fileName);
				$outputPath = SaasposeApp::$OutPutLocation . $fileName;
				Utils::saveFile($outputStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		}
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
    }
}

