<?php 
if (!defined('my_plugin_dir')) {
    define('my_plugin_dir', plugin_dir_url(__File__));
}
global $wpdb;

$value = $args['val'];
$userid = $args['userid'];
$username = $args['username'];
$useremail = $args['email'];
$score_arr = $score_quizarr = array();
$quiztable = $wpdb->prefix.'quiz_details';
$quiz_user = $wpdb->prefix.'quiz_user_details';
$score_sql = $wpdb->get_results("SELECT quizid,score FROM {$quiz_user} WHERE userid={$userid} and quizid IN (SELECT quizid FROM {$quiztable} WHERE sectionid={$value['id']}) ",ARRAY_A);

if(!empty($score_sql)) :
    foreach($score_sql as $row) {
        
        $score_data = json_decode($row['score'],true);
        $score_arr[] = $score_data['percentage'];
        $score_sql_row = $wpdb->get_row("SELECT subsection_title from {$quiztable} where quizid = {$row['quizid']}",ARRAY_A);
        $subsectitle = explode("_",$score_sql_row['subsection_title'])[1];
        $score_quizarr[$subsectitle] = $score_data['percentage'];
    }
    
    if(!empty($score_arr)) :
        $avg = array_sum($score_arr) / count($score_arr);
    endif;

    $quiz_score = round($avg);

    if($avg != ''){
        if($quiz_score == get_option('gold_score_min')):
            $cls = 'trophygold.png';
        elseif($quiz_score >= get_option('silver_score_min') && $quiz_score <= (get_option('gold_score_min') - 1)):
            $cls = 'trophysilver.png';
        elseif($quiz_score >= get_option('bronze_score_min') && $quiz_score <= (get_option('silver_score_min') - 1)):
            $cls = 'trophybronze.png';
        elseif($quiz_score >= get_option('fail_score_min') && $quiz_score <= (get_option('bronze_score_min') - 1)):
            $cls = 'trophyx.png';
        endif;
        $average = '<img src="'.my_plugin_dir.'/images/'.$cls.'" style="width:25px;" />';
    }else{
        $average = '';
    }
endif;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <title>EmailTemp</title>

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
                                                    <h1 style="margin-bottom: 15px;">Hey <?php echo $username; ?>,</h1>
                                                    <p style="margin-bottom: 15px;font-size: 20px;">You have a new course ready to complete</p>
                                                    <p style="text-align:center;margin-bottom: 15px;">
                                                        <a href="" style="color: #14a59c;display: inline-block;font-weight:300;font-size:22px;">Click the start button to begin</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- how we work parent table block starts here  -->
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center"
                                        style="margin-top: 10px;">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#fff" style="padding:40px 30px;border-radius:8px;">
                                                    <!-- how we work table starts  -->
                                                    <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                                        <tr>
                                                            <td width="25%" align="left">
                                                                
                                                                <span style="display: inline-block; vertical-align: middle; width: 100px; height: 100px; border-radius: 50%; background-color: #e6f7ff; text-align: center; line-height: 100px; padding: 10px;">
                                                                    <?php if (!empty($value['image_icon'])) : ?>
                                                                        <img src="<?php echo $value['image_icon']; ?>" alt="learning icon" style="max-width: 100%; max-height: 100%; border-radius: 50%;">
                                                                    <?php endif; ?>
                                                                </span>

                                                            </td>
                                                            <td width="75%" align="left" style="padding-left:15px ;">
                                                                <h3 style="color:#000;margin-bottom: 10px;"><?php echo $value['title']; ?> </h3>
                                                                <?php 
                                                                $count = 0;

                                                                    foreach ($value['pages'] as $key => $v) {
                                                                        if($v['status'] == 'completed' ){
                                                                            $sectionid = $value['id'];
                                                                            $count++;
                                                                        }
                                                                    }
                                                                    foreach ($value['pages'] as $key => $vv) {
                                                                        if($vv['status'] != 'completed' ){
                                                                            $link = $vv['sub_start_url'].'?step='.$vv['sub_title'];
                                                                            break;
                                                                        }
                                                                    }

                                                                    if($value['is_all_complated'] == 1){ ?>
                                                                       
                                                                        <a href="javascript:void(0)" style="display:inline-block;color:#5699e0;text-transform: uppercase;padding: 8px 30px;border: 1px solid #5699e0;font-size: 16px;">Completed</a>
                                                                        <br/>
                                                                        <a href="javascript:void(0)" class="redo-course" data-sid="<?php echo $sectionid; ?>" style="display:inline-block;color:#5699e0;text-transform: uppercase;padding: 8px 30px;border: 1px solid #5699e0;font-size: 16px;margin-top:10px;">Redo Course</a>
                                                                    
                                                                    <?php } else if($count == 0){ ?>
                                                                        <a href="<?php echo $link; ?>" style="display:inline-block;color:#5699e0;text-transform: uppercase;padding: 8px 30px;border: 1px solid #5699e0;font-size: 16px;">Start</a>
                                                                        
                                                                    <?php } else{ ?>
                                                                        <a href="<?php echo $link; ?>" style="display:inline-block;color:#5699e0;text-transform: uppercase;padding: 8px 30px;border: 1px solid #5699e0;font-size: 16px;">Continue</a>
                                                                    <?php } ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- how we work table ends  -->

                                                    <!-- list table starts  -->
                                                    <?php if(!empty($value['pages'])){ ?>
                                                    <table width="100%" cellpadding="0" cellspacing="0" align="center"
                                                        style="margin-top:70px; margin-bottom: 30px;">
                                                        <tr>
                                                            <td style="padding-bottom: 70px;border-bottom: 1px solid #eee;">
                                                            <?php 
                                                                $total_steps = 0;
                                                                $total_completed_step = 0;
                                                                foreach ($value['pages'] as $key => $learning_subsec) { 
                                                                    ?>
                                                                    <table  width="100%" cellpadding="0" cellspacing="0" align="center">
                                                                        <tbody>
                                                                            <tr>
                                                                            <?php
                                                                            $complated_class = '';
                                                                            if($learning_subsec['status'] == 'completed'){
                                                                                $complated_class = 'completed';
                                                                                $total_completed_step++;
                                                                                $sis = round($score_quizarr[$key]); //$sis = section individual score
                                                                                
                                                                                if($sis == '100') {
                                                                                    $complated_class = ' green-check';
                                                                                    ?>
                                                                                    <td width="50%" align="left" valign="middle" style="padding-bottom: 20px;">
                                                                                        <p style="font-size:18px;font-weight:600;">
                                                                                            <a href="<?php echo $learning_subsec['sub_start_url'].'?step='.urlencode($learning_subsec['sub_title']); ?>" style="color:#757376;"><?php echo $learning_subsec['sub_title']; ?></a>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td width="50%" align="right" valign="middle" style="padding-bottom: 20px;">
                                                                                        <img src="<?php echo site_url(); ?>/wp-content/uploads/2022/02/check-3-1.png" style="height:20px;width:20px;"/>
                                                                                    </td>
                                                                                    <?php
                                                                        
                                                                                }elseif($sis < '100' || $sis == ''){
                                                                                    $complated_class = ' red-check';
                                                                                    ?>
                                                                                    <td width="50%" align="left" valign="middle" style="padding-bottom: 20px;">
                                                                                        <p style="font-size:18px;font-weight:600;">
                                                                                            <a href="<?php echo $learning_subsec['sub_start_url'].'?step='.urlencode($learning_subsec['sub_title']); ?>" style="color:#757376;"><?php echo $learning_subsec['sub_title']; ?></a>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td width="50%" align="right" valign="middle" style="padding-bottom: 20px;">
                                                                                        <img src="<?php echo site_url(); ?>/wp-content/uploads/2022/10/check-red.png" style="height:20px;width:20px;"/>
                                                                                    </td>
                                                                                    <?php
                                                                                }  

                                                                            }else{
                                                                                $complated_class = '';
                                                                                ?>
                                                                                <td width="50%" align="left" valign="middle" style="padding-bottom: 20px;">
                                                                                    <p style="font-size:18px;font-weight:600;">
                                                                                        <a href="<?php echo $learning_subsec['sub_start_url'].'?step='.urlencode($learning_subsec['sub_title']); ?>" style="color:#757376;"><?php echo $learning_subsec['sub_title']; ?></a>
                                                                                    </p>
                                                                                </td>
                                                                                <td width="50%" align="right" valign="middle" style="padding-bottom: 20px;">
                                                                                    
                                                                                </td>
                                                                                <?php
                                                                                
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                <?php
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <?php 
                                                    } 
                                                    ?>
                                                    <!-- list table ends  -->
                                                    <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                                        <tr>
                                                            <td width="50%" align="left" style="padding-bottom:10px;">
                                                                <h3 style="color: #000;">
                                                                    <?php 
                                                                    if($average == '') {
                                                                        echo 'My Progress';
                                                                    }else{
                                                                        echo 'My Score';
                                                                    }
                                                                    ?>
                                                                </h3>
                                                            </td>
                                                            <td width="50%" align="right" style="padding-bottom:10px;" valign="middle">
                                                                <p style="color: #757376;" valign="middle">
                                                                    <?php 
                                                                    if($average == '') {
                                                                        $pro_percentage = 0;
                                                                        if($total_completed_step > 0){
                                                                            $pro_percentage = 100 / $total_steps;
                                                                            $pro_percentage = $pro_percentage * $total_completed_step;
                                                                        }
                                                                        echo '<span>'.round($pro_percentage).'%</span>';
                                                                        $final_per = round($pro_percentage);
                                                                    }else{

                                                                        echo '<span>'.$quiz_score.'%</span>';
                                                                        echo $average;
                                                                        $final_per = $quiz_score;
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="pro-percentage-bar" style="height: 10px;border-radius: 10px;background: #d2d1d3;margin-top: 0px;position: sticky;z-index: 0;">
                                                                    <div class="current-progress" style="background: #4d9ffc;content: '';display: block;height: 10px;border-radius: 10px;z-index: 1;width: <?php echo $final_per; ?>%;"></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- how we work parent table block ends here  -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- content ends here  -->

                    <!-- green content stripe starts here  -->
                    <table width="100%" cellpadding="0" cellspacing="0" align="center" bgcolor="#00b832">
                        <tbody>
                            <tr>
                                <td style="padding: 10px; font-size: 14px;">
                                    <table width="80%" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td width="28%" align="left" style="text-align:center;">
                                                <a href="" style="color: #fff;font-weight: 300;">
                                                    <b>Login Details</b>
                                                </a>
                                            </td>
                                            <td width="40%" align="left" style="text-align:center;">
                                                <a href="" style="color: #fff;font-weight: 300;">Username : <?php echo $username; ?></a>
                                            </td>
                                            <td width="32%" align="left" style="text-align:center;">
                                                <a href="" style="color: #fff;font-weight: 300;">Password : ******</a>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                        </tbody>
                    </table>
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