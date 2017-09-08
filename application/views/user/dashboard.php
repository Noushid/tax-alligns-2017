<?php
$user = $this->user->where('id', $this->session->userdata('user_id'))->with_message()->get();
?>
<section class="main-content bg-sidebar sidebar-left pt0">
            <div class="container">
                <?php
                if (isset($_SESSION['message'])) {
                    var_dump($_SESSION['message']);
                }
                ?>
                <div class="case">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flat-portfolio v1">
                                <ul class="portfolio-filter">
                                    <li class="active v1"><a data-filter="*" href="#">All MESSAGES</a></li>
                                    <li><a data-filter=".inbox" href="#">INBOX (<span class="not">200</span>)</a></li>
                                    <li><a data-filter=".compose" href="#">COMPOSE MESSAGE</a></li>
                                    <li><a data-filter=".sent" href="#">SENT MESSAGES</a></li>
                                    <li><a data-filter=".settings" href="#">YOUR SETTINGS</a></li>
                                </ul>

                                <div class="portfolio-wrap case-v1 clearfix">

                                    <div class="item v1 inbox" style="padding-top: 20px;">
                                        <article class="entry clearfix">
                                            <div class="comment-post">
                                                <div class="comment-list-wrap">
                                                    <ul class="comment-list">
                                                        <?php
                                                        if (isset($user->message) and $user->message != false) {
                                                            foreach ($user->message as $inbox) {
                                                                if ($inbox->type == 'sent') {
                                                                    ?>
                                                                    <li>
                                                                        <article class="comment v1" onclick="message(<?php echo $inbox->id?>)">
                                                                            <div class="comment-avatar">
                                                                                <img src="images/user.jpg" alt="image">
                                                                            </div>
                                                                            <div class="comment-detail">
                                                                                <div class="comment-meta">
                                                                                    <p class="comment-author"><a
                                                                                            href="#"><?php echo $inbox->subject?></a></p>

                                                                                    <p class="comment-date"><a href="#"><?php echo date('M d Y',$inbox->datetime)?></a></p>
                                                                                    <span class="line"></span>
                                                                                    <a class="my-reply" href="#"
                                                                                       data-toggle="modal"
                                                                                       data-target="#msgView"
                                                                                       class="comment-reply">View
                                                                                        more</a>
                                                                                </div>

                                                                                <p class="comment-body"><?php echo $inbox->message;?></p>
                                                                            </div>
                                                                        </article>
                                                                    </li>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </article>
                                    </div>

                                    <div class="item v1 sent" style="padding-top: 20px;">
                                        <article class="entry clearfix">
                                            <div class="comment-post">
                                                <div class="comment-list-wrap">
                                                    <ul class="comment-list">
                                                        <?php
                                                        if (isset($user->message) and $user->message != false) {
                                                            foreach ($user->message as $sent) {
                                                                if ($sent->type == 'received') {
                                                                    ?>
                                                                    <li>
                                                                        <article class="comment v1">
                                                                            <div class="comment-avatar">
                                                                                <img src="images/admin.png" alt="image">
                                                                            </div>
                                                                            <div class="comment-detail">
                                                                                <div class="comment-meta">
                                                                                    <p class="comment-author"><a
                                                                                            href="#"><?php echo $sent->subject;?></a></p>

                                                                                    <p class="comment-date"><a href="#"><?php echo date('M d Y', $inbox->datetime);?></a></p>
                                                                                    <span class="line"></span>
                                                                                    <a class="my-reply" href="#"
                                                                                       data-toggle="modal"
                                                                                       data-target="#msgView"
                                                                                       class="comment-reply">View
                                                                                        more</a>
                                                                                </div>
                                                                                <p class="comment-body"><?php echo $sent->message;?></p>
                                                                            </div>
                                                                        </article>
                                                                    </li>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </article>
                                    </div>

                                    <div class="item v1 compose">
                                        <article class="entry clearfix">
                                            <div class="comment-post">
                                                <div id="respond" class="comment-respond">
                                                    <form class="comment-form" method="POST" action="<?php echo base_url('send')?>"  enctype="multipart/form-data">
                                                        <p class="comment-notes">Small Description</p>

                                                        <p class="comment-form-author">
                                                            <label>Your Subject *</label>
                                                            <input id="subject" name="subject" type="text" required="required">
                                                        </p>
                                                        <p class="comment-form-author">
                                                            <label>Upload Your File *</label>
<!--                                                            <input id="file" name="file" type="file" required="required" multiple>-->
                                                            <input name="file" type="file" required="required" multiple>
                                                        </p>
                                                        <p class="comment-form-comment">
                                                            <label>Comment</label>
                                                            <textarea id="comment" name="message"></textarea>
                                                        </p>
                                                        <p class="form-submit text-right">
                                                            <button class="flat-button bg-orange" type="submit">Send Your Message</button>
                                                        </p>
                                                    </form>
                                                </div>
                                            </div>
                                        </article>
                                    </div>


                                    <div class="item v1 settings">
                                        <h1>settings</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Modal -->
        <div id="msgView" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Message Details</h4>
                    </div>
                    <div class="modal-body">
                        <article class="entry clearfix">
                            <div class="entry-border">
                                <div class="content-post">
                                    <div class="entry-meta">
                                        <ul class="meta-post clearfix">
                                            <li class="day">
                                                <a href="#">15 November 2016 ...</a>
                                            </li>
                                            <li class="author">
                                                <a href="#"> By admin</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <h4 class="title-post my-head">
                                        <a href="#">Responsive layout</a>
                                    </h4>

                                    <div class="entry-post">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into.</p>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <div class="widget widget-brochures">
                            <div class="title-link v6">
                                <h5 class="widget-title">Download Attached files</h5>
                            </div>
                            <ul class="dowload">
                                <li class="dl-word"><a href="#">Brochures.doc</a></li>
                                <li class="dl-pdf"><a href="#">Brochures.pdf</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn flat-button bg-orange" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<script>
    function message(item) {
        $.ajax({
            url: "delivered/" + item,
            method: "PUT"
        }).done(function (response) {
            console.log('succes');
        });
    }
</script>