<?php
/*
* This class contains features to work with charts
*/
class CellsChartEditor
{
	public $FileName = "";
	public $WorksheetName = "";
    public function CellsChartEditor($fileName, $worksheetName)
    {
        $this->FileName = $fileName;
		$this->WorksheetName = $worksheetName;
    }


	/*
    * Adds a new chart 
	* $chartType
	* $upperLeftRow
	* $upperLeftColumn
	* $lowerRightRow
	* $lowerRightColumn
	*/
	
	public function AddChart($chartType, $upperLeftRow, $upperLeftColumn, $lowerRightRow, $lowerRightColumn)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			//check whether workshett name is set or not
			if ($this->WorksheetName == "")
				throw new Exception("Worksheet name not specified");
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						"/worksheets/" . $this->WorksheetName . "/charts?chartType=" .
						$chartType . "&upperLeftRow=" . $upperLeftRow . "&upperLeftColumn=" .
						$upperLeftColumn . "&lowerRightRow=" . $lowerRightRow . 
						"&lowerRightColumn=" . $lowerRightColumn;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "PUT", "", "");

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save doc on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($this->FileName);
				$outputPath = SaasposeApp::$OutPutLocation . $this->FileName;
				Utils::saveFile($outputStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Deletes a chart 
	* $chartIndex
	*/
	
	public function DeleteChart($chartIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			//check whether workshett name is set or not
			if ($this->WorksheetName == "")
				throw new Exception("Worksheet name not specified");
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						"/worksheets/" . $this->WorksheetName . "/charts/" . $chartIndex;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "DELETE", "", "");

			$v_output = Utils::ValidateOutput($responseStream);
 
			if ($v_output === "") {
				//Save doc on server
				$folder = new Folder();
				$outputStream = $folder->GetFile($this->FileName);
				$outputPath = SaasposeApp::$OutPutLocation . $this->FileName;
				Utils::saveFile($outputStream, $outputPath);
				return "";
			} 
			else 
				return $v_output;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets ChartArea of a chart 
	* $chartIndex
	*/
	
	public function GetChartArea($chartIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			//check whether workshett name is set or not
			if ($this->WorksheetName == "")
				throw new Exception("Worksheet name not specified");
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						"/worksheets/" . $this->WorksheetName . "/charts/" . $chartIndex . "/chartArea";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->ChartArea;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets fill format of the ChartArea of a chart 
	* $chartIndex
	*/
	
	public function GetFillFormat($chartIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			//check whether workshett name is set or not
			if ($this->WorksheetName == "")
				throw new Exception("Worksheet name not specified");
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "/worksheets/" . 
						$this->WorksheetName . "/charts/" . $chartIndex . "/chartArea/fillFormat";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->FillFormat;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets border of the ChartArea of a chart 
	* $chartIndex
	*/
	
	public function GetBorder($chartIndex)
	{
		try
		{
			//check whether file is set or not
			if ($this->FileName == "")
				throw new Exception("No file name specified");
			//check whether workshett name is set or not
			if ($this->WorksheetName == "")
				throw new Exception("Worksheet name not specified");
				   
			$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . "/worksheets/" . 
						$this->WorksheetName . "/charts/" . $chartIndex . "/chartArea/border";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Line;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
}
?>