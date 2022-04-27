<?php

namespace is\Masters\Modules\Isengine\Menu;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

use is\Masters\View;

$sets = &$this->settings;

$sets_original = json_encode([
    'custom'  => $sets['custom'],
    'disable' => $sets['disable'],
    'levels'  => $sets['levels']
]);

$instance = $this->get('instance');

$view = View::getInstance();

?>
<nav class="navbar navbar-expand-md navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><?= $view->get('lang|title'); ?></a>
        <a class="btn d-md-none" data-bs-toggle="offcanvas" href="#offcanvasMenu<?= $instance; ?>" role="button" aria-controls="offcanvasMenu<?= $instance; ?>">
            <span class="navbar-toggler-icon"></span>
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <?php $view->get('module')->launch('menu', 'bootstrap-normal', $sets_original); ?>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu<?= $instance; ?>" aria-labelledby="offcanvasMenu<?= $instance; ?>Label">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenu<?= $instance; ?>Label"><?= $view->get('lang|title'); ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php $view->get('module')->launch('menu', 'bootstrap-offcanvas', $sets_original); ?>
    </div>
</div>