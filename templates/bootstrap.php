<?php

namespace is\Masters\Modules\Isengine\Menu;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

use is\Masters\View;

$sets = &$object -> settings;

$sets_original = json_encode([
	'custom'  => $sets['custom'],
	'disable' => $sets['disable'],
	'levels'  => $sets['levels']
]);

$instance = $object -> get('instance');

$view = View::getInstance();

?>
<nav class="navbar navbar-expand-md navbar-light">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">Navbar</a>
		<a class="btn d-md-none" data-bs-toggle="offcanvas" href="#offcanvasMenu<?= $instance; ?>" role="button" aria-controls="offcanvasMenu<?= $instance; ?>">
			<span class="navbar-toggler-icon"></span>
		</a>
		<div class="collapse navbar-collapse">
			<?php $view -> get('module') -> launch('menu', 'bootstrap-normal', $sets_original); ?>
		</div>
	</div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu<?= $instance; ?>" aria-labelledby="offcanvasMenu<?= $instance; ?>Label">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="offcanvasMenu<?= $instance; ?>Label">Navbar</h5>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<?php $view -> get('module') -> launch('menu', 'bootstrap-offcanvas', $sets_original); ?>
	</div>
</div>

<style>
.offcanvas .dropdown-toggle[aria-expanded="true"] {
    transform: rotateZ(-180deg);
    transition: transform 0.5s ease;
}
.offcanvas .dropdown-toggle {
    transform: rotateZ(0deg);
    transition: transform 0.5s ease;
    cursor: pointer;
}
</style>