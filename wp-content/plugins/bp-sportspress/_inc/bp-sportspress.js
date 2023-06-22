if ( typeof jq == "undefined" ) {
    var jq = jQuery;
}

jq( function() {

    // Chosen select
    jq(".chosen-select, #poststuff #post_author_override").chosen({
        allow_single_deselect: true,
        search_contains: true,
        single_backstroke_delete: false,
        disable_search_threshold: 10,
        placeholder_text_multiple: localized_strings.none
    });
});