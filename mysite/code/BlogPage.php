<?php

class BlogPage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('BlogPage')) {
	  $page = new BlogPage();
	  $page->Title = 'Blog';
	  $page->URLSegment = 'blog';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('BlogPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class BlogPage_Controller extends Page_Controller {

  static $allowed_actions = array(
	  'view'
  );

  function index() {
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$limit = 5;
	$offset = 0;
	if (isset($_REQUEST['page'])) {
	  $offset = ($page - 1) * $limit;
	}
	$list_data = BlogData::Search($_REQUEST, $limit, $offset);
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

  function view() {
	$id = $this->request->param("ID");
	$obj = BlogData::get()->where("URLSegment='$id'")->limit(1)->first();
	return $this->customise(array(
				'Data' => $obj
			))->renderWith(array('BlogViewPage', 'Page'));
  }

}
