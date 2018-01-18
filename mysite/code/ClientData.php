<?php

class ClientData extends DataObject {

  static $db = array(
	  'Title' => 'Varchar(100)',
	  'Description' => 'Text',
	  'Website' => 'Varchar(100)'
  );
  static $has_one = array(
	  'Photo' => 'Image'
  );

}
