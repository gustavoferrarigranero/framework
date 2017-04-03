<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title>Gerenciamento <?php echo TITLE ?></title>
	<link rel="stylesheet" href="<?php echo URL_ADMIN ?>/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="<?php echo URL_ADMIN ?>/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" href="<?php echo URL_ADMIN ?>/css/style.css"/>
	<script src="<?php echo URL_ADMIN ?>/js/jquery.min.js"></script>
	<script src="<?php echo URL_ADMIN ?>/js/bootstrap.min.js"></script>
	<script src="<?php echo URL_ADMIN ?>/js/global.js"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Visualizar</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand">Gerenciamento</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li><a href="<?php echo URL_ADMIN ?>/list/category">Categorias</a></li>
							<li><a href="<?php echo URL_ADMIN ?>/list/work">Cases</a></li>
							<li><a href="<?php echo URL_ADMIN ?>/list/post">Posts</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="#">Sair</a></li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div> <!-- /.container-fluid -->
			</nav>
		</div>
	</div>
</div>