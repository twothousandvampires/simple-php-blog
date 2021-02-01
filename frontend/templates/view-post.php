<?
	require_once('header.php');
?>
<div class = 'viewPostContainer'>
	<a href="<?= $this->base->url; ?>">Назад</a>

	<? foreach ($posts as $post){?>

	<h3><?= htmlspecialchars($post['title']);?></h3>
	<p><?= htmlspecialchars($post['content']); ?></p>
	<hr/>

	<?}?>

<? foreach($postComments as $comment){?>
	<div class = 'comment'>
		<div class = 'commentName'>
			<figure>
				<img src="http://www.gravatar.com/avatar/<?= md5($comment['email']);?>" alt="">
			</figure>	
			<h4><?= htmlspecialchars($comment['name']); ?></h4>			
		</div>
		<section class = 'commentContent'>
			<p><?= htmlspecialchars($comment['context']); ?></p>
		</section>	
	</div>
	<hr/>
<?}?>

<h3>Оставить комментрий</h3>
<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	<input type="hidden" value="<?=$id?>" name="postid" />
    <div>
    	<input type="text" name="name" placeholder="Ваше имя"/>
    </div>
    <div>	
    	<input type="email" name="email" placeholder="Ваш email"/>
	</div>
    <div>
    	<textarea name="context" cols='100' rows='10'></textarea>
    </div>
    <div>
    	<button type="submit">Подтвердить</button>
	</div>
</form>
<?
require_once('footer.php');
?>