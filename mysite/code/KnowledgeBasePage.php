<?php

class KnowledgeBasePage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('KnowledgeBasePage')) {
	  $page = new KnowledgeBasePage();
	  $page->Title = 'KnowledgeBase';
	  $page->URLSegment = 'knowledgebase';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('KnowledgeBasePage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class KnowledgeBasePage_Controller extends Page_Controller {

  static $allowed_actions = array(
	  'view'
  );

  function index() {
	$list_data = KnowledgeBaseData::Search($_REQUEST);
	return $this->customise(array(
				'Data' => $_REQUEST,
				'ListData' => $list_data,
	));
  }

  function getKnowledgeBaseCategoryData() {
	return KnowledgeBaseCategoryData::get();
  }

  function view() {
	$id = $this->request->param("ID");
	$obj = KnowledgeBaseData::get()->where("URLSegment='$id'")->limit(1)->first();
	return $this->customise(array(
				'Data' => $obj
			))->renderWith(array('KnowledgeBaseViewPage', 'Page'));
  }

}
