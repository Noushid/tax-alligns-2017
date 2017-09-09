        <!-- Blog posts -->
        <section class="main-content blog bg-sidebar sidebar-left">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title-section style1">
                            <h3 class="title">Our Latest Updates/News</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="post-wrap blog-v2 clearfix">
                            <?php
                            if (isset($blog) and $blog != false) {
                                foreach ($blog as $value) {
                                    $date = date_create($value->date);
                                    ?>
                                    <article class="entry clearfix">
                                        <div class="feature-post v2">
                                            <a href="#"><img class="blog-img" src="<?php echo($value->image_url != NULL ? $value->image_url : base_url('images/blog.jpg')) ?>" alt="image"></a>
                                        </div>
                                        <div class="content-post">
                                            <div class="entry-meta">
                                                <ul class="meta-post clearfix">
                                                    <li class="day">
                                                        <a href="#"><?php echo date_format($date,"d F Y")?></a>
                                                    </li>
                                                    <li class="author">
                                                        <a href="#">By admin</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h4 class="title-post">
                                                <a href="#"><?php echo $value->heading;?></a>
                                            </h4>

                                            <div class="entry-post">
                                                <p id="tag"><?php echo $value->introduction;?> [...]</p>
                                            </div>
                                            <div class="submit-wrap" style="float: right;">
                                                <button onclick="document.location='blogView'"
                                                        class="flat-button button-style">Read More <i
                                                        class="fa fa-chevron-right"></i></button>
                                            </div>
                                        </div>
                                    </article><!-- /entry -->
                                <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="blog-pagination">
<!--                            --><?php //echo $previous_page;?>
                            <ul class="flat-pagination">
                                <!--                                <li class="active"><a href="#">1</a></li>-->
                                <!--                                <li><a href="#">2</a></li>-->
                                <!--                                <li><a href="#">3</a></li>                                -->
                                <?php echo $all_pages;?>
                                <!--                                <li class="next">-->
                                <!--                                    <a href="#">Next <i class="fa fa-angle-double-right"></i></a>-->
                                <!--                                </li>-->
                            </ul><!-- /.flat-pagination -->
                        </div>
                    </div><!-- /col-md-9 -->
                </div><!-- /.row -->
            </div><!-- /.container -->   
        </section>

        