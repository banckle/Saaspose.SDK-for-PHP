<?php
/*
*  Main class that provides methods to perform all the transactions on the storage of a Saaspose Application.
*/
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
	
	/*
    * Uploads a file from your local machine to specified folder / subfolder on Saaspose storage.
    * 
    * @param string $strFile
    * @param string $strFolder
    */
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
    
    /*
    * Checks if a file exists
    *
    * @param string $fileName
    */
    public function FileExists($fileName)
    {
        try
        {
            //check whether file is set or not
            if ($fileName == "")
                throw new Exception("No file name specified");
                	
                	//build URI
            $strURI = $this->strURIExist . $fileName;
                	
            //sign URI
            $signedURI = Utils::Sign($strURI);
             
            $responseStream = json_decode(Utils::processCommand($signedURI, "GET", "", ""));
            if (!$responseStream->FileExist->IsExist) {
                return FALSE;
            }
            return TRUE;
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /*
    * Deletes a file from remote storage
    *
    * @param string $fileName
    */
    public function DeleteFile($fileName)
    {
        try
        {
            //check whether file is set or not
            if ($fileName == "")
                throw new Exception("No file name specified");
             
            //build URI
            $strURI = $this->strURIFile . $fileName;
             
            //sign URI
            $signedURI = Utils::Sign($strURI);
             
            $responseStream = json_decode(Utils::processCommand($signedURI, "DELETE", "", ""));
            if ($responseStream->Code != 200) {
                return FALSE;
            }
            return TRUE;
             
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>