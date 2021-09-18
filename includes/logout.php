<?php

setcookie("Token", "", time() - 3600, "/");

header("Location: /");