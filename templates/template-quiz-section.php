
<?php
if (!defined('my_plugin_dir')) {
    define('my_plugin_dir', plugin_dir_url(__File__));
} 
?>

<div class="wrapper">
<div class="quiz-main-section">
    <?php 
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'quiz_details';
    $list = $wpdb->get_results("SELECT * FROM {$table_name} WHERE quizid = {$_GET['quizid']}");
    $Questions = json_decode($list[0]->question_list, true);
    ?>
    <div class="title-wrap">
        <div class="backto-wrap">
            <a href="<?php echo admin_url('admin.php'); ?>?page=learning_sections&action=edit&section_id=<?php echo $_GET['section_id']; ?>" title="Back to Learning section" class="backtolearning">
                <img src="<?php echo my_plugin_dir.'/images/back.png'; ?>" />
            </a>
            <h1><?php echo $_GET['sub_sec_title']; ?> Quiz</h1> 
        </div><!-- .backto-wrap -->
        <?php if(!empty($list)) : ?>
            <button class="btn btn-danger delete-quiz" data-quizid="<?php echo $_GET['quizid']; ?>" title="Delete Quiz"><span class="dashicons dashicons-trash"></span></button>
        <?php endif; ?>
        
    </div>
    <form action="" id="quiz_ques_form" name="quiz_ques_form" method="">
        <input type="hidden" name="quizid" value="<?php echo $_GET['quizid']; ?>" />
    
        <div class="question-list">
            <?php 
            
            foreach($Questions as $key => $data) {
            ?>
            <div class="que-item">
                <div class="ques-data">
                    <div class="ques-sr">
                        <span class="dashicons dashicons-edit"></span>
                        <span class="question-no"><?php echo $key.'. '; ?></span>
                    </div>
                    <input type="text" placeholder="Enter Question" name="ques_title[]" id="ques_title_<?php echo $key; ?>" value="<?php echo $data['Question']; ?>" class="ques-title-input" readonly/>
                    <label class="ques-lbl"><?php echo $data['Question']; ?></label>
                    <span class="error ques-error"></span>
                </div>
                
                <div class="question-form">
                    
                    <div class="answer-wrap">
                    <?php 
                    foreach($data['Answers'] as $k => $ans) {
                        if(in_array($k,$data['CorrectAnswer'])){ 
                            $selected = 'checked';
                        }else{
                            $selected = '';
                        }
                    ?>
                    
                        <div class="ans-list">
                            <div class="ans-data">
                                <input type="checkbox" name="quiz_answer[]" id="quiz_answer_<?php echo $k; ?>" <?php echo $selected; ?> />
                                <label for="quiz_answer_<?php echo $k; ?>" name="answerlabel"><?php echo $ans; ?></label>
                                <input type="text" placeholder="Enter Answer" value="<?php echo $ans; ?>" name="answer_input[]" id="answer_input_<?php echo $k; ?>" class="answer-input" />
                                <span class="error ans-error"></span>
                            </div>
                            <div class="action">
                                <a href="javascript:void(0);" class="ans-del" data-key="<?php echo $k; ?>" data-ques="<?php echo $key; ?>"><span class="dashicons dashicons-trash"></span></a>
                                <a href="javascript:void(0);" class="ans-edit"><span class="dashicons dashicons-edit"></span></a>
                            </div>
                        </div>
                        <?php 
                    }
                    ?>
                    </div><!-- .answer-wrap -->
                    <span class="error anslist-error"></span>
                    <div class="new-ans-add">
                        <a href="#" class="">+ Add Answer</a>
                    </div>
                    
                    <div class="section-action-btn">
                        <input type="button" name="save_ques" id="save_ques" value="save" class="ques-save-btn">        
                        <input type="button" name="del_ques" value="Delete" class="ques-del-btn" data-quesid="<?php echo $key; ?>" >
                        <a href="javascript:void(0);" onclick="location.reload();">Cancel</a>
                        <div class="loader" style="display:none;">
                            <img class="ajax-loader" src="<?php echo my_plugin_dir  .'/templates/loading.gif'; ?>" />
                        </div>
                    </div>

                </div>  
            </div>
            <?php 
            }
            ?>
        </div>
        <div class="new-que-add">
            <a href="#" class="quiz-blue-btn add-question">Add Question</a>
        </div>  
    </form>
    
</div>
</div><!-- .wrapper -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.all.js" integrity="sha512-aYkxNMS1BrFK2pwC53ea1bO8key+6qLChadZfRk8FtHt36OBqoKX8cnkcYWLs1BR5sqgjU5SMIMYNa85lZWzAw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js" integrity="sha512-vDRRSInpSrdiN5LfDsexCr56x9mAO3WrKn8ZpIM77alA24mAH3DYkGVSIq0mT5coyfgOlTbFyBSUG7tjqdNkNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css" integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>  


<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(document).on('click','.que-item .ques-sr .dashicons-edit',function(e){
            /* if(jQuery(this).hasClass('open')) {
                jQuery(this).removeClass('open');
                jQuery(this).children('.question-form').hide();
                jQuery(this).find('.question-title').show();
                jQuery(this).find('.ques-title-input').hide().prop('readonly','readonly');
            }else{ */
                jQuery('.que-item').hide();
                jQuery('.new-que-add').hide();
                jQuery('.ques-lbl').hide();
                jQuery(this).parents('.que-item').addClass('open').show();
                jQuery(this).parents('.que-item').children('.question-form').show();
                jQuery(this).parents('.que-item').find('.question-title').hide();
                jQuery(this).parents('.que-item').find('.ques-title-input').show().removeAttr('readonly');
            /* } */
        });

        /* ADD NEW ANSWER */

        jQuery(document).on('click', '.new-ans-add a', function(e){

            e.preventDefault();
            var newobj = jQuery(this).parent('.new-ans-add').prev().prev('.answer-wrap').find('.ans-list:last-child').find('input[type=checkbox]');
            console.log(newobj);
            if(newobj.length == 0) {
                var numItems = 'A';
                numItems = String.fromCharCode(numItems.charCodeAt(0));

            }else{
                var numItems = newobj.attr('id').split("_")[2];
                numItems = String.fromCharCode(numItems.charCodeAt(0) + 1);
            }
            //numItems = numItems+1;
            
            var fields = '<div class="ans-list"><div class="ans-data"><input type="checkbox" name="quiz_answer[]" id="quiz_answer_'+numItems+'" /><input placeholder="Enter Answer" type="text" value="" name="answer_input[]" id="answer_input_'+numItems+'" class="answer-input show" /><span class="error ans-error"></span></div><div class="action cross"><a href="javascript:void(0)" onclick="deletethis(jQuery(this))">X</a></div></div>';

            jQuery(this).parent('.new-ans-add').siblings('.answer-wrap').append(fields);

            jQuery(this).show();

        });

        jQuery(document).on('click','.ans-edit',function(){
            jQuery(this).css({'opacity':'0.5','pointer-events':'none'});
            jQuery(this).parents('.ans-list').find('label').hide();
            jQuery(this).parents('.ans-list').find('.answer-input').addClass('show');
        });

        jQuery(document).on('click','.new-que-add a',function(e){
            e.preventDefault();
            jQuery(this).hide();
            jQuery('.que-item').hide();
            var numItems = jQuery('.que-item').length;
            numItems = numItems + 1;

            var fields = '<div class="que-item"><div class="ques-data"><div class="ques-sr"><span class="dashicons dashicons-edit"></span><span class="question-no">'+numItems+'. </span></div><input type="text" placeholder="Enter Question" name="ques_title[]" id="ques_title_'+numItems+'" value="" class="ques-title-input" /><span class="error ques-error"></span></div><div class="question-form" style="display:block;"><div class="answer-wrap"></div><span class="error anslist-error"></span><div class="new-ans-add"><a href="#" class="">+ Add Answer</a></div><div class="section-action-btn"><input type="button" name="save_ques" id="save_ques" value="save" class="ques-save-btn"><a href="javascript:void(0);" class="" onclick="location.reload();">Cancel</a><div class="loader" style="display:none;"><img class="ajax-loader" src="<?php echo get_stylesheet_directory_uri().'/templates/loading.gif'; ?>" /></div></div></div></div>';

            jQuery('.question-list').append(fields);
            

        });

        
        
        // save question answers
        jQuery(document).on('click','#save_ques',function(e){
            e.preventDefault();
            var validation = true;
            var btn = jQuery(this);
            jQuery(this).parents('.que-item').find('.ques-title-input').each(function(){
                var obj = jQuery(this);
                //Question title and answer list validation
                if(jQuery(this).val() == ''){
                    jQuery(this).parents('.ques-data').find('.ques-error').text('Please enter question text.').show();
                    validation = false;
                    console.log('first if flag'+validation);
                }else if(jQuery(this).parents('.que-item').find('input[type="checkbox"]').length == 0) {
                    jQuery(this).parents('.ques-data').find('.ques-error').text('There must be at least one correct answer to this question.').show();
                    validation = false;
                
                }
                else{
                    jQuery(this).parents('.ques-data').find('.ques-error').text('').hide();
                }

                //answer title and checked validation
                obj.parents('.que-item').find('.ans-list').each(function(){
                    if (jQuery(this).parents('.que-item').find('input:checkbox:checked').length == 0) {
                        
                        jQuery(this).parents('.que-item').find('.anslist-error').text('There must be at least one correct answer to this question.').show();
                        validation = false;
                    }else{
                        jQuery(this).parents('.que-item').find('.anslist-error').text('').hide();
                    }
                    console.log('second if flag'+validation);
                    var anslist = jQuery(this).find('input[name="answer_input[]"]');
                    if(anslist.val() == ''){
                        //text is empty.
                        anslist.next('.ans-error').text('Please enter answer text.').show();
                        validation = false;
                    }else{
                        anslist.next('.ans-error').text('').hide();
                    }
                    console.log('third if flag'+validation);
                });
            });
            var arr = [];
            console.log(validation);
            if(validation == true) {
                //var formData = jQuery('#quiz_ques_form').serialize(); // You need to use standard javascript object here
                var questitle = jQuery(this).parents('.que-item').find('input[name="ques_title[]"]').val();
                var quesid = jQuery(this).parents('.que-item').find('input[name="ques_title[]"]').attr('id');
                jQuery(this).parents('.que-item').find('input[name="answer_input[]"]').map(function(){
                    arr.push({"id":jQuery(this).attr('id'), "val" : jQuery(this).val()});
                });
                var answertitle = arr;
                
                var correctanswer = jQuery(this).parents('.que-item').find('input[name="quiz_answer[]"]').map(function(){
                    if(jQuery(this).is(':checked')) {
                        return jQuery(this).attr('id');
                    }
                }).get();
                var quizid = jQuery('input[name="quizid"]').val();
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: "POST",
                    data: {
                        'action': 'save_question_answers_module',
                        'sectionid': '<?php echo $_GET['section_id']; ?>',
                        'subtitle': '<?php echo $_GET['sub_sec_title']; ?>',
                        'questitle': questitle,
                        'quesid': quesid,
                        'quizid': quizid,
                        'answertitle': answertitle,
                        'correctanswer': correctanswer,
                    },
                    beforeSend: function() {
                        jQuery(".loader").show();
                        btn.addClass('overlay');
                    },
                    success: function(data) {
                        jQuery(".loader").hide();
                        btn.removeClass('overlay');
                        var resp = jQuery.parseJSON(data);
                        
                        if(resp.code == 'new_quiz'){
                            
                            let searchParams = new URLSearchParams(window.location.search);
                            
                            searchParams.set("quizid", resp.quizid);
                            window.history.replaceState({}, "", `${window.location.pathname}?${searchParams}`);
                            location.reload();
                                    
                                
                        }else if(resp.code == 'update_quiz'){
                            location.reload();      
                        }
                    }
                });
            }
        });

        //delete answer
        jQuery(document).on('click','.ans-del',function(e){
            e.preventDefault();
            var iconobj = jQuery(this);
            var answerid = jQuery(this).data('key');
            var quesid = jQuery(this).data('ques');
            var quizid = jQuery('input[name="quizid"]').val();
            Swal.fire({

                title: 'Are you sure you want to delete this answer?',

                text: "You won't be able to revert this!",

                icon: 'warning',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Yes, delete it!',

                showCancelButton: true,

                }).then((result) =>{

                if (result.isConfirmed) {

                    jQuery.ajax({

                        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php', 

                        type: "POST",             

                        data: { 

                            action: 'quiz_module_delete_answer_backend', 
                            quesid: quesid,
                            answerid : answerid,
                            quizid: quizid,
                            sectionid: '<?php echo $_GET['section_id']; ?>',
                            subsectiontitle: '<?php echo $_GET['sub_sec_title']; ?>',

                        },      

                        success: function(data) {
                            var resp = jQuery.parseJSON(data);
                            if(resp.code == 'delete_answer'){
                                iconobj.parents('.ans-list').remove();
                                var numItems = jQuery('.answer-wrap .ans-list').length;
                                if(numItems == 1){
                                    jQuery(this).hide();
                                } else{
                                    jQuery(this).show();
                                }
                            } 
                        }
                    });
                }
            });
        });

        //delete question
        jQuery(document).on('click','input[name=del_ques]',function(e){
            e.preventDefault();
            var iconobj = jQuery(this);
            var quesid = jQuery(this).data('quesid');
            var quizid = jQuery('input[name="quizid"]').val();
            Swal.fire({

                title: 'Are you sure you want to delete this Question?',

                text: "You won't be able to revert this!",

                icon: 'warning',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Yes, delete it!',

                showCancelButton: true,

                }).then((result) =>{

                if (result.isConfirmed) {

                    jQuery.ajax({

                        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php', 

                        type: "POST",             

                        data: { 

                            action: 'quiz_module_delete_question_backend', 
                            quesid: quesid,
                            quizid: quizid,
                            sectionid: '<?php echo $_GET['section_id']; ?>',
                            subsectiontitle: '<?php echo $_GET['sub_sec_title']; ?>',

                        },      

                        success: function(data) {
                            var resp = jQuery.parseJSON(data);
                            if(resp.code == 'delete_question'){

                                Swal.fire({

                                    title: 'Deleted!',

                                    text: resp.message,

                                    icon: 'success',

                                    confirmButtonText: 'Ok',

                                }).then((result) =>{

                                    if (result.isConfirmed) {
                                        location.reload();
                                        
                                    }

                                });

                            } 

                        }

                    });

                }

                });
            
        });
        
        //delete QUIZ
        jQuery(document).on('click','.delete-quiz',function(e){
            e.preventDefault();
            var iconobj = jQuery(this);
            var quizid = iconobj.attr('data-quizid');
            Swal.fire({

                title: 'Are you sure you want to delete this QUIZ ?',

                text: "You won't be able to undo this!",

                icon: 'warning',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Yes, delete it!',

                showCancelButton: true,

                }).then((result) =>{

                if (result.isConfirmed) {

                    jQuery.ajax({

                        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php', 

                        type: "POST",             

                        data: { 

                            action: 'quiz_module_delete_quiz_backend', 
                            quizid: quizid,
                        },      

                        success: function(data) {
                            var resp = jQuery.parseJSON(data);
                            if(resp.code == 'delete_quiz'){

                                Swal.fire({

                                    title: 'Deleted!',

                                    text: resp.message,

                                    icon: 'success',

                                    confirmButtonText: 'Ok',

                                }).then((result) =>{

                                    if (result.isConfirmed) {
                                        let searchParams = new URLSearchParams(window.location.search);
                                        
                                        searchParams.has('section_id'); // true
                                        
                                        let id = searchParams.get('section_id');
                                        window.location.href = '<?php echo site_url(); ?>/wp-admin/admin.php?page=learning_sections&action=edit&section_id='+id;
                                        
                                    }

                                });

                            } 

                        }

                    });

                }

                });
            
        });
    });

    


    /* REMOVE SECTION WHEN CLICK ON "X" ICON */
    function deletethis(e){

        jQuery(e).parent().parent().remove();

        var numItems = jQuery('.answer-wrap .ans-list').length;

        if(numItems == 1){

            jQuery(this).hide();

        } else{

            jQuery(this).show();

        }

    }
    function deletethisque(e){

        jQuery(e).parents('.que-item').remove();

        var numItems = jQuery('.que-item').length;

        if(numItems == 1){

            jQuery(this).hide();

        } else{

            jQuery(this).show();

        }
        jQuery('.question-list').load(window.href+'.question-list');
        

    }
</script>
<?php 

/* $Questions = array(
    1 => array(
        'Question' => 'CSS stands for',
        'Answers' => array(
            'A' => 'Computer Styled Sections',
            'B' => 'Cascading Style Sheets',
            'C' => 'Crazy Solid Shapes'
        ),
        'CorrectAnswer' => 'A'
    ),
    2 => array(
        'Question' => 'Second question',
        'Answers' => array(
            'A' => 'First answer of Second question',
            'B' => 'Second answer Second question',
            'C' => 'Third answer Second question'
        ),
        'CorrectAnswer' => 'C'
    )
);

if (isset($_POST['answers'])){
    $Answers = $_POST['answers']; // Get submitted answers.

    // Now this is fun, automated question checking! ;)

    foreach ($Questions as $QuestionNo => $Value){
        // Echo the question
        echo $Value['Question'].'<br />';

        if ($Answers[$QuestionNo] != $Value['CorrectAnswer']){
            echo '<span style="color: red;">'.$Value['Answers'][$Answers[$QuestionNo]].'</span>'; // Replace style with a class
        } else {
            echo '<span style="color: green;">'.$Value['Answers'][$Answers[$QuestionNo]].'</span>'; // Replace style with a class
        }
        echo '<br /><hr>';
    }
} else {
?>
    <form action="grade.php" method="post" id="quiz">
    <?php foreach ($Questions as $QuestionNo => $Value){ ?>
    <li>
        <h3><?php echo $Value['Question']; ?></h3>
        <?php 
            foreach ($Value['Answers'] as $Letter => $Answer){ 
            $Label = 'question-'.$QuestionNo.'-answers-'.$Letter;
        ?>
        <div>
            <input type="radio" name="answers[<?php echo $QuestionNo; ?>]" id="<?php echo $Label; ?>" value="<?php echo $Letter; ?>" />
            <label for="<?php echo $Label; ?>"><?php echo $Letter; ?>) <?php echo $Answer; ?> </label>
        </div>
        <?php } ?>
    </li>
    <?php } ?>
    <input type="submit" value="Submit Quiz" />
    </form>
<?php 
} */
?>