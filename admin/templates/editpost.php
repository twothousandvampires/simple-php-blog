<?require_once('adminheader.php')?>

<form action="<?= $this->base->url.'/admin/posts.php?action=edit'; ?>" method="POST">
    <section id = 'newPost'>
        <h3 class = 'newPostElem'>Редактировать пост</h3>
        <div class = 'newPostElem'>
            <div>
                <input type='hidden' name ='id' value = '<?=$post['id']?>'>
                <input type="text" name="title" id="title" value='<?=$post['title']?>' placeholder="Заголовок" />
            </div>
        </div>
        <div class = 'newPostElem'>
            <textarea name="content" cols = '100' rows = '10'><?=$post['content']?></textarea>
        </div>
        <div class = 'newPostElem'>
            <button type="submit">Подтвердить</button>
        </div>
    </section>
</form>
<?require_once('adminFooter.php')?>