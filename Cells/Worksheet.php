<?php
/*
* This class contains features to work with charts
*/
class CellsWorksheet
{
	public $FileName = "";
	public $WorksheetName = "";
    public function CellsWorksheet($fileName, $worksheetName)
    {
        $this->FileName = $fileName;
		$this->WorksheetName = $worksheetName;
    }


	/*
    * Gets a list of cells
	* $offset
	* $count
	*/
	
	public function GetCellsList($offset, $count)
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
						"/worksheets/" . $this->WorksheetName . "/cells?offset=" .
						$offset . "&count=" . $count;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			$listCells = array();
			
			foreach ($json->Cells->CellList as $cell) { 
				$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						"/worksheets/" . $this->WorksheetName . "/cells" . $cell->link->Href;
			 
				$signedURI = Utils::Sign($strURI);

				$responseStream = Utils::processCommand($signedURI, "GET", "", "");
				$json = json_decode($responseStream);
				
				array_push($listCells, $json->Cell);
			}
			
			return $listCells;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a list of rows from the worksheet
	*/
	
	public function GetRowsList()
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
						"/worksheets/" . $this->WorksheetName . "/cells/rows";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			$listRows = array();
			
			foreach ($json->Rows->RowsList as $row) { 
				$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						"/worksheets/" . $this->WorksheetName . "/cells/rows" . $row->link->Href;
			 
				$signedURI = Utils::Sign($strURI);

				$responseStream = Utils::processCommand($signedURI, "GET", "", "");
				$json = json_decode($responseStream);
				
				array_push($listRows, $json->Row);
			}
			
			return $listRows;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a list of columns from the worksheet
	*/
	
	public function GetColumnsList()
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
						"/worksheets/" . $this->WorksheetName . "/cells/columns";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			$listColumns = array();
			
			foreach ($json->Columns->ColumnsList as $column) { 
				$strURI = Product::$BaseProductUri . "/cells/" . $this->FileName . 
						"/worksheets/" . $this->WorksheetName . "/cells/columns" . $column->link->Href;
			 
				$signedURI = Utils::Sign($strURI);

				$responseStream = Utils::processCommand($signedURI, "GET", "", "");
				$json = json_decode($responseStream);
				
				array_push($listColumns, $json->Column);
			}
			
			return $listColumns;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets maximum column index of cell which contains data or style
	* $offset
	* $count
	*/
	
	public function GetMaxColumn($offset, $count)
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
						"/worksheets/" . $this->WorksheetName . "/cells?offset=" .
						$offset . "&count=" . $count;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Cells->MaxColumn;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/*
    * Gets maximum row index of cell which contains data or style
	* $offset
	* $count
	*/
	
	public function GetMaxRow($offset, $count)
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
						"/worksheets/" . $this->WorksheetName . "/cells?offset=" .
						$offset . "&count=" . $count;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Cells->MaxRow;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets cell count in the worksheet 
	* $offset
	* $count
	*/
	
	public function GetCellsCount($offset, $count)
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
						"/worksheets/" . $this->WorksheetName . "/cells?offset=" .
						$offset . "&count=" . $count;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Cells->CellCount;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets AutoShape count in the worksheet 
	*/
	
	public function GetAutoShapesCount()
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
						"/worksheets/" . $this->WorksheetName . "/autoshapes";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return Count($json->AutoShapes->AuotShapeList);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a specific AutoShape from the sheet
	* $index
	*/
	
	public function GetAutoShapeByIndex($index)
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
						"/worksheets/" . $this->WorksheetName . "/autoshapes/" . $index;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->AutoShape;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets charts count in the worksheet 
	*/
	
	public function GetChartsCount()
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
						"/worksheets/" . $this->WorksheetName . "/charts";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return Count($json->Charts->ChartList);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a specific chart from the sheet
	* $index
	*/
	
	public function GetChartByIndex($index)
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
						"/worksheets/" . $this->WorksheetName . "/charts/" . $index;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Chart;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets hyperlinks count in the worksheet 
	*/
	
	public function GetHyperlinksCount()
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
						"/worksheets/" . $this->WorksheetName . "/hyperlinks";
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return Count($json->Hyperlinks->HyperlinkList);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	/*
    * Gets a specific hyperlink from the sheet
	* $index
	*/
	
	public function GetHyperlinkByIndex($index)
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
						"/worksheets/" . $this->WorksheetName . "/hyperlinks/" . $index;
			 
			$signedURI = Utils::Sign($strURI);

			$responseStream = Utils::processCommand($signedURI, "GET", "", "");

			$json = json_decode($responseStream);
			
			return $json->Hyperlink;
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	
	
}
?>