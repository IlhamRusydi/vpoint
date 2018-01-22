<?php

class BlogData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(100)',
	  'Content' => 'HTMLText',
	  'URLSegment' => 'Varchar(100)',
	  'Views' => 'Double'
  );
  static $has_one = array(
	  'Member' => 'Member',
	  'Photo' => 'Image'
  );
  static $many_many = array(
	  'Categories' => 'BlogCategoryData'
  );
  static $summary_fields = array(
	  'Photo.StripThumbnail' => 'Thumbnail',
	  'Title' => 'Title',
	  'Content.FirstParagraph' => 'Description',
	  'Views' => 'Views'
  );

  public function getCMSFields() {
	$fields = new FieldList();
	$fields->add(new TabSet("Root"));
	$fields->addFieldToTab("Root.Main", new TextField("Title", "Title"));
	$listcategories = ListboxField::create("Categories", "Categories", BlogCategoryData::get()->map("ID", "Title")->toArray())->setMultiple(true);
	$listcategories->setDescription("Can select multiple categories");
	$fields->addFieldToTab("Root.Main", $listcategories);
	$fields->addFieldToTab("Root.Main", new HtmlEditorField("Content"));
	$img_banner_fields = new UploadField('Photo', 'Thumbnail Image');
	$img_validator = new Upload_Validator();
	$img_validator->setAllowedMaxFileSize(1240 * 800);
	$img_banner_fields->setValidator($img_validator);
	$fields->addFieldToTab("Root.Main", $img_banner_fields);
	return $fields;
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

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	$this->createURLSegment();
	$this->MemberID = Member::currentUserID();
  }

  static function Search($params, $limit = 5, $offset = 0) {
	$sql = "SELECT DISTINCT BlogData.ID FROM BlogData"
			. " JOIN BlogData_Categories ON BlogData.ID=BlogData_Categories.BlogDataID"
			. " JOIN BlogCategoryData ON BlogCategoryData.ID=BlogData_Categories.BlogCategoryDataID";
	$sql .= " WHERE BlogData.ID>0";
	if (isset($params['search']) && $params['search']) {
	  $sql .= " AND (BlogData.Title LIKE '%" . $params['search'] . "%'";
	  $sql .= " OR BlogData.Content LIKE '%" . $params['search'] . "%')";
	}
	if (isset($params['category']) && $params['category']) {
	  $sql .= " AND BlogCategoryData.URLSegment = '" . $params['category'] . "'";
	}
	$sql .= " ORDER BY BlogData.Created ASC LIMIT $offset, $limit ";
	$arr_id = DB::query($sql)->column("ID");
	$where = sizeof($arr_id) ? "ID IN (" . implode(",", $arr_id) . ")" : "ID=0";
	return BlogData::get()->where($where);
  }

  function ViewLink() {
	return BlogPage::get()->limit(1)->first()->Link() . "view/" . $this->URLSegment;
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
