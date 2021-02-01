<?php require_once('adminheader.php'); ?>
	<div class = 'adminMenu'>
		<p><a href="<?= $this->base->url.'/admin/posts.php?action=create'; ?>">Создать пост</a></p>
		<p><a href="<?= $this->base->url.'/admin/comments.php'; ?>">Комментарии</a></p>
		<p><a href="<?= $this->base->url.'/admin/posts.php'; ?>" >Посты</a></p>
	</div>
	<table>
		<tr>
				<td>Комментатор</td>
				<td>ID поста</td>
				<td>Комментарии</td>
				<td>Действия</td>
		</tr>
			
		<?php foreach($comments as $comment){ ?>
			<tr>
				<td><h4><?= htmlspecialchars($comment['name']); ?></h4></td>
				<td><p><?=htmlspecialchars($comment['postid']); ?></p></td>
				<td><p><?= htmlspecialchars($comment['context']); ?></p></td>
				<td class = 'actionButtom'><a  href="<?= $this->base->url."/admin/comments.php?id=".$comment['id']."&action=delete"; ?>">Удалить</a></td>
			</tr>
		<? } ?>
		
	</table>
	<?require_once('adminFooter.php')?>