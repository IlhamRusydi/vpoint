<?php

class MT {

  static function sendEmailSMTP($to, $subject, $arr_data = array(), $arr_template = array(), $cc = "", $bcc = "", $reply_to = "", $attachment = array()) {
	include_once "../PHPMailer/PHPMailerAutoload.php";
	$site_config = SiteConfig::current_site_config();
	SSViewer::set_theme(Config::inst()->get('SSViewer', 'theme'));
	Config::inst()->update('SSViewer', 'theme_enabled', true);

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->SMTPDebug = 2;
	//$mail->SMTPDebug = 2;
	$mail->Debugoutput = 'html';

	$mail->Host = $site_config->SMTPHost;
	$mail->SMTPAuth = true;
	$mail->Username = $site_config->SMTPUsername;
	$mail->Password = $site_config->SMTPPassword;
	$mail->SMTPSecure = 'ssl';
	$mail->Port = $site_config->SMTPPort;
	$mail->FromEmail = $site_config->FromEmail;
	$mail->FromName = $site_config->Title;

	if (sizeof($attachment)) {
	  $mail->addAttachment($attachment['path'], $attachment['name'], $attachment['encoding'], $attachment['type']);
	}

	$v = new ViewableData();
	$content = $v->renderWith($arr_template, $arr_data);
	//echo $content;die();

	$mail->clearAddresses();
	$mail->addAddress($to);
	if ($reply_to) {
	  $mail->addReplyTo($reply_to);
	}
	if ($cc) {
	  if (is_array($cc)) {
		foreach ($cc as $row_cc) {
		  $mail->addCC($row_cc);
		}
	  } else {
		$mail->addCC($cc);
	  }
	}
	if ($bcc) {
	  $mail->addBCC($bcc);
	} else {
	  //$mail->addBCC(self::$bcc_email);      
	}

	//var_dump($to);
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $content;

	if (!$mail->send()) {
	  echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
	  return 'Message could not be sent, check SMTP setting.';
	} else {
	  return true;
	}
  }

  static function sendEmailSS($to, $subject, $arr_data = array(), $arr_template = array(), $cc = "", $bcc = "", $reply_to = "") {
	$site_config = SiteConfig::current_site_config();
	SSViewer::set_theme(Config::inst()->get('SSViewer', 'theme'));
	Config::inst()->update('SSViewer', 'theme_enabled', true);

	$from = $site_config->EmailFrom;
	$to = $to;
	$email = new Email($from, $to, $subject);
	$email->addCustomHeader('From', "$site_config->Title <$site_config->EmailFrom>"); // custom email name    
	$email->populateTemplate($arr_data);
	$email->setTemplate($arr_template);
	if (is_array($cc)) {
	  $email->setCc(implode(',', $cc));
	} else {
	  $email->setCc($cc);
	}

	if ($bcc) {
	  $email->setBcc($bcc);
	} else {
	  $email->setBcc(self::$bcc_email);
	}
	$email->send();
  }

  static function sendEmail($to, $subject, $arr_data = array(), $arr_template = array(), $cc = "", $bcc = "", $reply_to = "", $attachment = array()) {
	if (self::$email_use_smtp) {
	  return self::sendEmailSMTP($to, $subject, $arr_data, $arr_template, $cc, $bcc, $reply_to, $attachment);
	} else {
	  return self::sendEmailSS($to, $subject, $arr_data, $arr_template, $cc, $bcc, $reply_to, $attachment);
	}
  }

  static function pagination($count = 0, $page_size = 1, $page = 1, $url = '', $variable = 'page') {
	//init
	$num_links = 3; // Number of "digit" links to show before/after the currently viewed page
	$total_page = 1;
	if ($count > 0) {
	  $total_page = ceil($count / $page_size);
	}

	$html = '';
	if ($total_page > 1) {
	  //first button
	  if ($page > ($num_links + 1)) {
		$url_temp = Controller::join_links($url, "?$variable=1");
		$html = $html . ' <li class="page-item"><a class="page-link" href="' . $url_temp . '" data-page="1"><< First</a></li> ';
	  }
	  //prev button
	  if ($page > 1) {
		$url_temp = Controller::join_links($url, "?$variable=" . ($page - 1));
		$html = $html . ' <li class="page-item"><a class="page-link" href="' . $url_temp . '" data-page="' . ($page - 1) . '">Prev</a></li> ';
	  }
	  //start & end
	  $start = (($page - $num_links) > 0) ? ($page - $num_links) : 1;
	  $end = (($page + $num_links) > $total_page) ? $total_page : ($page + $num_links);
	  //render digit
	  for ($i = $start; $i <= $end; $i++) {
		$url_temp = Controller::join_links($url, "?$variable=" . $i);
		($page == $i) ? $class = 'class="page-item active"' : $class = 'class="page-item"';
		$html .= ' <li ' . $class . '><a href="' . $url_temp . '" class="page-link" data-page="' . ($i) . '">' . $i . '</a></li> ';
	  }
	  //next button
	  if ($page < $total_page) {
		$url_temp = Controller::join_links($url, "?$variable=" . ($page + 1));
		$html .= ' <li class="page-item"><a class="page-link" href="' . $url_temp . '" data-page="' . ($page + 1) . '">Next</a></li> ';
	  }
	  //last button
	  if (($page + $num_links) < $total_page) {
		$url_temp = Controller::join_links($url, "?$variable=" . $total_page);
		$html = $html . ' <li class="page-item"><a class="page-link" href="' . $url_temp . '" data-page="' . ($total_page) . '">Last</a></li> ';
	  }
	}
	return '<nav class="text-xs-right"><ul class="pagination">' . $html . '</ul></nav>';
  }

}
