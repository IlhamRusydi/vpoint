<?php

class WorkOrderData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(200)',
	  'StartDate' => 'Date',
	  'EndDate' => 'Date',
	  'Number' => 'Varchar(100)',
	  'Content' => 'HTMLText',
	  'Status' => 'Enum("OPEN,RESPONDED,PROGRESS,CLOSED","OPEN")',
	  'Read' => 'Boolean',
	  'CloseOn' => 'Datetime'
  );
  static $has_one = array(
	  'Member' => 'Member',
	  'Ticket' => 'TicketData'
  );
  static $has_many = array(
	  'Responses' => 'WorkOrderResponseData'
  );
  static $summary_fields = array(
	  'Created.Nice' => 'Created',
	  'Number' => 'Number',
	  'Title' => 'Title',
	  'Status' => 'Status',
	  'Member.FirstName' => 'Member'
  );

  public function canCreate($member = null) {
	if ($_REQUEST['url'] == BASE_URL . "/admin/work-order/") {
	  return false;
	} else {
	  return true;
	}
  }

  public function canEdit($member = null) {
	return true;
  }

  public function canView($member = null) {
	return true;
  }

  function getRandomNomor() {
	$hold_value = "WO-1000000000";
	$random = rand(1, 9999999999);
	$start = strlen($hold_value) - strlen($random);
	$string = substr_replace($hold_value, $random, $start);
	$check_obj = self::get()->where("Number='$string'")->limit(1)->first();
	if ($check_obj) {
	  while ($check_obj) {
		$random = rand(1, 9999999999);
		$start = strlen($hold_value) - strlen($random);
		$string = substr_replace($hold_value, $random, $start);
		$check_obj = self::get()->where("Number='$string'")->limit(1)->first();
	  }
	}
	return $string;
  }

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	if (!$this->Number) {
	  $this->Number = $this->getRandomNomor();
	}
	if ($this->Status == 'CLOSED') {
	  $this->CloseOn = date("Y-m-d H:i:s");
	}
	if (!$this->ID) {
	  $this->Ticket()->Status = 'PROGRESS';
	  $this->Ticket()->write();
	}
  }

  public function getCMSFields() {
	$fields = new FieldList();
	$fields->add(new TabSet("Root"));
	if ($this->ID) {
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Number"));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Title"));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Creator", "Task To", $this->Member()->FirstName));
	  $fields->addFieldToTab("Root.Main", new LiteralField("Content", $this->Content));
	} else {
	  $fields->addFieldToTab("Root.Main", new TextField("Title"));
	  $fields->addFieldToTab("Root.Main", new DropdownField("MemberID", "Staff", Member::get()->where("Type='TEKNISI'")->map("ID", "FirstName"), null, null, "Select Staff"));
	  $startDate = new DateField("StartDate", "Start Date");
	  $startDate->setConfig("showcalendar", true);
	  $fields->addFieldToTab("Root.Main", $startDate);
	  $endDate = new DateField("EndDate", "End Date");
	  $endDate->setConfig("showcalendar", true);
	  $fields->addFieldToTab("Root.Main", $endDate);
	  $fields->addFieldToTab("Root.Main", new HtmlEditorField("Content"));
	}
	$responsegridfield = new GridField("Responses", "Responses", $this->Responses(), GridFieldConfig_RecordEditor::create());
	$fields->addFieldToTab("Root.Main", $responsegridfield);
	return $fields;
  }

}
