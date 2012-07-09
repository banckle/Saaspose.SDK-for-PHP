<?php
/*
* Deals with Annotations, Bookmarks, Attachments and Links in PDF document
*/
class AnnotationEditor
{
	public $FileName = "";
	
    public function AnnotationEditor($fileName)
    {
        $this->FileName = $fileName;
    }


	/*
    * Gets number of annotations on a specified document page
	* @param $pageNumber
	*/
	
	public function GetAnnotationsCount($pageNumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/annotations";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return count($json->Annotations->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a specfied annotation on a specified document page
	* @param $pageNumber
	* @param $annotationIndex
	*/
	
	public function GetAnnotation($pageNumber, $annotationIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/annotations/" . $annotationIndex;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Annotation;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets list of all the annotations on a specified document page
	* @param $pageNumber
	*/
	public function GetAllAnnotations($pageNumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$iTotalAnnotation = $this->GetAnnotationsCount($pageNumber);
			
			$listAnnotations = array();
			for ($index = 1; $index <= $iTotalAnnotation; $index++)
            {
				array_push($listAnnotations, $this->GetAnnotation($pageNumber, $index));
            }
			
			return $listAnnotations;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets total number of Bookmarks in a Pdf document
	*/
	
	public function GetBookmarksCount()
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/bookmarks";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return count($json->Bookmarks->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets number of child bookmarks in a specfied parent bookmark
	* @param $parent
	*/
	
	public function GetChildBookmarksCount($parent)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/bookmarks/" . $parent . "/bookmarks";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return count($json->Bookmarks->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a specfied Bookmark from a PDF document
	* @param $bookmarkIndex
	*/
	
	public function GetBookmark($bookmarkIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/bookmarks/" . $bookmarkIndex;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Bookmark;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a specfied child Bookmark for selected parent bookmark in Pdf document
	* @param $parentIndex
	* @param $childIndex
	*/
	
	public function GetChildBookmark($parentIndex, $childIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/bookmarks/" . $parentIndex . "/bookmarks/" . $childIndex;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Bookmark;  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets list of all the Bookmarks in a Pdf document
	*/
	public function GetAllBookmarks()
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$iTotalBookmarks = $this->GetBookmarksCount();
			
			$listBookmarks = array();
			for ($index = 1; $index <= $iTotalBookmarks; $index++)
            {
				array_push($listBookmarks, $this->GetBookmark($index));
            }
			
			return $listBookmarks;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/*
    * Gets number of attachments in the Pdf document
	*/
	
	public function GetAttachmentsCount()
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/attachments";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return count($json->Attachments->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets selected attachment from Pdf document
	* @param $attachmentIndex
	*/
	
	public function GetAttachment($attachmentIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/attachments/" . $attachmentIndex;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Attachment;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets List of all the attachments in Pdf document
	*/
	public function GetAllAttachments()
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$iTotalAttachments = $this->GetAttachmentsCount();
			
			$listAttachments = array();
			for ($index = 1; $index <= $iTotalAttachments; $index++)
            {
				array_push($listAttachments, $this->GetAttachment($index));
            }
			
			return $listAttachments;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Download the selected attachment from Pdf document
	* @param string $attachmentIndex
	*/
	
	public function DownloadAttachment($attachmentIndex) {
       try {
			//check whether files are set or not
			if ($this->FileName == "")
				throw new Exception("PDF file name not specified");
			
			$fileInformation = $this->GetAttachment($attachmentIndex);
			
			//build URI to download attachment
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/attachments/" . $attachmentIndex . "/download";
			
			//sign URI
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");
		
			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") 
			{
				Utils::saveFile($responseStream, SaasposeApp::$OutPutLocation . $fileInformation->Name);
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
    * Gets number of links on a specified document page
	* @param $pageNumber
	*/
	
	public function GetLinksCount($pageNumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/links";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return count($json->Links->List);  
				
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a specfied link on a specified document page
	* @param $pageNumber
	* @param $linkIndex
	*/
	
	public function GetLink($pageNumber, $linkIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$strURI = Product::$BaseProductUri . "/pdf/" . $this->FileName . "/pages/" . $pageNumber . "/links/" . $linkIndex;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Link;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets list of all the links on a specified document page
	* @param $pageNumber
	*/
	public function GetAllLinks($pageNumber)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
				   
			$iTotalLinks = $this->GetLinksCount($pageNumber);
			
			$listLinks = array();
			for ($index = 1; $index <= $iTotalLinks; $index++)
            {
				array_push($listLinks, $this->GetLink($pageNumber, $index));
            }
			
			return $listLinks;  
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
}
?>