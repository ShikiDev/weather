<div class="col-md-2">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $res->getDate('d.m');?></div>
        <?php if(is_object($res->getDataDecoded())):?>
        <ul class="list-group">
            <?php foreach($res->getDataDecoded() as $key => $elem):?>
            <li class="list-group-item"><?= $key; ?>:
                <?= (count($elem) > 1) ? implode(' - ', $elem) : ((count($elem) == 1) ? $elem : '-'); ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>