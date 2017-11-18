<?php
/**
 * @var array $jsScripts
 * @var array $cssScripts
 * @var \lib\View $this
 * @var string $viewContent
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Test project</title>
    <?php
        $this->renderPartial('layout/_scripts', [
            'jsScripts' => $jsScripts,
            'cssScripts' => $cssScripts,
        ]);
    ?>
</head>
<body>
    <?php $this->renderPartial('layout/_header'); ?>
    <div class="container">
        <?php echo $viewContent;?>
    </div>
</body>
</html>

