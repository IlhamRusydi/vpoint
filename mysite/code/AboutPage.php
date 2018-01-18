<?php

class AboutPage extends Page {

  static $db = array(
	  'SubTitle' => 'Varchar(200)'
  );

  function requireDefaultRecords() {
	if (!DataObject::get_one('AboutPage')) {
	  $page = new AboutPage();
	  $page->Title = 'About';
	  $page->URLSegment = 'about-us';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('AboutPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

  public function getCMSFields() {
	$fields = parent::getCMSFields();
	$config = GridFieldConfig_RecordEditor::create();
	$gridAbout = new GridField(
			'AboutUs', // Field name
			'About Us', // Field title
			AboutData::get(), // List of all related slide
			$config
	);
	$fields->addFieldToTab("Root.About", $gridAbout);
	$fields->insertAfter("Title", new TextField("SubTitle", "Sub Title"));
	return $fields;
  }

}

class AboutPage_Controller extends Page_Controller {

  function getAboutData() {
	return AboutData::get();
  }

  function index() {
	$id = $this->request->param("ID");
	$obj = AboutData::get()->where("URLSegment = '$id'")->limit(1)->first();
	return $this->customise(array(
				'Title' => $obj ? $obj->Title : $this->Title,
				'Data' => $obj
	));
  }

}
