  <footer>
                <img id="ajax-indicator" src="/ajax-loader.gif" alt="Working..." />

                <a rel="license" href="http://creativecommons.org/licenses/by/3.0/" title="This work is licensed under a Creative Commons Attribution 3.0 Unported License."><img alt="Creative Commons Attribution 3.0 Unported License" src="http://i.creativecommons.org/l/by/3.0/80x15.png" /></a>
                <a title="Clicky: Real Time Web Analytics" href="http://getclicky.com/147983"><img src="<?php echo WEBROOT ?>icons/chart_bar.png" alt="Clicky"></a>
                <a title="Validate HTML at the W3C Markup Validator" href="http://validator.w3.org/check?uri=<?php echo CURRENT_URI ?>"><img src="<?php echo WEBROOT ?>icons/html.png" alt="HTML"></a>
                <a title="Validate CSS at the W3C CSS Validator" href="http://jigsaw.w3.org/css-validator/validator?uri=<?php echo CURRENT_URI ?>&amp;profile=css3"><img src="<?php echo WEBROOT ?>icons/css.png" alt="CSS"></a>

                <?php if(isset($article)): ?>
                |  <a href="http://www.geekality.net/?p=<?php echo $article ?>"><strong>Go to blog post</strong></a>
                <?php endif ?>

                <?php if(isset($back_link)): ?>
                |       <a href="<?php echo $back_link ?>"><strong>Back</strong></a>
                <?php endif ?>

                | <a class="link-list-button" data-menu="#tiny-menu" href="<?php echo WEBROOT ?>">View menu...</a>

                | <a class="link-list-button" data-menu="#source-files" href="#">View source...</a>

                <ul id="tiny-menu" class="link-list">
                        <li><a href="<?php echo WEBROOT ?>">Home</a>
                        <?php echo implode(PHP_EOL, $site->menu_items) ?>
                </ul>

                <ul id="source-files" class="link-list">
                        <?php echo implode(PHP_EOL, $site->source_files) ?>
                </ul>
        </footer>

<?php if(defined('CLICKY_ID') AND ENV == 'production'): ?>
        <!-- REMOVE THE 3 LINES BELOW IF YOU COPY THE SOURCE -->
        <script src="http://static.getclicky.com/js"></script>
        <script>clicky.init(<?php echo CLICKY_ID ?>);</script>
        <noscript><p><img alt="Clicky" width="1" height="1" src="http://in.getclicky.com/<?php echo CLICKY_ID ?>ns.gif" /></p></noscript>
<?php endif ?>