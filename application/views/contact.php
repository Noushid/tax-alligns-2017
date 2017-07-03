        
        <section class="flat-row contact-page pad-top-134">
            <div class="container">
                <div class="row">

                    <div class="col-md-4">
                        <div class="contact-content">
                            <div class="contact-address">                                
                                <div class="details">
                                    <h5>Contact us Anytime</h5>
                                    <p>Mobile: (+91) 9446 5000 44</p>
                                    <p>For GST: (+91) 9446 7000 44</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-content">
                            <div class="contact-address">                                
                                <div class="details">
                                    <h5>Our Location</h5>
                                    <p>Accounts Outsourcing & Internal Auditors</p>
                                    <p>PP-13/211, Marva Building,Aravankara</p>
                                    <p>Pookkottur, Malappuram DT Pin:676517</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-content">
                            <div class="contact-address">                                
                                <div class="details">
                                    <h5>Write Some Words</h5>
                                    <p>info@accountsandtax.in</p>
                                    <p>career@accountsandtax.in</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->

                <div class="row">
                    <div class="flat-spacer d74px"></div>
                </div>

                <div id="respond" class="comment-respond contact style2">
                   <div class="title-section style1">
                     <h3 class="title">Leave a Message</h3>
                    </div>
                    <form id="contactform" class="flat-contact-form style2 bg-dark height-small" method="post" action="./contact/contact-process.php">
                        <div class="field clearfix">      
                            <div class="wrap-type-input">                    
                                <div class="input-wrap name">
                                    <input type="text" value="" tabindex="1" placeholder="Name" name="name" id="name" required>
                                </div>
                                <div class="input-wrap email">
                                    <input type="email" value="" tabindex="2" placeholder="Email" name="email" id="email" required>
                                </div>
                                <div class="input-wrap last Subject">
                                    <input type="text" value="" placeholder="Subject (Optinal)" name="subject" id="subject" >
                                </div>  
                            </div>
                            <div class="textarea-wrap">
                                <textarea class="type-input" tabindex="3" placeholder="Message" name="message" id="message-contact" required></textarea>
                            </div>
                        </div>
                        <div class="submit-wrap">
                            <button class="flat-button bg-orange">Send Your Message</button>
                        </div>
                    </form><!-- /.comment-form -->                     
                </div><!-- /#respond -->
            </div><!-- /.container -->   
        </section>

        <!-- Map -->
        <section class="row-map">
            <div class="container-fluid">
                <div class="row">
                    <div id="map" style="width: 100%; height: 450px; "></div> 
                </div>
            </div><!-- /.container -->
        </section>

        <script src="javascript/googlemap.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdYJAEwIvCJ409XkqnHRKTV2iFhFqYFDI&callback=initMap"
    async defer></script>