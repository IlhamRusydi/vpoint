<?php

class BlogAdmin extends ModelAdmin {

  private static $managed_models = array(
	  'BlogData' => array('title' => 'Blog'),
	  'BlogCategoryData' => array('title' => 'Category'),
  );
  private static $url_segment = 'blog';
  private static $menu_title = 'Blog';

}

class KnowledgeBaseAdmin extends ModelAdmin {

  private static $managed_models = array(
	  'KnowledgeBaseData' => array('title' => 'Knowledge Base'),
	  'KnowledgeBaseCategoryData' => array('title' => 'Category'),
  );
  private static $url_segment = 'knowledgebase';
  private static $menu_title = 'Knowledge Base';

}

class ProductAdmin extends ModelAdmin {

  private static $managed_models = array(
	  'ProductData' => array('title' => 'Product'),
  );
  private static $url_segment = 'product';
  private static $menu_title = 'Product';

}

class FAQAdmin extends ModelAdmin {

  private static $managed_models = array(
	  'FAQData' => array('title' => 'F.A.Q'),
  );
  private static $url_segment = 'faq';
  private static $menu_title = 'FAQ';

}

class ClientAdmin extends ModelAdmin {

  private static $managed_models = array(
	  'ClientData' => array('title' => 'Client'),
  );
  private static $url_segment = 'client';
  private static $menu_title = 'Client';

}

class TicketAdmin extends ModelAdmin {

  private static $managed_models = array(
	  'TicketData' => array('title' => 'Ticket'),
	  'DivisionData' => array('title' => 'Division')
  );
  private static $url_segment = 'ticket';
  private static $menu_title = 'Ticket';

}

class WorkOrderAdmin extends ModelAdmin {

  private static $managed_models = array(
	  'WorkOrderData' => array('title' => 'Work Order')
  );
  private static $url_segment = 'work-order';
  private static $menu_title = 'Work Order';

  public function getList() {
	$list = parent::getList();
	return $list->where("MemberID = " . Member::currentUserID());
  }

}

class NotificationAdmin extends ModelAdmin {

  static $menu_priority = 1000;
  private static $managed_models = array(
	  'NotificationData' => array('title' => 'Notification')
  );
  private static $url_segment = 'notification';
  private static $menu_title = 'Notification';

  public function getList() {
	$list = parent::getList();
	return $list->where("MemberToID = " . Member::currentUserID() . " AND NotificationData.Read=0")->sort("Created DESC");
  }

}
