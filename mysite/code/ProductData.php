<?php

class ProductData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(100)',
	  'Content' => 'HTMLText',
	  'DemoURL' => 'Varchar(100)',
	  'URLSegment' => 'Varchar(100)',
	  'Price' => 'Double',
  );
  static $has_one = array(
	  'Photo' => 'Image'
  );
  static $many_many = array(
	  'Photos' => 'Image'
  );
  static $summary_fields = array(
	  'Photo.StripThumbnail' => 'Product',
	  'Title' => 'Product Name',
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

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	$this->createURLSegment();
  }

  public function getCMSFields() {
	$fields = new FieldList();
	$fields->add(new TabSet("Root"));
	$fields->addFieldToTab("Root.Main", new TextField("Title", "Title"));
	$url_video = new TextField("DemoURL", "URL Video");
	$url_video->setDescription("URL Video Streaming");
	$fields->addFieldToTab("Root.Main", $url_video);
	$fields->addFieldToTab("Root.Main", new NumericField("Price", "Price"));
	$img_validator = new Upload_Validator();
	$img_validator->setAllowedMaxFileSize(1240 * 800);
	$photo = new UploadField("Photo");
	$photo->setValidator($img_validator);
	$fields->addFieldToTab("Root.Main", $photo);
	$fields->addFieldToTab("Root.Main", new HtmlEditorField("Content"));
	$photos = new UploadField("Photos");
	$photos->setValidator($img_validator);
	$fields->addFieldToTab("Root.Photos", $photos);
	return $fields;
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

  function checkExistingURLSegment($url_segment) {
	$class_name = get_class($this);
	return (DataObject::get_one($class_name, "URLSegment='" . $url_segment . "' AND ID !=" . $this->ID));
  }

  function ViewLink() {
	return ProductPage::get()->limit(1)->first()->Link() . "view/" . $this->URLSegment;
  }

}
