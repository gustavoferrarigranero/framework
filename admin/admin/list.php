<?php

if(isset($_GET['class']) && $_GET['class']){
	$class = 'Controller' . ucfirst($_GET['class']);
	$object = new $class;
}
else{
	$object = false;
}

Functions::callHeader();

?>
<link rel="stylesheet" href="<?php echo URL_ADMIN . DIR_SEP . 'css' . DIR_SEP . 'jquery.dynatable.css' ?>"/>
<script type="text/javascript" src="<?php echo URL_ADMIN . DIR_SEP . 'js' . DIR_SEP . 'jquery.dynatable.js' ?>"></script>
<div id="container" class="container list-box">
	<?php if ($object){ ?>
	<h1><?php echo $object->construct['title'] ?> <div class="pull-right"><a href="<?php echo URL_SITE ?>/admin/form/<?php echo $_GET['class'] ?>/" class="btn btn-success">Novo Registro</a></div></h1>
	<?php $object->setIdLanguage(1); ?>
	<?php $lists = $object->getList(); ?>
	<table id="list-table" width="100%" class="table table-responsive table-hover" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<?php if($lists){ ?>
				<?php foreach($lists as $key => $list){ ?>
					<?php if(!$key){ ?>
						<?php foreach($object->construct['fields'] as $key2 => $value){ ?>
							<?php if($value['list']){ ?>
								<th class="text-center"><?php echo $value['title']; ?></th>
							<?php } ?>
						<?php } ?>
					<?php }
					else{ ?>
						<?php break; ?>
					<?php } ?>
				<?php } ?>
				<?php if(isset($object->construct['fields_lang']) && $object->construct['fields_lang']){ ?>
					<?php foreach($lists as $key => $list){ ?>
						<?php if(!$key){ ?>
							<?php foreach($object->construct['fields_lang'] as $key2 => $value){ ?>
								<?php if($value['list']){ ?>
									<th class="text-center"><?php echo $value['title']; ?></th>
								<?php } ?>
							<?php } ?>
						<?php }
						else{ ?>
							<?php break; ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<th class="<?php if($lists){ ?>text-right<?php }else{ ?>text-left<?php } ?>"><?php if($lists){ ?>Ações<?php }else{ ?>Registros<?php } ?></th>
		</tr>
		</thead>
		<tbody>
			<?php if ($lists){ ?>
				<?php foreach ($lists as $key => $list){ ?>
				<tr>
					<?php foreach($object->construct['fields'] as $key2 => $value){ ?>
						<?php if(isset($value['type']) && $value['type'] && $value['list']){ ?>
							<td class="text-center">
								<?php switch($value['type']){
									case 'status':
										if($list[$key2]){
											echo '<img src="'.URL_ADMIN . '/img/icon-active.png" title="Ativado">';
										}else{
											echo '<img src="'.URL_ADMIN . '/img/icon-inactive.png" title="Desativado">';
										}
										break;
									default:
										echo $list[$key2];
										break;
								} ?>
							</td>
						<?php }elseif($value['list']){ ?>
							<td class="text-center"><?php echo $list[$key2]; ?></td>
						<?php } ?>
					<?php } ?>
					<?php if (isset($object->construct['fields_lang']) && $object->construct['fields_lang']){ ?>
						<?php foreach($object->construct['fields_lang'] as $key2 => $value){ ?>
							<?php if(isset($value['type']) && $value['type'] && $value['list']){ ?>
								<td class="text-center">
									<?php switch($value['type']){
										case 'ststus':
											if($list[$key2]){
												echo '<img src="'.URL_ADMIN . '/img/icon-active" title="Ativado">';
											}else{
												echo '<img src="'.URL_ADMIN . '/img/icon-inactive" title="Desativado">';
											}
											break;
										 default:
											echo $list[$key2];
											break;
									 } ?>
								</td>
							<?php }elseif($value['list']){ ?>
								<td class="text-center"><?php echo $list[$key2]; ?></td>
							<?php } ?>
						<?php } ?>
					<?php } ?>
					<td class="text-right">
						<a class="btn btn-primary" href="<?php echo URL_ADMIN ?>/form/<?php echo $_GET['class'] ?>/<?php echo $list[$object->construct['id_table']] ?>">Alterar</a>
						<a class="btn btn-danger" href="<?php echo URL_ADMIN ?>/delete/<?php echo $_GET['class'] ?>/<?php echo $list[$object->construct['id_table']] ?>">Excluir</a>
					</td>
				</tr>
				<?php } ?>
			<?php }else{ ?>
				<tr>
					<td class="text-left">Nenhum item encontrado!</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#list-table').dynatable();
	});
</script>