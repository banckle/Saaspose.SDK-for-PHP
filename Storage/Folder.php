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
		$this->strURIDisc = Product::$BaseProductUri . "/storage/disc";
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
	
	/*
    * Creates a new folder  under the specified folder on Saaspose storage. If no path specified, creates a folder under the root folder.
    * 
    * @param string $strFolder
    */
    public function CreateFolder($strFolder)
    {
        try
        {	
			//build URI
			$strURIRequest = $this->strURIFolder . $strFolder;
			
			//sign URI
			$signedURI = Utils::Sign($strURIRequest);

			$responseStream = json_decode(Utils::processCommand($signedURI, "PUT", "", ""));
			
            if ($responseStream->Code != 200) {
                return FALSE;
            }
            return TRUE;
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
	
	/*
    * Deletes a folder from remote storage
    *
    * @param string $folderName
    */
    public function DeleteFolder($folderName)
    {
        try
        {
            //check whether folder is set or not
            if ($folderName == "")
                throw new Exception("No folder name specified");
             
            //build URI
            $strURI = $this->strURIFolder . $folderName;
             
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
	
	/*
    * Provides the total / free disc size in bytes for your app
    */
    public function GetDiscUsage()
    {
        try
        {
            //build URI
            $strURI = $this->strURIDisc;
                	
            //sign URI
            $signedURI = Utils::Sign($strURI);
            
            $responseStream = json_decode(Utils::processCommand($signedURI, "GET", "", ""));
			
            return $responseStream->DiscUsage;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

	/*
    * Get file from Saaspose server
    *
    * @param string $fileName
    */
    public function GetFile($fileName)
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
             
            $responseStream = Utils::processCommand($signedURI, "GET", "", "");
            
            return $responseStream;
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
	
	/*
    * Retrives the list of files and folders under the specified folder. Use empty string to specify root folder.
    *
    * @param string $strFolder
    */
    public function GetFilesList($strFolder)
    {
        try
        {
			//build URI
            $strURI = $this->strURIFolder;
            //check whether file is set or not
            if (!$strFolder == "")
                $strURI .= $strFolder;    
                	
            //sign URI
            $signedURI = Utils::Sign($strURI);
             
            $responseStream = Utils::processCommand($signedURI, "GET", "", "");
            
			$json = json_decode($responseStream);
			
            return $json->Files;
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>