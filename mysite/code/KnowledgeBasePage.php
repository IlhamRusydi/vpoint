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

  public function init() {
	parent::init();
	if (!Member::currentUserID()) {
	  $this->redirect(Director::baseURL() . "Security/login");
	}
  }

  function index() {
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$limit = 5;
	$offset = 0;
	if (isset($_REQUEST['page'])) {
	  $offset = ($page - 1) * $limit;
	}
	$list_data = KnowledgeBaseData::Search($_REQUEST, $limit, $offset);
	$request = $_REQUEST;
	unset($request['url']);
	$url_query = http_build_query($request);
	$url = $this->Link() . 'index?' . $url_query;
	return $this->customise(array(
				'ListData' => $list_data,
				'Pagination' => MT::pagination($list_data->count(), $limit, $page, $url)
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
