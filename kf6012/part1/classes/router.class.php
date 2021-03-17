<?php
/**
* This router will return an html page, or a json formated page 
* 
* @author Tom Hegarty
*
*/
class Router {
    private $page;
    private $type = "HTML";

    /**
    * @param $pageType - can be "documentation" or "about"
    * @access public
    */
    public function __construct($recordset) {
        $url = $_SERVER["REQUEST_URI"];
        $path = parse_url($url)['path'];

        $path = str_replace(BASEPATH,"",$path);
        $pathArr = explode('/',$path);
        $path = (empty($pathArr[0])) ? "about" : $pathArr[0];

        ($path == "api") 
            ? $this->api_route($pathArr, $recordset) 
            : $this->html_route($path);
    }

    /**
    * This functin will return a JSON format page, for API requests  
    *
    * @param $pathArr - array of valaues from the URL path
    * @param $recordset - JSON record set of data
    * @access public
    */
    public function api_route($pathArr, $recordset) {
        $this->type = "JSON";
        $this->page = new JSONpage($pathArr, $recordset);
    }

    /**
    * outputs html page for speciifed url path
    *
    * @param $pathArr - array of valaues from the URL path
    * @access public
    */
    public function html_route($path) {
        $ini['routes'] = parse_ini_file("config/routes.ini",true);
        $pageInfo = isset($path, $ini['routes'][$path]) 
            ? $ini['routes'][$path] 
            : $ini['routes']['error'];

        $this->page = new WebPageWithNav($pageInfo['title'], $pageInfo['heading1'], $pageInfo['footer']);
        $this->page->addToBody($pageInfo['text']);
    }

    public function get_type() {
        return $this->type ; 
    }

    public function get_page() {
        return $this->page->get_page(); 
    }
}
?>