<?php
/// <summary>
/// Main class that provides methods to perform all the transactions on the storage of a Saaspose Application.
/// </summary>
class Folder
{
		public $strURIFolder = "";
		public $strURIFile = "";
		public $strURIExist = "";
		public $strURIDisc = "";
		
		public function Folder()
		{ 
			$this->strURIFolder = Product::$BaseProductUri . "/storage/folder/"; 
			$this->strURIFile = Product::$BaseProductUri . "/storage/file/"; 
			$this->strURIExist = Product::$BaseProductUri . "/storage/exist/";  
			$this->strURIDisc = Product::$BaseProductUri . "/storage/disc/";	 
		}
		
		/// <summary>
        /// Uploads a file from your local machine to specified folder / subfolder on Saaspose storage.
        /// </summary>
        /// <param name="strFile"></param>
        /// <param name="strFolder"></param>
        public function UploadFile($strFile, $strFolder)
        {
            try
            {	
				$strRemoteFileName = basename($strFile);
				 
				$strURIRequest = $this->strURIFile;
				
				if($strFolder == "")
					$strURIRequest .= $strRemoteFileName;
				else
					$strURIRequest .= $strFolder . "/". $strRemoteFileName;
 	
				$signedURI = Utils::Sign($strURIRequest);
 
				Utils::uploadFileBinary($signedURI, $strFile); 
 
            }
            catch (Exception $e)
            {
                throw new Exception($e->getMessage());
            }
        }
}
?>