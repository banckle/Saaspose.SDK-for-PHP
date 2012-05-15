<?php
/*
* generates new barcodes
*/
class BarcodeBuilder
{
	/*
    * generates new barcodes with specific text, symbology, image format, resolution and dimensions
	* @param string $codeText
	* @param string $symbology
	* @param string $imageFormat
	* @param string $xResolution
	* @param string $yResolution
	* @param string $xDimension
	* @param string $yDimension
	*/
	public function Save($codeText, $symbology, $imageFormat, $xResolution, $yResolution, 
	                                $xDimension, $yDimension)
	{
		//build URI to generate barcode
		$strURI = Product::$BaseProductUri . "/barcode/generate?text=" . $codeText .
					"&type=" . $symbology . "&format=" . $imageFormat . 
					($xResolution <= 0 ? "" : "&resolutionX=" . $xResolution) .
					($yResolution <= 0 ? "" : "&resolutionY=" . $yResolution) . 
					($xDimension <= 0 ? "" : "&dimensionX=" . $xDimension) .  
					($yDimension <= 0 ? "" : "&dimensionY=" . $yDimension);
		try
		{  		
			//sign URI
			$signedURI = Utils::Sign($strURI);

			//get response stream
			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
			
			//Save output barcode image
			$outputPath = SaasposeApp::$OutPutLocation . "barcode" . $symbology . "." . $imageFormat;
			Utils::saveFile($responseStream, $outputPath);
			return $outputPath;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}  	
	}
}
?>