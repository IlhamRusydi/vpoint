<?php

class FAQPage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('FAQPage')) {
	  $page = new FAQPage();
	  $page->Title = 'FAQ';
	  $page->URLSegment = 'faq';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('FAQPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class FAQPage_Controller extends Page_Controller {

  function index() {
	$list_data = FAQData::get();
	return $this->customise(array(
				'ListData' => $list_data
	));
  }

}
