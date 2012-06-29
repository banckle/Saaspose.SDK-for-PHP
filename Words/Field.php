<?php
/*
* Deals with Word document builder aspects
*/
class WordField
{
       
	/*
    * Inserts page number filed into the document.
	* @param string $fileName 
	* @param string $alignment
	* @param string $format 
	* @param string $isTop
	* @param string $setPageNumberOnFirstPage 
	*/
	public function InsertPageNumber($fileName, $alignment, $format, $isTop, $setPageNumberOnFirstPage) {
       try {
			//check whether files are set or not
			if ($fileName == "")
				throw new Exception("File not specified");
			
			//Build JSON to post
			$fieldsArray = array('Format'=>$format, 'Alignment'=>$alignment, 
									'IsTop'=>$isTop, 'SetPageNumberOnFirstPage'=>$setPageNumberOnFirstPage);
			$json = json_encode($fieldsArray);

			//build URI to insert page number
			$strURI = Product::$BaseProductUri . "/words/" . $fileName . "/insertPageNumbers";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "json", $json);

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
    * Gets all merge filed names from document.
	* @param string $fileName  
	*/
	public function GetMailMergeFieldNames($fileName)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/words/" . $this->FileName . "/mailMergeFieldNames";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->FieldNames->List; 
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
}

