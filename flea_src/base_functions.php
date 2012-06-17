<?php
require_once('classes/flea.inc');

function rand_polaroids(){
    $polaroid_mod = rand(1,4);
    switch($polaroid_mod){
        case '1':
            return 'p2';
        break;
        case '2':
            return 'p3';
        break;
        case '3':
            return 'm2';
        break;
        case '4':
            return 'm3';
        break;
    }
}

function ajaxShowPage($curpage, $total_page, $div2chang, $action_url, $paras){
	$output = "<div class='apagination'>";
		$pos = strrpos($div2chang, "-");
		if($pos!=0){
			$type = substr($div2chang,$pos+1);
		}else{
			$type = $div2chang;
		}
		if($total_page>5){
			if($curpage!=0){
				$pre = $curpage-1;
				$parameters = $action_url . "?" . $paras ."&page=".$pre;
				$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");' class='prevpage'>上一頁</a>&nbsp;";
			}
			if($curpage==0){
				$output.= "<span class=\"selected\">1</span>&nbsp;";
			}else{
				$parameters = $action_url . "?" . $paras ."&page=0";
				$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");'>1</a>";
			}
			if($curpage-1>1){
				$output.= "...";
			}
			for($i=1;$i<$total_page-1;$i++){
				$show_page = $i+1;
				if($i==$curpage-1){
					$parameters = $action_url . "?" . $paras ."&page=".$i;
					$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");'>".$show_page."</a>";
				}
				if($curpage==$i){
					$output.= "<span class=\"selected\">".$show_page."</span>&nbsp;";
				}
				if($i==$curpage+1){
					$parameters = $action_url . "?" . $paras ."&page=".$i;
					$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");'>".$show_page."</a>";
				}
			}
			//後點點點
			if($curpage+1<$total_page-1){
				$output.= "...";
			}
			//必顯示:最後一頁
			if($curpage==$total_page-1){
				$output.= "<span class=\"selected\">$total_page</span>&nbsp;";
			}else{
				$show = $total_page-1;
				$parameters = $action_url . "?" . $paras ."&page=".$show;
				$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");'>$total_page</a>";
			}
			//尾: 下一頁
			if($curpage!=$total_page-1){
				$next = $curpage+1;
				$parameters = $action_url . "?" . $paras ."&page=".$next;
				$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");' class=\"nextpage\">下一頁</a>";
			}
		
		}else{//directly show all link box
			//process from left to right element
			//頭:上一頁
			if($curpage!=0){
				$pre = $curpage-1;
				$parameters = $action_url . "?" . $paras ."&page=".$pre;
				$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");' class=\"prevpage\">上一頁</a>&nbsp;";
			}
			for($i=0;$i<$total_page;$i++){
				$show_page = $i+1;
				//中間:數字頁
				if($curpage==$i){
					if($total_page!=1){
						$output.= "<span class=\"selected\">".$show_page."</span>&nbsp;";
					}
				}else{
					$parameters = $action_url . "?" . $paras ."&page=".$i;
					$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");'>".$show_page."</a>&nbsp;";
				}
			}
			//尾: 下一頁
			if($curpage!=$total_page-1&&$total_page!=0){
				$next = $curpage+1;
				$parameters = $action_url . "?" . $paras ."&page=".$next;
				$output.= "<a onclick='loadAjaxPageContent(\"".$div2chang."\",\"".$parameters."\");' class=\"nextpage\">下一頁</a>";
			}
		}
        $output.= "</div>";
		return $output;
}

function showDateTime($datetime){
	global $lang;
	$now = time();
	$date2 = @strtotime($datetime);
	$dateDiff = $now - $date2;
	$fullDays = floor($dateDiff/(60*60*24));
	$fullHours = floor(($dateDiff-($fullDays*60*60*24))/(60*60));
	$fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);
	
	$today = @mktime (0,0,0,@date("m"),@date("d"),@date("Y"));
	$yesterday = @mktime (0,0,0,@date("m"),(@date("d")-1),@date("Y"));
	$dateDiffFromToday = $date2 - $today;
	$fullDaysFromToday = floor($dateDiffFromToday/(60*60*24));
	$fullHoursFromToday = floor(($dateDiffFromToday-($fullDays*60*60*24))/(60*60));
	
	if($fullDays==0){
		if($fullHours > 18){
			if($fullHoursFromToday > 0){
				return "今天 "." ".@date("G:i",$date2);
			}else{
				return "昨天 "." ".@date("G:i",$date2);
			}
		}else if($fullHours > 1){
			return $fullHours." 小時前";
		}else if($fullHours == 1){
			return " 1小時前";
		}else{
			if($fullMinutes > 1){
				return $fullMinutes." 分鐘前";
			}else{
				return " 1分鐘前";
			}
		}
	}else if($fullDays==1){
		if($fullHoursFromToday > -48){
			return "昨天 "." ".@date("G:i",$date2);
		}else{
			return @date("Y/m/d",@strtotime($datetime));
		}
	}else{
		return @date("Y/m/d",@strtotime($datetime));
	}
}


?>