<div class="learning-main-section">
<?php
if (!defined('my_plugin_dir')) {
    define('my_plugin_dir', plugin_dir_url(__File__));
}
global $wpdb;
if(isset($_GET['action'])){

    if($_GET['action'] == 'add'){?>
        <div class="learning-top-header">
            <h1>Add Section</h1>
        </div>
        <div class="crud-learning-section">
            <div class="wrapper">
                <form action="" method="" id="add_form" name="add_form">
                    <div class="top-section-details">
                        <div class="section_upload_icon">
                            <label for="section_icon"><img width="50px" src="http://atkinsonlearning.com/wp-content/uploads/2022/03/icons-camera.png"/></label>
                            <input id="section_icon" name="section_icon_attachment" type="text" />
                        </div>
                        <div class="form-field">
                            <input type="text" name="section_title" placeholder="Title"/>
                        </div>
                        
                        <div class="form-field">
                            <select name="section_cat" id="section_cat">
                                <option value="All">All</option>
                                <option value="Installation">Installation</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Maintenance">None</option>
                            </select>
                        </div>
                    </div>
                    <div class="subsection-learning-section">

                        <div class="sections-fields">

                            <div class="form-field">

                                <input type="text" name="sub_section_title[]" placeholder="Subsection Title"/>

                            </div>

                            <div class="form-field">

                                <input type="text" name="sub_section_start_url[]" placeholder="Starting URL"/>

                            </div>

                            <div class="form-field">

                                <input type="text" name="sub_section_completed_url[]" placeholder="Completed URL"/>

                            </div>

       <!-- <div class="form-field">
    <select name="sub_section_completed_url[]" >
        

        <?php
       
        $pages = get_pages(array('sort_column' => 'post_title', 'sort_order' => 'ASC'));
        foreach ($pages as $page) {
            $page_url = get_permalink($page->ID);
            

            ?>

            <option value="<?php echo esc_attr($page_url); ?>"><?php echo esc_html($page_url); ?></option>
            <?php
        }
        ?>

        <option value="None">None</option>
    </select>
</div> -->

                            <div class="form-field">

                                <!-- <a href="#" onclick="deletethis(jQuery(this))">X</a>  -->

                            </div>

                        </div>

                    </div>

                    <div class="add-new-subsection">

                            <a href="#">+ Add New Subsection</a>

                    </div>

                    <div class="section-action-btn">

                        <input type="submit" name="save_section" value="save"/>

                        <input type="submit" name="cancel_section" value="Cancel"/>

                    </div>

                </form>

            </div>

        </div>





    <?php } else if($_GET['action'] == 'edit'){?>



        <?php
            global $wpdb;
            $id = '';

            if(isset($_GET['section_id'])){

                $id = $_GET['section_id'];

                $get_data = get_specific_section_by_id($id);

                if(empty($get_data)){

                    wp_safe_redirect( site_url().'/wp-admin/admin.php?page=learning_sections&message=notfound');

                    exit;

                }

            }

            else{

                wp_safe_redirect( site_url().'/wp-admin/admin.php?page=learning_sections&message=notfound');

                exit;

            }?>



        <div class="learning-top-header">

            <h1>Edit Section</h1>

        </div>

        <div class="crud-learning-section">



            <?php

            $img = 'http://atkinsonlearning.com/wp-content/uploads/2022/03/icons-camera.png';

            $learning_subsection = unserialize($get_data->learning_subsection);

            //$image = wp_get_attachment_image_src($get_data->image, 'full');
            $image = wp_get_attachment_url($get_data->image);
            



            if(!empty($image)){

                $img = $image;

            }

            $table_name = $wpdb->prefix . 'quiz_details';

            ?>

            <div class="wrapper">



                <?php

                    $old_assigned_users = json_decode(stripslashes($get_data->assigned_users));

                    $read_only = '';

                    if(!empty($old_assigned_users)){

                        $read_only = 'readonly';

                        echo '<div class="information">This section is currently assigned. Existing entries can not be edited</div>';

                    }

                ?>



                <form action="" method="post" id="edit_form">

                    <div class="top-section-details">

                        <div class="section_upload_icon">

                            <label for="section_icon"><img width="50px" src="<?php echo $img;?>"/></label>

                            <input id="section_icon" name="section_icon_attachment" type="hidden" value="<?php echo $get_data->image;?>" />

                        </div>

                        <div class="form-field">

                            <input type="text" name="section_title" placeholder="Title" value="<?php echo $get_data->title;?>" />

                        </div>
                        <div class="form-field">
                            <select name="section_cat" id="section_cat">
                                <option value="All" <?php echo ($get_data->cat == 'All' ? 'selected' : ''); ?>>All</option>
                                <option value="Installation" <?php echo ($get_data->cat == 'Installation' ? 'selected' : ''); ?>>Installation</option>
                                <option value="Maintenance" <?php echo ($get_data->cat == 'Maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                            </select>
                        </div>

                    </div>

                    <div class="subsection-learning-section">

                        <?php if(!empty($learning_subsection)){

                            // foreach ($learning_subsection as $key => $item) {
                            //     $total_question = 0;
                            //     $title = $id.'_'.$item['sub_title'];
                            //     $ql = $wpdb->get_row("SELECT * FROM {$table_name} WHERE sectionid = {$id} AND subsection_title = '$title' ", ARRAY_A);

                                // $subtitle = explode("_",$ql['subsection_title']);

                                // if($subtitle[1] == $item['sub_title']){
                                //     $quizid = "&quizid=".$ql['quizid'];
                                //     $total_question = count(json_decode($ql['question_list'],true));
                                // }else{
                                //     $quizid = '';
                                // }
                                foreach ($learning_subsection as $key => $item) {
    $total_question = 0;
    $title = $id . '_' . $item['sub_title'];
    $ql = $wpdb->get_row("SELECT * FROM {$table_name} WHERE sectionid = {$id} AND subsection_title = '$title' ", ARRAY_A);

    // Add a check to ensure that $ql['subsection_title'] is not null
    $subtitle = !empty($ql['subsection_title']) ? explode("_", $ql['subsection_title']) : null;

    if (isset($subtitle[1]) && $subtitle[1] == $item['sub_title']) {
        $quizid = "&quizid=" . $ql['quizid'];
        if (!empty($ql['question_list'])) {
            $total_question = count(json_decode($ql['question_list'], true));
        }
    } else {
        $quizid = '';
    }
 
                                


                            ?>

                                <div class="sections-fields">

                                    <div class="form-field">

                                        <input type="text" name="sub_section_title[]" placeholder="Subsection Title" value="<?php echo $item['sub_title'];?>" id="sub_section_title_<?php echo $key; ?>"  <?php echo $read_only;?> />

                                    </div>

                                    <div class="form-field">

                                        <input type="text" name="sub_section_start_url[]" placeholder="Starting URL" value="<?php echo $item['sub_start_url'];?>" id="sub_section_start_url_<?php echo $key; ?>"  <?php echo $read_only;?> />

                                    </div>

                                    <div class="form-field">

                                        <input type="text" name="sub_section_completed_url[]" placeholder="Completed URL" value="<?php echo $item['sub_completed_url'];?>" id="sub_section_completed_url_<?php echo $key; ?>" <?php echo $read_only;?>/>

                                    </div>

                                    <div class="form-field action-field">

                                        <?php if($read_only == ''){ ?>

                                            <a href="javascript:void(0)" onclick="deletethis(jQuery(this))">X</a>

                                        <?php } ?>
                                        <a class="quiz-blue-btn" href="admin.php?page=quiz-section&section_id=<?php echo $id; ?>&sub_sec_title=<?php echo urlencode($item['sub_title']); ?><?php echo $quizid; ?>">Quiz Section</a>
                                        <h5 class="tot-qu"><?php echo $total_question; ?></h5>

                                    </div>

                                </div>

                        <?php }}  ?>

                    </div>

                    <div class="add-new-subsection">

                        <a href="#">+ Add New Subsection</a>

                    </div>

                    <div class="section-action-btn">

                        <input type="submit" name="save_section" value="Save"/>

                        <input type="submit" name="cancel_section" value="Cancel"/>

                        <input type="submit" name="move_to_trash" value="Delete" data-id="<?php echo $id;?>"/>
                        <!-- <input type="submit" name="delete_section" value="Delete" data-id="<?php echo $id;?>"/> -->

                    </div>

                    <input type="hidden" name="section_id" value="<?php echo $id;?>">

                </form>

            </div>

        </div>



    <?php } else if($_GET['action'] == 'assign_users'){?>

        <?php

            $id = '';

            if(isset($_GET['section_id'])){

                $id = $_GET['section_id'];

                $get_data = get_specific_section_by_id($id);

                if(empty($get_data)){

                    wp_safe_redirect( site_url().'/wp-admin/admin.php?page=learning_sections&message=notfound');

                    exit;

                }

            }

            else{

                wp_safe_redirect( site_url().'/wp-admin/admin.php?page=learning_sections&message=notfound');

                exit;

            }

        ?>



        <div class="learning-top-header">

            <h1>Assign Section</h1>

        </div>

        <div class="learning-page-content">

            <ul>

                <li class="header-content">

                    <div class="section-title"><?php echo $get_data->title;?></div>

                    <div class="section-action-btn">

                        <span>Assign</span>

                        <span>Complete</span>
                        
                        <span>Email</span>

                    </div>

                </li>



                <?php echo get_all_users($get_data);?>



            </ul>

        </div>

        <div class="crud-learning-section">

            <div class="section-action-btn">

                <input type="submit" name="assign_section" value="Save">

                <input type="submit" name="cancel_section" value="Cancel">

            </div>

            <input type="hidden" name="section_id" value="<?php echo $id;?>">

        </div>



    <?php } else{

        wp_redirect(site_url().'/wp-admin/admin.php?page=learning_sections');

    }



} else { ?>



    <?php

        if(isset($_GET['message']) && $_GET['message'] == 'notfound'){

            echo '<div class="warning"> Something went wrong ! </div>';

        }



    ?>



    <div class="learning-top-header">

        <h1>Learning Sections</h1>

        <a href="<?php echo admin_url('admin.php?page=learning_sections');?>&action=add">+ Add New Learning Section</a>

    </div>
    <?php $learning_sections = get_learning_section();?>

    <div class="learning-sections-list">

        <ul id="ui-sortable"> <!--id="ui-sortable" -->

            <?php

                if(!empty($learning_sections)){
                    ?>
                    <li>
                        <div class="sort-section"> </div>
                        <div class="section-title"> </div>
                        <div class="section-action-btn"> <a></a><a></a></div>
                        <div class="section-total-assigned-users">
                            <a class="assignedusers"><img src="<?php echo my_plugin_dir.'/images/gradcap.png'; ?>" width="40px"></a>
                            <a class="avgoftotal">Avg.</a>

                        </div>
                    </li>
                    <?php
                    foreach ($learning_sections as $key => $learning_section) {
                        if($learning_section->is_trash == 0) :
                        ?>

                        <li id="<?php echo $learning_section->id; ?>"> <!-- class="ui-sortable-handle" -->
                            <div class="sort"><span class="dashicons dashicons-move"></span></div>
                            <div class="section-title"><?php echo $learning_section->title;?></div>

                            <div class="section-action-btn">
                                <a href="<?php echo admin_url('admin.php?page=learning_sections');?>&action=edit&section_id=<?php echo $learning_section->id;?>">Edit</a>

                                <a href="<?php echo admin_url('admin.php?page=learning_sections');?>&action=assign_users&section_id=<?php echo $learning_section->id;?>">Assign</a>

                            </div>
                            <div class="section-total-assigned-users">
                                <?php
                                $quiztable = $wpdb->prefix.'quiz_details';
                                $quiz_user = $wpdb->prefix.'quiz_user_details';
                                $userslist = json_decode($learning_section->assigned_users,true);
                                $total_assigned_users = 0;
                                $completed_learning_modules[] = '';
                                $completed = 0;
                                $quiz_score = array();
                                foreach($userslist as $uid ) {
                                    $getdata = get_userdata($uid);
                                    if($getdata) {
                                        $total_assigned_users += 1;
                                    
                                        $learning_modules = get_user_meta( $uid , 'learning_modules_progress', true);
                                        $learning_modules = unserialize($learning_modules);
                                        
                                        
                                        foreach ($learning_modules as $key => $value) {
                                            $score_arr = array();
                                            if($key == $learning_section->id) {
                                                if($value['is_all_complated'] == 1 && $value['active'] == 1 ){
                                                    
                                                    $completed_learning_modules[] = $value;
                                                    $completed += 1;
                                                    
                                                    $score_sql = $wpdb->get_results("SELECT quizid,score FROM {$quiz_user} WHERE userid={$uid} and quizid IN (SELECT quizid FROM {$quiztable} WHERE sectionid={$value['id']}) ",ARRAY_A);
                                                    //single user all subsection percentage average. 
                                                    foreach($score_sql as $row) {
                                                                        
                                                        $score_data = json_decode($row['score'],true);
                                                        $score_arr[] = $score_data['percentage'];
                                                        
                                                    }
                                                    
                                                    if(!empty($score_arr)) :
                                                        $avg = array_sum($score_arr) / count($score_arr);
                                                    endif;
                                                    //total average of all users who has completed the quiz.
                                                    $quiz_score[$key][$uid] = round($avg);
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                echo '<a class="assignedusers">'.$completed.'/'.$total_assigned_users.'</a>';
                                if(!empty($quiz_score)) {
                                    $allusersaverage = number_format(array_sum($quiz_score[$learning_section->id]) / count($quiz_score[$learning_section->id]),2);
                                    echo '<a class="avgoftotal">'.$allusersaverage.'%</a>';
                                }else{
                                    echo '<a class="avgoftotal"></a>';
                                }
                                ?>

                               
                            </div>
                            
                        </li>

                    <?php
                        endif;
                    }
                }

            ?>

        </ul>

    </div>

<?php } ?>

</div>






<script>

jQuery(document).ready(function($){

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
    }, "Please enter only characters");

    jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9!@#$%&*\s]+$/i.test(value);
    }, "Allow alphabets, numbers and special characters only.");


// Add Sections start

  jQuery( "#add_form" ).validate({

          rules: {

     'section_title': {

        required: true,

        alphanumeric : true

    },

    'section_icon_attachment': {

        required: true,

    },

    'sub_section_title[]': {

        required: true,

        alphanumeric : true

    },

    'sub_section_start_url[]': {

        required: true,

        url: true

    },

    'sub_section_completed_url[]': {

        required: true,

        url: true

    }

},

submitHandler: function(form) {

    var formData = jQuery('#add_form').serialize(); // You need to use standard javascript object here

    jQuery.ajax({

        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',

        type: "POST",

        data: {

            action: 'learning_modules_save_action_backend',

            data: formData

        },

        success: function(data) {

            if(data == 'success'){

                Swal.fire({

                    title: 'Added',

                    text: "Section has been Added",

                    icon: 'success',

                    confirmButtonText: 'Ok',

                }).then((result) =>{

                    if (result.isConfirmed) {

                        window.location.href = '<?php echo site_url(); ?>/wp-admin/admin.php?page=learning_sections';

                    }

                });

            }

        }

    });

    return false;

}



});

// Add Sections end
// edit Sections start

  jQuery( "#edit_form" ).validate({

    rules: {

'section_title': {

    required: true,

    alphanumeric : true

},

'section_icon_attachment': {

    required: true,

},

'sub_section_title[]': {

    required: true,

    alphanumeric : true

},

'sub_section_start_url[]': {

    required: true,

    url: true

},

'sub_section_completed_url[]': {

    required: true,

    url: true

}

},

submitHandler: function(form) {

var formData = jQuery('#edit_form').serialize(); // You need to use standard javascript object here

jQuery.ajax({

    url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',

    type: "POST",

    data: {

        action: 'learning_modules_edit_action_backend',

        data: formData,

    },

    success: function(data) {

        if(data == 'updated'){

            Swal.fire({

                title: 'Updated!',

                text: "Section has been updated",

                icon: 'success',

                confirmButtonText: 'Ok',

            }).then((result) =>{

                if (result.isConfirmed) {

                    window.location.href = '<?php echo site_url(); ?>/wp-admin/admin.php?page=learning_sections';

                }

            });

        }

    }

});

return false;

}



});

// edit Sections end



});


    /* ADD NEW SUB SECTION */

    jQuery('.add-new-subsection a').on('click', function(e){

        e.preventDefault();

        var numItems = jQuery('.subsection-learning-section .sections-fields').length;

        numItems = numItems+1;

        var fields = '<div class="sections-fields"><div class="form-field"><input type="text" name="sub_section_title[]" placeholder="Subsection Title" id="sub_section_title_'+numItems+'"/></div><div class="form-field"><input type="text" name="sub_section_start_url[]" placeholder="Starting URL" id="sub_section_start_url_'+numItems+'"/></div> <div class="form-field"><input type="text" name="sub_section_completed_url[]" placeholder="Completed URL" id="sub_section_completed_url_'+numItems+'"/></div><div class="form-field"><a href="javascript:void(0)" onclick="deletethis(jQuery(this))">X</a> </div></div>';

        jQuery('.subsection-learning-section').append(fields);

        jQuery('.subsection-learning-section .sections-fields a').show();

    });



    /* REMOVE SECTION WHEN CLICK ON "X" ICON */



    function deletethis(e){

        jQuery(e).parent().parent().remove();

        var numItems = jQuery('.subsection-learning-section .sections-fields').length;

        if(numItems == 1){

            jQuery('.subsection-learning-section .sections-fields a').hide();

        } else{

            jQuery('.subsection-learning-section .sections-fields a').show();

        }

        

    }



    /* MEDIA UPLOAD BUTTON */



    jQuery('.top-section-details .section_upload_icon label').on('click', function(e) {

        e.preventDefault();

        var button = jQuery(this);

        var id = button.next();

        wp.media.editor.send.attachment = function(props, attachment) {

            id.val(attachment.id);

            jQuery('.top-section-details .section_upload_icon label img').attr('src',attachment.url);



        };

        wp.media.editor.open(button);

        return false;

    });












    // Cancel

    jQuery('.section-action-btn input[name="cancel_section"]').on('click', function(e){

        e.preventDefault();

        window.location.href = '<?php echo site_url(); ?>/wp-admin/admin.php?page=learning_sections';

    });

    //move section to trash
    jQuery('.section-action-btn input[name="move_to_trash"]').on('click', function(e){

        e.preventDefault();

        var id = jQuery(this).data('id');
        Swal.fire({

            title: 'Are you sure?',

            text: "It will be moved to trash! You can revert this from trash!",

            icon: 'warning',

            cancelButtonColor: '#d33',

            confirmButtonText: 'Yes, Move to trash!',

            showCancelButton: true,

        }).then((result) =>{

            if (result.isConfirmed) {

                jQuery.ajax({

                    url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',

                    type: "POST",

                    data: {

                        action: 'learning_modules_trash_action_backend',

                        section_id : id

                    },

                    success: function(data) {

                        if(data == 'deleted'){

                            Swal.fire({

                                title: 'Moved to Trash!',

                                text: "Section has been moved to trash",

                                icon: 'success',

                                confirmButtonText: 'Ok',

                            }).then((result) =>{

                                if (result.isConfirmed) {

                                    window.location.href = '<?php echo site_url(); ?>/wp-admin/admin.php?page=trash-list';

                                }

                            });

                        }

                    }

                });

            }

        });

    });


    


    $(document).ready(function() {
        /* SAVE ASSIGN USERS */
    jQuery('.section-action-btn input[name="assign_section"]').on('click', function(e){

e.preventDefault();

var user_ids = [];

jQuery('.learning-page-content ul .custom-switch input:checked').each(function () {

    user_ids.push(jQuery(this).data('id'));

});



var user_ids = JSON.stringify(user_ids);

var section_id = jQuery('input[name=section_id]').val();



jQuery.ajax({

    url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',

    type: 'post',

    data: {

        action: "learning_modules_assign_users",

        section_id: section_id,

        user_ids : user_ids,

    },

    success:function(data) {

        if(data == 'assigned'){

            Swal.fire({

                title: 'Assigned!',

                text: "Section has been assigned to the selected users",

                icon: 'success',

                confirmButtonText: 'Ok',

            }).then((result) =>{

                if (result.isConfirmed) {

                    window.location.href = '<?php echo site_url(); ?>/wp-admin/admin.php?page=learning_sections';

                }

            });

        }

    }

});

});

//notify user with email regarding new learning section
jQuery(document).on('click','.notify-user',function(){
var section_id = jQuery('input[name=section_id]').val();
var userid = jQuery(this).attr('data-userid');
Swal.fire({

    title: 'Are you sure? ',

    text: "Do you want to send an email?",

    icon: 'warning',

    cancelButtonColor: '#d33',

    confirmButtonText: 'Yes, send email',

    showCancelButton: true,

    }).then((result) =>{


    if (result.isConfirmed) {
        var overlay = jQuery('<div id="overlayemail"> Sending email.. Please Wait.. </div>');
        jQuery('body').append(overlay);
        jQuery.ajax({

            url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',

            type: "POST",

            data: {

                action: 'notify_user_with_email',

                section_id : section_id,

                user_id : userid,

            },

            success: function(data) {
                //jQuery('.learning-main-section').append(data);
                if(data == 'success'){
                    jQuery('#overlayemail').remove();
                    Swal.fire({

                        title: 'Email Sent',

                        text: "",

                        icon: 'success',

                        confirmButtonText: 'Ok',

                    });/* .then((result) =>{

                        if (result.isConfirmed) {

                            window.location.href = '<?php echo site_url(); ?>/wp-admin/admin.php?page=learning_sections&action=assign_users&section_id='+section_id;

                        }

                    }); */

                }

            }

        });

    }

    });
});

    //sort learning sections

        $('#ui-sortable').sortable({
        items: 'li', //skip the first to sort
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.sort',
        update: function (event, ui) {
            $(this).attr('disabled', 'disabled');
            var order = [];
            //loop trought each li...
            $('#ui-sortable li:not(:first-child)').each(function (e) {

                //add each li position to the array...     
                // the +1 is for make it start from 1 instead of 0
                order.push($(this).attr('id') + '=' + ($(this).index() + 1));

            });
            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: 'sort_learning_section',
                    sortingorder: order,
                },
                success: function (data) {
                    if (data == 'success') {
                        $(this).removeAttr('disabled');
                        //window.location.href = options_val.site_url+'/wp-admin/admin.php?page=message-settings';
                    }
                }
            });
        }
    });
    });
</script>