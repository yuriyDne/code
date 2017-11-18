<?php
/**
 * @var $errorMessage
 * @var $login
 */
?>
<form class="form-signin" method="post" action="?">
    <h2 class="form-signin-heading">Please Log in</h2>
    <?php if ($errorMessage):?>
        <?php $this->renderPartial('partials/alert', [
            'message' => $errorMessage,
            'type' => \mvc\Enum\Html\AlertType::DANGER(),
        ])?>
    <?php endif;?>
    <p>
        <label for="inputLogin" class="sr-only">Email address</label>
        <input
            type="login"
            id="inputLogin"
            name="login"
            class="form-control"
            placeholder="Logi"
            required="1"
            value="<?=$login;?>"
        >
    </p>
    <p>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required="">

    </p>
    <p>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
    </p>
</form>