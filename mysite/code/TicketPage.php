<?php

class TicketPage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('TicketPage')) {
	  $page = new TicketPage();
	  $page->Title = 'Ticket';
	  $page->URLSegment = 'ticket';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('TicketPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class TicketPage_Controller extends Page_Controller {

  static $allowed_actions = array(
	  'add',
	  'AddForm',
	  'view',
	  'close',
	  'uploadimages',
	  'CommentForm',
	  'ajax_getcategory'
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
	$list_data = TicketData::Search($_REQUEST, $limit, $offset);
	$request = $_REQUEST;
	unset($request['url']);
	$url_query = http_build_query($request);
	$url = $this->Link() . 'index?' . $url_query;
	return $this->customise(array(
				'Title' => 'Ticket List',
				'ListData' => $list_data,
				'Pagination' => MT::pagination($list_data->count(), $limit, $page, $url)
	));
  }

  function add() {
	return $this->customise(array(
				'Title' => 'Open New Ticket'
			))->renderWith(array('AddTicketPage', 'Page'));
  }

  function view() {
	$id = $this->request->param("ID");
	$obj = TicketData::get()->where("Number='$id'")->limit(1)->first();
	return $this->customise(array(
				'Data' => $obj,
			))->renderWith(array('TicketViewPage', 'Page'));
  }

  function CommentDo($data, $form) {
	$obj = new TicketResponseData();
	$obj->update($data);
	$obj->Ticket()->Status = 'RESPONDED';
	$obj->Ticket()->write();
	$obj->write();
	foreach (Member::get()->where("Type='ADMIN'") as $user) {
	  $arr = array(
		  'Title' => Member::currentUser()->FirstName . " merespon ticket " . $obj->Number . " - " . $obj->Title . " pada " . date('d-m-Y H:i'),
		  'URL' => Director::absoluteBaseURL() . "admin/" . "ticket/TicketData/EditForm/field/TicketData/item/" . $obj->ID,
		  'MemberToID' => $user->ID
	  );
	  NotificationData::create()->update($arr)->write();
	}
	$form->sessionMessage('ok', 'alert alert-success', "Ticket berhasil disimpan");
	$this->redirectBack();
  }

  function close() {
	$id = $this->request->param("ID");
	$obj = TicketData::get()->where("Number='$id'")->limit(1)->first();
	$obj->Status = 'CLOSED';
	$obj->CloseOn = date('Y-m-d H:i:s');
	$obj->write();
	foreach (Member::get()->where("Type='ADMIN'") as $user) {
	  $arr = array(
		  'Title' => Member::currentUser()->FirstName . " menutup ticket " . $obj->Number . " - " . $obj->Title . " pada " . date('d-m-Y H:i'),
		  'URL' => Director::absoluteBaseURL() . "admin/" . "ticket/TicketData/EditForm/field/TicketData/item/" . $obj->ID,
		  'MemberToID' => $user->ID
	  );
	  NotificationData::create()->update($arr)->write();
	}
	$this->redirectBack();
  }

  function AddForm() {
	$fields = new FieldList();
	$title = new TextField('Title', 'Judul');
	$title->addPlaceholder("Judul");
	$title->addExtraClass("form-control");
	$fields->push($title);
	$dropdowndivisi = new DropdownField("DivisionID", "Divisi", DivisionData::get()->map("ID", "Title"), null, null, "- Pilih Kategori -");
	$dropdowndivisi->addHolderClass("col-md-6");
	$dropdowndivisi->setHolderAttribute("style", "padding-left:0px");
	$fields->push($dropdowndivisi);
	$dropdowncategory = new DropdownField("CategoryID", "Kategori", TicketCategoryData::get()->map("ID", "Title"), null, null, "- Pilih Kategori -");
	$dropdowncategory->addHolderClass("col-md-6");
	$dropdowncategory->setHolderAttribute("style", "padding-right:0px");
	$fields->push($dropdowncategory);
	$content = new TextareaField('Content', 'Deskripsi');
	$fields->push($content);
	$button = new FormAction('AddDo', 'Kirim');
	$button->addExtraClass("btn btn-primary");
	$action = new FieldList($button);
	$validator = new RequiredFields('Title', 'CategoryID', 'Content');
	$form = new BootstrapForm($this, 'AddForm', $fields, $action, $validator);
	return $form;
  }

  function CommentForm($id = 0) {
	$fields = new FieldList();
	$fields->push(new HiddenField("TicketID", "TicketID", $id));
	$content = new TextareaField('Content', 'Respon');
	$fields->push($content);
	$button = new FormAction('CommentDo', 'Kirim');
	$button->addExtraClass("btn btn-primary");
	$action = new FieldList($button);
	$validator = new RequiredFields('Content');
	$form = new BootstrapForm($this, 'CommentForm', $fields, $action, $validator);
	return $form;
  }

  function AddDo($data, $form) {
	$obj = new TicketData();
	$obj->update($data);
	$obj->Via = "WEBSITE";
	$obj->write();
	$form->sessionMessage('ok', 'alert alert-success', "Ticket berhasil disimpan");
	foreach (Member::get()->where("Type='ADMIN'") as $user) {
	  $arr = array(
		  'Title' => Member::currentUser()->FirstName . " membuat ticket " . $obj->Number . " - " . $obj->Title . " pada " . date('d-m-Y H:i'),
		  'URL' => Director::absoluteBaseURL() . "admin/" . "ticket/TicketData/EditForm/field/TicketData/item/" . $obj->ID,
		  'MemberToID' => $user->ID
	  );
	  NotificationData::create()->update($arr)->write();
	}
	$this->redirect($this->Link());
  }

  function uploadimages() {

	if (!isset($_FILES['upload'])) {
	  return json_encode(array(
		  'error' => 'Upload Error broooooo'
	  ));
	}

	$upload = new Upload();
	$file = new File();

	$upload->loadIntoFile($_FILES['upload'], $file, 'Files/' . date('Ymd'));
	$file->ClassName = 'Image';
	$file->write();
	//}
	return json_encode(array(
		'url' => Director::baseURL() . $file->Filename,
		'fileName' => $file->Name,
		'uploaded' => 1,
		'error' => array(
			"message" => $upload->getErrors()
		)
	));
  }

  function ajax_getcategory() {
	if (isset($_POST['id'])) {
	  $arr = array();
	  echo json_encode(TicketCategoryData::get()->where("DivisionID=" . $_POST['id'] . "")->toNestedArray());
	}
  }

}
