<?php

class DivisionData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(100)'
  );
  static $has_many = array(
	  'Categories' => 'TicketCategoryData'
  );

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
