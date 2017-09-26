<section class="main-content bg-sidebar sidebar-left pt0">
            <div class="container">

                <div class="case">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flat-portfolio v1">
                                <ul class="portfolio-filter">
<!--                                    <li class="active v1"><a data-filter="*" href="#">All MESSAGES</a></li>-->
                                    <li class="active v1" id="inbox"><a  href="#filter=.inbox">INBOX<!-- (<span class="not">200</span>)--></a></li>
                                    <li id="compose"><a href="#filter=.compose">COMPOSE MESSAGE</a></li>
                                    <li id="sent"><a data-filter=".sent" href="#filter=.sent">SENT MESSAGES</a></li>
                                </ul>

                                <div class="portfolio-wrap case-v1 clearfix">

                                    <div class="item v1 inbox" style="padding-top: 20px;">
                                        <article class="entry clearfix">
                                            <div class="comment-post">
                                                <div class="comment-list-wrap">
                                                     <ul class="comment-list">
                                                        <?php
                                                        if (isset($received) and $received != false) {
                                                            foreach ($received as $inbox) {
                                                                ?>
                                                                <li>
                                                                    <article class="comment v1">
                                                                        <div class="comment-avatar">
                                                                            <img src="images/user.jpg" alt="image">
                                                                        </div>
                                                                        <div class="comment-detail">
                                                                            <div class="comment-meta">
                                                                                <p class="comment-author"><a
                                                                                        href="#"><?php echo $inbox->subject;?></a>
                                                                                </p>

                                                                                <p class="comment-date">
                                                                                    <?php
                                                                                        echo(($inbox->reference_id != null and $inbox->reference_id != 0) ? 'Reply  ->  ' . $inbox->reference->subject . '<span class="line"></span>' : '');
                                                                                    ?>

                                                                                    <a href="#"><?php echo date('M d Y', $inbox->datetime); ?></a>
                                                                                </p>
                                                                                <span class="line"></span>
                                                                                <!--                                                                                    <a class="my-reply" href="#" data-toggle="modal" data-target="#msgView" class="comment-reply">View more</a>-->
                                                                            </div>

                                                                            <input type="checkbox"
                                                                                   class="read-more-state"
                                                                                   id="post-<?php echo $inbox->id; ?>"
                                                                                   style="display: none;"/>

                                                                            <p class="comment-body read-more-wrap">
                                                                                <?php
                                                                                $message = str_split($inbox->message, 120);
                                                                                echo $message[0];
                                                                                ?>
                                                                                <span class="read-more-target">
                                                                                        <?php
                                                                                        echo(isset($message[1]) ? $message[1] : '');
                                                                                        ?>
                                                                                    </span>
                                                                                <input type="checkbox"
                                                                                       class="read-more-state"
                                                                                       id="post-<?php echo $inbox->id; ?>"
                                                                                       style="display: none;"/>

                                                                            <div style="display: flex;"
                                                                                class="widget widget-brochures myul read-more-wrap">
                                                                                <div
                                                                                    class="title-link v6 read-more-target">
                                                                                    <h5 class="widget-title">Download
                                                                                        Attached files</h5>
                                                                                </div>
                                                                                <ul class="dowload read-more-target">
                                                                                    <?php
                                                                                    foreach ($inbox->files as $value) {
                                                                                        ?>
                                                                                        <li class="dl-word"><a
                                                                                                href="<?php echo base_url('files/' . $value->file_name); ?>"><?php echo $value->file_name; ?></a>
                                                                                        </li>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                            </div>
                                                                            </p>
                                                                            <label for="post-<?php echo $inbox->id; ?>"
                                                                                   class="read-more-trigger"></label>

                                                                            <!-- <div class="modal-footer">
                                                                                <button type="button" class="btn flat-button bg-orange" data-dismiss="modal">Close</button>
                                                                            </div> -->
                                                                        </div>


                                                                    </article>
                                                                </li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <div class="blog-pagination">
<!--                                                    --><?php //echo $previous_page;?>
                                                    <ul class="flat-pagination">
                                                        <?php echo $all_pages_received;?>
                                                    </ul><!-- /.flat-pagination -->
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
                                                        if (isset($sent_item) and $sent_item != false) {
                                                            foreach ($sent_item as $sent) {
                                                                ?>
                                                                <li>
                                                                    <article class="comment v1">
                                                                        <div class="comment-avatar">
                                                                            <img src="images/admin.jpg" alt="image">
                                                                        </div>
                                                                        <div class="comment-detail">
                                                                            <div class="comment-meta">
                                                                                <p class="comment-author"><a
                                                                                        href="#"><?php echo $sent->subject; ?></a>
                                                                                </p>

                                                                                <p class="comment-date"><a
                                                                                        href="#"><?php echo date('M d Y', $sent->datetime); ?></a>
                                                                                </p>
                                                                                <span class="line"></span>
                                                                                <!--                                                                                    <a class="my-reply" href="#" data-toggle="modal" data-target="#msgView" class="comment-reply">View more</a>-->
                                                                            </div>

                                                                            <input type="checkbox"
                                                                                   class="read-more-state"
                                                                                   id="post-<?php echo $sent->id; ?>"
                                                                                   style="display: none;"/>

                                                                            <p class="comment-body read-more-wrap">
                                                                                <?php
                                                                                $message = str_split($sent->message, 120);
                                                                                echo $message[0];
                                                                                ?>
                                                                                <span class="read-more-target">
                                                                                        <?php
                                                                                        echo(isset($message[1]) ? $message[1] : '');
                                                                                        ?>
                                                                                    </span>
                                                                                <input type="checkbox"
                                                                                       class="read-more-state"
                                                                                       id="post-<?php echo $sent->id; ?>"
                                                                                       style="display: none;"/>

                                                                            <div
                                                                                class="widget widget-brochures myul read-more-wrap">
                                                                                <div
                                                                                    class="title-link v6 read-more-target">
                                                                                    <h5 class="widget-title">Download
                                                                                        Attached files</h5>
                                                                                </div>
                                                                                <ul class="dowload read-more-target">
                                                                                    <?php
                                                                                    foreach ($sent->files as $value) {
                                                                                        ?>
                                                                                        <li class="dl-word"><a
                                                                                                href="#"><?php echo $value->file_name; ?></a>
                                                                                        </li>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                            </div>
                                                                            </p>
                                                                            <label for="post-<?php echo $sent->id; ?>"
                                                                                   class="read-more-trigger"></label>

                                                                            <!-- <div class="modal-footer">
                                                                                <button type="button" class="btn flat-button bg-orange" data-dismiss="modal">Close</button>
                                                                            </div> -->
                                                                        </div>
                                                                    </article>
                                                                </li>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <div class="blog-pagination">
                                                    <!--                                                    --><?php //echo $previous_page;?>
                                                    <ul class="flat-pagination">
                                                        <?php echo $all_pages_sentitem;?>
                                                    </ul><!-- /.flat-pagination -->
                                                </div>
                                            </div>
                                        </article>
                                    </div>

                                    <div class="item v1 compose">

                                        <div class="row">
                                            <script type="text/javascript">
                                                $(document).ready( function() {
                                                    $('#alert').delay(10000).fadeOut();
                                                });
                                            </script>

                                            <?php
                                            if (isset($_SESSION['message'])) {
                                                ?>
                                                <script type="text/javascript">
                                                    $(document).ready( function() {
                                                        $( "#alert" ).show();
                                                    });
                                                </script>
                                                <div class="col-md-4 col-md-offset-3 alert alert-success" id="alert">
                                                    <strong>Success!</strong> Message Sent!.
                                                </div>
                                            <?php
                                            }
                                            if (isset($_SESSION['error'])) {
                                                ?>
                                                <script type="text/javascript">
                                                    $(document).ready( function() {
                                                        $( "#alert" ).show();
                                                    });
                                                </script>
                                                <div class="col-md-4 col-md-offset-3 alert alert-danger" id="alert">
                                                    <strong>Danger!</strong> Oops! Something went wrong! We will fix soon.
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>


                                        <article class="entry clearfix">
                                            <div class="comment-post">
                                                <div id="respond" class="comment-respond">
                                                        <?php echo form_open_multipart(base_url('send'), ['class' => 'comment-form']);?>
                                                        <p class="comment-notes">Compose Your message and send Now...</p>

                                                        <p class="comment-form-author">
                                                            <label>Message</label>
                                                            <select name="reference_id">
                                                                <option value="" selected>Select</option>
                                                                <?php
                                                                foreach ($all_inbox as $val) {
                                                                    ?>
                                                                    <option value="<?php echo $val->id?>"><?php echo $val->subject;?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </p>
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