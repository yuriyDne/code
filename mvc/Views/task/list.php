<?php
/**
 * @var \mvc\Dto\DataProvider $dataProvider
 * @var string $pagerBaseUrl
 * @var \mvc\Dto\View\TaskViewDto $taskView
 * @var \lib\View $this
 * @var string $paramSeparator
 */

use mvc\Enum\Repository\TaskField;

?>
<h3 class="m-3">Task list</h3>
<p>
    <a href="/task/form" class="btn btn-success">Add new task</a>
</p>
<?php if (empty($dataProvider->getData())):?>
    <?php $this->renderPartial('partials/alert', [
        'message' => 'No tasks yet',
        'type' => \mvc\Enum\Html\AlertType::INFO(),
    ])?>
<?php else:?>
<table class="table table-striped">
    <tr>
        <th>
            <a href="<?=$taskView->getOrderLink(TaskField::ID())?>">
                id
                <?=$taskView->getOrderArrow(TaskField::ID())?>
            </a>
        </th>
        <th>
            <a href="<?=$taskView->getOrderLink(TaskField::USER_NAME())?>">
                User name
                <?=$taskView->getOrderArrow(TaskField::USER_NAME())?>
            </a>
        </th>
        <th>
            <a href="<?=$taskView->getOrderLink(TaskField::EMAIL())?>">
                Email
                <?=$taskView->getOrderArrow(TaskField::EMAIL())?>
            </a>
        </th>
        <th>
            <a href="<?=$taskView->getOrderLink(TaskField::STATUS())?>">
                Status
                <?=$taskView->getOrderArrow(TaskField::STATUS())?>
            </a>
        </th>
        <th>Action</th>
    </tr>
    <?php /** @var \mvc\Dto\TaskDto $item */
    foreach($dataProvider->getData() as $item): ?>
        <tr>
            <td><?=$item->getId();?></td>
            <td><?=$item->getUserName();?></td>
            <td><?=$item->getEmail();?></td>
            <td><?=$item->getStatus()->getKey();?></td>
            <td>
                <a href="#"
                    class="js-task-in-list-preview"
                    data-user-name="<?=$item->getUserName();?>"
                    data-email="<?=$item->getEmail(); ?>"
                    data-status="<?=$item->getStatus()->getKey();?>"
                    data-description="<?=$item->getDescription()?>"
                    data-image="<?=$item->getImage();?>"
                >View</a>
                <?php if ($this->getUserDto()->isAuthorized()):?>
                    <a href="/task/form?id=<?=$item->getId();?>">Modify</a>
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php endif;?>
<?php
    $this->renderPartial('partials/pagination', [
        'pagerDto' => $taskView->getPagerDto(),
    ]);
?>