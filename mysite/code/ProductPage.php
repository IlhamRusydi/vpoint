<?php

class ProductPage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('ProductPage')) {
	  $page = new ProductPage();
	  $page->Title = 'Product';
	  $page->URLSegment = 'product';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('ProductPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class ProductPage_Controller extends Page_Controller {

  static $allowed_actions = array(
	  'view'
  );

  function index() {
	
  }

  function view() {
	$id = $this->request->param("ID");
	$obj = ProductData::get()->where("URLSegment='$id'")->limit(1)->first();
	return $this->customise(array(
				'Data' => $obj
			))->renderWith(array('ProductViewPage', 'Page'));
  }

}
