<?php
session_start();
$total=0;
include('database/connection.php');

//get action string
$action = isset($_GET['action'])?$_GET['action']:"";

//Add to cart
if($action=='addcart' && $_SERVER['REQUEST_METHOD']=='POST') {
	
	//Finding the product by code
	$query = "SELECT * FROM products WHERE product_id=:sku";
	$stmt = $conn->prepare($query);
	$stmt->bindParam('sku', $_POST['sku']);
	$stmt->execute();
	$product = $stmt->fetch();
	$_SESSION['products'][$_POST['sku']] =array('name'=>$product['name'],'image'=>$product['image'],'price'=>$product['price']);
	$product='';
	header("Location:shopping-cart.php");
}

//Empty All
if($action=='emptyall') {
	$_SESSION['products'] =array();
	header("Location:shopping-cart.php");	
}

//Empty one by one
if($action=='empty') {
	$sku = $_GET['sku'];
	$products = $_SESSION['products'];
	unset($products[$sku]);
	$_SESSION['products']= $products;
	header("Location:shopping-cart.php");	
}
 //Get all Products
$query = "SELECT * FROM products where `status`=0";
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();

?>


  <?php 
    /***Header For All Pages **/
    echo include('include/header.php');
    echo include('include/header_main.php');
   ?>
  

    <div class="row">
      <div class="container bootstrap snippet"><br>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                  <strong class=""><i class="fa fa-mouse-pointer"></i> Choose your products to buy</strong>
                </div>
                <div class="panel-body">
                    <?php if(!empty($_SESSION['products'])):?>
                      <div class="alert alert-success" role="alert"><i class="fa fa-cart-plus"></i> Product added correctly <a href="cart.php">Go to shopping cart</a></div>
                    <?php endif;?> 

                    <?php foreach($products as $product):?>
                      <div class="product-content">
                        <div class="col-md-12 panelTop">  
                          <div class="col-md-4">  
                            <img class="img-responsive product-img" src="<?php print $product['image']?>" alt=""/>
                          </div>
                          <div class="col-md-8">  
                            <h2><?php print $product['name']?></h2>
                            <p><?php print utf8_decode($product['description']) ?></p>
                          </div>

                          <div class="col-md-12"><br>
                            <form method="post" action="shopping-cart.php?action=addcart">
                              <div class="col-md-4 text-center">
                                <button class="btn btn-lg btn-add-to-cart add-to-cart"><span class="glyphicon glyphicon-shopping-cart"></span>   Add to Cart</button>     
                                <input type="hidden" name="sku" value="<?php print $product['product_id']?>">      
                              </div>
                            </form>
                            <div class="col-md-4 text-left">
                              <h5>Price <span class="itemPrice">$<?php print number_format($product['price']) ?></span></h5>
                            </div>
                            <div class="col-md-4">
                              
                            </div>                                  
                          </div>                                  
                        </div>
                      </div>
                      <hr>
                    <?php endforeach;?>      
                </div>
                <div class="panel-footer">Add Product? <a href="add.php" class="">Enter here</a>
                </div>
            </div>
        </div>
      </div>      
    </div>
<?php echo include('include/footer.php'); ?>
