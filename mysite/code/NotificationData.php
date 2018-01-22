<?php

class NotificationData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(200)',
	  'Read' => 'Boolean',
	  'URL' => 'Varchar(300)'
  );
  static $has_one = array(
	  'MemberFrom' => 'Member',
	  'MemberTo' => 'Member'
  );
  static $summary_fields = array(
	  'Title' => 'Title',
	  'MemberFrom.FirstName' => 'Member'
  );

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	if (!$this->MemberFromID) {
	  $this->MemberFromID = Member::currentUserID();
	}
  }

  public function canCreate($member = null) {
	return false;
  }

  public function canEdit($member = null) {
	return false;
  }

  public function canDelete($member = null) {
	return false;
  }

  public function canView($member = null) {
	return true;
  }

  public function getCMSFields() {
	$fields = parent::getCMSFields();
	$this->setReadNotification();
	$fields->replaceField("URL", new LiteralField("Link", "<a href='" . $this->URL . "'>Direct Link</a>"));
	return $fields;
  }

  function setReadNotification() {
	$this->Read = 1;
	$this->write();
  }

}
