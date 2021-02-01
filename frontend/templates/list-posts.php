<?
require_once('header.php');
?>
    <div class='posts'>
        <?foreach($posts as $post){ ?>
            <div class='post'>
                <hr/>
                <h3><?=$post['title']?></h3>
                <p><?= implode(' ', array_slice(explode(' ', strip_tags($post['content'])), 0, 10)); ?> <a href="<?= $this->base->url."/?id=".$post['id']; ?>">читать дальше...</a></p>
                <p>Комметариев : <?= $post['comments']; ?></p>
            </div>  
        <? } ?>
    </div>
<?
require_once('footer.php');
?>