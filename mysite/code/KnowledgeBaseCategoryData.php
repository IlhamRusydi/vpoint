<?php

class KnowledgeBaseCategoryData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(100)',
	  'URLSegment' => 'Varchar(100)'
  );
  static $belongs_many_many = array(
	  'KnowledgeBases' => 'KnowledgeBaseData'
  );

  protected function onBeforeWrite() {
	parent::onBeforeWrite();
	$this->createURLSegment();
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

  public function getCMSFields() {
	$fields = parent::getCMSFields();
	$fields->removeByName("URLSegment");
	return $fields;
  }

}
