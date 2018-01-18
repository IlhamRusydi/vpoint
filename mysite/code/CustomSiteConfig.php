<?php

class CustomSiteConfig extends DataExtension {

  static $db = array(
	  'Address' => 'Text',
	  'EmailContact' => 'Varchar(100)',
	  'EmailFrom' => 'Varchar(100)',
	  'Phone' => 'Varchar',
	  'MapScript' => 'Text',
	  'ChatScript' => 'Text',
	  'GoogleAnalyticsScript' => 'Text'
  );
  static $has_one = array(
	  'Logo' => 'Image'
  );

  public function updateCMSFields(\FieldList $fields) {
	parent::updateCMSFields($fields);
	$socialgridfield = new GridField("Socials", "Social", SocialData::get(), GridFieldConfig_RecordEditor::create());
	$fields->addFieldToTab("Root.Social", $socialgridfield);
	$fields->removeByName("Access");
	$fields->removeByName("Theme");
	$fields->addFieldToTab("Root.Main", new UploadField("Logo"));
	$fields->addFieldToTab("Root.Main", new TextField("Phone", "Phone"));
	$fields->addFieldToTab("Root.Main", new TextareaField("Address", "Address"));
	$fields->addFieldToTab("Root.Main", new TextField("EmailContact", "Email Contact"));
	$fields->addFieldToTab("Root.Main", new TextField("EmailFrom", "Email From"));
	$fields->addFieldToTab("Root.Script", new TextareaField("ChatScript", "Chat Script"));
	$fields->addFieldToTab("Root.Script", new TextareaField("MapScript", "Map Script"));
	$fields->addFieldToTab("Root.Script", new TextareaField("GoogleAnalyticsScript", "Google Analytics Script"));
  }

}
