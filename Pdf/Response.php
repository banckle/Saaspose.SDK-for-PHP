<?php
    class PagesEnvelop
    {
        public List<LinkResponse> Links { get; set; }
        public List<PageResponse> List { get; set; }
    }
	
	class PagesResponse 
    {
        public $Pages  = "";
    }
	
	class BaseResponse
    {
        public function BaseResponse() { }

        public $Code = "";
        public $Status = "";
    }
	
	class LinkResponse
    {
        public $Href  = "";
        public $Rel  = "";
        public $Title  = "";
        public $Type  = "";
    }
	
	class PageResponse
    {
      
        public List<LinkResponse> Links { get; set; }
        public $Id   = "";
        public $Images   = "";

    }
?>