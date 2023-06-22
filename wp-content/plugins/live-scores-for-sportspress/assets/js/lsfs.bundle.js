!function(e){var t={};function s(a){if(t[a])return t[a].exports;var n=t[a]={i:a,l:!1,exports:{}};return e[a].call(n.exports,n,n.exports,s),n.l=!0,n.exports}s.m=e,s.c=t,s.d=function(e,t,a){s.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:a})},s.r=function(e){Object.defineProperty(e,"__esModule",{value:!0})},s.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="",s(s.s=4)}([function(e,t,s){},,,,function(e,t,s){"use strict";var a,n,l=s(0);(a=l)&&a.__esModule;(n=jQuery)(function(){n.fn.wake=function(e){return"function"==typeof e?n(this).on("wake",e):n(this).trigger("wake")},{self:null,timeout:lsfs.live_refresh,live_intervals:[],currentTime:!1,init:function(){self=this,this.startLiveEvents(),this.liveEventForm(),this.startLiveLeagueTables(),n(document.body).on("lsfs_trigger_live_events",this.refreshEventResults)},liveEventForm:function(){n(".lsfs-form-live-event-results").length>0&&n(document).on("click",".lsfs-form-live-event-results .lsfs-button-live",function(e){e.preventDefault();var t=n(this),s=n(this).parent(),a=t.attr("data-id"),l=t.attr("data-config"),i=t.attr("data-event"),r=t.attr("data-input"),f=!1,o="lsfs_ajax_live_",d={};a&&(d.event_id=a),l&&(d.config_id=l),i&&(d.type=i,o+=i.replace(/-/g,"_")),o&&(d.action=o),r&&(f=n(r).length>1?n(r).serializeArray():n(r).val(),d.value=f),d.nonce=lsfs.nonce,s.find(".lsfs-notice").remove(),n.ajax({url:lsfs.ajaxurl,dataType:"json",type:"POST",data:d,success:function(e){if(e&&e.success){if(e.data.hasOwnProperty("type")&&"live"===e.data.type)t.html(e.data.message);else{if(e.data.message){var a='<div class="lsfs-notice"><p>';a+=e.data.message,a+="</p></div>",s.append(a),setTimeout(function(){s.find(".lsfs-notice").fadeOut(500)},2e3)}"pause"===e.data.type&&("pause"===i?n("[data-config="+l+"][data-event=start]").removeAttr("disabled"):n("[data-config="+l+"][data-event=pause]").removeAttr("disabled"))}e.data.hasOwnProperty("disable")&&e.data.disable&&t.attr("disabled","disabled")}else void 0!==e.data.message&&(a='<div class="lsfs-notice error"><p>',a+=e.data.message,a+="</p></div>",s.append(a),setTimeout(function(){s.find(".lsfs-notice").fadeOut(500)},2e3))}})})},refreshEventResults:function(e,t){var s=n(this),a=s.attr("data-lsfs-live"),l=s.attr("data-lsfs-type"),i={nonce:lsfs.nonce};switch(void 0!==l&&l||(l="list"),void 0!==t&&t&&(a=t),l){case"list":i.action="lsfs_event_results",i.list=a;break;case"event":i.action="lsfs_event_single_result",i.event=a}n.ajax({url:lsfs.ajaxurl,data:i,type:"GET",dataType:"json",success:function(e){if(e.success&&e.data.events){n(document.body).trigger("lsfs_refresh_events",[e.data.events]);var t=[];for(var a in e.data.events){var l=e.data.events[a];if(""!==l.status||""!==l.results){var i=s.find("[data-live-event="+a+"]");t[a]=i.find(".data-live-results");var r=t[a];if(t[a].find("a").length&&(r=t[a].find("a")),r.html()!==l.results+l.status?(t[a].addClass("change"),r.html(l.results+l.status)):delete t[a],i.parent().find(".lsfs-live-scorers").length){var f=i.parent().find(".lsfs-live-scorers");if(l.scorers){f.removeClass("lsfs-hidden");var o=l.scorer_information||"minutes";for(var d in l.scorers){f.find(".lsfs-live-team-scorers[data-team="+d+"]").removeClass("lsfs-hidden");var u=f.find(".lsfs-live-team-scorers[data-team="+d+"] ul"),v=l.scorers[d];u.find("li").remove();for(var c=0;c<v.length;c++){var m=v[c],p=m.minutes;"minutes"!==o&&(p=m.points),u.append("<li>"+m.name+'<span class="lsfs-scorer-minutes">'+p+"</span></li>")}}}}}}setTimeout(function(){for(var e in t)t[e].removeClass("change")},500)}}})},refreshLeagueTables:function(e){var t=n(this),s=t.attr("data-lsfs-live-table"),a={nonce:lsfs.nonce,action:"lsfs_league_table",show_logo:t.attr("data-lsfs-live-table-logo"),columns:t.attr("data-lsfs-live-table-columns"),link_teams:t.attr("data-lsfs-live-table-link-teams"),table:s};n.ajax({url:lsfs.ajaxurl,data:a,type:"GET",dataType:"json",success:function(e){if(e.success)for(var s=e.data,a=t.find(".dataTables_wrapper table").DataTable(),n=a.rows().ids().length,l=0;l<n;l++)a.row(l).data(s[l]).draw(),console.log("Drawwing Row: "+l)}})},startLiveEvents:function(){(new Date).getTime(),n("[data-lsfs-live]").length>0&&(n("[data-lsfs-live]").wake(this.refreshEventResults),n("[data-lsfs-live]").each(function(){var e=n(this).attr("data-lsfs-live");self.live_intervals[e]=setInterval(function(){self.currentTime=(new Date).getTime(),n("[data-lsfs-live="+e+"]").wake(),self.currentTime},self.timeout)}))},startLiveLeagueTables:function(){(new Date).getTime(),n("[data-lsfs-live-table]").length>0&&(n("[data-lsfs-live-table]").wake(this.refreshLeagueTables),n("[data-lsfs-live-table]").each(function(){var e=n(this).attr("data-lsfs-live-table");self.live_intervals[e]=setInterval(function(){self.currentTime=(new Date).getTime(),n("[data-lsfs-live-table="+e+"]").wake(),self.currentTime},self.timeout)}))}}.init()})}]);