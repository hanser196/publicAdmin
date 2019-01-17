//管理员信息表单验证
$('#add-user').submit(function(){
    var password = $('#user_password').val(),
        againPassowrd = $('#again_user_password').val();
    if(againPassowrd != password){
        $('.mine-password').addClass('has-error');
        return false;
    }
})
$('#again_user_password').focus(function(){
    $('.mine-password').removeClass('has-error');
})
$('#again_user_password').blur(function(){
    var password = $('#user_password').val(),
        againPassowrd = $('#again_user_password').val();
    if(againPassowrd != password){
        $('.mine-password').addClass('has-error');
    }
})

$('#edit-password-form').submit(function(){
    var password = $('#edit-password').val(),
        againPassowrd = $('#edit-again-passowrd').val();
    if(againPassowrd != password){
        $('.mine-edit-password').addClass('has-error');
        return false;
    }
})
$('#edit-again-passowrd').focus(function(){
    $('.mine-edit-password').removeClass('has-error');
})
$('#edit-again-passowrd').blur(function(){
    var password = $('#edit-password').val(),
        againPassowrd = $('#edit-again-passowrd').val();
    if(againPassowrd != password){
        $('.mine-edit-password').addClass('has-error');
    }
})
// Ajax方法
function ajax(url,obj){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var res;
    $.ajax({
        url: "http://www.padmin.com/api/"+url,
        type: "POST",
        dataType: "json",
        data:obj,
        async:false,
        success:function(data){
            res = data;
        }
    })
    return res;
}
//首页信息方法
function replace_pic(){
    $('#my-modal-info-show').on('change','input.replace_pic_add',function(e){
        var imgBox = e.target;
        f_target = $(imgBox).parent();
        uploadImg(f_target,imgBox);
    })
}

function index_info_html(ac_url){
    $('#edit-form').attr('action',ac_url);
    $('#edit-form').attr('enctype','multipart/form-data');
    $('#my-modal-info-show').html('<div class="index-info-edit-pic">'+
                                        '<div class="replace_pic">'+
                                            '<input class="replace_pic_add" type="file" name="path">'+
                                        '</div>'+
                                    '</div>');
    $('.mine-index-info-footer').html('<div class="index-info-btn">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>'+
                                            '<button type="submit" class="btn btn-primary">提交</button>'+
                                        '</div>');
}

function edit_form_html(type,id){
    $('#index-info-image-edit-id').remove();
    $('#edit-form').append('<input id="index-info-image-edit-id" type="hidden" name="id" value="'+id+'">');
}

function pic_edit_logo(ac_url,id,type){
    $('.modal-title').html('替换LOGO');
    edit_form_html(type,id);
    index_info_html(ac_url);
}

function pic_edit_qrcode(ac_url,id,type){
    $('.modal-title').html('替换二维码');
    edit_form_html(type,id);
    index_info_html(ac_url);
}

function company_add(){
    $('.modal-title').html('添加公司信息');
    $('#my-modal-info-show').html('<table class="table">'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<th>公司地址：</th>'+
                                                '<td>'+
                                                    '<input type="text" name="address" class="form-control" aria-describedby="basic-addon1">'+
                                                '</td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<th>公司电话：</th>'+
                                                '<td>'+
                                                    '<input type="text" name="phone" class="form-control" aria-describedby="basic-addon1">'+
                                                '</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>');
    $('.mine-index-info-footer').html('<div class="index-info-btn">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>'+
                                            '<button type="submit" class="btn btn-primary">提交</button>'+
                                        '</div>');
    $('#edit-form').removeAttr('enctype');
    $('#edit-form').attr('action','/admin/index/add/company');
}

//获取公司信息方法
function editCompany(addressId,phoneId){
    //console.log(addressId,phoneId);
    var url = 'edit/company',
        obj = {'address_id':addressId,'phone_id':phoneId},
        data = ajax(url, obj);
    updateCompany(data);
}

//修改公司信息方法
function updateCompany(data){
    //console.log(data);
    $('.modal-title').html('添加公司信息');
    $('#my-modal-info-show').html('<table class="table">'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<th>公司地址：</th>'+
                                                '<td>'+
                                                    '<input type="text" name="address" class="form-control" aria-describedby="basic-addon1" value="'+data['address']+'">'+
                                                    '<input type="hidden" name="address_id" value="'+data['address_id']+'">'+
                                                '</td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<th>公司电话：</th>'+
                                                '<td>'+
                                                    '<input type="text" name="phone" class="form-control" aria-describedby="basic-addon1" value="'+data['phone']+'">'+
                                                    '<input type="hidden" name="phone_id" value="'+data['phone_id']+'">'+
                                                '</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>');
    $('.mine-index-info-footer').html('<div class="index-info-btn">'+
                                            '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>'+
                                            '<button type="submit" class="btn btn-primary">提交</button>'+
                                        '</div>');
    $('#edit-form').removeAttr('enctype');
    $('#edit-form').attr('action','/admin/index/edit/company');
}
























//新闻方法
function info(data){
    $('.modal-title').html(data.title);
    $('.modal-at-time').html(data.updated_at);
    $('#my-modal-info-show').html(data.content);
    $('.modal-footer-content-thumbnail').html('<img src="/uploads/'+data.path+'">');
    $('.modal-footer-content-introduction').children('textarea').html('测试文章简介22222测试文章简介22222测试文章简介22222测试文章简介22222测试文章简介22222测试文章简介22222');
}

function showinfo(id){
    var url = 'shownews',
        obj = {'id':id},
        data = ajax(url, obj)[0];
    info(data);
}

//轮播图方法
function loop_add(){
    //console.log('添加轮播图');
    $('.modal-title').html('添加轮播图');
    $('.modal-at-time').html('<span class="label label-primary loop_add_slot">添加插槽</span>');
    $('#my-modal-info-show').html('<div class="browse_pic_list">'+
                                    '<div class="browse_pic">'+
                                        '<input class="browse_pic_add" type="file" name="path[]">'+
                                    '</div>'+
                                '</div>');
    $('.modal-footer').html('<div class="loop-btn">'+
                                '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>'+
                                '<button type="submit" class="btn btn-primary">提交</button>'+
                            '</div>'+
                            '<div class="loop-position-type">'+
                                '<select class="form-control" name="position">'+
                                    '<option value="0">首页顶部</option>'+
                                    '<option value="1">首页底部</option>'+
                                '</select>'+
                            '</div>');
    $('#edit-form').attr('action','/admin/loop');
    $('#edit-form').attr('enctype','multipart/form-data');
    
}

function replace(){
    $('#my-modal-info-show').on('change','input.browse_pic_add',function(e){
        var imgBox = e.target;
        f_target = $(imgBox).parent();
        uploadImg(f_target,imgBox);
    })
}

function uploadImg(element, tag){
    var file = tag.files[0];
    var imgSrc;
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(){
        //console.log(this.result);
        imgSrc = this.result;
        var imgs = document.createElement('img');
        $(imgs).attr('src', imgSrc);
        element.prepend('<div class="browse_pic_item">'+
                            '<img src="'+imgSrc+'">'+
                        '</div>');
    }
}

function loop_show(id,position){
    var url = 'showloop',
        obj = {'id':id},
        data = ajax(url, obj);
    loop_info(data,position);
}

function loop_info(data,position){
    var position_s = '';
    switch(position)
    {
        case '0':
            position_s = '顶部轮播图';
        break;
        case '1':
            position_s = '底部轮播图';
        break;
    }
    $('.modal-title').html('轮播图');
    $('.modal-at-time').html(data.updated_at);
    $('#my-modal-info-show').html('<div style="font-size:0;width:100%;"><img src="/uploads/'+data.path+'" style="display:block;width:100%;"></div>');
    $('.mine-loop-footer').html('<div class="input-group">'+
                                    '<div class="input-group-addon">类别</div>'+
                                    '<input type="text" class="form-control" value="'+position_s+'" readonly>'+
                                '</div>');
}

//banner图方法
function banner_add(){
    $('.modal-title').html('添加Banner图');
    $('#my-modal-info-show').html('<div class="browse_pic_list">'+
                                    '<div class="browse_pic">'+
                                        '<input class="browse_pic_add" type="file" name="path">'+
                                    '</div>'+
                                '</div>');
    $('.modal-footer').html('<div class="loop-btn">'+
                                '<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>'+
                                '<button type="submit" class="btn btn-primary">提交</button>'+
                            '</div>'+
                            '<div class="loop-position-type">'+
                                '<select class="form-control" name="position">'+
                                    '<option value="0">品牌背景</option>'+
                                    '<option value="1">新闻动态</option>'+
                                    '<option value="2">加盟专区</option>'+
                                    '<option value="3">加盟动态</option>'+
                                    '<option value="4">创业学院</option>'+
                                    '<option value="5">在线留言</option>'+
                                '</select>'+
                            '</div>');
    $('#edit-form').attr('action','/admin/banner');
    $('#edit-form').attr('enctype','multipart/form-data');
}

function banner_show(id,position){
    var url = 'showbanner',
        obj = {'id':id},
        data = ajax(url, obj);
    banner_info(data,position);
}

function banner_info(data,position){
    var position_s = '';
    switch(position)
    {
        case '0':
            position_s = '品牌背景';
        break;
        case '1':
            position_s = '新闻动态';
        break;
        case '2':
            position_s = '加盟专区';
        break;
        case '3':
            position_s = '加盟动态';
        break;
        case '4':
            position_s = '创业学院';
        break;
        case '5':
            position_s = '在线留言';
        break;
    }
    $('.modal-title').html('Banner图');
    $('.modal-at-time').html(data.updated_at);
    $('#my-modal-info-show').html('<div style="font-size:0;width:100%;"><img src="/uploads/'+data.path+'" style="display:block;width:100%;"></div>');
    $('.mine-loop-footer').html('<div class="input-group">'+
                                    '<div class="input-group-addon">类别</div>'+
                                    '<input type="text" class="form-control" value="'+position_s+'" readonly>'+
                                '</div>');
}

