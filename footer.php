<?php
if (et_theme_builder_overrides_layout(ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE) || et_theme_builder_overrides_layout(ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE)) {
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
do_action('et_after_main_content');

if ('on' === et_get_option('divi_back_to_top', 'false')):
?>

<span class="et_pb_scroll_top et-pb-icon"></span>

<?php
endif;

if (!is_page_template('page-template-blank.php')):
?>

<footer id="main-footer">
    <?php get_sidebar('footer'); ?>


    <?php
    if (has_nav_menu('footer-menu')):
    ?>

    <div id="et-footer-nav">
        <div class="container flex align-items-center">
            <div class="ftr_left_col flex align-items-center">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'depth' => '1',
                    'menu_class' => 'bottom-nav',
                    'container' => '',
                    'fallback_cb' => '',
                ));
                ?>
                <span class="ftr_copyright">
                    ©Copyright Charltons 2024. All rights reserved.
                </span>
            </div>
            <div class="ftr_right_col ml-auto">
                <div class="social-networks__list flex">
                    <div class="social-networks__item">
                        <a class="social-networks__link" href="https://www.facebook.com/charltons/" target="_blank"
                            rel="noopener" aria-label="link goes to facebook">
                            <img style="max-width: 24px" src="/media/icons/social-media/facebook.svg" alt="facebook" />
                        </a>
                    </div>
                    <div class="social-networks__item">
                        <a class="social-networks__link"
                            href="https://www.linkedin.com/company/charltons-law/mycompany/" target="_blank"
                            rel="noopener" aria-label="link goes to LinkedIn">
                            <img style="max-width: 24px; height: 24px; padding-top: 6px"
                                src="https://dev2.charltonslaw.com/static/images/icons/social-media/in.svg"
                                alt="linkedin" />
                        </a>
                    </div>
                    <div class="social-networks__item">
                        <a class="social-networks__link" href="https://www.instagram.com/charltonslaw/" target="_blank"
                            rel="noopener" aria-label="link goes to Instagram">
                            <img style="max-width: 24px" src="/media/icons/social-media/instagram.svg"
                                alt="instagram" />
                        </a>
                    </div>
                    <div class="social-networks__item">
                        <a class="social-networks__link" href="https://www.youtube.com/@charltons-law" target="_blank"
                            rel="noopener" aria-label="link goes to YouTube">
                            <img style="max-width: 24px" src="/media/icons/social-media/youtube.svg" alt="youtube" />
                        </a>
                    </div>
                    <div class="social-networks__item">
                        <a class="social-networks__link" href="https://anchor.fm/charltons" target="_blank"
                            rel="noopener" aria-label="link goes to Anchor">
                            <img style="max-width: 24px" src="/media/icons/social-media/anchor.svg" alt="youtube" />
                        </a>
                    </div>
                    <div class="social-networks__item">
                        <a class="social-networks__link" href="https://rumble.com/c/c-1647355" target="_blank"
                            rel="noopener" aria-label="link goes to Rumble">
                            <img style="max-width: 24px" src="/media/icons/social-media/rumble.svg" alt="rumble" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- #et-footer-nav -->

    <?php endif; ?>

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

</body>

</html>