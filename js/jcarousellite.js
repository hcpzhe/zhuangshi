/*  已添加鼠标浮动停止滚动 */
(function($) { 
  $.fn.jCarouselLite = function(o) {
  o = $.extend({
  btnPrev: null,	//上一个按钮的class名, 比如  btnPrev: ".prev"
  btnNext: null,	//下一个按钮的class名, 比如  btnPrev: ".prev"
  btnGo: null,
  btnDisabled: 'btn-inactive', //禁用的时候的样式类名
  mouseWheel: false,	//鼠标滑轮是否可以控制滚动,可选： true,false
  auto: null,	//指定多少秒内容定期自动滚动。默认为空(null),是不滚动,如果设定的,单位为毫秒,如1秒为1000
   
  speed: 2800,	//滑动的速度,可以尝试800 1000 1500,设置成0将删除效果
  easing: null,	//缓冲效果名称,如：easing: "bounceout",需要jquery中的easing pluin（缓冲插件实现）,只适用于jq1.2
   
  vertical: false,	//是否垂直滚动,可选：false,true
  circular: true,	//是否循环滚动,默认为true,如果为false,滚动到最后一个将停止滚动
  visible: 3,	//可见数量,可以为小数，如2.5为2.5个li
  start: 0,	//开始的地方,默认是0
  scroll: 1,	//每次滚动的li数量
   
  beforeStart: null,
  afterEnd: null
  }, o || {});
   
  return this.each(function() { // Returns the element collection. Chainable.
   
  var running = false, animCss=o.vertical?"top":"left", sizeCss=o.vertical?"height":"width";
  var div = $(this), ul = $("ul", div), tLi = $("li", ul), tl = tLi.size(), v = o.visible;
   
  if(tl == 0) {
  return false;
  }
  if(o.circular) {
  ul.prepend(tLi.slice(tl-v-1+1).clone())
  .append(tLi.slice(0,v).clone());
  o.start += v;
  }
   
  var li = $("li", ul), itemLength = li.size(), curr = o.start;
  div.css("visibility", "visible");
   
  li.css({overflow: "hidden", 'float': o.vertical ? "none" : "left"});
  ul.css({margin: "0", padding: "0", position: "relative", "list-style-type": "none", "z-index": "1"});
  div.css({overflow: "hidden", position: "relative", "z-index": "2", left: "0px"});
   
  var liSize = o.vertical ? height(li) : width(li); // Full li size(incl margin)-Used for animation
  var ulSize = liSize * itemLength; // size of full ul(total length, not just for the visible items)
  var divSize = liSize * v; // size of entire div(total length for just the visible items)
   
  li.css({width: li.width(), height: li.height()});
  ul.css(sizeCss, ulSize+"px").css(animCss, -(curr*liSize));
   
  div.css(sizeCss, divSize+"px"); // Width of the DIV. length of visible images
   
  if(o.btnPrev)
  $(o.btnPrev).click(function() {
  return go(curr-o.scroll);
  });
   
  if(o.btnNext)
  $(o.btnNext).click(function() {
  return go(curr+o.scroll);
  });
   
  if(o.btnGo)
  $.each(o.btnGo, function(i, val) {
  $(val).click(function() {
  return go(o.circular ? o.visible+i : i);
  });
  });
   
  if(o.mouseWheel && div.mousewheel)
  div.mousewheel(function(e, d) {
  return d>0 ? go(curr-o.scroll) : go(curr+o.scroll);
  });
  var jcarouselliteAutoId;
  if(o.auto) {
  jcarouselliteAutoId = setInterval(function() {
  go(curr+o.scroll);
  }, o.auto+o.speed);
  /*  添加鼠标浮动停止滚动 */
  ul.hover(function(){
  clearInterval(jcarouselliteAutoId);
  },function(){
  jcarouselliteAutoId = setInterval(function() {
  go(curr+o.scroll);
  }, o.auto+o.speed);
  });
  };
   
  function vis() {
  return li.slice(curr).slice(0,v);
  };
   
  function go(to) {
  if(tl <= 3) {
  return false;
  }
   
  if(!running) {
   
  if(o.beforeStart)
  o.beforeStart.call(this, vis());
   
  if(o.circular) { // If circular we are in first or last, then goto the other end
  if(to<=o.start-v-1) { // If first, then goto last
  ul.css(animCss, -((itemLength-(v*2))*liSize)+"px");
  // If "scroll" > 1, then the "to" might not be equal to the condition; it can be lesser depending on the number of elements.
  curr = to==o.start-v-1 ? itemLength-(v*2)-1 : itemLength-(v*2)-o.scroll;
  } else if(to>=itemLength-v+1) { // If last, then goto first
  ul.css(animCss, -( (v) * liSize ) + "px" );
  // If "scroll" > 1, then the "to" might not be equal to the condition; it can be greater depending on the number of elements.
  curr = to==itemLength-v+1 ? v+1 : v+o.scroll;
  } else curr = to;
  } else { // If non-circular and to points to first or last, we just return.
  if(to<0 || to>itemLength-v) return;
  else curr = to;
  } // If neither overrides it, the curr will still be "to" and we can proceed.
   
  running = true;
   
  ul.animate(
  animCss == "left" ? { left: -(curr*liSize) } : { top: -(curr*liSize) } , o.speed, o.easing,
  function() {
  if(o.afterEnd)
  o.afterEnd.call(this, vis());
  running = false;
  }
  );
  // Disable buttons when the carousel reaches the last/first, and enable when not
  if(!o.circular) {
  $(o.btnPrev + "," + o.btnNext).removeClass(o.btnDisabled);
  $( (curr-o.scroll<0 && o.btnPrev)
  ||
  (curr+o.scroll > itemLength-v && o.btnNext)
  ||
  []
  ).addClass(o.btnDisabled);
  }
   
  }
  return false;
  };
  });
  };
   
  function css(el, prop) {
  return parseInt($.css(el[0], prop)) || 0;
  };
  function width(el) {
  return el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
  };
  function height(el) {
  return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
  };
   
  })(jQuery);