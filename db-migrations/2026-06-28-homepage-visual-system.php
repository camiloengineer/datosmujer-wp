<?php

require __DIR__ . '/wp-load.php';

$token = 'CAMBIAR';
$provided_token = isset($_GET['token']) && is_string($_GET['token']) ? $_GET['token'] : '';

if (!hash_equals($token, $provided_token)) {
    http_response_code(403);
    exit('forbidden');
}

header('Content-Type: text/plain; charset=utf-8');

$css = <<<'CSS'
.home.page-id-637 {
    --dm-accent: #ef0e59;
    --dm-ink: #18181b;
    --dm-muted: #66676b;
    --dm-border: #e8e6e3;
    --dm-surface: #ffffff;
    --dm-font: "Roboto", Arial, sans-serif;
    --dm-space-2: 8px;
    --dm-space-3: 12px;
    --dm-space-4: 16px;
    --dm-space-5: 24px;
    --dm-space-6: 32px;
    --dm-space-7: 48px;
    --dm-space-8: 64px;
    --td_theme_color: var(--dm-accent);
    --td_header_color: var(--dm-ink);
    --td_text_color: var(--dm-ink);
}

.home.page-id-637 .td-main-content-wrap {
    background: var(--dm-surface);
    color: var(--dm-ink);
    font-family: var(--dm-font);
}

.home.page-id-637 .td-main-page-wrap {
    padding-top: var(--dm-space-6);
}

.home.page-id-637 .td-main-content-wrap .td_block_wrap {
    font-family: var(--dm-font);
}

.home.page-id-637 .td-main-content-wrap .td_block_trending_now {
    margin-bottom: var(--dm-space-5) !important;
}

.home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 {
    margin-bottom: var(--dm-space-8) !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block_3,
.home.page-id-637 .td-main-content-wrap .td_flex_block_4 {
    margin-bottom: var(--dm-space-8) !important;
}

.home.page-id-637 .td-main-content-wrap .block-title {
    border-bottom: 1px solid var(--dm-border) !important;
    margin-bottom: var(--dm-space-5) !important;
}

.home.page-id-637 .td-main-content-wrap .block-title span,
.home.page-id-637 .td-main-content-wrap .block-title a {
    background: var(--dm-ink) !important;
    color: var(--dm-surface) !important;
    font-family: var(--dm-font) !important;
    font-size: 12px !important;
    font-weight: 700 !important;
    letter-spacing: 0.04em !important;
    line-height: 1 !important;
    padding: 11px 14px !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block_3 .block-title {
    border-bottom-color: var(--dm-accent) !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block_3 .block-title span,
.home.page-id-637 .td-main-content-wrap .td_flex_block_3 .block-title a {
    background: var(--dm-accent) !important;
}

.home.page-id-637 .td-main-content-wrap .td-module-title,
.home.page-id-637 .td-main-content-wrap .entry-title {
    font-family: var(--dm-font) !important;
    font-weight: 600 !important;
    letter-spacing: -0.015em !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block .td-module-title,
.home.page-id-637 .td-main-content-wrap .td_flex_block .entry-title {
    color: var(--dm-ink) !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block .td-module-title a,
.home.page-id-637 .td-main-content-wrap .td_flex_block .entry-title a {
    color: inherit !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block .td-module-title a:hover,
.home.page-id-637 .td-main-content-wrap .td_flex_block .entry-title a:hover {
    color: var(--dm-accent) !important;
}

.home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .entry-title,
.home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .entry-title a {
    color: var(--dm-surface) !important;
}

.home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .td_module_flex_6 .entry-title {
    font-size: 32px !important;
    line-height: 1.16 !important;
}

.home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .td_module_flex_7 .entry-title,
.home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .td_module_flex_8 .entry-title {
    font-size: 18px !important;
    line-height: 1.28 !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block_3 .td_module_flex_1 .entry-title,
.home.page-id-637 .td-main-content-wrap .td_flex_block_4 .td_module_flex_1 .entry-title {
    font-size: 24px !important;
    line-height: 1.24 !important;
    margin-bottom: var(--dm-space-2) !important;
    margin-top: var(--dm-space-4) !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block_3 .td_module_flex_3 .entry-title,
.home.page-id-637 .td-main-content-wrap .td_flex_block_4 .td_module_flex_4 .entry-title {
    font-size: 15px !important;
    line-height: 1.4 !important;
}

.home.page-id-637 .td-main-content-wrap .td-post-author-name,
.home.page-id-637 .td-main-content-wrap .td-post-date,
.home.page-id-637 .td-main-content-wrap .td-editor-date {
    font-family: var(--dm-font) !important;
    font-size: 12px !important;
    line-height: 1.4 !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block .td-post-author-name a {
    color: var(--dm-ink) !important;
    font-weight: 700 !important;
}

.home.page-id-637 .td-main-content-wrap .td_flex_block .td-post-date,
.home.page-id-637 .td-main-content-wrap .td_flex_block .td-excerpt {
    color: var(--dm-muted) !important;
}

.home.page-id-637 .td-main-content-wrap .td-excerpt {
    font-family: var(--dm-font) !important;
    font-size: 14px !important;
    line-height: 1.6 !important;
    margin-top: var(--dm-space-3) !important;
}

.home.page-id-637 .td-main-content-wrap .td-post-category {
    background: var(--dm-ink) !important;
    color: var(--dm-surface) !important;
    font-family: var(--dm-font) !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 0.04em !important;
    line-height: 1 !important;
    padding: 6px 8px !important;
}

.home.page-id-637 .td-main-content-wrap .td-post-category:hover {
    background: var(--dm-accent) !important;
    color: var(--dm-surface) !important;
}

.home.page-id-637 .td-main-content-wrap .td-image-container,
.home.page-id-637 .td-main-content-wrap .td-module-thumb,
.home.page-id-637 .td-main-content-wrap .td-image-wrap {
    overflow: hidden;
}

.home.page-id-637 .td-main-content-wrap .entry-thumb {
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    object-fit: cover;
}

.home.page-id-637 .td-main-content-wrap .td-next-prev-wrap a {
    border-color: var(--dm-border) !important;
    color: var(--dm-muted) !important;
}

.home.page-id-637 .td-main-content-wrap .td-next-prev-wrap a:hover {
    background: var(--dm-accent) !important;
    border-color: var(--dm-accent) !important;
    color: var(--dm-surface) !important;
}

.home.page-id-637 .td-main-content-wrap .td-trending-now-title {
    background: var(--dm-ink) !important;
    font-family: var(--dm-font) !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.04em !important;
    line-height: 1 !important;
    padding: 10px 14px !important;
}

.home.page-id-637 .td-main-content-wrap .td-trending-now-display-area .entry-title {
    font-size: 14px !important;
    line-height: 1.4 !important;
}

@media (min-width: 768px) {
    .home.page-id-637 .td-main-content-wrap .td-big-grid-flex {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: auto !important;
    }
}

@media (min-width: 1019px) {
    .home.page-id-637 .td-main-content-wrap .tdc-row {
        max-width: 1240px;
        width: calc(100% - 48px);
    }

    .home.page-id-637 .td-main-content-wrap .tdc-row .td-pb-row {
        margin-left: -16px;
        margin-right: -16px;
    }

    .home.page-id-637 .td-main-content-wrap .tdc-row .td-pb-row [class*="td-pb-span"] {
        padding-left: 16px;
        padding-right: 16px;
    }
}

@media (min-width: 768px) and (max-width: 1018px) {
    .home.page-id-637 .td-main-content-wrap .tdc-row {
        max-width: 960px;
        width: calc(100% - 40px);
    }

}

@media (max-width: 767px) {
    .home.page-id-637 .td-main-page-wrap {
        padding-top: var(--dm-space-4);
    }

    .home.page-id-637 .td-main-content-wrap .tdc-row {
        padding-left: var(--dm-space-4);
        padding-right: var(--dm-space-4);
    }

    .home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5,
    .home.page-id-637 .td-main-content-wrap .td_flex_block_3,
    .home.page-id-637 .td-main-content-wrap .td_flex_block_4 {
        margin-bottom: var(--dm-space-7) !important;
    }

    .home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .td_module_flex_6 .entry-title {
        font-size: 25px !important;
        line-height: 1.18 !important;
    }

    .home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .td_module_flex_7 .entry-title,
    .home.page-id-637 .td-main-content-wrap .td_block_big_grid_flex_5 .td_module_flex_8 .entry-title {
        font-size: 16px !important;
        line-height: 1.3 !important;
    }

    .home.page-id-637 .td-main-content-wrap .td_flex_block_3 .td_module_flex_1 .entry-title,
    .home.page-id-637 .td-main-content-wrap .td_flex_block_4 .td_module_flex_1 .entry-title {
        font-size: 22px !important;
        line-height: 1.28 !important;
    }
}
CSS;

$option_name = 'dm_homepage_visual_system_css';
$existing = trim((string) wp_get_custom_css());
$previous = trim((string) get_option($option_name, ''));

if ($previous !== '') {
    $existing = trim(str_replace($previous, '', $existing));
}

$next = $existing === '' ? $css : $existing . "\n\n" . $css;
$result = wp_update_custom_css_post($next . "\n");

if (is_wp_error($result)) {
    http_response_code(500);
    exit('CSS ERROR: ' . $result->get_error_message());
}

update_option($option_name, $css, false);

echo "CSS visual de portada actualizado.\n";
