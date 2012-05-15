<?php
/*
* reads barcodes from images
*/
class BarcodeReader
{
	public $FileName = "";
	
    public function BarcodeReader($fileName)
    {
        $this->FileName = $fileName;
    }
	/*
    * reads all or specific barcodes from images
	* @param string $symbology
	*/
	public function Read($symbology)
	{
	    try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");

            //build URI to read barcode
			$strURI = Product::$BaseProductUri . "/barcode/" . $this->FileName . "/recognize?" .
						(!isset($symbology) || trim($symbology)==='' ? "type=" : "type=" . $symbology); 
						 				   
			//sign URI
			$signedURI = Utils::Sign($strURI);

			//get response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			$json = json_decode($responseStream);
			
			//returns a list of extracted barcodes
			return $json->Barcodes;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}  	
	}
}
?>