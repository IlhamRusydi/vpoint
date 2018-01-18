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
	$name->addHolderClass("col-sm-6 breaking");
	$name->addExtraClass("form-control");
	$name->setHolderAttribute("style", "padding-left:0px");
	$fields->push($name);

	$email = new TextField("Email", "");
	$email->addPlaceholder("Email");
	$email->addHolderClass("col-sm-6 breaking");
	$email->addExtraClass("form-control");
	$email->setHolderAttribute("style", "padding-right:0px");
	$fields->push($email);

	$phone = new TextField("Phone", "");
	$phone->addPlaceholder("Phone");
	$phone->addHolderClass("col-sm-6 breaking");
	$phone->addExtraClass("form-control");
	$phone->setHolderAttribute("style", "padding-left:0px");
	$fields->push($phone);

	$subject = new TextField("Subject", "");
	$subject->addPlaceholder("Subject");
	$subject->addHolderClass("col-sm-6 breaking");
	$subject->addExtraClass("form-control");
	$subject->setHolderAttribute("style", "padding-right:0px");
	$fields->push($subject);

	$message = new TextareaField('Message', '', '');
	$message->addPlaceholder("Message");
	$fields->push($message);

	$spam_code = new TextField('CaptchaField', '');
	$spam_code->addPlaceholder("Spam Code");
	$spam_code->addHolderClass("col-sm-6 breaking");
	$spam_code->setAttribute("class", "form-control");
	$spam_code->setHolderAttribute("style", "padding-left:0px");
	$fields->push($spam_code);
	$capctha = new LiteralField('CaptchaCode', '<div class="form-group col-sm-6 breaking">
        <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image"/>
        </div>');
	$fields->push($capctha);

	$button = new FormAction('DoContactForm', 'Send');
	$button->addHolderClass("breaking col-md-12");
	$button->addExtraClass("btn btn-primary");

	$action = new FieldList(
			$button
	);

	$validator = new RequiredFields('Name', 'Email', 'Message');
	$form = new BootstrapForm($this, 'ContactForm', $fields, $action, $validator);
	$form->setGridActionClass("col-md-12");
	return $form;
  }

  function DoContactForm($data, $form) {
	$valid = true;

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
	//$data['Subject'] = $subject;
	MT::sendEmail($site_config->EmailContact, $subject, $data, array("EmailContact"), "");
	$form->sessionMessage('Your message was sent from ' . $data['Email'], 'alert alert-warning');
	$this->redirect($this->Link() . 'emailsent');
  }

  function emailsent() {
	$form = $this->ContactForm();
	return array(
		'Title' => 'Email Sent',
		'MetaTitle' => 'Email Sent',
		'ContactForm' => $form,
		'Content' => $this->ContactDesc . '<div class="message success alert alert-success" role="alert">' . nl2br($this->SuccessMessage) . '</div>'
	);
  }

}
