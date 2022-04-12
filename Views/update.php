<?php
require('../Controllers/ContactController.php');
$contacts = new ContactController();
$data = $contacts->update();
