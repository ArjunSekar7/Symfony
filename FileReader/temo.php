<?php

$msg = "First line of text\nSecond line of text";

$msg = wordwrap($msg,70);

mail("arjun.sekar@aspiresys.com","My subject",$msg);
?> 