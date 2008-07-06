/*
 * Ext JS Library 2.1
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

(function(){var B;Ext.lib.Dom={getViewWidth:function(D){return D?this.getDocumentWidth():this.getViewportWidth()},getViewHeight:function(D){return D?this.getDocumentHeight():this.getViewportHeight()},getDocumentHeight:function(){var D=(document.compatMode!="CSS1Compat")?document.body.scrollHeight:document.documentElement.scrollHeight;return Math.max(D,this.getViewportHeight())},getDocumentWidth:function(){var D=(document.compatMode!="CSS1Compat")?document.body.scrollWidth:document.documentElement.scrollWidth;return Math.max(D,this.getViewportWidth())},getViewportHeight:function(){var D=self.innerHeight;var E=document.compatMode;if((E||Ext.isIE)&&!Ext.isOpera){D=(E=="CSS1Compat")?document.documentElement.clientHeight:document.body.clientHeight}return D},getViewportWidth:function(){var D=self.innerWidth;var E=document.compatMode;if(E||Ext.isIE){D=(E=="CSS1Compat")?document.documentElement.clientWidth:document.body.clientWidth}return D},isAncestor:function(E,F){E=Ext.getDom(E);F=Ext.getDom(F);if(!E||!F){return false}if(E.contains&&!Ext.isSafari){return E.contains(F)}else{if(E.compareDocumentPosition){return !!(E.compareDocumentPosition(F)&16)}else{var D=F.parentNode;while(D){if(D==E){return true}else{if(!D.tagName||D.tagName.toUpperCase()=="HTML"){return false}}D=D.parentNode}return false}}},getRegion:function(D){return Ext.lib.Region.getRegion(D)},getY:function(D){return this.getXY(D)[1]},getX:function(D){return this.getXY(D)[0]},getXY:function(F){var E,J,L,M,I=(document.body||document.documentElement);F=Ext.getDom(F);if(F==I){return[0,0]}if(F.getBoundingClientRect){L=F.getBoundingClientRect();M=C(document).getScroll();return[L.left+M.left,L.top+M.top]}var N=0,K=0;E=F;var D=C(F).getStyle("position")=="absolute";while(E){N+=E.offsetLeft;K+=E.offsetTop;if(!D&&C(E).getStyle("position")=="absolute"){D=true}if(Ext.isGecko){J=C(E);var O=parseInt(J.getStyle("borderTopWidth"),10)||0;var G=parseInt(J.getStyle("borderLeftWidth"),10)||0;N+=G;K+=O;if(E!=F&&J.getStyle("overflow")!="visible"){N+=G;K+=O}}E=E.offsetParent}if(Ext.isSafari&&D){N-=I.offsetLeft;K-=I.offsetTop}if(Ext.isGecko&&!D){var H=C(I);N+=parseInt(H.getStyle("borderLeftWidth"),10)||0;K+=parseInt(H.getStyle("borderTopWidth"),10)||0}E=F.parentNode;while(E&&E!=I){if(!Ext.isOpera||(E.tagName!="TR"&&C(E).getStyle("display")!="inline")){N-=E.scrollLeft;K-=E.scrollTop}E=E.parentNode}return[N,K]},setXY:function(D,E){D=Ext.fly(D,"_setXY");D.position();var F=D.translatePoints(E);if(E[0]!==false){D.dom.style.left=F.left+"px"}if(E[1]!==false){D.dom.style.top=F.top+"px"}},setX:function(E,D){this.setXY(E,[D,false])},setY:function(D,E){this.setXY(D,[false,E])}};Ext.lib.Event={getPageX:function(D){return Event.pointerX(D.browserEvent||D)},getPageY:function(D){return Event.pointerY(D.browserEvent||D)},getXY:function(D){D=D.browserEvent||D;return[Event.pointerX(D),Event.pointerY(D)]},getTarget:function(D){return Event.element(D.browserEvent||D)},resolveTextNode:function(D){if(D&&3==D.nodeType){return D.parentNode}else{return D}},getRelatedTarget:function(E){E=E.browserEvent||E;var D=E.relatedTarget;if(!D){if(E.type=="mouseout"){D=E.toElement}else{if(E.type=="mouseover"){D=E.fromElement}}}return this.resolveTextNode(D)},on:function(F,D,E){Event.observe(F,D,E,false)},un:function(F,D,E){Event.stopObserving(F,D,E,false)},purgeElement:function(D){},preventDefault:function(D){D=D.browserEvent||D;if(D.preventDefault){D.preventDefault()}else{D.returnValue=false}},stopPropagation:function(D){D=D.browserEvent||D;if(D.stopPropagation){D.stopPropagation()}else{D.cancelBubble=true}},stopEvent:function(D){Event.stop(D.browserEvent||D)},onAvailable:function(I,E,D){var H=new Date(),G;var F=function(){if(H.getElapsed()>10000){clearInterval(G)}var J=document.getElementById(I);if(J){clearInterval(G);E.call(D||window,J)}};G=setInterval(F,50)}};Ext.lib.Ajax=function(){var E=function(F){return F.success?function(G){F.success.call(F.scope||window,{responseText:G.responseText,responseXML:G.responseXML,argument:F.argument})}:Ext.emptyFn};var D=function(F){return F.failure?function(G){F.failure.call(F.scope||window,{responseText:G.responseText,responseXML:G.responseXML,argument:F.argument})}:Ext.emptyFn};return{request:function(L,I,F,J,G){var K={method:L,parameters:J||"",timeout:F.timeout,onSuccess:E(F),onFailure:D(F)};if(G){var H=G.headers;if(H){K.requestHeaders=H}if(G.xmlData){L=(L?L:(G.method?G.method:"POST"));if(!H||!H["Content-Type"]){K.contentType="text/xml"}K.postBody=G.xmlData;delete K.parameters}if(G.jsonData){L=(L?L:(G.method?G.method:"POST"));if(!H||!H["Content-Type"]){K.contentType="application/json"}K.postBody=typeof G.jsonData=="object"?Ext.encode(G.jsonData):G.jsonData;delete K.parameters}}new Ajax.Request(I,K)},formRequest:function(J,I,G,K,F,H){new Ajax.Request(I,{method:Ext.getDom(J).method||"POST",parameters:Form.serialize(J)+(K?"&"+K:""),timeout:G.timeout,onSuccess:E(G),onFailure:D(G)})},isCallInProgress:function(F){return false},abort:function(F){return false},serializeForm:function(F){return Form.serialize(F.dom||F)}}}();Ext.lib.Anim=function(){var D={easeOut:function(F){return 1-Math.pow(1-F,2)},easeIn:function(F){return 1-Math.pow(1-F,2)}};var E=function(F,G){return{stop:function(H){this.effect.cancel()},isAnimated:function(){return this.effect.state=="running"},proxyCallback:function(){Ext.callback(F,G)}}};return{scroll:function(I,G,K,L,F,H){var J=E(F,H);I=Ext.getDom(I);if(typeof G.scroll.to[0]=="number"){I.scrollLeft=G.scroll.to[0]}if(typeof G.scroll.to[1]=="number"){I.scrollTop=G.scroll.to[1]}J.proxyCallback();return J},motion:function(I,G,J,K,F,H){return this.run(I,G,J,K,F,H)},color:function(I,G,J,K,F,H){return this.run(I,G,J,K,F,H)},run:function(G,O,K,N,H,Q,P){var F={};for(var J in O){switch(J){case"points":var M,S,L=Ext.fly(G,"_animrun");L.position();if(M=O.points.by){var R=L.getXY();S=L.translatePoints([R[0]+M[0],R[1]+M[1]])}else{S=L.translatePoints(O.points.to)}F.left=S.left+"px";F.top=S.top+"px";break;case"width":F.width=O.width.to+"px";break;case"height":F.height=O.height.to+"px";break;case"opacity":F.opacity=String(O.opacity.to);break;default:F[J]=String(O[J].to);break}}var I=E(H,Q);I.effect=new Effect.Morph(Ext.id(G),{duration:K,afterFinish:I.proxyCallback,transition:D[N]||Effect.Transitions.linear,style:F});return I}}}();function C(D){if(!B){B=new Ext.Element.Flyweight()}B.dom=D;return B}Ext.lib.Region=function(F,G,D,E){this.top=F;this[1]=F;this.right=G;this.bottom=D;this.left=E;this[0]=E};Ext.lib.Region.prototype={contains:function(D){return(D.left>=this.left&&D.right<=this.right&&D.top>=this.top&&D.bottom<=this.bottom)},getArea:function(){return((this.bottom-this.top)*(this.right-this.left))},intersect:function(H){var F=Math.max(this.top,H.top);var G=Math.min(this.right,H.right);var D=Math.min(this.bottom,H.bottom);var E=Math.max(this.left,H.left);if(D>=F&&G>=E){return new Ext.lib.Region(F,G,D,E)}else{return null}},union:function(H){var F=Math.min(this.top,H.top);var G=Math.max(this.right,H.right);var D=Math.max(this.bottom,H.bottom);var E=Math.min(this.left,H.left);return new Ext.lib.Region(F,G,D,E)},constrainTo:function(D){this.top=this.top.constrain(D.top,D.bottom);this.bottom=this.bottom.constrain(D.top,D.bottom);this.left=this.left.constrain(D.left,D.right);this.right=this.right.constrain(D.left,D.right);return this},adjust:function(F,E,D,G){this.top+=F;this.left+=E;this.right+=G;this.bottom+=D;return this}};Ext.lib.Region.getRegion=function(G){var I=Ext.lib.Dom.getXY(G);var F=I[1];var H=I[0]+G.offsetWidth;var D=I[1]+G.offsetHeight;var E=I[0];return new Ext.lib.Region(F,H,D,E)};Ext.lib.Point=function(D,E){if(Ext.isArray(D)){E=D[1];D=D[0]}this.x=this.right=this.left=this[0]=D;this.y=this.top=this.bottom=this[1]=E};Ext.lib.Point.prototype=new Ext.lib.Region();if(Ext.isIE){function A(){var D=Function.prototype;delete D.createSequence;delete D.defer;delete D.createDelegate;delete D.createCallback;delete D.createInterceptor;window.detachEvent("onunload",A)}window.attachEvent("onunload",A)}})();