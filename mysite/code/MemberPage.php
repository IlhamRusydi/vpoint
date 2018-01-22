<?php

class MemberPage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('MemberPage')) {
	  $page = new MemberPage();
	  $page->Title = 'Member';
	  $page->URLSegment = 'member';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('MemberPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class MemberPage_Controller extends Page_Controller {

  function index() {
	return $this->customise(array(
				'Title' => 'Member',
	));
  }

  function ProfileForm() {
	$fields = new FieldList();
	$name = new TextField("Name", "");
	$name->addPlaceholder("Name", "");
	$name->addHolderClass("col-sm-6 breaking");
	$name->addExtraClass("form-control");
	$fields->push($name);

	$email = new TextField("Email", "Email");
	$email->addPlaceholder("Email");
	$email->addHolderClass("col-sm-6 breaking");
	$email->addExtraClass("form-control");
	$fields->push($email);

	$button = new FormAction('DoProfilForm', 'Send');
	$button->addHolderClass("breaking col-md-12");
	$button->addExtraClass("btn btn-primary");

	$action = new FieldList(
			$button
	);

	$validator = new RequiredFields('FirstName', 'Email', 'Address');
	$form = new BootstrapForm($this, 'ProfilForm', $fields, $action, $validator);
	$form->setGridActionClass("col-md-12");
	return $form;
  }

}
