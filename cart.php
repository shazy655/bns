<?php
  error_reporting(0);
  //Setting session start
  include('database/connection.php');
  session_start();

  $total=0;
  $amount=0;
  //get action string
  $action = isset($_GET['action'])?$_GET['action']:"";

  //Empty All
  if($action=='emptyall') {
    $_SESSION['products'] =array();
    header("Location:shopping-cart.php"); 
  }

  if($action=='buy') {
    
    if(isset($_SESSION['products'])){
      foreach($_SESSION['products'] as $key=>$value){
        
        $query = "Update products set status=1 WHERE product_id=:id";
	      $stmt = $conn->prepare($query);
	      $stmt->bindParam('id', $key);
	    $stmt->execute();
      }
    }
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

 /***Header For All Pages **/
    echo include('include/header.php');
    echo include('include/header_cart.php');
?>




    <div class="container" style="margin-top:40px;background: #fff;border-radius: 13px;">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-md-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="pull-right">(<strong><?php echo count($_SESSION['products'] ) ?></strong>) items</span>
                            <h5>Products in your cart</h5>
                        </div>
                        
                        <?php foreach($_SESSION['products'] as $key=>$product):?>
                          <div class="ibox-content">
                              <div class="table-responsive">
                                  <table class="table shoping-cart-table">
                                      <tbody>
                                      <tr>
                                          <td width="90">
                                              <div class="cart-product-imitation">
                                                   <img src="<?php print $product['image']?>" class="img-responsive">
                                              </div>
                                          </td>
                                          <td class="desc">
                                              <h3>
                                                <a href="javascript:void(0)" class="text-navy">
                                                    <?php print $product['name']?>                                          </a>
                                              </h3>
                                              <div class="m-t-sm">
                                                  <a href="cart.php?action=empty&sku=<?php print $key?>" class="text-muted"><i class="fa fa-trash"></i> Delete</a>
                                              </div>
                                          </td>

                                          <td>
                                              $<?php print number_format($product['price']) ?>                                    </td>
                                          
                                          <td>
                                              <h4 class="total-product-2"><?php print number_format($product['price']) ?> </h4>
                                          </td>
                                      </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>  
                        <?php  $amount +=$product['price']; ?>
                        <?php endforeach;?>                    
                                            <div class="ibox-content">
                            <a href="cart.php?action=buy" class="btn btn-primary pull-right"><i class="fa fa fa-shopping-cart"></i> To buy</a>
                            <a href="shopping-cart.php" class="btn btn-white"><i class="fa fa-arrow-left"></i> Keep buying</a>
                            <a href="shopping-cart.php?action=emptyall" class="btn btn-danger"><i class="fa fa-remove"></i> Empty cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Summary</h5>
                        </div>
                        <div class="ibox-content">
                            <span>
                                Total
                            </span>
                            <h2 class="font-bold total-general"><?php print number_format($amount) ?></h2>
                            <hr>
                            <span class="text-muted small">
                                                    </span>
                            <div class="m-t-sm">
                                <div class="btn-group">
                                <a href="cart.php?action=buy" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> To buy</a>
                                <a href="javascript:void(0)" class="btn btn-white btn-sm"> Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Support</h5>
                        </div>
                        <div class="ibox-content text-center">
                            <h3><i class="fa fa-whatsapp"></i> +923213448655</h3>
                            <span class="small">
                                Contact us if you have a question. we're 24/7
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<?php echo include('include/footer.php'); ?>