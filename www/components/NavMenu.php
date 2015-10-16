<?php 

	class 	NavMenu
	{
		/**
		*	assoc array, (name => value)
		*/
		private $items 	= array();
		
		/**
		*	string
		*/
		private $log 	= '';

		/**
		*	add item
		*/
		public function addItem($val, $name) 
		{
			$this->items[$name] = $val;
		}

		/**
		*	add logo
		*/
		public function addLogo($name)
		{
			$this->logo = $name;
		}

		/**
		*	return nav.mainNav>div.wrap>ul>li + div.crear
		*/
		public function show()
		{
		?>
			
			<nav class="navbar navbar-default">
		      	<div class="container-fluid">
		        <!-- Brand and toggle get grouped for better mobile display -->
		        	<div class="navbar-header">
		          		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			            	<span class="sr-only">Toggle navigation</span>
			            	<span class="icon-bar"></span>
			            	<span class="icon-bar"></span>
			            	<span class="icon-bar"></span>
			          	</button>
			          	<a class="navbar-brand" href="index.php"><?php echo $this->logo; ?></a>
		        	</div>
		        <!-- Collect the nav links, forms, and other content for toggling -->
			        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			          	<ul class="nav navbar-nav navbar-right">
							<?php if (isset($_SESSION['us_name'])): ?>
				          		<li>
				          			<p class="navbar-text">Здравствуйте, <?php echo ucwords($_SESSION['us_name']); ?></p>
				          		</li>
							<?php endif ?>
			            	<?php foreach ($this->items as $k => $v): ?>
			            		<li>
			            			<a href="index.php?page=<?php echo $k; ?>"><?php echo $v; ?></a>
			            		</li>
			            	<?php endforeach ?>
			            	<?php //if (Author::check()): ?>
			              	<!-- <li>
			              				                	<a href="">Личный кабинет</a>
			              	</li>
			              	<li>
			              				                	<a href="">Выйти</a>
			              	</li> -->
			            	<?php //endif ?>
			            	<!-- <li><a href="index.php?page=author">Войти</a></li> -->
			          	</ul>
			        </div><!-- /.navbar-collapse -->
		      	</div><!-- /.container-fluid -->
		    </nav>

		<?php
		}
	}

 ?>