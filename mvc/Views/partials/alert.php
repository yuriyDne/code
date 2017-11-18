<?php
/**
 * @var \mvc\Enum\Html\AlertType $type
 * @var string $message
 */
?>
<div class="alert <?=$type->getValue()?>">
  <?=$message;?>
</div>