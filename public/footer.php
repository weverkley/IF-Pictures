        <footer>
            <div class="container">
                <div class="row">
                    <p>© 2015 IF - Pictures. All Rights Reserved.
                    <a class="pull-right page-scroll" href="#voltar-topo" data-toggle="tooltip" title="Voltar ao topo!"><i class="fa fa-2x fa-angle-up"></i></a>
                    </p>
                </div>
            </div>
        </footer>
        <script src="<?php echo PUBLIC_DIR; ?>/js/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo PUBLIC_DIR; ?>/js/jquery.lazyload.min.js" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo PUBLIC_DIR; ?>/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo PUBLIC_DIR; ?>/js/jquery.easing.min.js" type="text/javascript"></script>
        <script src="<?php echo PUBLIC_DIR; ?>/js/scrolling-nav.js" type="text/javascript"></script>
        <script src="<?php echo PUBLIC_DIR; ?>/js/wow.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            new WOW().init();
        </script>
        <script type="text/javascript">
            $('img.lazy').lazyload({
                effect : 'fadeIn'
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#nav').affix({
                    offset: {
                        top: 173
                    }
                });
            });
        </script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>