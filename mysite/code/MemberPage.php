<?php

class MemberPage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('MemberPage')) {
	  $page = new MemberPage();
	  $page->Title = 'Member';
	  $page->URLSegment = 'member';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('MemberPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class MemberPage_Controller extends Page_Controller {
  
}
