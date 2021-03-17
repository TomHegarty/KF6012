<?php
/**
* Creates an HTML webpage using the given params
* 
* @author Tom Hegarty
* 
*/

abstract class WebPage {
  private $main; 
  private $pageStart;
  protected $header; 
  private $css; 
  private $footer; 
  private $pageEnd;

 /**
 *
 * @param $pageTitle - A string to appear as web page title
 * @param $css - links to the css file (styles/style.css)
 * @param $pageHeading1 - heading of the page
 * @param $footerText - text to appear in the footer 
 *
 */
  public function __construct($pageTitle, $pageHeading1, $footerText) {
    $this->main = "";
    $this->set_css();
    $this->set_pageStart($pageTitle,$this->css);
    $this->set_header($pageHeading1);
    $this->set_footer($footerText);
    $this->set_pageEnd();
  }

  private function set_pageStart($pageTitle,$css) {
    $this->pageStart = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8" /><title>' . $pageTitle . '</title><link rel="stylesheet" href="' . $css . '"></head><body>';
  }

  private function set_css() {
    $this->css = BASEPATH.CSSPATH; 
  }

  protected function set_header($pageHeading1) {
    $this->header = '<header><h1>' . $pageHeading1 . '</h1></header>';
  }

  private function set_main($main) {
    $this->main = '<main>' . $main . '</main>';
  }

  private function set_footer($footerText) {
    $this->footer = '<footer>' . $footerText . '</footer>';
  }

  private function set_pageEnd() {
    $this->pageEnd = '</body></html>';
  }

  public function addToBody($text) {
    if($text == "docs"){
      $this->main .=  include 'markup/docs.php';
    } else if($text == "about"){
      $this->main .=  include 'markup/about.php';
    } else {
      $this->main .= $text;
    }
  }

  /**
    * main function to return each element of the webpage
    */
  public function get_page() {
    $this->set_main($this->main);
    return 
      $this->pageStart.
      $this->header.
      $this->main.
      $this->footer.
      $this->pageEnd; 
  }
}
