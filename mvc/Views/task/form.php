<?php
/**
 * @var string $pageTitle;
 * @var array $textFields
 * @var \mvc\Dto\TaskDto $task
 */
?>
<h3><?=$pageTitle?></h3>

<form method="POST" action="?">
    <?php if ($task->getId()):?>
        <input type="hidden" name="id" value="<?=$task->getId();?>">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <?php foreach ($task->getStatus()::toArray() as $key => $value):?>
                    <option
                        value="<?=$value?>"
                        <?php if ($value === $task->getStatus()->getValue()):?>
                            selected="selected"
                        <?php endif;?>
                    ><?=$key?></option>
                <?php endforeach;?>
            </select>
        </div>
    <?php endif; ?>
    <?php foreach($textFields as $name => $field): ?>
        <?php $hasError = !empty($field['error']); ?>
        <div class="form-group<?=$hasError ? ' has-error' : '';?>">
            <label for="<?=$name?>"><?=$field['placeholder']?></label>
            <?php if ($name === 'description'):?>
                <textarea
                        class="form-control js-<?=$name?>"
                        name="<?=$name;?>"
                        placeholder="<?=$field['placeholder']?>"
                ><?=$field['value'];?></textarea>
            <?php else: ?>
                <input
                    type="text"
                    class="form-control js-<?=$name?>"
                    name="<?=$name;?>"
                    value="<?=$field['value'];?>"
                    placeholder="<?=$field['placeholder']?>"
                />
            <?php endif;?>
            <?php if($hasError):?>
                <div class="control-label">
                    <?=$field['error'];?>
                </div>
            <?php endif;?>
        </div>
    <?php endforeach;?>
    <div class="js-image-preview" style="display: <?=$task->getImage() ? 'block' : 'none';?>">
        <img src="<?=$task->getImage();?>">
        <input name="image" type="hidden" class="js-image-field">
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" placeholder="Select file" class="js-resize-image-file">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="#" class="js-task-preview">Preview</a>
</form>