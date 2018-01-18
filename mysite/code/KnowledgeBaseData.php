<?php

class KnowledgeBaseData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(200)',
	  'Content' => 'HTMLText',
	  'Status' => 'Varchar',
	  'URLSegment' => 'Varchar(100)'
  );
  static $has_one = array(
	  'Member' => 'Member'
  );
  static $many_many = array(
	  'Categories' => 'KnowledgeBaseCategoryData',
	  'Files' => 'File'
  );
  static $statuses = array(
	  'PENDING' => 'PENDING',
	  'APPROVED' => 'APPROVED',
	  'PUBLISHED' => 'PUBLISHED',
  );

  public function canView($member = null) {
	return true;
  }

  static function Search($params, $limit = 5, $offset = 0) {
	$sql = "SELECT DISTINCT KnowledgeBaseData.ID FROM KnowledgeBaseData"
			. " JOIN KnowledgeBaseData_Categories ON KnowledgeBaseData.ID=KnowledgeBaseData_Categories.KnowledgeBaseDataID";
	$sql .= " WHERE KnowledgeBaseData.ID>0";
	if (isset($params['search']) && $params['search']) {
	  $sql .= " AND KnowledgeBaseData.Title LIKE '%" . $params['search'] . "%'";
	  $sql .= " AND KnowledgeBaseData.Content LIKE '%" . $params['search'] . "%'";
	}
	if (isset($params['category']) && $params['category']) {
	  $sql .= " AND KnowledgeBaseData_Categories.BlogCategoryDataID = " . $params['category'] . "";
	}
	$sql .= " ORDER BY KnowledgeBaseData.Created ASC LIMIT $offset, $limit ";
	$arr_id = DB::query($sql)->column("ID");
	$where = sizeof($arr_id) ? "ID IN (" . implode(",", $arr_id) . ")" : "ID=0";
	return KnowledgeBaseData::get()->where($where);
  }

  public function getCMSFields() {
	$fields = new FieldList();
	$fields->add(new TabSet("Root"));
	$fields->addFieldToTab("Root.Main", new TextField("Title", "Title"));
	$status = new DropdownField("Status", "Status", self::$statuses);
	$status->setEmptyString("Select Status");
	if ($this->canChangeStatus()) {
	  $fields->addFieldToTab("Root.Main", $status);
	} else {
	  $fields->addFieldToTab("Root.Main", new ReadonlyField("Status", "Status"));
	}
	$listcategories = ListboxField::create("Categories", "Categories", KnowledgeBaseCategoryData::get()->map("ID", "Title")->toArray())->setMultiple(true);
	$listcategories->setDescription("Can select multiple categories");
	$fields->addFieldToTab("Root.Main", $listcategories);
	$fields->addFieldToTab("Root.Main", new HtmlEditorField("Content"));
	if ($this->CanEdit()) {
	  $fields->addFieldToTab("Root.Documents", new UploadField("Files"));
	} else {
	  $content = "<div><b>Documents : </b></div><p>";
	  foreach ($this->Files() as $row) {
		$content .= "<a href='" . $row->Filename . "'>" . $row->Name . "</a><br>";
	  }
	  $content .= "</p>";
	  $fields->addFieldToTab("Root.Main", new LiteralField("Dokumen", $content));
	}
	return $fields;
  }

  function canChangeStatus() {
	return true;
  }

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	$this->createURLSegment();
	$this->MemberID = Member::currentUserID();
  }

  function checkExistingURLSegment($url_segment) {
	$class_name = get_class($this);
	return (DataObject::get_one($class_name, "URLSegment='" . $url_segment . "' AND ID !=" . $this->ID));
  }

  function createURLSegment() {
	$class_name = get_class($this);
	// If there is no URLSegment set, generate one from Address
	if ((!$this->URLSegment || $this->URLSegment == $class_name) && $this->Title != $class_name) {
	  //if((!$this->URLSegment || $this->URLSegment == $class_name) && $this->Name != $class_name){
	  //$this->URLSegment = SiteTree::generateURLSegment($this->Address);
	  $segment = preg_replace('/[^A-Za-z0-9]+/', '-', $this->Title);
	  //$segment = preg_replace('/[^A-Za-z0-9]+/','-',$this->Name);
	  $segment = preg_replace('/-+/', '-', $segment);
	  $segment = strtolower($segment);
	  $segment = trim($segment);
	  $this->URLSegment = $segment;
	} else if ($this->isChanged('Title')) {
	  // Make sure the URLSegment is valid for use in a URL
	  $segment = preg_replace('/[^A-Za-z0-9]+/', '-', $this->Title);
	  //$segment = preg_replace('/[^A-Za-z0-9]+/','-',$this->Name);
	  $segment = preg_replace('/-+/', '-', $segment);
	  $segment = strtolower($segment);
	  $segment = trim($segment);

	  // If after sanitising there is no URLSegment, give it a reasonable default
	  if (!$segment) {
		$segment = strtolower($class_name) . "-$this->ID";
	  }
	  $this->URLSegment = $segment;
	}
	// Ensure that this object has a non-conflicting URLSegment value.
	$count = 2;
	while ($this->checkExistingURLSegment($this->URLSegment)) {
	  $this->URLSegment = preg_replace('/-[0-9]+$/', null, $this->URLSegment) . '-' . $count;
	  $count++;
	}
  }

  function ViewLink() {
	return KnowledgeBasePage::get()->limit(1)->first()->Link() . "view/" . $this->URLSegment;
  }

}
