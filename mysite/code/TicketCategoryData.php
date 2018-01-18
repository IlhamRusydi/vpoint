<?php

class TicketCategoryData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(100)'
  );
  static $has_one = array(
	  'Division' => 'DivisionData'
  );

  public function getCMSFields() {
	$fields = new FieldList();
	$fields->add(new TabSet("Root"));
	$fields->addFieldToTab("Root.Main", new TextField("Title", "Title"));
	return $fields;
  }

}
