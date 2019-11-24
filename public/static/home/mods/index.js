layui.define(['layer','element', 'carousel'], function(exports){

  var $ = layui.jquery
  ,layer = layui.layer
  ,device = layui.device()
  ,carousel = layui.carousel;
  
  //阻止IE7以下访问
  if(device.ie && device.ie < 8){
    layer.alert('如果您非得使用 IE 浏览器访问Fly社区，那么请使用 IE8+');
  }
  //手机设备的简单适配
  var treeMobile = $('.site-tree-mobile')
  ,shadeMobile = $('.site-mobile-shade');

  treeMobile.on('click', function(){
    $('body').addClass('site-mobile');
  });

  shadeMobile.on('click', function(){
    $('body').removeClass('site-mobile');
  });

  //轮播渲染
  carousel.render({
    elem: '#banner'
    ,width: '100%'
    ,height: '898px'
    ,arrow: 'always'
  });

  //滚动监听
  $(window).scroll(function() {
    var scr=$(document).scrollTop();
    scr > 0 ? $(".nav").addClass('scroll') : $(".nav").removeClass('scroll');
  });

  //轮播文字
  $(function(){
    $('.banner').children('.title').addClass('active');
  });
  exports('index',{});
});