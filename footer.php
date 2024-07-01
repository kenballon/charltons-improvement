<?php
if ( et_theme_builder_overrides_layout( ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE ) || et_theme_builder_overrides_layout( ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE ) ) {
    // Skip rendering anything as this partial is being buffered anyway.
    // In addition, avoids get_sidebar() issues since that uses
    // locate_template() with require_once.
    return;
}

/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */
do_action( 'et_after_main_content' );

if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

<footer id="main-footer">
    <?php get_sidebar( 'footer' ); ?>


    <?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

    <div id="et-footer-nav">
        <div class="container">
            <?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
        </div>
    </div> <!-- #et-footer-nav -->

    <?php endif; ?>

    <div id="footer-bottom" style="display:none;">
        <div class="container clearfix">
            <?php
					if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
						get_template_part( 'includes/social_icons', 'footer' );
					}

					// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
					echo et_core_fix_unclosed_html_tags( et_core_esc_previously( et_get_footer_credits() ) );
					// phpcs:enable
				?>
        </div> <!-- .container -->
    </div>
</footer> <!-- #main-footer -->
</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

</div> <!-- #page-container -->

<?php wp_footer(); ?>
<script>
(function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
ga('create', 'UA-58524536-2', 'auto');
ga('set', 'anonymizeIp', true);
ga('send', 'pageview');
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function(m, e, t, r, i, k, a) {
    m[i] = m[i] || function() {
        (m[i].a = m[i].a || []).push(arguments)
    };
    m[i].l = 1 * new Date();
    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k,
        a)
})
(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

ym(57540187, "init", {
    clickmap: true,
    trackLinks: true,
    accurateTrackBounce: true
});
</script>

<script>
function loadVideo(element) {
    const videoId = element.getAttribute('data-video-id');
    const iframe = document.createElement('iframe');
    iframe.width = '560';
    iframe.height = '315';
    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&si=D4aiLegx8t4uizoe`;
    iframe.title = 'YouTube video player';
    iframe.frameBorder = '0';
    iframe.allow =
        'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
    iframe.referrerPolicy = 'strict-origin-when-cross-origin';
    iframe.allowFullscreen = true;

    // Replace the placeholder with the iframe
    element.innerHTML = '';
    element.appendChild(iframe);
}
</script>


</body>

</html>