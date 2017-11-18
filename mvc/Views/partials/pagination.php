<?php
/**
 * @var \mvc\Dto\Html\PagerDto $pagerDto
 */

$dataProvider = $pagerDto->getDataProvider();
$paramSeparator = $pagerDto->getPagerParamSeparator();
$pagerBaseUrl = $pagerDto->getBaseUrl();
?>
<?php if ($dataProvider->getTotalPages() > 1):?>
<ul class='pager list-inline'>
    <?php foreach($dataProvider->getPages() as $page):?>
        <li class='list-inline-item'>
            <?php if ($dataProvider->isCurrentPage($page)):?>
                <span><?=$page;?></span>
            <?php else: ?>
                <a href="<?=$pagerBaseUrl.$paramSeparator."page=$page"?>"><?=$page;?></a>
            <?php endif;?>
        </li>
    <?php endforeach;?>
</ul>
<?php endif;?>
