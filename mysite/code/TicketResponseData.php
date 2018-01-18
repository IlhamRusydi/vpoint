<?php

class TicketResponseData extends DataObject {

  static $db = array(
	  'Content' => 'HTMLText'
  );
  static $has_one = array(
	  'Ticket' => 'TicketData',
	  'Member' => 'Member'
  );
  static $summary_fields = array(
	  'Created.Nice' => 'Created',
	  'Content.FirstParagraph' => 'Content',
	  'Member.FirstName' => 'Member'
  );

  public function getTitle() {
	return $this->Ticket()->Number;
  }

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	$this->MemberID = Member::currentUserID();
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
