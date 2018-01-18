<?php

class Page extends SiteTree {

  private static $db = array(
  );
  private static $has_one = array(
  );

}

class Page_Controller extends ContentController {

  /**
   * An array of actions that can be accessed via a request. Each array element should be an action name, and the
   * permissions or conditions required to allow the user to access it.
   *
   * <code>
   * array (
   *     'action', // anyone can access this action
   *     'action' => true, // same as above
   *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
   *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
   * );
   * </code>
   *
   * @var array
   */
  private static $allowed_actions = array(
  );

  public function init() {
	parent::init();
	// You can include any CSS or JS required by your project here.
	// See: http://doc.silverstripe.org/framework/en/reference/requirements
	Requirements::block(BOOTSTRAP_FORMS_DIR . '/javascript/bootstrap_forms.js');
  }

  function getUserLogged() {
	return Member::currentUser();
  }

  function getClientData() {
	return ClientData::get();
  }

  function getSocialData() {
	return SocialData::get();
  }

  function getProductData() {
	return ProductData::get();
  }

  function getBlogCategoryData() {
	return BlogCategoryData::get();
  }

  function getOneMemberPage() {
	return MemberPage::get()->limit(1)->first();
  }

  function getOneBlogPage() {
	return BlogPage::get()->limit(1)->first();
  }

  function getOneAboutPage() {
	return AboutPage::get()->limit(1)->first();
  }

  function getOneTicketPage() {
	return TicketPage::get()->limit(1)->first();
  }

  function getOneFAQPage() {
	return FAQPage::get()->limit(1)->first();
  }

  function getOneProductPage() {
	return ProductPage::get()->limit(1)->first();
  }

  function getOneContactPage() {
	return ContactPage::get()->limit(1)->first();
  }

  function getOneKnowledgeBasePage() {
	return KnowledgeBasePage::get()->limit(1)->first();
  }

}
