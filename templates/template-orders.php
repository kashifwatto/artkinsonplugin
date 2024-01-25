<?php
global $wpdb;
?>
<div class="atl-main-section">
    <div class="atl-top-header">
        <h1>Orders</h1>
        <!-- <a href="<?php echo admin_url('admin.php?page=shop-items'); ?>&action=add">+ Add New Product</a> -->
    </div>
    <?php 
    
    $results = $wpdb->get_results("SELECT *,ao.id as orderid FROM {$wpdb->prefix}atl_orders as ao INNER JOIN {$wpdb->prefix}atl_products as ap ON ao.product_id = ap.id",ARRAY_A);
    
    if(!empty($results)) {
    ?>
    <div class="atl-content shopping-list">
    <div class="table-responsive">
    <table id="orders-table"  class="table cell-border dataTable no-footer" cellspacing="0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>User name</th>
                    <th>Order Total</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                    <!-- <th>Payment Method</th> -->
                    <!-- <th>Edit Status</th> -->
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($results as $row) : ?>
                <tr>
                    <td><?php echo $row['orderid'];?></td>
                    <td><?php echo $row['product_name'];?></td>
                    <td><?php echo get_userdata($row['user_id'])->data->user_login; ?></td>
                    <td><?php echo $row['order_total'];?></td>
                    <td class="edit-order" data-orderid="<?php echo $row['orderid']; ?>">
                        <span><?php echo $row['order_status']; ?></span>
                        <select name="change_status" id="change_status" style="display:none;" >
                            <option value="Processing" <?php echo ($row['order_status'] == 'Processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="Completed" <?php echo ($row['order_status'] == 'Completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="On Hold" <?php echo ($row['order_status'] == 'On Hold' ? 'selected' : ''); ?>>On Hold</option>
                            <option value="Cancelled" <?php echo ($row['order_status'] == 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                        </select>
                    </td>
                    <td><?php echo $row['order_created']; ?></td>
                    <!-- <td><?php echo $row['payment_method']; ?></td> -->
                    <!-- <td>
                        <a href="javascript:void(0);" data-orderid="<?php echo $row['id']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        
                    </td> -->
                    <td>
                        <a href="javascript:void(0);" class="delete-order" data-orid="<?php echo $row['orderid']; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
        
    </div>
    <?php 
    } ?>
</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css" integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.all.js" integrity="sha512-aYkxNMS1BrFK2pwC53ea1bO8key+6qLChadZfRk8FtHt36OBqoKX8cnkcYWLs1BR5sqgjU5SMIMYNa85lZWzAw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js" integrity="sha512-vDRRSInpSrdiN5LfDsexCr56x9mAO3WrKn8ZpIM77alA24mAH3DYkGVSIq0mT5coyfgOlTbFyBSUG7tjqdNkNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.6.2/js/dataTables.select.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/editor.dataTables.editor.min.js"></script>

<script>
    jQuery(document).ready(function($){
        $('#orders-table').DataTable({
            bLengthChange:false,
            //order: [[1, 'desc']],
            paging: false,
            searching:false,
            bInfo: false,
            // columnDefs: [{
            //     orderable: false,
            //     targets: "no-sort"
            // }]
        });
       
        $('.edit-order').on('click',function(e){
            e.stopPropagation();
            $(this).find('span').hide();
            $(this).find('select').show();

        });

        $('body').on('click',function(){
            $('.edit-order').find('span').show();
            $('.edit-order').find('select').hide();
        });
        
        $('select[name="change_status"]').on('change',function(){
            var elem = $(this);
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: "POST",
                data: {
                    action: 'update_order_status',
                    order_id : $(this).parents('.edit-order').attr('data-orderid'),
                    order_status : $(this).val(),
                },
                success: function(response) {
                    var res = $.parseJSON(response); 
                    console.log(res);
                    if(res.success == 'changed'){
                        
                        Swal.fire({
                            title: 'Status updated!',
                            text: "Order status has been changed.",
                            icon: 'success',
                            confirmButtonText: 'Ok',
                        }).then((result) =>{
                            if (result.isConfirmed) {
                                elem.siblings('span').text(res.order_status).show();
                                elem.hide();
                                // window.location.href = '<?php //echo admin_url('admin.php?page=shop-items'); ?>';
                            }
                        });
                    }
                }
            });
        });

        jQuery('.delete-order').on('click', function(e){

            e.preventDefault();

            var id = jQuery(this).data('orid');
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete the order?",
                icon: 'warning',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showCancelButton: true,
            }).then((result) =>{
                if (result.isConfirmed) {
                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: "POST",
                        data: {
                            action: 'atl_delete_order',
                            order_id : id
                        },
                        success: function(data) {
                            if(data == 'deleted'){
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: "Order has been deleted.",
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                }).then((result) =>{
                                    if (result.isConfirmed) {
                                        window.location.href = '<?php echo admin_url('admin.php?page=manage-orders'); ?>';
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });

        
    });
</script>