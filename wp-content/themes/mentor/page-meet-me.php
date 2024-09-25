<?php
	  /*
        Template Name: Meet Me
    */

    get_header();
?>

        <div class="heading">
            <div class="container">
                <h1>Meet Me</h1>
            </div>
        </div>

        <div class="container">
            <h2>Let’s Meet and Discuss Your Possibilities</h2>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <img src="assets/img/author.jpg" alt="">
                </div>
                <!--/ .col-md-4-->
                <div class="col-md-8 col-sm-8">
                    <div class="row no-gutters">
                        <div class="col-md-6 col-sm-6">
                            <div class="box text-color-white equal-height">
                                <h3>Make an Appointment</h3>
                                <p>
                                    Sed iaculis dapibus tellus eget condimentum. Curabitur ut tellus congue, convallis tortor
                                    et, pellentesque diam. Nullam non dolor eu ligula ultrices pellentesque placerat imperdiet
                                    metus. Etiam lobortis bibendum egestas.
                                </p>
                                <p>
                                    In quis massa a felis molestie consequat rhoncus vitae nisl. In pharetra posuere dictum.
                                    In eget metus eu leo rutrum venenatis vitae sit amet elit. Duis luctus enim enim.
                                </p>
                                <div class="bg bg-color-default"></div>
                            </div>
                            <!--/ .box-->
                        </div>
                        <!--/ .col-md-6-->
                        <div class="col-md-6 col-sm-6">
                            <div class="box equal-height">
                                <div class="calendar small text-color-white"></div>
                                <div class="bg bg-color-default-darker"></div>
                            </div>
                            <!--/ .box-->
                        </div>
                        <!--/ .col-md-6-->
                    </div>
                    <!--/ .row-->
                </div>
                <!--/ .col-md-8-->
            </div>
            <!--/ .row-->
        </div>
        <!--/ .container-->



        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h3>Contact</h3>
                        <address>
                            <strong>Jane Doe</strong><br>
                            1577 Daylene Drive<br>
                            Southfield, MI 48075
                            <hr>
                            <figure>
                                <div class="info">
                                    <i class="icon_phone"></i>
                                    <span>734-593-3512</span>
                                </div>
                                <div class="info">
                                    <i class="icon_mail"></i>
                                    <span><a href="mailto:hello@example.com?subject=Hello">hello@example.com</a></span>
                                </div>
                                <div class="info">
                                    <i class="icon_globe-2 "></i>
                                    <a href="#">www.example.com</a>
                                </div>
                                <div class="info">
                                    <i class="social_facebook"></i>
                                    <a href="#">jane.doe</a>
                                </div>
                                <div class="info">
                                    <i class="social_skype"></i>
                                    <a href="#">jane.doe.motivations</a>
                                </div>
                            </figure>
                        </address>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3>Contact Form</h3>
                        <form id="form-contact" class="clearfix">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control framed" id="contact-form-name" name="name" placeholder="Your Name" required>
                                    </div><!-- /.form-group -->
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control framed" id="contact-form-email" name="email" placeholder="Your E-mail" required>
                                    </div><!-- /.form-group -->
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control framed" id="contact-form-message" rows="3" name="message" placeholder="Your Message" required></textarea>
                            </div><!-- /.form-group -->
                            <div class="form-group">
                                <button type="submit" class="btn pull-right btn-primary" id="form-contact-submit">Contact Me</button>
                            </div><!-- /.form-group -->
                            <div class="pull-left"><div class="form-status"></div></div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/ .container-->
            <div class="bg"></div><!--/ .bg-->
        </div>
        <!--/ .block-->

        <div class="container"><hr></div>

        <div class="block">
            <div class="container">
                <h2>The Closest Workshops With Me</h2>
                <div class="workshop-list">
                    <h3>March</h3>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="workshop">
                                <div class="date-info">
                                    <div class="date">02.03.2015</div>
                                    <div class="place">University of London City</div>
                                    <div class="time"><i class="icon_clock"></i>11:00</div>
                                </div>
                                <h4><a href="#" data-toggle="modal" data-target="#modal-workshop">Life Success is Never Ending Battle</a></h4>
                                <p>
                                    Praesent cursus nulla non arcu tempor, ut egestas elit tempus. In ac ex fermentum, gravida
                                    felis nec, tincidunt ligula.
                                </p>
                            </div>
                            <!--/ .workshop-->
                        </div>
                        <!--/ .col-md-4-->
                        <div class="col-md-4 col-sm-4">
                            <div class="workshop">
                                <div class="date-info">
                                    <div class="date">06.03.2015</div>
                                    <div class="place">Town Hall Manchester City</div>
                                    <div class="time"><i class="icon_clock"></i>08:00</div>
                                </div>
                                <h4><a href="#" data-toggle="modal" data-target="#modal-workshop">Why You need a Personal Health Coach</a></h4>
                                <p>
                                    Praesent cursus nulla non arcu tempor, ut egestas elit tempus. In ac ex fermentum, gravida
                                    felis nec, tincidunt ligula.
                                </p>
                            </div>
                            <!--/ .workshop-->
                        </div>
                        <!--/ .col-md-4-->
                        <div class="col-md-4 col-sm-4">
                            <div class="workshop">
                                <div class="date-info">
                                    <div class="date">18.03.2015</div>
                                    <div class="place">Conference Building Downtown</div>
                                    <div class="time"><i class="icon_clock"></i>09:30</div>
                                </div>
                                <h4><a href="#" data-toggle="modal" data-target="#modal-workshop">Kick-up Your Career</a></h4>
                                <p>
                                    Praesent cursus nulla non arcu tempor, ut egestas elit tempus. In ac ex fermentum, gravida
                                    felis nec, tincidunt ligula.
                                </p>
                            </div>
                            <!--/ .workshop-->
                        </div>
                        <!--/ .col-md-4-->
                    </div>
                    <!--/ .row-->
                </div>
                <!--/ .workshop-list-->
                <a href="workshops.html" class="btn btn-default">All Workshops</a>
            </div>
            <!--/ .container-->
            <div class="bg"></div><!--/ .bg-->
        </div>
        <!--/ .block-->
        
<?php
	get_footer();
?>

<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Make an Appointment</h2>
                <h4>Select the Time</h4>
            </div>
            <div class="modal-body">
                <div class="times">
                    <form>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn time-radio">
                                <input type="radio" name="options" id="option1">08:00
                                <span>Available</span>
                            </label>
                            <label class="btn time-radio">
                                <input type="radio" name="options" id="option2">09:00
                                <span>Available</span>
                            </label>
                            <label class="btn time-radio">
                                <input type="radio" name="options" id="option3">10:00
                                <span>Available</span>
                            </label>
                            <label class="btn time-radio">
                                <input type="radio" name="options" id="option4">11:00
                                <span>Available</span>
                            </label>
                            <label class="btn time-radio not-available">
                                <input type="radio" name="options" id="option5">12:00
                                <span>Not available</span>
                            </label>
                            <label class="btn time-radio">
                                <input type="radio" name="options" id="option6">13:00
                                <span>Available</span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control framed" name="modal-first-name" placeholder="First Name" required>
                                </div><!-- /.form-group -->
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control framed" name="modal-last-name" placeholder="Last Name" required>
                                </div><!-- /.form-group -->
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <input type="email" class="form-control framed" name="modal-email" placeholder="E-mail" required>
                                </div><!-- /.form-group -->
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control framed" name="modal-number" placeholder="Number" pattern="\d*" required>
                                </div><!-- /.form-group -->
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn pull-right btn-primary" id="modal-submit">Contact Me</button>
                            </div><!-- /.form-group -->
                        </div>
                    </form>
                </div><!-- /.times -->
            </div><!-- /.modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade workshop-detail" id="modal-workshop">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Life Success is Never Ending Battle</h2>
                <h3 class="date">02.03.2015</h3>
                <h4 class="place">University of London City</h4>
                <figure class="time"><i class="icon_clock"></i>11:00</figure>
            </div>
            <div class="modal-body">
                <div class="image"><img src="assets/img/workshop-detail.jpg" alt=""></div>
                <h3>About This Workshop</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc volutpat pretium tincidunt. Interdum
                    et malesuada fames ac ante ipsum primis in faucibus. In imperdiet magna vitae rhoncus interdum. Donec
                    viverra accumsan elit ut porttitor. Nunc sed velit ut augue porta euismod vitae ut urna. Nullam commodo
                    ligula eu luctus euismod. Curabitur at sapien dolor. Integer vel laoreet mi. Etiam neque nisl, feugiat
                    vitae turpis ac, tempus rhoncus lacus. Suspendisse laoreet, leo nec suscipit facilisis, justo nulla
                    feugiat nunc, et suscipit arcu sapien nec lorem. Vestibulum consequat arcu non lorem auctor,
                    sit amet ornare velit scelerisque.
                </p>
                <div class="clearfix">
                    <a href="#" class="btn btn-default pull-right">Get the tickets</a>
                </div>
            </div><!-- /.modal-body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

