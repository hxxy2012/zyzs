@extends('manage.site')
@section('main')
<div class="container bg-white margin-large-top">
  <div class="padding-large">
    <form method="POST">
    <div class="line-big margin-large-bottom">
      <div class="x6">
        <ul class="bread">
            <li><a href="/manage/main" class="icon-home"> 管理后台</a> </li>
            <li>自定义表单</li>
        </ul>
      </div>
      <div class="x6 text-right">
        <a href="/manage/main" class="button icon-mail-reply bg-black margin-right"> 返回</a>
        <a href="/manage/forms/create" class="button bg-little-yellow "> 新增表单</a>
        <button class="button bg-green icon-save" type="submit"> 保存修改</button>
      </div>
    </div>

    <div class="x12">
      <h1 class="padding-large-bottom border-bottom margin-large-bottom">
      <span class="icon-thumb-tack"> </span>自定义表单</h1>

      

      <div class="table-responsive padding-large-bottom articletable">
            <table class="table table-striped table-bordered">
                <tr>
                  <td align="center" width="50">序号</td>
                  <td align="center" width="150">标题</td>
                  <td align="center" width="50">预览</td>
                  <td align="center" width="50">编辑</td>
                  <td align="center" width="50">内容</td>
                  <td align="center" width="70">删除</td></tr>
                @if($forms->count()>0)
                @foreach ($forms as $key=>$value)
                <tr>
                <td align="center">
                  {{$value->id}}<input type="hidden" name="id[]" value="{{$value->id}}">
                </td>
                <td>
                  <input type="text" name="title[]" value="{{$value->title}}" class="input input-small">
                </td>
                <td align="center">
                  <a href="/forms/{{$value->id}}" class="button button-little">预览</a>
                </td>
                <td align="center">
                  <a href="/manage/forms/{{$value->id}}/edit" class="button button-little icon-edit bg-little-yellow">编辑</a>
                </td>
                <td align="center">
                  <a href="/manage/forms/{{$value->id}}/manage" class="button button-little">管理</a>
                </td>
                <td align="center"><a href="/manage/forms/{{ $value->id }}/delete" class="button button-little bg-main icon-trash-o" onclick="{if(confirm('删除后不可恢复：')){return true;}return false;}"> 删除</a></td>
                
                </tr>
                @endforeach
                @else
                <tr><td colspan="5" align="center">没有内容请添加</td></tr>
                @endif
            </table>
            </div>
    </div>

    <div class="x12 margin-large-bottom padding-large-bottom">
            <div class="x4 x2-move text-center"><button class="button bg-gray button-big win-refresh icon-refresh" type="button"> 重新载入</button></div>
            <div class="x4 text-center"><button class="button bg-green button-big icon-save" type="submit"> 保存修改</button></div>
        </div>
    {!! csrf_field() !!}
    </form>

  </div>
</div>
@stop

@section('extrajs')
<script type="text/javascript" src="/manage/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/manage/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
function BrowseServer( startupPath, functionData ){
  var finder = new CKFinder();
  finder.basePath = '/manage';
  finder.startupPath = startupPath;
  finder.selectActionFunction = SetFileField;
  finder.selectActionData = functionData;
  finder.selectThumbnailActionFunction = ShowThumbnails;
  finder.popup();
  }

  function SetFileField( fileUrl, data ){
  document.getElementById( data["selectActionData"] ).value = fileUrl;
  document.getElementById( data["selectActionData"] ).focus();
  document.getElementById( data["selectActionData"] ).blur();
  var postfix = data["fileUrl"].match(/^(.*)(\.)(.{1,8})$/)[3].toLowerCase();
  }

  function ShowThumbnails( fileUrl, data ){
  var sFileName = this.getSelectedFile().name;
  document.getElementById( 'thumbnails' ).innerHTML +=
      '<div class="thumb">' +
        '<img src="' + fileUrl + '" />' +
        '<div class="caption">' +
          '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + '</a> (' + data["fileSize"] + 'KB)' +
        '</div>' +
      '</div>';

  document.getElementById( 'preview' ).style.display = "";
  return false;
}
function hidedetails(){
  $(".showdetailschoose").hide();
  $(".detailspositionchoose").hide();
  $(".detailsedit").hide();
}
function showdetails(){
  $(".showdetailschoose").show();
  showsnot = $(".showdetailschoose div input:checked").val();
  if (showsnot==1) {
    $(".detailspositionchoose").show();
    $(".detailsedit").show();
  } else {
    $(".detailspositionchoose").hide();
    $(".detailsedit").hide();
  };
}


$(function(){
  $('.showdetailschoose input').click(function(){
    if ($(this).val()==1) {
      $(".detailspositionchoose").show();
      $(".detailsedit").show();
    } else {
      $(".detailspositionchoose").hide();
      $(".detailsedit").hide();
    };
  });
  $('.pagestylechoose input').click(function(){
    thisvalue = $(this).val();
    thistype = $(this).attr("data-type");
    switch(thistype){
      case "menu":
        if (thisvalue=="1") {
          hidedetails();
        } else {
          hidedetails();
          $(".detailsedit").show();
        };
      break;
      case "page":
        hidedetails();
        $(".detailsedit").show();
      break;
      case "article":
        showdetails();
      break;
      case "job":
        showdetails();
      break;
      case "product":
        showdetails();
      break;
    }
  })
})
  CKEDITOR.replace( 'editor1', { 
  filebrowserBrowseUrl: '/manage/ckfinder/ckfinder.html', 
  filebrowserImageBrowseUrl: '/manage/ckfinder/ckfinder.html?Type=Images',
  filebrowserFlashBrowseUrl: '/manage/ckfinder/ckfinder.html?Type=Flash',
  filebrowserUploadUrl: '/manage/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
  filebrowserImageUploadUrl: '/manage/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
  filebrowserFlashUploadUrl: '/manage/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
  allowedContent: true
  }); 
</script>
@stop