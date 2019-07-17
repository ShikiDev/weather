<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.07.2019
 * Time: 11:00
 */
?>
<div class="col-md">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $res->getDate('d.m'); ?></div>
        <?php if (is_object($res->getDataDecoded())): ?>
            <ul class="list-group">
                <?php foreach ($res->getDataDecoded() as $key => $elem): ?>
                    <li class="list-group-item"><?= $key; ?>:
                        <?= (count($elem) > 1) ? implode(' - ', $elem) : ((count($elem) == 1) ? $elem : '-'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
