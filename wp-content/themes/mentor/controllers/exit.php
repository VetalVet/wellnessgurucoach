<?php

	/*
   	Template Name: Exit admin panel
   */

// setcookie('user', $user['f_name'], time() - 3600, "/");
setcookie("id", $info["id"], time() - 3600, '/', NULL);
setcookie("sess", $info["session"], time() - 3600, '/', NULL);
header('Location: /');