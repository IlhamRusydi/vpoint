<?php

class ContactPage extends Page {

  function requireDefaultRecords() {
	if (!DataObject::get_one('ContactPage')) {
	  $page = new ContactPage();
	  $page->Title = 'Contact';
	  $page->URLSegment = 'contact-us';
	  $page->Status = 'Published';
	  $page->write();
	  $page->publish('Stage', 'Live');
	  $page->flushCache();
	  DB::alteration_message('ContactPage created on page tree', 'created');
	}
	parent::requireDefaultRecords();
  }

}

class ContactPage_Controller extends Page_Controller {

  static $allowed_actions = array(
	  'emailsent',
	  'ContactForm'
  );

  public function ContactForm() {
	$fields = new FieldList();
	$name = new TextField("Name", "");
	$name->addPlaceholder("Name", "");
	$name->addExtraClass("form-control");
	$fields->push($name);

	$email = new TextField("Email", "");
	$email->addPlaceholder("Email");
	$email->addExtraClass("form-control");
	$fields->push($email);


	$subject = new TextField("Subject", "");
	$subject->addPlaceholder("Subject");
	$subject->addExtraClass("form-control");
	$fields->push($subject);

	$message = new TextareaField('Message', '', '');
	$message->addPlaceholder("Message");
	$fields->push($message);

	$capctha = new LiteralField('CaptchaCode', '<div class="form-group">
        <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image"/>
        </div>');
	$fields->push($capctha);

	$spam_code = new TextField('CaptchaField', '');
	$spam_code->addPlaceholder("Spam Code");
	$spam_code->setAttribute("class", "form-control");
	$fields->push($spam_code);

	$button = new FormAction('DoContactForm', 'Send');
	$button->addHolderClass("col-md-12");
	$button->addExtraClass("btn btn-primary");

	$action = new FieldList(
			$button
	);

	$validator = new RequiredFields('Name', 'Email', 'Message');
	$form = new BootstrapForm($this, 'ContactForm', $fields, $action, $validator);
	return $form;
  }

  function DoContactForm($data, $form) {
	$valid = true;
	include_once "../securimage/securimage.php";
	$securimage = new Securimage();
	if ($securimage->check($_POST['CaptchaField']) == false) {
	  $form->addErrorMessage("CaptchaField", 'The security code entered was incorrect.', "bad");
	  //<script>alert("The security code entered was incorrect.");</script>
	  $valid = false;
	}

	if ($valid == false) {
	  //Session::set("FormInfo.Form_ContactForm.data", $data);
	  Session::set("FormInfo.BootstrapForm_ContactForm.data", $data);
	  $this->redirectBack();
	  return;
	}

	$site_config = SiteConfig::current_site_config();

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	  $ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	  $ip = $_SERVER['REMOTE_ADDR'];
	}
	$subject = '[' . $site_config->Title . '] Email From ' . $data['Name'];
	$data['VisitorIP'] = $ip;
	$data['Message'] = nl2br($data['Message']);
	$data['Subject'] = $subject;
	MT::sendEmail($site_config->EmailContact, $subject, $data, array("EmailContact"), "");
	$form->sessionMessage('Your message was sent from ' . $data['Email'], 'ok');
	$this->redirectBack();
  }

}
