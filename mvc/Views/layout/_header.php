<?php
/**
 * @var \lib\View $this
 */
?>
<nav class="navbar navbar-inverse fixed-top bg-inverse">
    <a class="navbar-brand" href="/">Home</a>

    <?php if ($this->getUserDto()->isAuthorized()): ?>
        <div class="navbar-form navbar-right">
            <a href="/user/logout" class="btn btn-info mr5">Logout</a>
        </div>

    <?php else:?>
        <form class="navbar-form navbar-right" method="post" action="/user/login">
            <input class="form-control" type="text" name="login" placeholder="login">
            <input class="form-control" type="password" name="password" placeholder="Password">
            <button class="btn btn-info mr5" type="submit">Login</button>
        </form>
    <?php endif;?>
</nav>
