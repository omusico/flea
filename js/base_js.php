<?
require_once('/var/www/html/flea/flea_src/base_functions.php');
?>
function call_login_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=login-form.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}
function call_item_icon_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=item_icon_box.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}
function call_invite_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=invite-form.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}
function call_alert_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=alert_box.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}
function invite_validate(){
    
    if($('#email').val()==''){
		$('#email_error').html('<br/><span class="alert">不可為空值</span>');
		return false;
	}else{
        var input_email = $('#email').val();
        var email_array = input_email.split("@");
        if(email_array[1]!='nccu.edu.tw'){
            $('#email_error').html('<br/><span class="alert">請使用政大郵件網址索取邀請函</span>');
            return false;
        } else {
            $('#email_error').html('');
            var req_url = "/flea/flea_src/action/invite_action.php";
            $.ajax({
                    url: req_url, 
                    type: "POST",
                    dataType: "json",
                    data:"email="+input_email,
                    success:function(msg){
                        if(msg.status=='success'){
                            $('.boxy-wrapper').remove();
                            $('.boxy-modal-blackout').remove();
                            call_alert_box('&type=invite_success');  
                        } else {
                            $('.boxy-wrapper').remove();
                            $('.boxy-modal-blackout').remove();
                            call_alert_box('&type=invite_fail');
                        }
                    }
            });
            return true;
        }
	}
}

$(function() {
    $( "#signupform_btn_button" ).click(function() {
		var options = {};
        $( "#signup_form_block" ).toggle( "blind", options, 500 );
        return false;
    });
});

$('#signup_form').submit(function() {
    return register_validate();
});

function register_validate(){
    if($('#department_id').val()=='0'||$('#nickname').val()==''||$('#email').val()==''||$('#password1').val()==''||$('#password2').val()==''||$('#gender').val()=='0'||$('#birth_y').val()=='0'||$('#birth_m').val()=='0'||$('#birth_d').val()=='0'||$('#last_name').val()==''||$('#first_name').val()==''){
        if($('#department_id').val()=='0'){
            $('#department_id_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#department_id_error').html('');
        }
        if($('#nickname').val()==''){
            $('#nickname_error').html('<span class="alert">不可為空值</span>');
        }else{
            $('#nickname_error').html('');
        }
        if($('#email').val()==''){
            $('#email_error').html('<span class="alert">不可為空值</span>');
        }else{
            check_email();
        }
        if($('#password1').val()==''){
            $('#password1_error').html('<span class="alert">不可為空值</span>');
        }else{
            check_passwrd1();
        }
        if($('#password2').val()==''){
            $('#password2_error').html('<span class="alert">不可為空值</span>');
        }else{
            check_passwrd2();
        }
        if($('#gender').val()=='0'){
            $('#gender_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#gender_error').html('');
        }
        if($('#birth_y').val()=='0'||$('#birth_m').val()=='0'||$('#birth_d').val()=='0'){
            $('#birth_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#birth_error').html('');
        }
        if($('#first_name').val()==''){
            $('#first_name_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#first_name_error').html('');
        }
        if($('#last_name').val()==''){
            $('#last_name_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#last_name_error').html('');
        }
		
		return false;
	}else{
        $('#department_id_error').html('');
        $('#nickname_error').html('');
        $('#email_error').html('');
        $('#gender_error').html('');
        $('#birth_error').html('');
        $('#first_name_error').html('');
        $('#last_name_error').html('');
        
        if(check_passwrd1()&&check_passwrd2()&&check_email()){
            $('#signup_form').submit();
            return true;
        } else {
            return false;
        }
    }
}

function check_passwrd1(){
    if($('#password1').val().length<8){
        $('#password1_error').html('<span class="alert">長度不可小於8個字元</span>');
        return false;
    }else{
        $('#password1_error').html('');
        return true;
    }
    
}
function check_passwrd2(){
    if($('#password2').val()!=$('#password1').val()){
        $('#password2_error').html('<span class="alert">密碼不相符</span>');
        return false;
    }else{
        $('#password2_error').html('');
        return true;
    }
    
}

function check_email(){
    var reg = new RegExp("^[0-9a-zA-Z]+@[0-9a-zA-Z]+[\.]{1}[0-9a-zA-Z]+[\.]?[0-9a-zA-Z]+$");
    if(reg.test($('#email').val())){
        $('#email_error').html('');
        return true;
    } else {
        $('#email_error').html('<span class="alert">請輸入合法電子郵件地址</span>');
        return false;
    }
}

function login_validate(){
    if($('#login_email').val()==''||$('#login_passwd').val()==''){
        if($('#login_email').val()==''){
            $('#login_email_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#login_email_error').html('');
        }
        if($('#login_passwd').val()==''){
            $('#login_passwd_error').html('<span class="alert">不可為空值</span>');
        }else{
            $('#login_passwd_error').html('');
        }
        return false;
    } else {
        $('#login_email_error').html('');
        $('#login_passwd_error').html('');
        $('#login_error').css("display", "none");
        var req_url = "/flea/flea_src/action/login_action.php";
        $.ajax({
                url: req_url, 
                type: "POST",
                dataType: "json",
                data:"email="+$('#login_email').val()+"&password="+$('#login_passwd').val(),
                success:function(msg){
                    if(msg.status=='success'){
                        location.reload();
                    } else {
                        $('#login_error').css("display", "block");
                    }
                }
        });
        return true;
    }
}

function change_mypage_active(page_name){
    var my_pages = new Array(5);
    my_pages[0] = "message";
    my_pages[1] = "transaction";
    my_pages[2] = "settings";
    my_pages[3] = "fleabox";
    my_pages[4] = "fleaitem";
    my_pages[5] = "specialitem";
    for(var i=0; i<6; i++){
        var check_page = my_pages[i];
        if(check_page==page_name){
            $('#'+check_page+'_page').css('background-color','#e0e0e0');
        } else {
            $('#'+check_page+'_page').css('background-color','');
        }
    }
}

function settings_validate(){
    if($('#department_id').val()=='0'||$('#nickname').val()==''||$('#email').val()==''||$('#gender').val()=='0'||$('#birth_y').val()=='0'||$('#birth_m').val()=='0'||$('#birth_d').val()=='0'||$('#last_name').val()==''||$('#first_name').val()==''){
         if($('#department_id').val()=='0'){
            $('#department_id_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#department_id_error').html('');
        }
        if($('#nickname').val()==''){
            $('#nickname_error').html('<span class="alert">不可為空值</span>');
        }else{
            $('#nickname_error').html('');
        }
         if($('#email').val()==''){
            $('#email_error').html('<span class="alert">不可為空值</span>');
        }else{
            check_email();
        }
        if($('#gender').val()=='0'){
            $('#gender_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#gender_error').html('');
        }
        if($('#birth_y').val()=='0'||$('#birth_m').val()=='0'||$('#birth_d').val()=='0'){
            $('#birth_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#birth_error').html('');
        }
        if($('#first_name').val()==''){
            $('#first_name_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#first_name_error').html('');
        }
        if($('#last_name').val()==''){
            $('#last_name_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#last_name_error').html('');
        }
        return false;
    } else {
        $('#department_id_error').html('');
        $('#nickname_error').html('');
        $('#email_error').html('');
        $('#gender_error').html('');
        $('#birth_error').html('');
        $('#first_name_error').html('');
        $('#last_name_error').html('');
        
        if(check_email()){
            var req_url = "/flea/flea_src/action/settings_action.php";
            $.ajax({
                    url: req_url, 
                    type: "POST",
                    dataType: "json",
                    data:"department_id="+$('#department_id').val()+"&nickname="+$('#nickname').val()+"&email="+$('#email').val()+"&gender="+$('#gender').val()+"&birth_y="+$('#birth_y').val()+"&birth_m="+$('#birth_m').val()+"&birth_d="+$('#birth_d').val()+"&first_name="+$('#first_name').val()+"&last_name="+$('#last_name').val()+"&contact_number="+$('#contact_number').val()+"&about_me="+$('#about_me').val(),
                    success:function(msg){
                        if(msg.status=='success'){
                            call_alert_box('&type=settings_success'); 
                        } else {
                            call_alert_box('&type=error'); 
                        }
                    }
            });
            return true;
        } else {
            return false;
        }
       
    }
}

function update_icon_src(size){
    var req_url = "/flea/flea_src/action/get_usericon_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"size="+size,
            success:function(msg){
                if(msg.status=='success'){
                    $("#user_icon").attr("src",msg.user_icon);
                } else {
                    call_alert_box('&type=error'); 
                }
            }
    }); 
}

function edit_item(item_id){
    $('#item_block'+item_id).html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/get_itemform_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"item_id="+item_id,
            success:function(msg){
               $('#item_block'+item_id).html(msg);
            }
    }); 
}

function call_edit_item_box(para){
    Boxy.load("/flea/bx_includes/box_template.php?include=edit-item-form.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function call_edit_sitem_box(para){
    Boxy.load("/flea/bx_includes/box_template.php?include=edit-sitem-form.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function call_delete_item_box(para){
    Boxy.load("/flea/bx_includes/box_template.php?include=delete-item-confirm.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function call_delete_sitem_box(para){
    Boxy.load("/flea/bx_includes/box_template.php?include=delete-sitem-confirm.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function edit_item_validate(){
    if($('#item_title').val()==''||$('#price').val()==''||$('#school_location_id').val()=='0'||$('#category_id').val()=='0'||$('#subcategory_id').val()=='0'||$('#item_content').val()==''){
         if($('#item_title').val()==''){
            $('#item_title_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            check_item_title();  
        }
        if($('#price').val()==''){
            $('#price_error').html('<span class="alert">不可為空值</span>');
        }else{
            check_item_price(); 
        }
        if($('#item_content').val()==''){
            $('#item_content_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            check_item_content(); 
        }
        if($('#school_location_id').val()=='0'){
            $('#school_location_id_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#school_location_id').html('');
        }
        if($('#category_id').val()=='0'){
            $('#category_id_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#category_id_error').html('');
        }
        if($('#subcategory_id').val()=='0'){
            $('#subcategory_id_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#subcategory_id_error').html('');
        }
        
        return false;
    } else {
        $('#item_title_error').html('');
        $('#price_error').html('');
        $('#item_content_error').html('');
        $('#school_location_id_error').html('');
        $('#category_id_error').html('');
        $('#subcategory_id_error').html('');
        
        if(check_item_title()&&check_item_price()&&check_item_content()){
            var req_url = "/flea/flea_src/action/edit_item_action.php";
            $.ajax({
                    url: req_url, 
                    type: "POST",
                    dataType: "json",
                    data:"item_id="+$('#item_id').val()+"&item_title="+$('#item_title').val()+"&price="+$('#price').val()+"&school_id="+$('#school_id').val()+"&school_location_id="+$('#school_location_id').val()+"&category_id="+$('#category_id').val()+"&subcategory_id="+$('#subcategory_id').val()+"&item_content="+$('#item_content').val(),
                    success:function(msg){
                        if(msg.status=='success'){
                            get_item_block($('#item_id').val());
                            $('.boxy-wrapper').remove();
                            $('.boxy-modal-blackout').remove();
                        } else {
                            call_alert_box('&type=error'); 
                        }
                    }
            });
            return true;
        } else {
            return false;
        }
       
    }
}

function edit_sitem_validate(){
    if($('#sitem_title').val()==''||$('#scategory_id').val()=='0'||$('#sitem_content').val()==''){
         if($('#sitem_title').val()==''){
            $('#sitem_title_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            check_sitem_title();  
        }
        if($('#sitem_content').val()==''){
            $('#sitem_content_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            check_sitem_content(); 
        }
        if($('#scategory_id').val()=='0'){
            $('#scategory_id_error').html('<br/><span class="alert">不可為空值</span>');
        }else{
            $('#scategory_id_error').html('');
        }
        return false;
    } else {
        $('#sitem_title_error').html('');
        $('#sitem_content_error').html('');
        $('#scategory_id_error').html('');
        
        if(check_sitem_title()&&check_sitem_content()){
            var req_url = "/flea/flea_src/action/edit_sitem_action.php";
            $.ajax({
                    url: req_url, 
                    type: "POST",
                    dataType: "json",
                    data:"sitem_id="+$('#sitem_id').val()+"&sitem_title="+$('#sitem_title').val()+"&scategory_id="+$('#scategory_id').val()+"&sitem_content="+$('#sitem_content').val(),
                    success:function(msg){
                        if(msg.status=='success'){
                            get_sitem_block($('#sitem_id').val());
                            $('.boxy-wrapper').remove();
                            $('.boxy-modal-blackout').remove();
                        } else {
                            call_alert_box('&type=error'); 
                        }
                    }
            });
            return true;
        } else {
            return false;
        }
       
    }
}

function check_sitem_title(){
    if($('#sitem_title').val()=='尚未填寫元件名稱'){
        $('#sitem_title_error').html('<span class="alert">請更改元件名稱</span>');
        return false;
    }else{
        $('#sitem_title_error').html('');
        return true;
    }
}

function check_sitem_content(){
    if($('#sitem_content').val()=='尚未填寫元件描述'){
        $('#sitem_content_error').html('<span class="alert">請更改商元件描述</span>');
        return false;
    }else{
        $('#sitem_content_error').html('');
        return true;
    }
}

function check_item_title(){
    if($('#item_title').val()=='尚未填寫品名'){
        $('#item_title_error').html('<span class="alert">請更改商品名稱</span>');
        return false;
    }else{
        $('#item_title_error').html('');
        return true;
    }
}
function check_item_price(){
    if($('#price').val()>=0 && $('#price').val()<=99999){
        $('#price_error').html('');
        return true;
    } else {
        $('#price_error').html('<span class="alert">價錢請定在0-99999之間</span>');
    }
}
function check_item_content(){
    if($('#item_content').val()=='尚未填寫商品描述'){
        $('#item_content_error').html('<span class="alert">請更改商品描述</span>');
        return false;
    }else{
        $('#item_content_error').html('');
        return true;
    }
}

function get_item_block(item_id){
    $('#item_block'+item_id).html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/get_item_block_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"item_id="+item_id,
            success:function(msg){
               $('#item_block'+item_id).html(msg);
            }
    }); 
}

function get_sitem_block(sitem_id){
    $('#sitem_block'+sitem_id).html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/get_sitem_block_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"sitem_id="+sitem_id,
            success:function(msg){
               $('#sitem_block'+sitem_id).html(msg);
            }
    }); 
}

function get_item_block_new(){
    var req_url = "/flea/flea_src/action/get_item_block_new_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"",
            success:function(msg){
               $('#item_container_block').prepend(msg);
            }
    }); 
}

function change_subcategory_select(){
    $('#subcategory_id').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var current_category_id = $('#category_id').val();
    var req_url = "/flea/flea_src/action/get_subcategory_select.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"category_id="+current_category_id,
            success:function(msg){
                $('#subcategory_id').html(msg);
            }
    }); 
}

function delete_item(item_id){
    $('#box_confirm_message').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/delete_item_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"item_id="+item_id,
            success:function(msg){
                if(msg.status=='success'){
                    $('#item_block'+item_id).remove();
                    $('.boxy-wrapper').remove();
                    $('.boxy-modal-blackout').remove(); 
                } else {
                    $('.boxy-wrapper').remove();
                    $('.boxy-modal-blackout').remove();
                    call_alert_box('&type=error');
                }
            }
    }); 
}

function delete_sitem(sitem_id){
    $('#box_confirm_message').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/delete_sitem_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"sitem_id="+sitem_id,
            success:function(msg){
                if(msg.status=='success'){
                    $('#sitem_block'+sitem_id).remove();
                    $('.boxy-wrapper').remove();
                    $('.boxy-modal-blackout').remove(); 
                } else {
                    $('.boxy-wrapper').remove();
                    $('.boxy-modal-blackout').remove();
                    call_alert_box('&type=error');
                }
            }
    }); 
}

function get_itemlist_block(){  
    $('#item_container_block').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/get_itemlist_block_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"",
            success:function(msg){
               $('#item_container_block').html(msg);
            }
    }); 
}

function get_sitemlist_block(){  
    $('#item_container_block').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/get_specialitemlist_block_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"",
            success:function(msg){
               $('#item_container_block').html(msg);
            }
    }); 
}

function loadAjaxPageContent(div2chang,parameters){
    $('#'+div2chang).html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/"+parameters;
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"",
            success:function(msg){
               $('#'+div2chang).html(msg);
            }
    }); 
}

function call_item_shelve_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=item-shelve.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function call_box_decoration_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=box_decoration.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function get_boxitemlist_block(box_id){  
    $('#box_items_block'+box_id).html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/get_boxitemlist_block_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"box_id="+box_id,
            success:function(msg){
                $('#box_items_block'+box_id).html(msg);
            }
    }); 
}

function iframe_call_box_cover(status,box_id){
    if(status=='success'){
        //$('#sitem_block'+sitem_id).remove();
        var req_url = "/flea/flea_src/action/get_boxcover_action.php";
        $.ajax({
                url: req_url, 
                type: "GET",
                dataType: "json",
                data:"box_id="+box_id+"&size=570",
                success:function(msg){
                    if(msg.status=='success'){
                        $("#box_cover_img"+box_id).attr("src",msg.box_cover);
                        $('.boxy-wrapper').remove();
                        $('.boxy-modal-blackout').remove();
                    } else {
                        call_alert_box('&type=error'); 
                    }
                }
        });
         
    } else {
        $('.boxy-wrapper').remove();
        $('.boxy-modal-blackout').remove();
        call_alert_box('&type=error');
    }
}

function setInfo_none(box_id){
    $('#header_box_block_info'+box_id).fadeOut('fast', function() {
                    // Animation complete
                });
}
function setInfo_diplay(box_id){
    $('#header_box_block_info'+box_id).fadeIn('fast', function() {
                    // Animation complete
                });
}

function seteInfo_none(box_id){
    $('#explore_box_block_info'+box_id).fadeOut('fast', function() {
                    // Animation complete
                });
}
function seteInfo_diplay(box_id){
    $('#explore_box_block_info'+box_id).fadeIn('fast', function() {
                    // Animation complete
                });
}


function setboxiteminfo_none(box_item_id){
    $('#home_box_item_merch_info'+box_item_id).fadeOut('fast', function() {
                    // Animation complete
                });
}
function setboxiteminfo_diplay(box_item_id){
    $('#home_box_item_merch_info'+box_item_id).fadeIn('fast', function() {
                    // Animation complete
                });
}

function follow_box_item(item_id,box_item_id){
    var req_url = "/flea/flea_src/action/insert_follow_box_item_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"item_id="+item_id+"&box_item_id="+box_item_id,
            success:function(msg){
                if(msg.status=='success'){
                    $('#follow_box_item_link'+box_item_id).remove();
                    call_alert_box('&type=box_item_followed');
                } else if(msg.status=='follow_self_error'){
                    call_alert_box('&type=box_item_follow_self_error');
                } else {
                    call_alert_box('&type=error');
                }
            }
    }); 
}

function buy_box_item_box(item_id,box_item_id){
    var para = "&item_id="+item_id+"&box_item_id="+box_item_id;
    Boxy.load("/flea/bx_includes/box_template.php?include=buy_box_item_box.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true}); 
}

function buy_box_validate(){
    var req_url = "/flea/flea_src/action/buy_box_item_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"item_id="+$('#buy_item_id').val()+"&box_item_id="+$('#buy_box_item_id').val()+"&contact_name="+$('#contact_name').val()+"&contact_number="+$('#contact_number').val()+"&message_content="+$('#message_content').val(),
            success:function(msg){
                if(msg.status=='success'){
                    $('#buy_box_item_link'+$('#buy_box_item_id').val()).remove();
                    $('.boxy-wrapper').remove();
                    $('.boxy-modal-blackout').remove();
                    call_alert_box('&type=box_item_buyed');
                } else if(msg.status=='buy_self_error'){
                    call_alert_box('&type=box_item_buy_self_error');
                } else if(msg.status=='buyed'){
                    call_alert_box('&type=box_item_buyed_error');
                }else{
                    call_alert_box('&type=error');
                }
            }
    }); 
}

function loadExploreBox(school_id,current_item){
    if(current_item==0){
        $('#explore_result').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    } else {
        $('#load_more_block').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    }
    var req_url = "/flea/flea_src/action/get_explore_box_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"school_id="+school_id+"&current_item="+current_item,
            success:function(msg){
                if(current_item==0){
                    $('#explore_result').html(msg);
                } else {
                    $('#load_more_block').remove();
                    $('#explore_result').append(msg);
                }
            }
    }); 
}

function loadExploreItem(category_id,current_item){
    if(current_item==0){
        $('#explore_result').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    } else {
        $('#load_more_block').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    }
    var req_url = "/flea/flea_src/action/get_explore_item_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"category_id="+category_id+"&current_item="+current_item,
            success:function(msg){
                if(current_item==0){
                    $('#explore_result').html(msg);
                } else {
                    $('#load_more_block').remove();
                    $('#explore_result').append(msg);
                }
            }
    }); 
}

function search_explore(){
    if($('#explore_search_input').val()==''||$('#explore_search_input').val()=='Search...'){
		call_alert_box('&type=search_value_error');
	}else{
        $('#explore_result').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
        var req_url = "/flea/flea_src/action/get_explore_search_action.php";
        $.ajax({
                url: req_url, 
                type: "GET",
                dataType: "html",
                data:"search_value="+$('#explore_search_input').val(),
                success:function(msg){
                    $('#explore_result').html(msg);
                }
        });
    }
}

function loadItemMore(category_id,current_item){
    $('#load_more_block').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/get_index_item_action.php";
    $.ajax({
            url: req_url, 
            type: "GET",
            dataType: "html",
            data:"category_id="+category_id+"&current_item="+current_item,
            success:function(msg){
                $('#load_more_block').remove();
                $('#home_item_block').append(msg);
            }
    });
}

function remove_back(item_id){
    $('#item_icon_block'+item_id).html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/remove_back_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"item_id="+item_id,
            success:function(msg){
                if(msg.status=='success'){
                    recreate_thumb(item_id);
                }
            }
    }); 
    
}

function recreate_thumb(item_id){
    $('#item_icon_block'+item_id).html('<img src="<?=SITE_URL?>/images/loading.gif" />');
    var req_url = "/flea/flea_src/action/recreate_thumb_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "html",
            data:"item_id="+item_id,
            success:function(msg){
                $('#item_icon_block'+item_id).html(msg);
            }
    });
}

function read_message_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=read_message_box.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function send_message_box(para){
    if(typeof(para) == "undefined"){
        para = '';
    }
	Boxy.load("/flea/bx_includes/box_template.php?include=send_message_box.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function reply_message(message_id,content){
    if(content==''){
        $('#message_content_error').html('<br/><span class="alert">您沒有填寫訊息喔!</span>');
    } else {
        $('#message_content_error').html('');
        $('.boxy-wrapper').remove();
        $('.boxy-modal-blackout').remove();
        var req_url = "/flea/flea_src/action/reply_message_action.php";
        $.ajax({
                url: req_url, 
                type: "POST",
                dataType: "json",
                data:"message_id="+message_id+"&content="+content,
                success:function(msg){
                    if(msg.status=='success'){
                        call_alert_box('&type=message_replyed');
                    }else{
                        call_alert_box('&type=error');
                    }
                }
        }); 
    }
}

function send_message(){
    if($('#message_title').val()==''||$('#message_content').val()==''){
        if($('#message_title').val()==''){
            $('#message_title_error').html('<br/><span class="alert">請填寫主旨</span>');
        }else{
            $('#message_title_error').html('');
        }
        if($('#message_content').val()==''){
            $('#message_content_error').html('<span class="alert">請填寫內容</span>');
        }else{
            $('#message_content_error').html('');
        }
        return false;
    } else {
        $('#message_title_error').html('');
        $('#message_content_error').html('');
        var req_url = "/flea/flea_src/action/send_message_action.php";
        $.ajax({
                url: req_url, 
                type: "POST",
                dataType: "json",
                data:"receiver_id="+$('#receiver_id').val()+"&message_title="+$('#message_title').val()+"&message_content="+$('#message_content').val(),
                success:function(msg){
                    if(msg.status=='success'){
                        $('.boxy-wrapper').remove();
                        $('.boxy-modal-blackout').remove();
                        call_alert_box('&type=message_replyed');
                    }else{
                        $('.boxy-wrapper').remove();
                        $('.boxy-modal-blackout').remove();
                        call_alert_box('&type=error');
                    }
                }
        }); 
        return true;
    }
}

function complete_exchange_confirm(para){
    Boxy.load("/flea/bx_includes/box_template.php?include=complete_exchange_confirm.php"+para,{modal:true,center:true,fixed:true,unloadOnHide:true});
}

function complete_exchange(exchange_id){
    var req_url = "/flea/flea_src/action/complete_exchange_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"exchange_id="+exchange_id,
            success:function(msg){
                if(msg.status=='success'){
                    $('#buy_form_item_block'+exchange_id).remove();
                    $('.boxy-wrapper').remove();
                    $('.boxy-modal-blackout').remove();
                    call_alert_box('&type=exchange_complete');
                }else{
                    $('.boxy-wrapper').remove();
                    $('.boxy-modal-blackout').remove();
                    call_alert_box('&type=error');
                }
            }
    });
}

function delete_follow_item(follow_id){
    var req_url = "/flea/flea_src/action/delete_follow_item_action.php";
    $.ajax({
            url: req_url, 
            type: "POST",
            dataType: "json",
            data:"follow_id="+follow_id,
            success:function(msg){
                if(msg.status=='success'){
                    $('#follow_form_item_block'+follow_id).remove();
                    call_alert_box('&type=follow_item_deleted');
                } else {
                    call_alert_box('&type=error');
                }
            }
    }); 
}

function exchange_comment_box(para){
    call_alert_box('&type=construct');
}


