<?php

namespace is\Masters\Modules\Isengine\Menu;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

$inner = [
	'
	<a class="nav-link" href="{link}">{lang}</a>
	<a class="dropdown-toggle dropdown-toggle-split" data-bs-toggle="collapse" data-bs-target="#navbar-sub-{id}" aria-controls="navbar-sub-{id}" aria-expanded="',
	'" aria-label="Toggle navigation">
		<span class="visually-hidden">Toggle Dropdown</span>
	</a>'
];

$object -> eget('main-link') -> addContent('{lang}');
$object -> eget('sub-link') -> addContent('{lang}');

$object -> eget('sub-wrapper') -> addId('navbar-sub-{id}');

$object -> eget('main-link-dropdown') -> addContent($inner[0] . 'true' . $inner[1]);
$object -> eget('sub-link-dropdown') -> addContent($inner[0] . 'true' . $inner[1]);

$object -> eget('main-link-dropdown-active') -> addContent($inner[0] . 'false' . $inner[1]);
$object -> eget('sub-link-dropdown-active') -> addContent($inner[0] . 'false' . $inner[1]);

$object -> build();
$object -> print();

?>