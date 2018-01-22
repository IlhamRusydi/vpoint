<?php

class FAQData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(200)',
	  'Content' => 'HTMLText'
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

  static function Search($params, $limit = 10, $offset = 0) {
	$sql = "SELECT DISTINCT FAQData.ID FROM FAQData";
	$sql .= " WHERE FAQData.ID>0";
	if (isset($params['search']) && $params['search']) {
	  $sql .= " AND (FAQData.Title LIKE '%" . $params['search'] . "%'";
	  $sql .= " OR FAQData.Content LIKE '%" . $params['search'] . "%')";
	}
	$sql .= " ORDER BY FAQData.Created ASC LIMIT $offset, $limit ";
	$arr_id = DB::query($sql)->column("ID");
	$where = sizeof($arr_id) ? "ID IN (" . implode(",", $arr_id) . ")" : "ID=0";
	return FAQData::get()->where($where);
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

}
