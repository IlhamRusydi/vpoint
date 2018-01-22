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
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$limit = 5;
	$offset = 0;
	if (isset($_REQUEST['page'])) {
	  $offset = ($page - 1) * $limit;
	}
	$list_data = FAQData::Search($_REQUEST, $limit, $offset);
	$request = $_REQUEST;
	unset($request['url']);
	$url_query = http_build_query($request);
	$url = $this->Link() . 'index?' . $url_query;
	return $this->customise(array(
				'ListData' => $list_data,
				'Data' => $_REQUEST,
				'Pagination' => MT::pagination($list_data->count(), $limit, $page, $url)
	));
  }

}
