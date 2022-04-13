<?php
require('../Controllers/ContactController.php');
$contacts = new ContactController();
$contacts->delete();
