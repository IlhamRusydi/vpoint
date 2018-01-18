<?php

class SliderImageData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(100)',
	  'Description' => 'Text',
	  'Content' => 'HTMLText'
  );
  static $has_one = array(
	  'Photo' => 'Image'
  );
  static $summary_fields = array(
	  'getThumbnail' => 'Image',
	  'Title' => 'Title'
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

  public function getCMSFields() {
	$fields = new FieldList();
	$fields->add(new TabSet("Root"));
	$fields->addFieldToTab("Root.Main", new TextField("Title", "Title"));
	$fields->addFieldToTab("Root.Main", new TextareaField("Description", "Description"));
	$img_field = new UploadField("Photo", "Photo");
	$fields->addFieldToTab("Root.Main", $img_field);
	$fields->addFieldToTab("Root.Main", new HtmlEditorField("Content"));
	return $fields;
  }

  function getThumbnail() {
	return $this->Photo()->CroppedImage(100, 50);
  }

}
