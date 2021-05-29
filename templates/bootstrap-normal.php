<?php

namespace is\Masters\Modules\Isengine\Menu;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

$object -> eget('main-link-dropdown') -> addCustom('id', 'navbarDropdown-{id}');
$object -> eget('main-link-dropdown') -> addCustom('role', 'button');
$object -> eget('main-link-dropdown') -> addCustom('data-bs-toggle', 'dropdown');
$object -> eget('main-link-dropdown') -> addCustom('aria-expanded', 'false');

$object -> eget('sub-link-dropdown')  -> addCustom('id', 'navbarDropdown-{id}');
$object -> eget('sub-link-dropdown')  -> addCustom('role', 'button');
$object -> eget('sub-link-dropdown')  -> addCustom('data-bs-toggle', 'dropdown');
$object -> eget('sub-link-dropdown')  -> addCustom('aria-expanded', 'false');

$object -> eget('sub-container')      -> addCustom('aria-labelledby', 'navbarDropdown-{id}');

$object -> build();
$object -> print();

?>