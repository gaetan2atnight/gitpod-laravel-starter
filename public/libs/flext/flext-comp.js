var Flext=new Class({Implements:Options,options:{aniTime:300,maxHeight:0,defaultMaxHeight:1000,parentDepth:6,growClass:"growme",enterStoppedClass:"stopenter",enterSubmitsClass:"entersubmits",replaceGhostTextClass:"replaceghosttext",growParentsClass:"growparents",ghostTextAttr:"ghosttext",ghostClassAttr:"ghostclass"},initialize:function(a,b){this.setOptions(b);this.el=document.id(a);this.autoGrow=a.hasClass(this.options.growClass);this.stopEnter=a.hasClass(this.options.enterStoppedClass);this.enterSubmits=
a.hasClass(this.options.enterSubmitsClass);this.useGhostText=a.hasClass(this.options.replaceGhostTextClass);this.growParents=a.hasClass(this.options.growParentsClass);if(this.autoGrow){this.resizer=new Fx.Tween(this.el,{duration:this.options.aniTime});this.getMaxSize();this.reachedMax=false;this.startSize=this.origSize=this.el.getSize().y;this.vertPadding=this.el.getStyle("padding-top").toInt()+this.el.getStyle("padding-bottom").toInt()+this.el.getStyle("border-top").toInt()+this.el.getStyle("border-bottom").toInt();
this.el.setStyle("overflow","hidden");this.el.addEvents({keyup:function(c){this.checkSize(c)}.bind(this),change:function(c){this.checkSize(c)}.bind(this),click:function(c){this.checkSize(c)}.bind(this)});this.checkSize()}this.stopEnter&&this.el.addEvent("keydown",function(c){if(c.key=="enter"){c.stop();this.enterSubmits&&this.submitForm()}}.bind(this));if(this.useGhostText){this.ghostText=this.el.get(this.options.ghostTextAttr);this.ghostClass=this.el.get(this.options.ghostClassAttr);if(this.ghostText){this.el.value!=
this.ghostText&&this.el.removeClass(this.ghostClass);this.el.addEvents({focus:function(){if(this.el.value==this.ghostText){this.el.set("value","");this.ghostClass&&this.el.removeClass(this.ghostClass)}}.bind(this),blur:function(){if(this.el.value==""){this.el.set("value",this.ghostText);this.ghostClass&&this.el.addClass(this.ghostClass)}}.bind(this)})}}},getMaxSize:function(){this.maxSize=this.options.maxHeight;if(this.maxSize==0){var a=this.el.className.match(/maxheight-(\d*)/);this.maxSize=a?a[1]:
this.options.defaultMaxHeight}},checkSize:function(){var a=this.el.getSize(),b=this.el.getScrollSize(),c=navigator.userAgent.toLowerCase().indexOf("chrome")>-1?b.y:b.y+this.vertPadding;c>a.y&&this.resizeIt(a,b)},resizeIt:function(a,b){a=b.y;if(b.y+this.vertPadding>this.maxSize&&!this.reachedMax){a=this.maxSize;this.el.setStyle("overflow","");this.resizer.start("height",a);if(this.growParents){b=a-this.startSize;this.resizeParents(this.el,0,b)}this.reachedMax=true}if(!this.reachedMax){b=a-this.startSize;
if(b<0)b=0;this.startSize=a;this.resizer.start("height",a);this.growParents&&this.resizeParents(this.el,0,b)}},resizeParents:function(a,b,c){if(b<this.options.parentDepth)if(a=a.getParent()){if(a.style.height&&a.style.height!=""){if(a.retrieve("flextAdjusted"))var d=a.getStyle("height").toInt()+c;else{a.store("flextAdjusted",true);d=a.getStyle("height").toInt()+c+this.vertPadding}a.setStyle("height",d)}return this.resizeParents(a,b+1,c)}return true},submitForm:function(){var a=this.el.getParent("form");
if(a){a=a.get("name");document[a].submit()}}});window.addEvent("domready",function(){$$("textarea.flext").each(function(a){new Flext(a)})});