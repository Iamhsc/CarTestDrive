/**

 @Name: 用户模块

 */
 
layui.define(['laypage', 'element', 'flow'], function(exports){

  var $ = layui.jquery;
  var element = layui.element;

  //显示当前tab
  if(location.hash){
    element.tabChange('user', location.hash.replace(/^#/, ''));
  }

  element.on('tab(user)', function(){
    var othis = $(this), layid = othis.attr('lay-id');
    if(layid){
      location.hash = layid;
    }
  });
  exports('user', null);
  
});