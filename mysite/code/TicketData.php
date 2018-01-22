<?php

class TicketData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar',
	  'Number' => 'Double',
	  'Content' => 'HTMLText',
	  'Via' => 'Varchar(100)',
	  'Status' => 'Enum("OPEN,RESPONDED,PROGRESS,CLOSED","OPEN")',
	  'Read' => 'Boolean',
	  'CloseOn' => 'Datetime'
  );
  static $has_many = array(
	  'Responses' => 'TicketResponseData',
	  'WorkOrders' => 'WorkOrderData'
  );
  static $has_one = array(
	  'Category' => 'TicketCategoryData',
	  'Division' => 'DivisionData',
	  'Member' => 'Member',
	  'MemberCreate' => 'Member'
  );
  static $summary_fields = array(
	  'Created.Nice' => 'Created',
	  'Number' => 'Number',
	  'Title' => 'Title',
	  'Status' => 'Status',
	  'Division.Title' => 'Division',
	  'Category.Title' => 'Category',
	  'Member.FirstName' => 'Member'
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

  static function Search($params, $limit = 5, $offset = 0) {
	$sql = "SELECT DISTINCT TicketData.ID FROM TicketData WHERE ID>0 AND MemberID=" . Member::currentUserID() . "";
	if (isset($params['search']) && $params['search']) {
	  $sql .= " OR TicketData.Title LIKE '%" . $params['search'] . "%'";
	  $sql .= " OR TicketData.Content LIKE '%" . $params['search'] . "%'";
	}
	$sql .= " ORDER BY TicketData.Created ASC LIMIT $offset, $limit ";
	$arr_id = DB::query($sql)->column("ID");
	$where = sizeof($arr_id) ? "ID IN (" . implode(",", $arr_id) . ")" : "ID=0";
	return self::get()->where($where);
  }

  function CanComment() {
	if ($this->Status == 'CLOSED') {
	  return false;
	}
	return true;
  }

  function CanClose() {
	if ($this->Status == 'CLOSED') {
	  return false;
	}
	return true;
  }

  public function getCMSFields() {
	$fields = new FieldList();
	$fields->add(new TabSet("Root"));
	if ($this->ID) {
	  $this->setTicketRead();
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Number"));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Status"));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Created"));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Divisi", "Division", $this->Division()->Title));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Kategori", "Category", $this->Category()->Title));
	}
	if ($this->MemberCreateID == Member::currentUserID()) {
	  $fields->addFieldToTab("Root.Main", new TextField("Title"));
	  $fields->addFieldToTab("Root.Main", new DropdownField("MemberID", "Customer", Member::get()->where("Type='CLIENT'")->map("ID", "FirstName"), null, null, "Select Customer"));
	  $fields->addFieldToTab("Root.Main", new TextField("Via", "Via (Ticket Opened by)"));
	  $fields->addFieldToTab("Root.Main", new HtmlEditorField("Content"));
	} else {
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Title"));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Member", "Customer", ""));
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Via", "Via (Ticket Opened by)"));
	  $fields->addFieldToTab("Root.Main", new HtmlEditorField_Readonly("Content"));
	}
	$responsegridfield = new GridField("Responses", "Responses", $this->Responses(), GridFieldConfig_RecordEditor::create());
	$fields->addFieldToTab("Root.Responses", $responsegridfield);
	$wogridfield = new GridField("WorkOrders", "Work Orders", $this->WorkOrders(), GridFieldConfig_RecordEditor::create());
	$fields->addFieldToTab("Root.WorkOrders", $wogridfield);
	return $fields;
  }

  function setTicketRead() {
	if (!$this->Read) {
	  $this->Read = 1;
	  $this->write();
	}
  }

  function getRandomNomor() {
	$hold_value = "1000000000";
	$random = rand(1, 9999999999);
	$start = strlen($hold_value) - strlen($random);
	$string = substr_replace($hold_value, $random, $start);
	$check_obj = self::get()->where("Number=$string")->limit(1)->first();
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
	if (!$this->MemberID) {
	  $this->MemberID = Member::currentUserID();
	}
	if (!$this->MemberCreateID) {
	  $this->MemberCreateID = Member::currentUserID();
	}
  }

  function getStatusLabel() {
	switch ($this->Status) {
	  case 'OPEN' : return "<span class='label label-danger'>" . $this->Status . "</span>";
	  case 'RESPONDED' : return "<span class='label label-info'>" . $this->Status . "</span>";
	  case 'PROGRESS' : return "<span class='label label-warning'>" . $this->Status . "</span>";
	  case 'CLOSED' : return "<span class='label label-success'>" . $this->Status . "</span>";
	}
  }

  function ViewLink() {
	return TicketPage::get()->limit(1)->first()->Link() . "view/" . $this->Number;
  }

  function CloseLink() {
	return TicketPage::get()->limit(1)->first()->Link() . "close/" . $this->Number;
  }

}
