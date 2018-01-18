<?php

class SocialData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar',
	  'URL' => 'Varchar',
	  'FaIcon' => 'Varchar'
  );
  static $summary_field = array(
	  'Title' => 'Title',
	  'URL' => 'Link',
	  'FaIcon' => 'Icon'
  );
  static $has_one = array(
	  'Icon' => 'Image'
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
