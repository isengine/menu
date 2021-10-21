<?php

namespace is\Masters\Modules\Isengine\Menu;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

$inner = [
	'<a class="',
	'" href="{link}">{lang}</a>
	<a class="dropdown dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
		<span class="visually-hidden">Toggle Dropdown</span>
	</a>'
];

$this -> eget('main-link') -> addContent('{lang}');
$this -> eget('sub-link') -> addContent('{lang}');

$this -> eget('main-item-dropdown') -> addContent($inner[0] . 'nav-link' . $inner[1]);
$this -> eget('sub-item-dropdown') -> addContent($inner[0] . 'dropdown-item' . $inner[1]);

$this -> build();
$this -> print();

?>