<?php 
global $wpdb;

$product_table = $wpdb->prefix.'atl_products';

$product_id = $args['product_id'];
$userid = $args['userid'];
$order_created = $args['order_created'];
$order_total = $args['order_total'];
$payment_method = $args['payment_method'];
$order_status = $args['order_status'];
$orderid = $args['orderid'];

$get_product_detail = $wpdb->get_row("SELECT product_name FROM $product_table WHERE id = $product_id",ARRAY_A);
$product_name = $get_product_detail['product_name'];

$userdata = get_userdata( $userid );
$username = $userdata->user_login;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <title>Order Created</title>

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        body {
            font-family: 'Roboto', sans-serif !important;
            height: 100% !important;
            width: 100% !important;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            border: none;
        }
        table th{
            text-align:left;
            font-size:15px;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        img {
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        a {
            text-decoration: none;
        }

        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
        }

        a,
        a:link,
        a:visited {
            text-decoration: none;
            color: #00788a;
        }

        a:hover {
            text-decoration: none;
        }

        h2,
        h2 a,
        h2 a:visited,
        h3,
        h3 a,
        h3 a:visited,
        h4,
        h5,
        h6,
        .t_cht {
            color: #000 !important;
        }

        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td {
            line-height: 100%;
        }
    </style>
</head>
<body>
    <table class="table-pdf" width="100%" cellpadding="0" cellspacing="0" align="center"
        style="border:1px solid #eee;max-width:600px;margin:auto;font-family: 'Roboto', sans-serif !important;">
        <tbody>
            <tr>
                <td>
                    <!-- logo starts here  -->
                    <table width="100%" cellpadding="0" cellspacing="0" align="center" bgcolor="#fff" style="font-family: 'Roboto', sans-serif !important;">
                        <tbody>
                            <tr>
                                <td style="padding:15px 10px;" align="center">
                                    <?php get_custom_logo_function(); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- logo ends here  -->
                    <!-- content starts here  -->
                    <table width="100%" cellpadding="0" cellspacing="0" align="center">
                        <tbody>
                            <tr>
                                <td style="padding: 40px 30px;" bgcolor="#f9f7fa">
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                        <tbody>
                                            <tr>
                                                <td style="color: #757376;">
                                                    <h1 style="margin-bottom: 15px;">Hey Admin,</h1>
                                                    <p style="margin-bottom: 15px;font-size: 20px;">You have received an order from <?php echo $username; ?>. The order is as follows:</p>
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Order id starts  -->
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center"
                                        style="margin-top: 10px;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p style="text-align:center;margin-bottom: 15px;">
                                                        <a href="<?php echo admin_url('admin.php?page=manage-orders'); ?>" style="color: #14a59c;display: inline-block;font-weight:300;font-size:22px;">Order #<?php echo $orderid; ?> (<?php echo date('F j, Y',strtotime($order_created)); ?>)</a>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td style="padding:40px 30px;border-radius:8px;">
                                                    <!-- order details start  -->
                                                    <table width="100%" cellpadding="10" cellspacing="10" border="1" align="center">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Price</th>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td><?php echo $product_name; ?></td>
                                                            <td><?php echo $order_total; ?> Pts</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Payment Method:</th>
                                                            <td><?php echo $payment_method; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td><?php echo $order_total; ?> Pts</td>
                                                        </tr>
                                                       
                                                    </table>
                                                    <!-- order details end  -->

                                                    <!-- customer details start  -->
                                                    
                                                    <table width="100%" cellpadding="0" cellspacing="0" align="center"
                                                        style="margin-top:30px; margin-bottom: 20px;">
                                                        <tr>
                                                            <td style="padding-bottom: 30px;border-bottom: 1px solid #eee;">
                                                                <h4>Customer Details</h4>
                                                                <p>User Name : <?php echo $username; ?></p>
                                                                <p>User Email : <?php echo $userdata->user_email; ?></p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                   
                                                    <!-- customer details end  -->
                                            
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- order id ends  -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- content ends here  -->

                    <!-- green content stripe ends here  -->
                    <table width="100%" align="center" cellpadding="0" cellspacing="0">
                        <tbody> 
                            <tr>
                                <td style="background-image: url(<?php echo site_url(); ?>/wp-content/uploads/2022/11/email-footer-banner.png);background-repeat:no-repeat;background-size: 100%;background-position:left;">
                                    <!-- seperatorder table starts here  -->
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" bgcolor="">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" height="55"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- seperatorder table ends here  -->
                
                                    <!-- footer table starts here -->
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" bgcolor="">
                                        <tbody>
                                            <tr>
                                                <td height="100">
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- footer table ends here -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>