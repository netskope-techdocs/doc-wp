<?php
    function docy_acf_block_image_hotspots(){
        $img = get_field('docy_hotspots_img');
        $strtonum = new Numbers_Words();
        echo $strtonum
        ?>
        <div class="pointing_img_container pointing_img_two">
            <div class="divs">
                <div class="cls1" style="display: none;">1</div>
                <div class="cls2" style="display: none;">2</div>
                <div class="cls3" style="display: none;">3</div>
                <div class="cls4" style="display: none;">4</div>
            </div>
            <img class="img-fluid" src="<?php echo $img['url'] ?>" alt="<?php echo $img['alt'] ?>">
            <ul class="nav list">
                <li class="cls1">
                    <div class="img_pointing one" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <div class="dot"></div>
                    </div>
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -262px, 0px);">
                        <div class="text_part">
                            <div class="close_btn">
                                <img src="img/svg/close.svg" alt="">
                            </div>
                            <h4 id="welcome-to-docy-1-6">Welcome to Docy <span>1/6</span><a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="" href="#welcome-to-docy-1-6" style="font: 1em / 1 anchorjs-icons; padding-left: 0.375em;"></a></h4>
                            <p>
                                In order to input a question start by choosing atemplate by
                                clicking
                                on 'Choose Template' button. (Screen to gif 'choose your
                                template
                                button').Input numbers into spaces provided.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="prev">prev</div>

                            </div>
                            <div class="col-6">
                                <div class="bullets_pointing">
                                    <ul class="nav justify-content-center">
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="next">next</div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="cls2">
                    <div class="img_pointing two" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dot"></div>
                    </div>
                    <div class="dropdown-menu">
                        <div class="text_part">
                            <div class="close_btn">
                                <img src="img/svg/close.svg" alt="">
                            </div>
                            <h4 id="welcome-to-docy-2-6">Welcome to Docy <span>2/6</span><a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="" href="#welcome-to-docy-2-6" style="font: 1em / 1 anchorjs-icons; padding-left: 0.375em;"></a></h4>
                            <p>
                                In order to input a question start by choosing atemplate by
                                clicking
                                on 'Choose Template' button. (Screen to gif 'choose your
                                template
                                button').Input numbers into spaces provided.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="prev">prev</div>

                            </div>
                            <div class="col-6">
                                <div class="bullets_pointing">
                                    <ul class="nav justify-content-center">
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="next">next</div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="cls3">
                    <div class="img_pointing three" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dot"></div>
                    </div>
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -262px, 0px);">
                        <div class="text_part">
                            <div class="close_btn">
                                <img src="img/svg/close.svg" alt="">
                            </div>
                            <h4 id="welcome-to-docy-3-6">Welcome to Docy <span>3/6</span><a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="" href="#welcome-to-docy-3-6" style="font: 1em / 1 anchorjs-icons; padding-left: 0.375em;"></a></h4>
                            <p>
                                In order to input a question start by choosing atemplate by
                                clicking
                                on 'Choose Template' button. (Screen to gif 'choose your
                                template
                                button').Input numbers into spaces provided.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="prev">prev</div>

                            </div>
                            <div class="col-6">
                                <div class="bullets_pointing">
                                    <ul class="nav justify-content-center">
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="next">next</div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="cls4">
                    <div class="img_pointing four" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dot"></div>
                    </div>
                    <div class="dropdown-menu">
                        <div class="text_part">
                            <div class="close_btn">
                                <img src="img/svg/close.svg" alt="">
                            </div>
                            <h4 id="welcome-to-docy-4-6">Welcome to Docy <span>4/6</span><a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="" href="#welcome-to-docy-4-6" style="font: 1em / 1 anchorjs-icons; padding-left: 0.375em;"></a></h4>
                            <p>
                                In order to input a question start by choosing atemplate by
                                clicking
                                on 'Choose Template' button. (Screen to gif 'choose your
                                template
                                button').Input numbers into spaces provided.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="prev">prev</div>

                            </div>
                            <div class="col-6">
                                <div class="bullets_pointing">
                                    <ul class="nav justify-content-center">
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="next">next</div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
        <?php


    }