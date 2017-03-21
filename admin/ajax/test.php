<?php
echo ini_get("session.gc_maxlifetime");
ini_set('session.gc_maxlifetime', 5356800);
session_set_cookie_params(5356800);
echo ini_get("session.gc_maxlifetime");
?>