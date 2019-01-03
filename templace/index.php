<?php
session_start();
require_once 'database.php';
$database = new Database();
echo '<pre>';
print_r($_SESSION);
echo '</pre>'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>
<?php if (isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])){?>
<div class="container">
    <h2>Giỏ Hàng</h2>
    <p>Chi Tiết Giỏ Hàng Của Bạn</p>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID sản phẩm</th>
            <th>Tên Sản PHẩm</th>
            <th>Hình Ảnh</th>
            <th>Giá Tiền</th>
            <th>Số Lượng</th>
            <th>Thành Tiền</th>
            <th>Xóa Khỏi Giỏ Hàng</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total= 0;
        foreach ($_SESSION['cart_item'] as $key_car => $val_cart_item) :?>
        <tr>
            <td><?php echo $val_cart_item['product_id']?></td>
            <td><?php echo $val_cart_item['product_name']?></td>
            <td><img class="card-img-top" style="height: 25px; width: auto; display: block;" src="image/<?php echo $val_cart_item['product_image']?>" data-holder-rendered="true"></td>
            <td><?php echo $val_cart_item['price']?></td>
            <td><?php echo number_format($val_cart_item['quantity'],0,',','.');?></td>
            <td><?php
                $total_item = $val_cart_item['price'] * $val_cart_item['quantity'];
                echo number_format($total_item,0,',','.');
                ?> VND</td>
            <td>
                <form action="process.php" name="remove<?php echo $val_cart_item['product_id']?>" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $val_cart_item['product_id']?>">
                    <input type="hidden" name="action" value="remove">
                    <input type="submit" name="submit" value="Xoá" class="btn btn-sm btn-outline-secondary">
                </form>
            </td>

        </tr>
        <?php
            $total +=($val_cart_item['price'] * $val_cart_item['quantity']);
        endforeach;?>

        </tbody>
    </table>
    <div>Tổng Hóa Đơn Thanh Toán <strong><?php echo number_format($total,0,',','.')?> VND</strong></div>
</div>
<?php }else{?>
    <div class="container">
        <h2>Giỏ Hàng</h2>
        <p>Giỏ Hàng Của Bạn Đang Rỗng</p>
    </div>
<?php }?>
<div class="container"style="margin-top: 50px">
    <div class="row">
        <?php
        $sql ="SELECT * FROM products";
        $products = $database->runQuery($sql);
        ?>
        <?php
            if (!empty($products)) :
        ?>
            <?php
                    foreach ($products as $product) :

                ?>
                        <div class="col-sm-6">
                            <form action="process.php" name="product<?php echo $product['id']?>" method="post">
                                <div class="card mb-4 box-shadow">
                                    <img class="card-img-top" style="height: 358px; width: 100%; display: block;" src="image/<?php echo $product['product_image']?>" data-holder-rendered="true">
                                    <div class="card-body">
                                        <p class="card-text"> <strong>Product <?php echo $product['product_name']?></strong></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-inline">
                                                <input type="text" class="form-control" name="quantity" value="1">
                                                <input type="hidden" name="action" value="add">
                                                <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                                                <input type="submit" name="submit" value="Thêm Vèo Giả Hàng" class="btn btn-sm btn-outline-secondary">
                                            </div>
                                            <small class="text-muted">9 mins</small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
            <?php
                    endforeach;
            ?>
        <?php
            endif;
        ?>
</div>
</body>
</html>
