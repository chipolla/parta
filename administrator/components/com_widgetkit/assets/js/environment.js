!function(t,e){function n(t){var n=e.tinymce.editors[t.attr("id")];return{getContent:function(){return n.getContent()},insertContent:function(t){n.execCommand("mceInsertContent",!1,t)},updateContent:function(t,e,o){var i=this.getContent();i=i.substring(0,e)+t+'<span id="tmp-wkid"></span>'+i.substring(o),n.setContent(i),n.selection.select(n.dom.select("#tmp-wkid")[0],!0),n.selection.collapse(!1),n.dom.remove("tmp-wkid",!1),n.focus()},getCursorPosition:function(){var t=n.selection.getBookmark(0),e="[data-mce-type=bookmark]",o=n.dom.select(e);n.selection.select(o[0]),n.selection.collapse();var i="######cursor######",r='<span id="'+i+'"></span>';n.selection.setContent(r);var s=n.getContent({format:"html"}),a=s.indexOf(r);return n.dom.remove(i,!1),n.selection.moveToBookmark(t),a}}}function o(t){return{getContent:function(){return t.val()},insertContent:function(e){this.updateContent(e,t.prop("selectionStart"),t.prop("selectionEnd"))},updateContent:function(e,n,o){var i=t.val(),r=n+e.length;i=i.substring(0,n)+e+i.substring(o),t.val(i),t[0].setSelectionRange(r,r),t.focus().trigger("change")},getCursorPosition:function(){return t.prop("selectionStart")}}}function i(t){var e=t.next()[0].CodeMirror;return{getContent:function(){return e.getValue()},insertContent:function(t){e.replaceRange(t,e.getCursor()),e.focus()},updateContent:function(t,n,o){e.replaceRange(t,this.translateOffset(n),this.translateOffset(o)),e.focus()},getCursorPosition:function(){return this.translatePosition(e.getCursor())},translatePosition:function(t){return e.getValue().split("\n",t.line).join("").length+t.line+t.ch},translateOffset:function(t){var n=e.getValue().substring(0,t).split("\n");return{line:n.length-1,ch:n[n.length-1].length}}}}function r(t){var n=e.ace.edit(t.parent().attr("id"));return{getContent:function(){return n.getValue()},insertContent:function(t){n.insert(t),n.focus()},updateContent:function(t,e,o){e=this.translateOffset(e),o=this.translateOffset(o);var i=n.getSelectionRange();i.setStart(e.row,e.column),i.setEnd(o.row,o.column),n.getSession().getDocument().replace(i,t),n.focus()},getCursorPosition:function(){return this.translatePosition(n.getSelection().getCursor())},translatePosition:function(t){return this.getContent().split("\n",t.row).join("").length+t.row+t.column},translateOffset:function(t){var e=this.getContent().substring(0,t).split("\n");return{row:e.length-1,column:e[e.length-1].length}}}}function s(e){var n=CKEDITOR.instances[e.attr("id")];return{getContent:function(){return n.getData()},insertContent:function(t){this.updateContent(t,this.getCursorPosition(),this.getCursorPosition())},updateContent:function(t,e,o){var i=n.getData();i=i.substring(0,e)+t+i.substring(o),n.setData(i)},getCursorPosition:function(){return"source"==n.mode?t(n.textarea.$).prop("selectionStart"):this.getCursorPositionInWYSIWYG()},getCursorPositionInWYSIWYG:function(){var t=n.getSelection().createBookmarks(),e="######cursor######",o='<span id="'+e+'">&nbsp;</span>',i=CKEDITOR.dom.element.createFromHtml(o);i.insertBefore(t[0].startNode);var r=this.getContent(),s=r.indexOf(o);return i.remove(),n.getSelection().selectBookmarks(t),s}}}var a={init:function(e,n,o){var i=t(this.tmpl).appendTo("body");this.mode=e,this.attrs=n,this.cb=o,this.modal=t.UIkit.modal(i),this.modal.on("hide.uk.modal",function(){i.remove()}),t.UIkit.domObserve(i,function(){var e=this;t.UIkit.domObservers.forEach(function(t){t(e)})}),angular.bootstrap(i,["widgetkit"])},editor:function(t){var a;a=(e.WFEditor||e.JContentEditor||e.tinyMCE)&&!t.is(":visible")?new n(t):e.CodeMirror&&t.next()[0]&&t.next()[0].CodeMirror?new i(t):e.ace?new r(t):e.CKEDITOR?new s(t):new o(t);for(var c,l,g=a.getContent(),d=a.getCursorPosition(),f=/\[widgetkit([^\]]*)\]/gi;l=f.exec(g);)if(l.index<=d&&f.lastIndex>d){c=l[0];break}this.init("editor",u.parse("widgetkit",c).attrs,function(t){var e=new u({tag:"widgetkit",attrs:t}).string();c?a.updateContent(e,l.index,f.lastIndex):a.insertContent(e)})},update:function(t){this.cb(t),this.modal.hide()},cancel:function(){this.modal.hide()},tmpl:'<div class="uk-modal"><div style="width: 1000px;" class="uk-modal-dialog" ng-include="\'picker\'"></div></div>'},u=function(e){t.extend(this,{tag:"",attrs:{},type:"single",content:""},e)};t.extend(u,{parse:function(t,e){var n,o=this.regexp(t).exec(e),i={tag:t};return o&&(n=o[4]?"self-closing":o[6]?"closed":"single",i={tag:o[2],attrs:this.attrs(o[3]),type:n,content:o[5]}),new u(i)},attrs:function(t){var e,n=/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/g,o={};for(t=t.replace(/[\u00a0\u200b]/g," ");e=n.exec(t);)e[1]?o[e[1].toLowerCase()]=e[2]:e[3]?o[e[3].toLowerCase()]=e[4]:!e[5]||"true"!==e[6]&&"1"!==e[6]?!e[5]||"false"!==e[6]&&"0"!==e[6]?e[5]?o[e[5].toLowerCase()]=e[6]:e[7]?o[e[7]]=!0:e[8]&&(o[e[8]]=!0):o[e[5].toLowerCase()]=!1:o[e[5].toLowerCase()]=!0;return o},regexp:function(t){return new RegExp("\\[(\\[?)("+t+")(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)","g")}}),t.extend(u.prototype,{string:function(){var e="["+this.tag;return t.each(this.attrs,function(t,n){"boolean"==typeof n?e+=" "+t+"="+(n?1:0):""!==n&&(e+=" "+t+'="'+n+'"')}),"single"===this.type?e+"]":"self-closing"===this.type?e+" /]":(e+="]",this.content&&(e+=this.content),e+"[/"+this.tag+"]")}}),t(function(){t.extend(e.widgetkit,{env:a,shortcode:u})})}(jQuery,window);