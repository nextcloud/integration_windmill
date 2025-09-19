<?php

declare(strict_types=1);

use OCP\Util;

Util::addScript(OCA\Windmill\AppInfo\Application::APP_ID, OCA\Windmill\AppInfo\Application::APP_ID . '-main');
Util::addStyle(OCA\Windmill\AppInfo\Application::APP_ID, OCA\Windmill\AppInfo\Application::APP_ID . '-main');

?>

<div id="integration_windmill"></div>
