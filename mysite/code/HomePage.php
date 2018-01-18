<?php

class HomePage extends Page {

  static $db = array(
	  'Description' => 'Text'
  );

  function requireDefaultRecords() {
	if (!DataObject::get_one('HomePage')) {
	  $page = new HomePage();
	  $page->Title = 'Home';
	  $page->URLSegment = 'home';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('HomePage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

  public function getCMSFields() {
	$fields = parent::getCMSFields();
	$fields->insertBefore("Content", new TextareaField("Description"));
	$config = GridFieldConfig_RecordEditor::create();
	$gridfieldSlideImage = new GridField(
			'SliderImageData', // Field name
			'Slide Images', // Field title
			SliderImageData::get(), // List of all related slide
			$config
	);
	$fields->addFieldToTab("Root.SlideImage", $gridfieldSlideImage);
	return $fields;
  }

}

class HomePage_Controller extends Page_Controller {

  function getSliderImageData() {
	return SliderImageData::get();
  }

  function getLatestBlogData() {
	return BlogData::get()->limit(2)->sort('Created DESC');
  }

  function getLatestKnowledgeBaseData() {
	return KnowledgeBaseData::get()->limit(5)->sort('Created DESC');
  }

}
