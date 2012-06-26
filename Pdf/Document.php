<?php
/*
* Deals with PDF document level aspects
*/
class Document
{
        public $FileName = "";
		
		
		public function Document($fileName)
        {
            $this->FileName = $fileName;
        }

		/*
		* Gets the page count of the specified PDF document
		*/
        public function GetPageCount()
        {
			 //build URI
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages";
 
			//sign URI
			$signedURI = Utils::Sign($strURI);
 
			//get response stream
			$responseStream = Utils::ProcessCommand($signedURI, "GET", "");		
			
			$json = json_decode($responseStream);
			 
			 return count($json->Pages->List);  
        }     
	/*
    * Merges two PDF documents
	* @param string $basePdf (name of the base/first PDF file)
	* @param string $newPdf (name of the second PDF file to merge with base PDF file)
	* @param string $startPage (page number to start merging second PDF: enter 0 to merge complete document)
	* @param string $endPage (page number to end merging second PDF: enter 0 to merge complete document)
	* @param string $sourceFolder (name of the folder where base/first and second input PDFs are present)
	*/
	public function AppendDocument($basePdf, $newPdf, $startPage, $endPage, $sourceFolder) {
       try {
			//check whether files are set or not
			if ($basePdf == "")
				throw new Exception("Base file not specified");
			if ($newPdf == "")
				throw new Exception("File to merge is not specified");
				
			//build URI to merge PDFs
			if ($sourceFolder == "")	   
				$strURI = Product::$BaseProductUri . "/pdf/" . $basePdf . 
							"/appendDocument?appendFile=" . $newPdf . "&startPage=" . 
							$startPage . "&endPage=" . $endPage;
			else
				$strURI = Product::$BaseProductUri . "/pdf/" . $basePdf . 
							"/appendDocument?appendFile=" . $sourceFolder . "/" . $newPdf . 
							"&startPage=" . $startPage . "&endPage=" . $endPage . 
							"&folder=" . $sourceFolder;
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "POST", "", "");

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save merged PDF on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($sourceFolder . "/" . $basePdf);
				$outputPath = SaasposeApp::$OutPutLocation . $basePdf;
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
    * Creates a PDF from HTML
	* @param string $pdfFileName (name of the PDF file to create)
	* @param string $htmlFileName (name of the HTML template file)
	*/
	public function CreateFromHtml($pdfFileName, $htmlFileName) {
       try {
			//check whether files are set or not
			if ($pdfFileName == "")
				throw new Exception("PDF file name not specified");
			if ($htmlFileName == "")
				throw new Exception("HTML template file name not specified");
				
			//build URI to create PDF
			$strURI = Product::$BaseProductUri . "/pdf/" . $pdfFileName . 
							"?templateFile=" . $htmlFileName . "&templateType=html";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "PUT", "", "");

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save PDF file on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($pdfFileName);
				$outputPath = SaasposeApp::$OutPutLocation . $pdfFileName;
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
    * Creates a PDF from XML
	* @param string $pdfFileName (name of the PDF file to create)
	* @param string $xsltFileName (name of the XSLT template file)
	* @param string $xmlFileName (name of the XML file)
	*/
	public function CreateFromXml($pdfFileName, $xsltFileName, $xmlFileName) {
       try {
			//check whether files are set or not
			if ($pdfFileName == "")
				throw new Exception("PDF file name not specified");
			if ($xsltFileName == "")
				throw new Exception("XSLT file name not specified");
			if ($xmlFileName == "")
				throw new Exception("XML file name not specified");
				
			//build URI to create PDF
			$strURI = Product::$BaseProductUri . "/pdf/" . $pdfFileName . "?templateFile=" . 
						$xsltFileName . "&dataFile=" . $xmlFileName .  "&templateType=xml";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "PUT", "", "");

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save PDF file on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($pdfFileName);
				$outputPath = SaasposeApp::$OutPutLocation . $pdfFileName;
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
?> 
