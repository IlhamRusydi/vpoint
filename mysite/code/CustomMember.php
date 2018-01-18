<?php

class CustomMember extends DataExtension {

  static $db = array(
	  'Address' => 'Text',
	  'Type' => 'Enum("ADMIN, CLIENT, OPERATOR", "CLIENT")'
  );

  public function updateCMSFields(\FieldList $fields) {
	$fields->removeByName("DateFormat");
	$fields->removeByName("TimeFormat");
	$fields->removeByName("FailedLoginCount");
	$fields->removeByName("Divisions");
	$fields->removeByName("Surename");
	$source = array("ADMIN" => "ADMIN", "OPERATOR" => "OPERATOR", "CLIENT" => "CLIENT");
	$fields->replaceField("Type", new DropdownField("Type", "Type", $source, null, null, "Select Type"));
  }

  public function updateSummaryFields(&$fields) {
	$fields = array(
		'FirstName' => 'Name',
		'Email' => 'Email',
		'LastVisited.Nice' => 'Last Login'
	);
  }

}
