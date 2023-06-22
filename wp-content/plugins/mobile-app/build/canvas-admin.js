jQuery(document).ready((function(a){var e=a("#theme").val();a("#theme").on("change",(function(){a(this).val()!=e?(a("#canvas_theme_warning").show(),a("#canvas_theme_link").hide()):(a("#canvas_theme_warning").hide(),a("#canvas_theme_link").show())})),a("#canvas_different_theme").on("change",(function(){a(this).is(":checked")?a("#theme_choice_block").show():a("#theme_choice_block").hide()})),a(".canvas-other-options-checkbox").on("change",(function(){a(this).is(":checked")?a(".canvas-other-options").show():a(".canvas-other-options").hide()})),a("#canvas_push_log_enable").on("change",(function(){a(this).is(":checked")?a("#canvas_push_log_name_block").show():a("#canvas_push_log_name_block").hide()})),a("#canvas_different_theme, #theme").on("change",(function(){var e={action:"canvas_save_theme",use:a("#canvas_different_theme").is(":checked")?1:0,theme:a("#theme").val()};a.post(ajaxurl,e,(function(e){"Ok"==e&&(a("#canvas_theme_warning").hide(),a("#form_editor").trigger("setClean.areYouSure"),a.notify("Updated",{position:"top right",className:"canvas-success"}),a("#canvas_theme_link").show())}))})),a(".canvas-chosen-select").chosen(),a("#form_editor").areYouSure(),a("#canvas_bp_private_messages").length&&a(".canvas-other-options-checkbox").trigger("change");var s=function(){a("#canvas_notification_history").css("display","none"),a.post(ajaxurl,{action:"canvas_notification_history",async:!0},(function(e){a("#canvas_notification_history").html(e).show()}))};if(a("#canvas_message").on("input",(function(){!function(a,e,s){chars=a.value.length;var t=107-chars;document.getElementById(s).innerHTML=t+" character"+(1!=t?"s":"")+" left.",chars>107&&(a.value=a.value.substring(0,107),document.getElementById(s).innerHTML="0 characters left.")}(this,0,"canvas_message_chars")})),a.post(ajaxurl,{action:"canvas_attachment_content",async:!0},(function(e){e.search("<option")>-1&&a("#canvas_notification_data_id").html(e).val("").trigger("change")})),a("#canvas_notification_data_id").on("change",(function(){switch(a(this).val()){case"url":a("#canvas_post_id_block").hide(),a("#canvas_url_block").show();break;case"custom":a("#canvas_post_id_block").show(),a("#canvas_url_block").hide();break;default:a("#canvas_post_id_block, #canvas_url_block").hide()}})),a("#canvas_notification_manual_send_submit").click((function(){{a("#canvas_notification_manual_send_submit").val(a("#canvas_notification_manual_send_submit").data("sending")),a("#canvas_notification_manual_send_submit").attr("disabled",!0),a("#canvas_notification_manual_send_submit").css("opacity","0.5");var e={action:"canvas_notification_manual_send",msg:a("#canvas__sns-notification-text-area").val(),data_id:a("#canvas_notification_data_id").val(),post_id:a("#canvas__sns-post-search").val(),url:a("#canvas__sns-notification-url").val(),os:a("#canvas__sns-send-to-platforms:checked").val(),category_as_tag:a("#canvas__sns-use-post-category-as-tags:checked").val()||"",tags_list:a("#canvas__sns-additional-tags").val(),use_post_featured_image:a("#canvas__sns-use-post-featured-image:checked").val()||!1,featured_image_url:a("#canvas__sns-featured-image-url").val(),notification_type:a("#canvas__sns-notification-type").val()};const t=a(".canvas__sns-spinner");t.show(),a.post(ajaxurl,e,(function(e){a("#canvas_notification_manual_send_submit").val(a("#canvas_notification_manual_send_submit").data("send")),a("#canvas_notification_manual_send_submit").attr("disabled",!1),a("#canvas_notification_manual_send_submit").css("opacity","1.0"),!0===e?(s(),a("#success-message").show(),setTimeout((function(){a("#success-message").fadeOut()}),2e3)):(e=!1===e?"There was an error sending this notification":"There was an error sending this notification:<br>"+e,a("#error-message").html(e).show(),setTimeout((function(){a("#error-message").fadeOut()}),2e4)),t.hide()}))}})),a('#canvas_manual_message input:not([type="submit"]), #canvas_manual_message select').on("click.clear-error, input.clear-error, change.clear-error",(function(){a("#error-message").hide()})),s(),a("#canvas_push_clean_history").length&&a("#canvas_push_clean_history").on("click",(function(){var e=a(this);if(!e.hasClass("disabled")){e.addClass("disabled");var s={action:"canvas_clean_history",_ajax_nonce:a("#canvas-clean-history-nonce").val()};a.ajax({url:ajaxurl,data:s,type:"POST",async:!0,success:function(s){e.removeClass("disabled"),"OK"===s&&a.notify("Cleaned",{position:"top right",className:"canvas-success"})},error:function(s){console.log(s),e.removeClass("disabled"),a.notify("Error",{position:"top right",className:"canvas-error"})}})}return!1})),a(".custom-color-picker-field").wpColorPicker(),a("body").on("click",".canvas_upload_image_button",(function(e){e.preventDefault();var s=a(this),t=wp.media({title:"Insert image",library:{type:"image"},button:{text:"Use this image"},multiple:!1}).on("select",(function(){var e=t.state().get("selection").first().toJSON();a(s).removeClass("button").html('<img class="true_pre_image" src="'+e.url+'" style="max-width:150px;display:block;" />').next().val(e.id).next().show()})).open()})),a("body").on("click",".canvas_remove_image_button",(function(){return a(this).hide().prev().val("").prev().addClass("button").html("Upload image"),!1})),a(".canvas-codemirror-css-field").length&&wp&&wp.codeEditor){var t=canvas_editor&&canvas_editor.css?canvas_editor.css:wp.codeEditor.defaultSettings?_.clone(wp.codeEditor.defaultSettings):{};wp.codeEditor.initialize(a(".canvas-codemirror-css-field"),t)}if(a(".canvas-codemirror-html-field").length&&wp&&wp.codeEditor){var n=canvas_editor&&canvas_editor.html?canvas_editor.html:wp.codeEditor.defaultSettings?_.clone(wp.codeEditor.defaultSettings):{};wp.codeEditor.initialize(a(".canvas-codemirror-html-field"),n)}const i=a("#canvas__sns-notification-type"),o=a("#canvas__sns-notification-title"),c=a("#canvas__sns-notification-text-area"),r=a(".canvas__sns-post-search"),l=a(".canvas__sns-notification-url"),d=a(".canvas__sns-use-post-category-as-tags"),u=a("#canvas__sns-use-post-category-as-tags"),h=a("#canvas__sns-featured-image-wrapper"),v=a(".canvas__sns-use-post-featured-image"),m=a("#canvas__sns-use-post-featured-image"),f=a("#canvas__sns-upload-featured-image"),p=a("#canvas__sns-upload-featured-image"),g=a("#canvas__sns-additional-tags"),b=a(".canvas__sns--all-tags"),w=a(".canvas-restore-default-templates");let k="";i.on("change",(function(e){r.toggleClass("sns--hide"),l.toggleClass("sns--hide"),d.toggleClass("sns--hide"),o.val(""),c.val(""),u.prop("checked",!1),g.val(""),"url"===a(this).val()?(v.addClass("sns--hide"),m.prop("checked",!1),p.removeClass("sns--hide")):(v.removeClass("sns--hide"),m.prop("checked",!0),p.addClass("sns--hide"))})),m.on("change",(function(a){a.target.checked?(f.addClass("sns--hide"),h.addClass("sns--hide")):(f.removeClass("sns--hide"),h.removeClass("sns--hide"))}));const y=a("#canvas__sns-post-search");i.select2({minimumResultsForSearch:-1}),y.select2({ajax:{url:ajaxurl,delay:300,data:function(a){return{search_term:a.term,action:"canvas_get_posts_for_notification"}},processResults:function(a){const{success:e,data:s}=a;return e?{results:s}:{results:[]}}}}).on("select2:select",(function(a){const e=a.params.data,{text:s,content:t,tags:n}=e;o.val(s),c.val(t),g.val(""),b.text(`(${n.join(", ")})`),k=n.join(", ")})),u.on("change",(function(){const a=g.val().trim().split(",").map((a=>a.trim())).filter((a=>a)).join(", ");if(this.checked)g.val(`${a}${a.length?",":""} ${k}`.trim());else if(a.includes(k)){const e=a.replace(k,"").trim().split(",").map((a=>a.trim())).filter((a=>a)).join(", ");g.val(e)}})),p.on("click",(function(e){e.preventDefault(),a(this);const s=wp.media({title:"Add image",library:{type:"image"},button:{text:"Use this image"},multiple:!1}).on("select",(function(){const e=s.state().get("selection").first().toJSON(),t=a("#canvas__sns-featured-image-url");h.html(""),h.html(`<img style="width: 100%;" src="${e.url}">`),t.val(e.url)})).open()}));const C=a(".canvas-code-editor textarea"),x=a('select[name="canvas-code-editor"]');C.each((function(e,s){const t=a(s).data("mode"),n=s.id;let i=wp.codeEditor.defaultSettings?_.clone(wp.codeEditor.defaultSettings):{};i.codemirror=_.extend({},i.codemirror,{mode:t});const o=wp.codeEditor.initialize(a(`#${n}`),i);a(o.codemirror.getWrapperElement()).hide()})),x.on("change",(function(){const e=a(this).val(),s=a(`#${e} + .CodeMirror`)[0].CodeMirror;a(".canvas-code-editor .CodeMirror").each((function(e,s){const t=a(s)[0].CodeMirror;a(t.getWrapperElement()).hide()})),a(s.getWrapperElement()).show()})).change(),w.on("click",(function(a){return window.confirm("Confirm restore default templates?")}))}));