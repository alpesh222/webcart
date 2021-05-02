<?php
$primary_color          = !empty(config('customcss.css_front_primary')) ? config('customcss.css_front_primary') : '#3f9eef';
$secondary_color        = !empty(config('customcss.css_front_secondary')) ? config('customcss.css_front_secondary') : '#3f9eef';
$panel_btn_color        = !empty(config('customcss.panel_btn_color')) ? config('customcss.panel_btn_color') : '#3f9eef';
$panel_btn_hover_color  = !empty(config('customcss.panel_btn_hover_color')) ? config('customcss.panel_btn_hover_color') : '#3f9eef';
$head_foot_text_color   = !empty(config('customcss.head_foot_text_color')) ? config('customcss.head_foot_text_color') : '#fff';
$head_foot_icon_color   = !empty(config('customcss.head_foot_icon_color')) ? config('customcss.head_foot_icon_color') : '#fff';
$link_hover_color       = !empty(config('customcss.link_hover_color')) ? config('customcss.link_hover_color') : '#3f9eef';
$header_text_color      = !empty(config('customcss.header_text_color')) ? config('customcss.header_text_color') : '#000';

?>
<style>
    :root {
        --main-color: {{$primary_color}};
        --bg-color: {{$secondary_color}};
        --btn-color: {{$panel_btn_color}};
        --btn-hover-color: {{$panel_btn_hover_color}};
        --head-foot-text-color: {{$head_foot_text_color}};
        --head-foot-icons-color: {{$head_foot_icon_color}};
        --links-hover-color: {{$link_hover_color}};
        --header-text-color: {{$header_text_color}};
        --light-color: #eaeaea;
        --dark-color: #333;
    }
</style>
