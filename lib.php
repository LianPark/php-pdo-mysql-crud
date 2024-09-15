<?php
// 메타태그를 이용한 URL 이동
function goto_url($url)
{
    $url = str_replace("&amp;", "&", $url);

    if (!headers_sent())
        header('Location: '.$url);
    else {
        echo '<script>';
        echo 'location.replace("'.$url.'");';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
    exit;
}

// 경고메세지를 경고창으로
function alert($msg='', $url='', $error=true, $post=false)
{
    global $g5, $config, $member, $is_member, $is_admin, $board;

    $msg = $msg ? strip_tags($msg, '<br>') : '올바른 방법으로 이용해 주십시오.';

    $header = '';
    if (isset($g5['title'])) {
        $header = $g5['title'];
    }
    //include_once(G5_BBS_PATH.'/alert.php');
    echo '<script>';
    echo 'alert("'.$msg.'");';
    if ($url) {
      echo 'document.location.replace(' . str_replace('&amp;', '&', $url) .')';
    } else {
      echo 'history.back()';
    }
    echo '</script>';
    exit;
}

function print_r2($var)
{
    ob_start();
    print_r($var);
    $str = ob_get_contents();
    ob_end_clean();
    $str = str_replace(" ", "&nbsp;", $str);
    echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
}