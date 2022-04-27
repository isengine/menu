<?php

namespace is\Masters\Modules\Isengine\Menu;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

$instance = $this->get('instance');
$sets = &$this->settings;

//echo print_r($this, 1);

//$this->eget('container')->addClass('new');
//$this->eget('container')->open(true);
//$this->eget('container')->close(true);
//$this->eget('container')->print();

//$this->eget('main-inner')->addContent('{lang}');
//$this->eget('sub-inner')->addContent('{lang}');

$this->build();
$this->print();

?>

<style>
nav div {
    display: block;
}
.parl {
    color: red;
}
</style>

<div class="<?= $instance; ?>">

    <p><?= $sets['key']; ?></p>

    <?php
        if (System::typeIterable($sets['array'])) {
    ?>
    <ul>
    <?php
        foreach ($sets['array'] as $item) {
    ?>
        <li><?= $item; ?></li>
    <?php
        }
        unset($item);
    ?>
    </ul>
    <?php
        }
    ?>

    <?php $this->block('block'); ?>

</div>
