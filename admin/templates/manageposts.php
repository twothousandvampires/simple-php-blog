<? require_once('adminheader.php'); ?>
	<div class = 'adminMenu'>
		<p class = 'scalable' ><a  href="<?= $this->base->url.'/admin/posts.php?action=create'; ?>">Создать пост</a></p>
		<p class = 'scalable'><a href="<?= $this->base->url.'/admin/comments.php'; ?>" >Комментарии</a></p>
		<p class = 'scalable'><a href="<?= $this->base->url; ?>">Посты</a></p>
	</div>
	
	<table>		
		<tr>
			<td class = 'titleTD'>Заголовок поста</td>
			<td>Содержимое поста</td>
			<td>Действия</td>
		</tr>
				
	<?php foreach($posts as $post){ ?>
		<tr>
			<td><h4><?= (!empty($post['title']) ? htmlspecialchars($post['title']): 'Post #'.htmlspecialchars($post['id'])); ?></h3></td>
			<td><p><?= implode(' ', array_slice(explode(' ', strip_tags($post['content'])), 0, 10)); ?> [...]</p></td>
			<td class = 'actionButtom'><a class= 'scalable' href="<?= $this->base->url."/admin/posts.php?id=".$post['id']."&action=edit"; ?>">Редактировать</a><a  class= 'scalable'href="<?=$this->base->url."/admin/posts.php?id=".$post['id']."&action=delete"; ?>">Удалить</a></td>
		</tr>
	<? } ?>		
	</table>
<? 
require_once('adminFooter.php');
 ?>