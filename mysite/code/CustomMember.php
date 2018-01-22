<?php

class CustomMember extends DataExtension {

  static $db = array(
	  'Address' => 'Text',
	  'Type' => 'Enum("ADMIN, CLIENT, TEKNISI, CS", "CLIENT")'
  );

  public function updateCMSFields(\FieldList $fields) {
	$fields->removeByName("DateFormat");
	$fields->removeByName("TimeFormat");
	$fields->removeByName("FailedLoginCount");
	$fields->removeByName("Divisions");
	$fields->removeByName("Surename");
	$source = array("ADMIN" => "ADMIN", "TEKNISI" => "TEKNISI", "CLIENT" => "CLIENT", "CS" => "CUSTOMER SERVICE");
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
