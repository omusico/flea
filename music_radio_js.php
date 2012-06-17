<?
require_once($_SERVER['DOCUMENT_ROOT'].'/anm/src/music_radio_src/music_radio_base_functions.php');
?>
// start of 文件下載完成後 執行javascript元件的安裝
jQuery(document).ready(function(){
	
	// start of facebook javascript api 初始化
	window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        FB.getLoginStatus(function(response) {
          if (response.session) {
            //onConnected();
          } else {
            //onNotConnected();
          }
        });
        
        FB.Event.subscribe('edge.create', function(response) {
            if(response!=''){
				var trim_like_resp = response.split("/");
                var like_thing_id = trim_like_resp[4];
				var like_thing_type = trim_like_resp[3];

            	var action_url = '/db_includes/fb_like_thumb_up_action.php';
                var action_pars = 'like_thing_type='+like_thing_type+'&like_thing_id='+like_thing_id;
                $.ajax({
				    url: action_url, 
				    type: "POST",
				    dataType: "html",
				    data: action_pars,
				    success:function(msg){
				    }
				});
            }
        });
    };

    (function() {
        var e = document.createElement('script');
        //e.src = document.location.protocol + '//connect.facebook.net/zh_TW/all.js';
        //e.src = document.location.protocol + "//static.ak.fbcdn.net/connect/en_US/core.debug.js";
		e.src = document.location.protocol + '//www.indievox.com/js/fb_connect_zh_local.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
    // end of facebook javascript api 初始化

	// start of music genius 開關動畫
	var music_genius_opened = '0';
	$(function() {
		function toggle_music_genius(){
			switch (music_genius_opened){
				case '0':
					$('#music_genius_handle').animate({"marginLeft": "-=5px"}, "fast"); 
					$('#music_genius').animate({"marginLeft": "-=0px"}, "fast");
					$('#music_genius_handle').animate({"marginLeft": "+=387px"}, "slow"); 
					$('#music_genius').animate({"marginLeft": "+=390px"}, "slow");
					music_genius_opened = '1';
				break;
				case '1':
					$('#music_genius').animate({"marginLeft": "-=390px"}, "slow");
					$('#music_genius_handle').animate({"marginLeft": "-=387px"}, "slow").animate({"marginLeft": "+=5px"}, "fast"); 
					music_genius_opened = '0';	
				break;
			}
		};

		$( "#music_genius_handle" ).click(function() {
            toggle_music_genius();
            return false;
        });
	});
	// end of music genius 開關動畫

	// start of 照片 slideshow 初始化
	var obj = jQuery("#fullscreen");
    function _init(){
		obj.jbgallery({
            menu  : false,
            style : 'zoom',
            randomize : 0,
            slideshow:true
        });
		$("#wrapper_all").css("visibility", "visible");
    }
	// end of 照片 slideshow 初始化
	
	// start of 取得圖片及音樂
	var req_url = "action/music_radio_action/get_song_action.php";
    $.ajax({
        url: req_url, 
        type: "GET",
        dataType: "json",
        data:"mode=g&channel=0g0",
        success:function(msg){
            if(msg.status=='success'){
                $('.jbgallery ul').empty();
                $(msg.photo_array).each(function(i, item){
                    $('.jbgallery ul').append('<li><a href="' + item.photo_url + '">' + item.photo_name + '</a></li>');
                });

				$("#jquery_jplayer_1").jPlayer({
					ready: function () {
						$(this).jPlayer("setMedia", {
							mp3:msg.audio_stream
						}).jPlayer("play");
						//$('#jplayer_play_btn').css('display', 'none');
					},
					timeupdate: function(event) {
						$("#play_status").html($.jPlayer.convertTime(Math.floor(event.jPlayer.status.currentTime)));
					},
					ended: function (event) {
						play_new_song();
					},
					swfPath: "http://www.indievox.com/library/jquery-jplayer-demos-2.0.0/js",
					supplied: "mp3",
					<? if($user_browser['name']=='Google Chrome') { ?>
					solution: 'flash, html',
					<? } else { ?>
					solution: 'html, flash',
					<? } ?>
					preload: 'metadata'
					//errorAlerts: true,
					//warningAlerts: true
				});
				
				build_song_block(msg);
				count_play_song();

                $('#song_info_block').fadeIn('slow', function() {
                    // Animation complete
                });

				_init();
				
            } else {

            }
        }
    });
	// end of of 取得圖片及音樂
});
// end of 文件下載完成後 執行javascript元件的安裝

// start of 播放器控制按鈕
/*$(function() {
    $( "#song_info_btn" ).click(function() {
		var options = {};
        $( "#song_info_block" ).toggle( "explode", options, 500 );
        return false;
    });
});*/
$(function() {
    $( "#jplayer_play_btn" ).click(function() {
		$("#jquery_jplayer_1").jPlayer("play");
		//$("#jplayer_play_btn").css("display", "none");
		//$("#jplayer_pause_btn").css("display", "block");
        return false;
    });
});
$(function() {
    $( "#jplayer_pause_btn" ).click(function() {
		$("#jquery_jplayer_1").jPlayer("pause");
		//$("#jplayer_pause_btn").css("display", "none");
		//$("#jplayer_play_btn").css("display", "block");
        return false;
    });
});
// end of 播放器控制按鈕

// start of current song variable
var current_song_id = '';
var current_fb_song_title = '';
var current_fb_song_des = '';
var current_fb_song_artist = '';
var current_song_url = '';
var current_song_cover = '';
// end of current song variable

// start of facebook publish stream function
function indievox_fb_publish(){
    FB.ui(
       {
         method: 'stream.publish',
         message: '',
         attachment: {
           name: current_fb_song_title+" - "+current_fb_song_artist,
           caption: current_fb_song_title+" - "+current_fb_song_artist,
           description: (
           		current_fb_song_des
           ),
           href: current_song_url,
           media: [{'type': 'flash', 'swfsrc': "http://www.indievox.com/swf/indievox_player.swf?pid="+current_song_id+"&ptype=song&initPlay=1", 'imgsrc': current_song_cover, 'expanded_width': '320', 'expanded_height': '260'}]
         },
         action_links: [
           { text: current_fb_song_title+" - "+current_fb_song_artist, href: current_song_url }
         ],
         user_message_prompt: '<?=$lang['radioshare']?> '+current_fb_song_title+' - '+current_fb_song_artist
       },
       function(response) {
         if (response && response.post_id) {
           //alert('Post was published.');
         } else {
           //alert('Post was not published.');
         }
       }
     );
}
// end of facebook publish stream function

// start of radio globle variable
var mode = 'g';
var channel = '0g0';
// end of radio globle variable

// start of radio title string function
function update_radio_title(){
	var radio_title_string = '';
	switch (mode){
		case 'a':
			switch (channel){
				case 'popular':
					radio_title_string = 'iV Popular Radio';
				break;
				case 'hot':
					radio_title_string = 'iV Hot Radio';
				break;
				case 'new':
					radio_title_string = 'iV News Radio';
				break;
				case 'pwys':
					radio_title_string = 'iV PWYW Radio';
				break;
				case 'power':
					radio_title_string = 'iV Power Radio';
				break;
				case 'party':
					radio_title_string = 'iV Party Radio';
				break;
				case 'library':
					radio_title_string = 'iV Library Radio';
				break;
				case 'favorite':
					radio_title_string = 'iV Favorite Radio';
				break;
				case 'random':
					radio_title_string = 'iV Random Radio';
				break;
			}
		break;
		case 'm':
			switch (channel){
				case 's_1':
					radio_title_string = 'iV Relax Radio';
				break;
				case 'm_1':
					radio_title_string = 'iV Happy Radio';
				break;
				case 'f_1':
					radio_title_string = 'iV Excited Radio';
				break;
				case 's_0':
					radio_title_string = 'iV Sad Radio';
				break;
				case 'm_0':
					radio_title_string = 'iV Cry Radio';
				break;
				case 'f_0':
					radio_title_string = 'iV Angry Radio';
				break;
			}
		break;
		case 'k':
			switch (channel){
				case '0m1':
					radio_title_string = 'iV C Major Radio';
				break;
				case '1m1':
					radio_title_string = 'iV #C Major Radio';
				break;
				case '2m1':
					radio_title_string = 'iV D Major Radio';
				break;
				case '3m1':
					radio_title_string = 'iV #D Major Radio';
				break;
				case '4m1':
					radio_title_string = 'iV E Major Radio';
				break;
				case '5m1':
					radio_title_string = 'iV F Major Radio';
				break;
				case '6m1':
					radio_title_string = 'iV #F Major Radio';
				break;
				case '7m1':
					radio_title_string = 'iV G Major Radio';
				break;
				case '8m1':
					radio_title_string = 'iV #G Major Radio';
				break;
				case '9m1':
					radio_title_string = 'iV A Major Radio';
				break;
				case '10m1':
					radio_title_string = 'iV #A Major Radio';
				break;
				case '11m1':
					radio_title_string = 'iV B Major Radio';
				break;
				case '0m0':
					radio_title_string = 'iV C Minor Radio';
				break;
				case '1m0':
					radio_title_string = 'iV #C Minor Radio';
				break;
				case '2m0':
					radio_title_string = 'iV D Minor Radio';
				break;
				case '3m0':
					radio_title_string = 'iV #D Minor Radio';
				break;
				case '4m0':
					radio_title_string = 'iV E Minor Radio';
				break;
				case '5m0':
					radio_title_string = 'iV F Minor Radio';
				break;
				case '6m0':
					radio_title_string = 'iV #F Minor Radio';
				break;
				case '7m0':
					radio_title_string = 'iV G Minor Radio';
				break;
				case '8m0':
					radio_title_string = 'iV #G Minor Radio';
				break;
				case '9m0':
					radio_title_string = 'iV A Minor Radio';
				break;
				case '10m0':
					radio_title_string = 'iV #A Minor Radio';
				break;
				case '11m0':
					radio_title_string = 'iV B Minor Radio';
				break;
			}
		break;
		case 'g':
			switch (channel){
				case '0g0':
					radio_title_string = 'iV Alternative Radio';
				break;
				case '1g0':
					radio_title_string = 'iV Rock Radio';
				break;
				case '2g0':
					radio_title_string = 'iV Hip Hop/R&B Radio';
				break;
				case '3g0':
					radio_title_string = 'iV Jazz Radio';
				break;
				case '4g0':
					radio_title_string = 'iV Electronic Radio';
				break;
				case '5g0':
					radio_title_string = 'iV World Radio';
				break;
				case '6g0':
					radio_title_string = 'iV Sound Track Radio';
				break;
				case '7g0':
					radio_title_string = 'iV Pop Radio';
				break;
				case '8g0':
					radio_title_string = 'iV Folk Radio';
				break;
			}
		break;
		default:
		break;
	}
	$("#radio_title_block").html(radio_title_string);
}
// end of radio title string function

function systemMsg(msg){
	$("#radio_alert_block").html(msg);
	$("#radio_alert_wrapper").fadeIn('slow', function() {
    	// Animation complete
		setTimeout(function() {
			$('#radio_alert_wrapper').fadeOut('slow', function() {
                // Animation complete
				$("#radio_alert_block").html("");
            });
		}, 1000 );
    });
}

// start of 更新歌曲按鈕
function update_song_func_block(song_id){
	var req_url = "/anm/action/music_radio_action/update_song_func_block_action.php";
	$("#song_func_block").html('<img src="http://www.indievox.com/images/loadingGraphic.gif" style="margin:5px;" />');

	$.ajax({
	    url: req_url, 
	    type: "GET",
	    dataType: "html",
	    data:"song_id="+song_id,
	    success:function(msg){
	        $("#song_func_block").html(msg); 
	    }
	});
}
// end of 更新歌曲按鈕

// start of 更新歌曲資訊區塊
function build_song_block(msg){
	current_song_id = msg.song_id;
	current_fb_song_title = msg.fb_song_title;
	current_fb_song_des = msg.fb_song_des;
	current_fb_song_artist = msg.fb_song_artist_name;
	current_song_url = msg.song_url;
	current_song_cover = msg.song_cover_url;
	
	var mode = msg.mode;

	var key_string = '';
	if(msg.song_key!=null && msg.song_mode!=null){
		key_string = '<?=$lang['key'].$lang['colon']?>'+msg.song_key+' '+msg.song_mode+'<br/>';
	}
	var disc_title_string = '';
	if(msg.song_disc_title!=''){
		disc_title_string = '<h2><a href="'+msg.song_disc_url+'" target="_lfr">'+msg.song_disc_title+'</a></h2>';
	}
	var song_is_mp = '';
	if(msg.song_is_mp){
		song_is_mp = '<div style="margin:5px 0px;">'+
						'<span style="background-color:#ffff00;color:#000;font-size:11px;padding:2px 4px;font-weight:normal;margin-right:3px;"><?=$lang["MonthlyPass"]?></span>'+
					 '</div>';
	}
	
	var song_des = '';
	var social_string = '';
	var current_song_head = '';
	var cover_url = '';
	if(mode=='ad'){
		disc_title_string = '';
		current_song_head = 
		'<h1><a href="'+msg.song_url+'" target="_lfr">'+msg.song_title+'</a></h1>';
		song_des = 
		'<p>'+
			msg.song_description+
		'</p>';
		cover_url = msg.song_url;
		
	} else {
		current_song_head = 
		'<h1><a href="'+msg.song_url+'" target="_lfr">'+msg.song_title+'</a> - <a href="http://www.indievox.com/'+msg.song_artist_path+'" target="_lfr">'+msg.song_artist_name+'</a></h1>';
		song_des =
		'<p>'+
			song_is_mp+
			key_string+
			'<?=$lang['style']?><?=$lang['colon']?>'+msg.song_subgenre+'<br/>'+
			'<?=$lang['genre']?><?=$lang['colon']?>'+msg.song_genre+'<br/>'+
			'<?=$lang['ReleaseDate']?><?=$lang['colon']?>'+msg.song_release_date+
		'</p>';
		
		social_string = 
		'<div id="fb_like_btn_block">'+
			'<fb:like href="'+msg.song_url+'" layout="button_count" show_faces="false" width="100"></fb:like>'+
		'</div>'+
		'<div style="float:right;margin-top:12px;">'+
	        '<a title="Twitter" href="http://twitter.com/home?status='+encodeURIComponent(msg.song_title+' '+msg.song_url)+'" target="_blank"><img src="http://data.indievox.com/images/png-fillbg.php?img=ico_twitter.png" border="0" /></a>'+
		'</div>'+
	    '<div style="float:right;margin-right:5px;margin-top:12px;">'+
	        '<a title="Plurk" href="http://www.plurk.com/m?content='+encodeURIComponent(msg.song_url+' ('+msg.song_title+')')+'&qualifier=shares" target="_blank"><img src="http://data.indievox.com/images/png-fillbg.php?img=ico_plurk.png" border="0" /></a>'+
	    '</div>'+
		'<div style="float:right;margin-right:8px;margin-top:12px;">'+
	        '<a title="Facebook" onclick="indievox_fb_publish()" ><img src="http://data.indievox.com/images/png-fillbg.php?img=ico_facebook.png" border="0" /></a>'+
	    '</div>';
		cover_url = "http://www.indievox.com/"+msg.song_artist_path;
	}
	
	$("#song_info_block").html(
		'<div class="cnt" id="contact">'+
			'<div class="wrapper">'+
				'<div id="song_info_text">'+
					current_song_head+
					disc_title_string+
					song_des+
					'<div id="song_func_block">'+ 
		            '</div>'+
				'</div>'+
				'<div id="song_info_cover">'+
					'<a href="'+cover_url+'" target="_lfr"><img border="0" width="180" src="'+msg.song_cover_url+'"/></a>'+
					'<div id="social_block">'+
						social_string+
					'</div>'+
				'</div>'+
				'<div class="clearboth"><hr></div>'+
			'</div>'+
		'</div>'
    );
	if(mode!='ad'){
		update_song_func_block(msg.song_id);
	}
	get_song_lyric(msg.song_id);
	<? if($login_user!='guest'){ ?>
	build_tag_block();
	<? } ?>
	FB.XFBML.parse();
}
// end of 更新歌曲資訊區塊

// start of 動態消息發送
function send_feed(feeder_id,thing_id,type){
	$.ajax({
            url: "/anm/action/music_radio_action/send_feed_action.php", 
            type: "POST",
            dataType: "html",
            data:"feeder_id="+feeder_id+"&thing_id="+thing_id+"&type="+type,
            success:function(msg){
				$('#send_feed_block').html(msg);
			}
	});
}
// end of 動態消息發送

// start of 購買歌曲按鈕控制
function buy_music(thing_id,price,payway,type,buy_mode){
	$.ajax({
            url: "/anm/action/music_radio_action/buy_music_action.php", 
            type: "POST",
            dataType: "json",
            data:"thing_id="+thing_id+"&price="+price+"&payway="+payway+"&type="+type+"&buy_mode="+buy_mode,
            success:function(msg){
				switch(msg.status){
					case 'success':
						switch(msg.message){
							case 'bonus_done':
								$('#buy_btn_block').html(
									'<div id="buy_btn_price_text">'+
										"<?=$lang['purchased']?>"+
									'</div>'+
									'<div class="buy-song">'+
										'<img src="http://www.indievox.com/images/ico_downloaded.png" />'+
									'</div>'	
								);
								$("#radio_alert_block").html('<?=$lang["PurchaseSuccessful"];?> <a href="/m/downloads"> <?=$lang["Go2MyDownloads"];?></a>');
								$("#mt_num").html(msg.mt_num);
								$("#radio_alert_wrapper").fadeIn('slow', function() {
				                	// Animation complete
									setTimeout(function() {
										$('#radio_alert_wrapper').fadeOut('slow', function() {
					                        // Animation complete
											$("#radio_alert_block").html("");
					                    });
									}, 1000 );
				                });
							break;
							case 'mt_done':
								$('#buy_btn_block').html(
									'<div id="buy_btn_price_text">'+
										"<?=$lang['purchased']?>"+
									'</div>'+
									'<div class="buy-song">'+
										'<img src="http://www.indievox.com/images/ico_downloaded.png" />'+
									'</div>'	
								);
								$("#radio_alert_block").html('<?=$lang["PurchaseSuccessful"];?> <a href="/m/downloads"> <?=$lang["Go2MyDownloads"];?></a>');
								$("#mt_num").html(msg.mt_num);
								$("#radio_alert_wrapper").fadeIn('slow', function() {
				                	// Animation complete
									setTimeout(function() {
										$('#radio_alert_wrapper').fadeOut('slow', function() {
					                        // Animation complete
											$("#radio_alert_block").html("");
					                    });
									}, 1000 );
				                });
							break;
							case 'add_to_cart':
								$("#radio_alert_block").html('<?=$lang["AddedToCart"];?> <a href="/my/shopping-cart"> <?=$lang["ViewShoppingCart"];?></a>');
								$("#radio_alert_wrapper").fadeIn('slow', function() {
				                	// Animation complete
									setTimeout(function() {
										$('#radio_alert_wrapper').fadeOut('slow', function() {
					                        // Animation complete
											$("#radio_alert_block").html("");
					                    });
									}, 1000 );
				                });
							break;
							case 'money_done':
								$('#buy_btn_block').html(
									'<div id="buy_btn_price_text">'+
										"<?=$lang['purchased']?>"+
									'</div>'+
									'<div class="buy-song">'+
										'<img src="http://www.indievox.com/images/ico_downloaded.png" />'+
									'</div>'	
								);
								$("#radio_alert_block").html('<?=$lang["PurchaseSuccessful"];?> <a href="/m/downloads"> <?=$lang["Go2MyDownloads"];?></a>');
								$("#money_num").html(msg.money_num);
								$("#radio_alert_wrapper").fadeIn('slow', function() {
				                	// Animation complete
									setTimeout(function() {
										$('#radio_alert_wrapper').fadeOut('slow', function() {
					                        // Animation complete
											$("#radio_alert_block").html("");
					                    });
									}, 1000 );
				                });
							break;
							case 'pwys_done':
								$('#buy_btn_block').html(
									'<div id="buy_btn_price_text">'+
										"<?=$lang['purchased']?>"+
									'</div>'+
									'<div class="buy-song">'+
										'<img src="http://www.indievox.com/images/ico_downloaded.png" />'+
									'</div>'	
								);
								$("#radio_alert_block").html('<?=$lang["PurchaseSuccessful"];?> <a href="/m/downloads"> <?=$lang["Go2MyDownloads"];?></a>');
								$("#money_num").html(msg.money_num);
								$("#radio_alert_wrapper").fadeIn('slow', function() {
				                	// Animation complete
									setTimeout(function() {
										$('#radio_alert_wrapper').fadeOut('slow', function() {
					                        // Animation complete
											$("#radio_alert_block").html("");
					                    });
									}, 1000 );
				                });
							break;
						}
					break;
					case 'fail':
						switch(msg.message){
							case 'not_licensed':
								Boxy.load("/bx_includes/box_template.php?includeFile=buy-song-done.php&song_id="+thing_id+"&status=not_licensed",{modal:true,center:true,fixed:true,unloadOnHide:true});
							break;
							case 'demo':
								Boxy.load("/bx_includes/box_template.php?includeFile=buy-song-done.php&song_id="+thing_id+"&status=demo",{modal:true,center:true,fixed:true,unloadOnHide:true});
							break;
							case 'perchased':
								Boxy.load("/bx_includes/box_template.php?includeFile=buy-song-done.php&song_id="+thing_id+"&status=perchased",{modal:true,center:true,fixed:true,unloadOnHide:true});
							break;
							case 'not_enough':
								Boxy.load("/bx_includes/box_template.php?includeFile=buy-song-done.php&song_id="+thing_id+"&status=not_enough_money",{modal:true,center:true,fixed:true,unloadOnHide:true});
							break;
						}
					break;
				}
			}
	});
}
// end of 購買歌曲按鈕控制

// start of 驗證隨意付金額
function isIntegerZero(s){ 
	var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
function validatePrice() {
	if($('#NT').val()==''){
		$('#songPriceError').html('<span class="alert"><?=$lang['FieldEmpty']?></span>');
		return false;
	}else if(!isIntegerZero($('#NT').val())){
		$('#songPriceError').html('<span class="alert"><?=$lang['PlzEnterArabic']?></span>');
		return false;
	}else{
		$('#songPriceError').html('');
		return true;
	}
}
// end of 驗證隨意付金額

// start of 我喜歡
function like_song(song_id,uid){
	<? if($login_user!='guest'){ ?>
	var req_url = "/anm/action/music_radio_action/like_song_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"song_id="+song_id,
            success:function(msg){
				if(msg.status='success'){
					update_song_func_block(song_id);
					send_feed(uid,song_id,'fav_song');
					$("#radio_alert_block").html("<?=$lang['addedintofavoritelist']?>");
					$("#like_song_num").html(msg.like_song_num);
					$("#radio_alert_wrapper").fadeIn('slow', function() {
	                	// Animation complete
						setTimeout(function() {
							$('#radio_alert_wrapper').fadeOut('slow', function() {
		                        // Animation complete
								$("#radio_alert_block").html("");
		                    });
						}, 1000 );
	                });
				}
			}
	});
	<? } else { ?>
	call_login_box("&direct=/anm/music_radio.php");
	<? } ?>
}
// end of 我喜歡

// start of 不喜歡
function dislike_song_confirmed(song_id){
	var req_url = "/anm/action/music_radio_action/dislike_song_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"song_id="+song_id,
            success:function(msg){
				if(msg.status='success'){
					update_song_func_block(song_id);
					$("#radio_alert_block").html("<?=$lang['recordAsUnlike']?>");
					$("#like_song_num").html(msg.like_song_num);
					$("#radio_alert_wrapper").fadeIn('slow', function() {
	                	// Animation complete
						setTimeout(function() {
							$('#radio_alert_wrapper').fadeOut('slow', function() {
		                        // Animation complete
								$("#radio_alert_block").html("");
		                    });
						}, 1000 );
	                });
					play_new_song();
				}
			}
	});
}
function dislike_song(song_id){
	<? if($login_user!='guest'){ ?>
	Boxy.load("/bx_includes/box_template.php?includeFile=dislike_song_confirm.php&song_id="+song_id,{modal:true,center:true,fixed:true,unloadOnHide:true});
	<? } else { ?>
	call_login_box("&direct=/anm/music_radio.php");
	<? } ?>
}
// end of 不喜歡

// start of login box
function call_login_box(para){
	Boxy.load("/bx_includes/box_template.php?includeFile=login-form.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}
function call_alert_box(para){
	Boxy.load("/bx_includes/box_template.php?includeFile=alert_box.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}
// end of login box

// start of 取得歌詞
function get_song_lyric(song_id){
	$("#popup_lyrics_content").html('<img src="http://www.indievox.com/images/loadingGraphic.gif" style="margin:5px;" />');
	var req_url = "/anm/action/music_radio_action/get_lyrics_block.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "json",
            data:"song_id="+song_id,
            success:function(msg){
					$("#popup_lyrics_content").html(msg.lyric);
					$("#popup_lyrics_func").html(msg.lyric_func);
			}
	});
}
// end of 取得歌詞

// start of 取得歌詞表單
function openLyricWikiForm(song_id){
	<? if($login_user!='guest'){ ?>
	$("#popup_lyrics_content").html('<img src="http://www.indievox.com/images/loadingGraphic.gif" style="margin:5px;" />');
	var req_url = "/anm/action/music_radio_action/get_lyric_form.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"song_id="+song_id,
            success:function(msg){
					$("#popup_lyrics_content").html(msg);
			}
	});
	<? } else { ?>
	call_login_box("&direct=/anm/music_radio.php");
	<? } ?>
}
// end of 取得歌詞表單

// start of 儲存歌詞
function save_lyric(song_id){
	var lyric = $("#lyricwiki_text").val();
	$("#popup_lyrics_content").html('<img src="http://www.indievox.com/images/loadingGraphic.gif" style="margin:5px;" />');
	var req_url = "/anm/action/music_radio_action/save_lyric_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "html",
            data:"song_id="+song_id+"&lyric="+lyric,
            success:function(msg){
					$("#popup_lyrics_content").html(msg);
			}
	});
}
// end of 儲存歌詞

// start of 顯示或隱藏選單
function show_tag_block(){
	$('#popup_tag_block').fadeIn('slow', function() {
        // Animation complete
    });
	$('#popup_dedicated_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_mood_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_key_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_genre_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_hot_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_lyrics_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function hide_tag_block(){
	$('#popup_tag_block').fadeOut('slow', function() {
        // Animation complete
    });
}

function show_lyric_block(){
	$('#popup_lyrics_block').fadeIn('slow', function() {
        // Animation complete
    });
	$('#popup_dedicated_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_mood_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_key_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_genre_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_hot_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_tag_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function hide_lyric_block(){
	$('#popup_lyrics_block').fadeOut('slow', function() {
        // Animation complete
    });
}

function show_mood_menu(){
	$('#popup_mood_block').fadeIn('slow', function() {
        // Animation complete
    });
	$('#popup_dedicated_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_key_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_genre_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_hot_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_lyrics_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_tag_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function hide_mood_menu(){
	$('#popup_mood_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function show_dedicated_menu(){
	$('#popup_dedicated_block').fadeIn('slow', function() {
        // Animation complete
    });
	$('#popup_mood_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_key_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_genre_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_hot_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_lyrics_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_tag_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function hide_dedicated_menu(){
	$('#popup_dedicated_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function show_key_menu(){
	$('#popup_key_block').fadeIn('slow', function() {
        // Animation complete
    });
	$('#popup_dedicated_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_mood_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_genre_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_hot_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_lyrics_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_tag_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function hide_key_menu(){
	$('#popup_key_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function show_genre_menu(){
	$('#popup_genre_block').fadeIn('slow', function() {
        // Animation complete
    });
	$('#popup_dedicated_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_mood_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_key_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_hot_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_lyrics_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_tag_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function hide_genre_menu(){
	$('#popup_genre_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function show_hot_menu(){
	$('#popup_hot_block').fadeIn('slow', function() {
        // Animation complete
    });
	$('#popup_dedicated_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_genre_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_mood_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_key_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_lyrics_block').fadeOut('slow', function() {
        // Animation complete
    });
	$('#popup_tag_block').fadeOut('slow', function() {
        // Animation complete
    });
}
function hide_hot_menu(){
	$('#popup_hot_block').fadeOut('slow', function() {
        // Animation complete
    });
}
// end of 顯示或隱藏選單

// start of 選擇播放頻道
function play_mood_radio(mood){
    mode = 'm';
    channel = mood;
    play_new_song();
}
function play_alt_radio(state){
    mode = 'a';
    channel = state;
    play_new_song();
}
function play_key_radio(key){
    mode = 'k';
    channel = key;
    play_new_song();
}
function play_genre_radio(genre){
    mode = 'g';
    channel = genre;
    play_new_song();
}
// end of 選擇播放頻道

function build_tag_block(){
	updateTaggedSongNum();
	updateTagScore();
	updateTagBlock();
}

function updateTagBlock(){
	$("#tag-block").html('<img src="http://www.indievox.com/images/loadingGraphic.gif" style="margin:5px;" />');
	var req_url = "/anm/action/music_radio_action/tag_game_block.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"song_id="+current_song_id,
            success:function(msg){
					$("#tag-block").html(msg);
			}
	});
}
function updateTaggedSongNum(){
	$("#tagged_song_num").html('<img src="http://www.indievox.com/images/loadingGraphic.gif" style="margin:5px;" />');
	var req_url = "/anm/action/music_radio_action/get_tagged_song_num.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "html",
            data:"",
            success:function(msg){
					$("#tagged_song_num").html(msg);
			}
	});
}
function updateTagScore(){
	$("#tag_score").html('<img src="http://www.indievox.com/images/loadingGraphic.gif" style="margin:5px;" />');
	var req_url = "/anm/action/music_radio_action/get_tag_score.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "html",
            data:"",
            success:function(msg){
					$("#tag_score").html(msg);
			}
	});
}

var toggle_tag = "none";
function toggle_tag_list(){
    var site_tag_list2 = document.getElementById("site_tag_list2");
    var toggle_tag_list = document.getElementById("toggle_tag_list");
    if(toggle_tag=="none"){
        toggle_tag = "block";
        site_tag_list2.style.display = "block";
        toggle_tag_list.firstChild.nodeValue = "<?=$lang['hideTags']?>";
    }else{
        toggle_tag = "none";
        site_tag_list2.style.display = "none";
        toggle_tag_list.firstChild.nodeValue = "<?=$lang['dispalyMoreTags']?>";
    }
}

var tag_count = 0;
function addTag(tagName,tag_id){
    if(tag_count>=5){
        systemMsg("<?=$lang['notMoreThan5tag']?>");
        return;
    }
    tag_count++;
    var tagNameE = document.getElementById("site_"+tagName);
    tagNameE.style.display = "none";
    var user_tag_div = document.getElementById("user_tag_div");
    var user_tag_listDiv = document.getElementById("user_tag_list");
    var span = document.createElement("span");
    span.id = tagName;
    span.className = "tag_item";
    span.onclick= function() { deleteTag(tagName,tag_id); };
    var tagNameText = document.createTextNode(tagName);
    span.appendChild(tagNameText);
    user_tag_listDiv.appendChild(span);
    if(tag_count>0){
        user_tag_div.style.display = "block";
    }
    insertTagAction(tag_id);
}
function deleteTag(tagName,tag_id){
    tag_count--;
    removeTag(tagName);
    var tagNameE = document.getElementById("site_"+tagName);
    tagNameE.style.display = "inline";
    if(tag_count==0){
        var user_tag_div = document.getElementById("user_tag_div");
        user_tag_div.style.display = "none";
    }
    deleteTagAction(tag_id);
}
function removeTag(tagName){
    var tagName_node = document.getElementById(tagName);
    var tagName_parent = tagName_node.parentNode;
    tagName_parent.removeChild(tagName_node);
}
function insertTagAction(tag_id){
	var req_url = "/anm/action/music_radio_action/insert_tag_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "html",
            data:"song_id="+current_song_id+"&tag_id="+tag_id,
            success:function(msg){
			}
	});
}
function deleteTagAction(tag_id){
	var req_url = "/anm/action/music_radio_action/delete_tag_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "html",
            data:"song_id="+current_song_id+"&tag_id="+tag_id,
            success:function(msg){
			}
	});
}
function count_tag_score() {
	Boxy.load("/bx_includes/box_template.php?includeFile=count_score_action.php&song_id="+current_song_id,{modal:true,center:true,fixed:true,unloadOnHide:true});
}
function count_play_song() {
	var req_url = "/anm/action/music_radio_action/count_play_song_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "html",
            data:"song_id="+current_song_id,
            success:function(msg){
				<? if($login_user!='guest'){ ?>
				$('#listen_song_num').html(msg);
				<? } ?>
			}
	});
}

// start of 播放新歌
var count_played_song = 1;
function play_new_song(){
    tag_count = 0;
	$('#radio_title_wrapper').fadeOut('slow', function() {
        // Animation complete
    });
	$('#think_block_wrapper').fadeIn('slow', function() {
        // Animation complete
    });
	$('#song_info_block').fadeOut('slow', function() {
        // Animation complete
    });
	var req_url = "action/music_radio_action/get_song_action.php";
	var para = "mode="+mode+"&channel="+channel;
	if(count_played_song%5==0){
		para = "mode=ad&channel=1";
	}
	$.ajax({
        url: req_url, 
        type: "GET",
        dataType: "json",
        data: para,
        success:function(msg){
            if(msg.status=='success'){
	
				if((msg.channel=='library'||msg.channel=='favorite')&&msg.auth_status=='false'){
					switch(msg.channel){
						case 'library':
							call_alert_box("&type=library_radio_alert");
						break;
						case 'favorite':
							call_alert_box("&type=favorite_radio_alert");
						break;
					}
					mode = 'g';
				    channel = '0g0';
				} else {
					count_played_song++;
				}
				
                $(".jbgallery").jbgallery("destroy");
                $('.jbgallery ul').empty();
                $(msg.photo_array).each(function(i, item){
                    $('.jbgallery ul').append('<li><a href="' + item.photo_url + '">' + item.photo_name + '</a></li>');
                });
               
                jQuery("#fullscreen").jbgallery({
	           		menu  : false,
	            	style : 'zoom',
	            	randomize : 0,
	            	slideshow:true
	            });
              
			    $("#jquery_jplayer_1").jPlayer( "clearMedia" );
			    $("#jquery_jplayer_1").jPlayer( "setMedia", {
	      			mp3: msg.audio_stream
	    	    });
                $("#jquery_jplayer_1").jPlayer("play");
			    //$("#jplayer_play_btn").css("display", "none");
			    //$("#jplayer_pause_btn").css("display", "block");
			
				build_song_block(msg);
				update_radio_title();
				count_play_song();
			
                $('#song_info_block').fadeIn('slow', function() {
                    // Animation complete
                });
				$('#think_block_wrapper').fadeOut('slow', function() {
                    // Animation complete.
                });
				$('#radio_title_wrapper').fadeIn('slow', function() {
		            // Animation complete
		        });

            }
        }
	});
}
// end of 播放新歌
<?
require_once($_SERVER['DOCUMENT_ROOT'].'/anm/src/music_radio_src/music_radio_clear.php');
?>