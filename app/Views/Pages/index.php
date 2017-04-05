<?php if($auth):?>
Your login: <?=$user->login?>
    <?php foreach ($users as $user):?>
        <p><?=$user->id?>: <?=$user->login?></p>
    <?php endforeach;?>
<?php else:?>
Авторизуйтесь!
<?php endif;?>
