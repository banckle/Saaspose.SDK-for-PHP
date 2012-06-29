<?php
/*
* Deals with Word document builder aspects
*/
class WordDocumentBuilder
{
       
	/*
    * Inserts water mark text into the document.
	* @param string $fileName 
	* @param string $text
	* @param string $rotationAngle 
	*/
	public function InsertWatermarkText($fileName, $text, $rotationAngle) {
       try {
			//check whether files are set or not
			if ($fileName == "")
				throw new Exception("File not specified");
			
			//Build JSON to post
			$fieldsArray = array('Text'=>$text, 'RotationAngle'=>$rotationAngle);
			$json = json_encode($fieldsArray);

			//build URI to insert watermark text
			$strURI = Product::$BaseProductUri . "/words/" . $fileName . "/insertWatermarkText";
			
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
    * Inserts water mark image into the document.
	* @param string $fileName 
	* @param string $imageFile
	* @param string $rotationAngle 
	*/
	public function InsertWatermarkImage($fileName, $imageFile, $rotationAngle) {
       try {
			//check whether files are set or not
			if ($fileName == "")
				throw new Exception("File not specified");
			
			//build URI to insert watermark image
			$strURI = Product::$BaseProductUri . "/words/" . $fileName . 
			"/insertWatermarkImage?imageFile=" . $imageFile . "&rotationAngle=" . $rotationAngle;
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "json", '');

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save doc on server
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
    * Replace a text with the new value in the document
	* @param string $fileName 
	* @param string $oldValue
	* @param string $newValue 
	* @param string $isMatchCase
	* @param string $isMatchWholeWord
	*/
	public function ReplaceText($fileName, $oldValue, $newValue, $isMatchCase, $isMatchWholeWord) {
       try {
			//check whether files are set or not
			if ($fileName == "")
				throw new Exception("File not specified");
			
			//Build JSON to post
			$fieldsArray = array('OldValue'=>$oldValue, 'NewValue'=>$newValue, 
									'IsMatchCase'=>$isMatchCase, 'IsMatchWholeWord'=>$isMatchWholeWord);
			$json = json_encode($fieldsArray);

			//build URI to replace text
			$strURI = Product::$BaseProductUri . "/words/" . $fileName . "/replaceText";
			
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
}

