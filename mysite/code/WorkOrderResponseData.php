<?php

class WorkOrderResponseData extends DataObject {

  static $db = array(
	  'Content' => 'HTMLText'
  );
  static $has_one = array(
	  'WorkOrder' => 'WorkOrderData',
	  'Member' => 'Member'
  );
  static $summary_fields = array(
	  'Created.Nice' => 'Created',
	  'Content.FirstParagraph' => 'Content',
	  'Member.FirstName' => 'Member'
  );

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	$this->MemberID = Member::currentUserID();
  }

  public function getTitle() {
	return $this->WorkOrder()->Number;
  }

  public function canCreate($member = null) {
	return true;
  }

  public function canEdit($member = null) {
	return true;
  }

  public function canView($member = null) {
	return true;
  }

}
