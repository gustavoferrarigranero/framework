<?php

if(isset($_GET['class']) && $_GET['class']){
	$class = 'Controller' . ucfirst($_GET['class']);

	if(isset($_REQUEST['action']) && $_REQUEST['action'])
		$object = new $class($_REQUEST['action'], $_GET['id_table']);
	else
		$object = new $class(false, $_GET['id_table']);
}
else{
	$object = false;
}


Functions::callHeader();

?>
<div id="content" class="container form-box">
	<?php if ($object){ ?>
		<h1><?php echo $object->construct['title'] ?></h1>
		<br/><br/><br/>
		<form action="<?php echo URL_ADMIN ?>/form/<?php echo $_GET['class'] ?>/<?php echo isset($_GET['id_table']) && $_GET['id_table'] ? $_GET['id_table'] : '' ?>" class="form-horizontal" method="post">
			<div class="row">
				<div class="col-xs-12 text-right">
					<?php if(isset($_GET['id_table']) && $_GET['id_table']){ ?>
						<a href="<?php echo URL_ADMIN ?>/delete/<?php echo $_GET['class'] ?>/<?php echo $_GET['id_table'] ?>" class="btn btn-danger">Excluir</a>
					<?php } ?>
					<a href="<?php echo URL_ADMIN ?>/list/<?php echo $_GET['class'] ?>/" class="btn btn-warning">Cancelar</a>
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>
			</div>
			<input type="hidden" name="action" value="<?php echo isset($_GET['id_table']) && $_GET['id_table'] ? 'update' : 'add' ?>"/>
			<input type="hidden" name="<?php echo $object->construct['id_table'] ?>" value="<?php echo isset($_GET['id_table']) && $_GET['id_table'] ? $_GET['id_table'] : '' ?>"/>
			<?php foreach($object->construct['fields'] as $key => $value){ ?>
				<?php if($value['form']){ ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="<?php echo $key ?>"><?php echo $value['title']; ?></label>

						<div class="col-sm-<?php echo isset($value['col']) && $value['col'] ? $value['col'] : 10 ?>">
							<?php if(isset($value['type']) && $value['type']){ ?>
								<?php if($value['type'] == 'status'){ ?>
									<select name="<?php echo $key ?>" id="<?php echo $key ?>" class="form-control">
										<option value="1" <?php if ($object->getField($key) == 1){ ?>selected="selected" <?php } ?>>
											Habilitado
										</option>
										<option value="0" <?php if ($object->getField($key) == 0){ ?>selected="selected" <?php } ?>>
											Desabilitado
										</option>
									</select>
								<?php }
								elseif($value['type'] == 'description'){ ?>
									<textarea name="<?php echo $key ?>" id="<?php echo $key ?>" class="form-control" rows="15"><?php echo $object->getField($key) ?></textarea>
								<?php }
								elseif($value['type'] == 'content_multiple'){ ?>
                                    <script type="text/javascript" src="<?php echo URL_ADMIN . DIR_SEP . 'js' . DIR_SEP . 'jquery.multiselect.js' ?>"></script>
                                    <?php if(isset($object->construct['content_multiple'.'_'.$key]) && $object->construct['content_multiple'.'_'.$key]){ ?>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <select name="from[]" id="multiselect-<?php echo $key ?>" class="form-control" size="8" multiple="multiple">
                                                    <?php foreach($object->construct['content_multiple'.'_'.$key] as $valor){ ?>
                                                        <?php if(!$valor['selected']){ ?>
                                                            <option value="<?php echo $valor[$key] ?>"><?php echo $valor['name'] ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-xs-2">
                                                <br/>
                                                <button type="button" id="multiselect-<?php echo $key ?>_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                                <button type="button" id="multiselect-<?php echo $key ?>_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                                <button type="button" id="multiselect-<?php echo $key ?>_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                                <button type="button" id="multiselect-<?php echo $key ?>_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                            </div>

                                            <div class="col-xs-5">
                                                <select name="<?php echo $key ?>[]" id="multiselect-<?php echo $key ?>_to" class="form-control" size="8" multiple="multiple">
                                                    <?php foreach($object->construct['content_multiple'.'_'.$key] as $valor){ ?>
                                                        <?php if($valor['selected']){ ?>
                                                            <option value="<?php echo $valor[$key] ?>"><?php echo $valor['name'] ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            jQuery(document).ready(function($) {
                                                $('#multiselect-<?php echo $key ?>').multiselect({
                                                    search: {
                                                        left: '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span><input type="text" name="q" class="form-control" placeholder="Buscar..." /></div>',
                                                        right: '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span><input type="text" name="q" class="form-control" placeholder="Buscar..." /></div>',
                                                    }
                                                });
                                            });
                                        </script>
                                    <?php }else{ ?>
                                        Nenhum registro cadastrado!
                                    <?php } ?>
								<?php }
								else{ ?>
									<input type="text" class="form-control" name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $object->getField($key) ?>" <?php if ($key == $object->construct['id_table']){ ?>readonly="readonly" <?php } ?>/>
								<?php } ?>
							<?php }
							else{ ?>
								<input type="text" class="form-control" name="<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $object->getField($key) ?>" <?php if ($key == $object->construct['id_table']){ ?>readonly="readonly" <?php } ?>/>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			<br/><br/>
			<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
				<?php foreach($object->getLanguages() as $language){ ?>
					<li class="<?php echo $language['id_language'] == 1 ? 'active' : '' ?>"><a href="#language_box_<?php echo $language['id_language'] ?>" data-toggle="tab"><?php echo $language['name'] ?>(<?php echo $language['code'] ?>)</a></li>
				<?php } ?>
			</ul>
			<br/><br/><br/>
			<div id="my-tab-content" class="tab-content">
				<?php if(isset($object->construct['id_table_lang']) && $object->construct['id_table_lang']){ ?>
					<?php foreach($object->getLanguages() as $language){ ?>
						<div id="language_box_<?php echo $language['id_language'] ?>" class="tab-pane <?php echo $language['id_language'] == 1 ? 'active' : '' ?>">
							<?php $object->setIdLanguage($language['id_language']); ?>
							<?php if($object->get()){ ?>
								<?php foreach($object->construct['fields_lang'] as $key => $value){ ?>
									<?php if($value['form']){ ?>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="<?php echo $key ?>[<?php echo $language['id_language'] ?>]"><?php echo $value['title']; ?></label>

											<div class="col-sm-<?php echo isset($value['col']) && $value['col'] ? $value['col'] : 10 ?>">
												<?php if(isset($value['type']) && $value['type']){ ?>
													<?php if($value['type'] == 'status'){ ?>
														<select name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" class="form-control">
															<option value="1" <?php if ($object->getField($key) == 1){ ?>selected="selected" <?php } ?>>
																Habilitado
															</option>
															<option value="0" <?php if ($object->getField($key) == 0){ ?>selected="selected" <?php } ?>>
																Desabilitado
															</option>
														</select>
													<?php }
													elseif($value['type'] == 'description'){ ?>
														<textarea name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" class="form-control" rows="15"><?php echo $object->getField($key) ?></textarea>
													<?php }
													else{ ?>
														<input type="text" class="form-control" name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" value="<?php echo $object->getField($key) ?>" <?php if ($key == $object->construct['id_table']){ ?>readonly="readonly" <?php } ?>/>
													<?php } ?>
												<?php }
												else{ ?>
													<input type="text" class="form-control" name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" value="<?php echo $object->getField($key) ?>" <?php if ($key == $object->construct['id_table']){ ?>readonly="readonly" <?php } ?>/>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							<?php }else{ ?>
								<?php foreach($object->construct['fields_lang'] as $key => $value){ ?>
									<?php if($value['form']){ ?>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="<?php echo $key ?>[<?php echo $language['id_language'] ?>]"><?php echo $value['title']; ?></label>

											<div class="col-sm-<?php echo isset($value['col']) && $value['col'] ? $value['col'] : 10 ?>">
												<?php if(isset($value['type']) && $value['type']){ ?>
													<?php if($value['type'] == 'status'){ ?>
														<select name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" class="form-control">
															<option value="1">
																Habilitado
															</option>
															<option value="0">
																Desabilitado
															</option>
														</select>
													<?php }
													elseif($value['type'] == 'description'){ ?>
														<textarea name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" class="form-control" rows="15"></textarea>
													<?php }
													else{ ?>
														<input type="text" class="form-control" name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" value="" <?php if ($key == $object->construct['id_table']){ ?>readonly="readonly" <?php } ?>/>
													<?php } ?>
												<?php }
												else{ ?>
													<input type="text" class="form-control" name="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" id="<?php echo $key ?>[<?php echo $language['id_language'] ?>]" value="" <?php if ($key == $object->construct['id_table']){ ?>readonly="readonly" <?php } ?>/>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
			<br/>
			<div class="row">
				<div class="col-xs-12 text-right">
					<?php if(isset($_GET['id_table']) && $_GET['id_table']){ ?>
						<a href="<?php echo URL_ADMIN ?>/delete/<?php echo $_GET['class'] ?>/<?php echo $_GET['id_table'] ?>" class="btn btn-danger">Excluir</a>
					<?php } ?>
					<a href="<?php echo URL_ADMIN ?>/list/<?php echo $_GET['class'] ?>/" class="btn btn-warning">Cancelar</a>
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>
			</div>
		</form>
	<?php } ?>
</div>

