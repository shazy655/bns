<body class="bg_image">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
              <a href="cart.php"> Cart <i class="fa fa-2x fa-cart-plus" style="margin-top: 10px;"></i></a>
              <lavel id="cart-badge" class="badge badge-warning"><?php echo count($_SESSION['products']) ?></lavel>  
          </a>
          <ul class="nav navbar-nav">
            <li class="active"><a href="shopping-cart.php">Buy And Sell</a></li>
          </ul>
        </div>
      </div><!--/.container-fluid -->
    </nav>