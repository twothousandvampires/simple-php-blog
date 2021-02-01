<?php require_once('adminheader.php'); ?>
	<form action="<?= $this->base->url.'/admin/posts.php?action=save'; ?>" method="POST">
		<section id = 'newPost'>
			<h3>Новый пост</h3>
			<div>
		    	<div class = 'newPostElem'>
		    		<input type="text" maxlength="100" name="title" id="title" placeholder="Заголовок" />
		    	</div>
		    </div>
		    <div >
			    <div class = 'newPostElem'>
				    <textarea cols = '100' rows ='10' name="content"></textarea>
				</div>
		    </div>
		    <div >
		    	<div class = 'newPostElem'>
		    		<button type="submit">Сохранить пост</button>
		    	</div>
		    </div>
		</section>
	</form>
<?require_once('adminFooter.php')?>