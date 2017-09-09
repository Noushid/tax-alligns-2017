<!-- Blog posts -->
        <section class="main-content blog bg-sidebar sidebar-left blog-single v1">
            <div class="container">
                <div class="row">
                    <div class="wrap-main-post">
                        <div class="col-md-9">
                            <div class="post-wrap single-v1 clearfix">
                                <article class="entry clearfix">
                                    <div class="entry-border">
                                        <div class="content-post">
                                            <div class="entry-post">
                                                <?php echo $blog->content;?>
                                            </div>
<!--                                            <iframe src="--><?php //echo base_url('uploads/') . $blog[0]->document->file_name;?><!--" style="height: 600px; width: 100%;"></iframe>-->
                                        </div>
                                    </div><!-- /.entry-border -->
                                </article><!-- /.entry -->
                            </div><!-- /.post-wrap -->
                        </div><!-- /.col-md-9 -->

                        <div class="col-md-3">
                            <div class="sidebar">
                                <div class="widget widget-recent-posts">
                                    <div class="title-link v1">
                                        <h5 class="widget-title">Recent Posts</h5>
                                    </div>
                                    <ul class="categories">
                                        <?php
                                        if (isset($recent) and $recent != false) {
                                            foreach ($recent as $value) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo base_url('gst/' . $value->id);?>"><?php echo $value->heading; ?></a>
                                                </li>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div><!-- /widget-archives -->
                            </div><!-- /sidebar -->
                        </div><!-- /col-md-3 --> 
                    </div><!-- /.wrap-main-post -->
                </div><!-- /.row -->               
            </div><!-- /.container -->   
        </section><!-- /.main-content -->