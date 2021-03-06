<!doctype html>
<link rel="stylesheet" href="style.css">

<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "Storage.php";
    $storage = new Storage();

    include "DB.php";
    $db = new DB();

    $comments = &$db->getTable();

    if (array_key_exists('remove', $_GET)) {
        $storage->remove($_GET['remove']);
    }
    elseif (
        array_key_exists('message', $_POST) &&
        array_key_exists('name', $_POST)
    ) {
        $db->addEntry([
            'name' => $_POST['name'],
            'message' => $_POST['message']
        ]);
    }

?>

<div id="app">
    <section class="comments">
    <h1>Comments</h1>
    <form class="comments__form" action="/comments/" method="post">
        <div class="form_block">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
        </div>

        <div class="form_block">
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="7"></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>

    <div class="comments__entries">
        <?php foreach ($comments as $id => $comment): ?>
           <div class="comment" data-id="<?= $id; ?>">
                <?php $d = new DateTime(@$comment['time']); ?>
                <span class="name"><?=@$comment['name']; ?></span>
                <span class="time"><?=$d->format('d.m.Y H:i'); ?></span>
                <pre><?=@$comment['message']; ?></pre>
                <a class="remove" href="?remove=<?= $id; ?>">x</a>
                <a class="update" href="update.php?id=<?= $id; ?>">edit</a>
           </div>
        <?php endforeach; ?>
    </div>
    </section>
</div>
