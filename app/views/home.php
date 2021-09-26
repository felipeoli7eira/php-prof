<h1>Users</h1>

<ul>
    <?php foreach($users as $index => $user): ?>
        <li>
            <?= $user->name ?> | <a href="/user/<?= $user->id ?>/">detalhes</a>
        </li>
    <?php endforeach ?>
</ul>