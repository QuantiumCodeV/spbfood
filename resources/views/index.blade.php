<!DOCTYPE html>
<html lang="ru-RU" prefix="og: http://ogp.me/ns#">

<head>

    <meta charset="UTF-8">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Absolute Balance - доставка здоровой еды | Санкт-Петербург">

    <meta property="og:title" content="Доставка правильного питания в Санкт-Петербурге от 966 ₽ в день" />
    <meta property="og:description" content="Готовая здоровая еда с доставкой в Санкт-Петербурге. Здоровое питание на каждый день. Доставка рационов питания. Меню для похудения, набора веса, спорта или диетического питания" />
    <meta property="og:url" content="http://kzn.perfectbalance.ru/">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:image" content="https://kzn.perfectbalance.ru/new_design/img/logo-preload1.jpg" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="400">
    <meta property="og:image:height" content="300">

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="http://kzn.perfectbalance.ru/" />
    <meta name="twitter:title" content="Доставка правильного питания в Санкт-Петербурге от 966 ₽ в день" />
    <meta name="twitter:description" content="Готовая здоровая еда с доставкой в Санкт-Петербурге. Здоровое питание на каждый день. Доставка рационов питания. Меню для похудения, набора веса, спорта или диетического питания" />
    <meta name="twitter:image:src" content="https://kzn.perfectbalance.ru/new_design/img/logo-preload1.jpg" />
    <meta name="twitter:image:width" content="800" />
    <meta name="twitter:image:height" content="400" />




    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="format-detection" content="address=no" />
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <meta name="csrf-param" content="_csrf-frontend">
    <meta name="csrf-token" content="v2MLUTkMlKYN2N1PEUsANmGyPW86zdIsiq3dGl_CoVuLOVQOeE_sznjhjBBeKVIbFOBONwz0_xTHzLV-LrPyEA==">
    <title>Доставка правильного питания в Санкт-Петербурге от 966 ₽ в день</title>
    <meta name="description" content="Готовая здоровая еда с доставкой в Санкт-Петербурге. Здоровое питание на каждый день. Доставка рационов питания. Меню для похудения, набора веса, спорта или диетического питания" />
    <link href="new_design/css/style%EF%B9%96v=17.03.1.css" rel="stylesheet">

</head>

<body class=" hide_page"
    data-ya_id="88478810">

    <div class="spinner">
        <div class="spinner__inner">
            <img src="new_design/img/logo-preload.jpg" alt="Absolute Balance">
            <div class="spinner__inner--line"></div>
        </div>
    </div>

    <!-- snow block -->
    <style>
        .snow {
            z-index: 40;
            height: 100%;
            background: transparent;
            pointer-events: none;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            display: none;
        }
    </style>
    <section class="snow"></section>
    <script>
        var particleCount = 50;
        var particleMax = 1000;
        var sky = document.querySelector('.snow');
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var width = sky.clientWidth;
        var height = sky.clientHeight;
        var i = 0;
        var active = false;
        var snowflakes = [];
        var snowflake;

        canvas.style.position = 'absolute';
        canvas.style.left = canvas.style.top = '0';

        var Snowflake = function() {
            this.x = 0;
            this.y = 0;
            this.vy = 0;
            this.vx = 0;
            this.r = 0;

            this.reset();
        };

        Snowflake.prototype.reset = function() {
            this.x = Math.random() * width;
            this.y = Math.random() * -height;
            this.vy = 1 + Math.random() * 3;
            this.vx = 0.5 - Math.random();
            this.r = 1 + Math.random() * 2;
            this.o = 0.5 + Math.random() * 0.5;
        };

        function generateSnowFlakes() {
            snowflakes = [];
            for (i = 0; i < particleMax; i++) {
                snowflake = new Snowflake();
                snowflake.reset();
                snowflakes.push(snowflake);
            }
        }

        generateSnowFlakes();

        function update() {
            ctx.clearRect(0, 0, width, height);

            if (!active) {
                return;
            }

            for (i = 0; i < particleCount; i++) {
                snowflake = snowflakes[i];
                snowflake.y += snowflake.vy;
                snowflake.x += snowflake.vx;

                ctx.globalAlpha = snowflake.o;
                ctx.beginPath();
                ctx.arc(snowflake.x, snowflake.y, snowflake.r, 0, Math.PI * 2, false);
                ctx.closePath();
                ctx.fill();

                if (snowflake.y > height) {
                    snowflake.reset();
                }
            }

            requestAnimFrame(update);
        }

        function onResize() {
            width = sky.clientWidth;
            height = sky.clientHeight;
            canvas.width = width;
            canvas.height = height;
            ctx.fillStyle = '#FFF';

            var wasActive = active;
            //active = width > 600;
            active = true;

            if (!wasActive && active) {
                requestAnimFrame(update);
            }
        }

        // shim layer with setTimeout fallback
        window.requestAnimFrame = (function() {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                function(callback) {
                    window.setTimeout(callback, 1000 / 60);
                };
        })();

        onResize();
        window.addEventListener('resize', onResize, false);

        sky.appendChild(canvas);

        /*var gui = new dat.GUI();
        gui.add(window, 'particleCount').min(1).max(particleMax).step(1).name('Particles count').onFinishChange(function() {
          requestAnimFrame(update);
        });*/
    </script>



    <div id="app" data-min="">
        <div id="top"></div>
        <header>
            <div class="container">
                <div class="header">
                    <div class="logo">
                        <a href="index.html"><img src="new_design/img/logo.svg" alt=""></a>
                        <span>Ежедневная доставка здорового питания</span>
                    </div>
                    <div class="h_right">
                        <a href="tel:+7 (843) 258-08-38" class="h_phone">+7 (843) 258-08-38 <span>Мы на связи вс-пт<br> с 8:00 до 22:00<br> сб с 12:00 до 20:00</span>

                        </a>
                        <a href="javascript:void(0)" data-popup="callback_popup" class="_btn v1 open_popup">Перезвоните мне</a>
                        <div class="soc_box"><a href="https://t.me/PBkazan" target="_blank" class="soc_item soc_tg"></a>
                            <a href="https://wa.me/79600480838" target="_blank" class="soc_item soc_wa"></a>
                            <a href="https://vk.com/perfectbalancekzn" class="soc_item soc_vk" target="_blank"></a>
                        </div>
                    </div>
                </div>
                <div class="nav_box">
                    <nav>
                        <ul>
                            <li><a href="#select">Меню</a></li>
                            <li><a href="#about_block">Что это</a></li>
                            <li><a href="#whom_block">Для кого</a></li>
                            <li><a href="#work_block">Как работает</a></li>
                            <li><a href="#reviews_block">Отзывы</a></li>
                        </ul>
                    </nav>

                </div>

                <div class="header_mobile">
                    <div class="logo">
                        <a href="index.html"><img src="new_design/img/logo.svg" alt=""></a>
                    </div>
                    <div class="header_mobile_right">
                        <a href="tel:+7 (843) 258-08-38" class="h_m_phone"></a>
                        <div class="mobile_toggle">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="nav_mobile_box">
                    <ul>
                        <li><a href="#select">Меню</a></li>
                        <li><a href="#about_block">Что это</a></li>
                        <li><a href="#whom_block">Для кого</a></li>
                        <li><a href="#work_block">Как работает</a></li>
                        <li><a href="#reviews_block">Отзывы</a></li>
                    </ul>
                    <p><a href="tel:+7 (843) 258-08-38">+7 (843) 258-08-38</a></p>
                    <div class="soc_box"><a href="https://t.me/PBkazan" target="_blank" class="soc_item soc_tg"></a>
                        <a href="https://wa.me/79600480838" target="_blank" class="soc_item soc_wa"></a>
                        <a href="https://vk.com/perfectbalancekzn" class="soc_item soc_vk" target="_blank"></a>
                    </div>
                </div>
            </div>
        </header>


        <div class="main_block" style="display: block;">
            <div class="main_slider">
                <div class="main_slide">
                    <div class="main_slide_box">
                        <div class="main_slide_text">
                            <h1>Здоровое питание<br> на каждый день для похудения, поддержания или набора веса с доставкой на дом <b>в&nbsp;Санкт-Петербурге</b> <!--noindex--><span>-15% на первый заказ</span><!--/noindex--> </h1>

                            <a href="#select" class="_btn lg v2">Выбрать программу</a>
                        </div>
                        <div class="main_slide_img">
                            <img src="https://perfectbalance.ru/admin/uploads/slides/slide_img_1.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="main_slide">
                    <div class="main_slide_box">
                        <div class="main_slide_text">
                            <div class="h3">Absolute Balance —<br> это не только здоровая,<br> но и вкусная еда <!--noindex--><span>-15% на первый заказ</span><!--/noindex--> </div>

                            <a href="#select" class="_btn lg v2">Выбрать программу</a>
                        </div>
                        <div class="main_slide_img">
                            <img src="https://perfectbalance.ru/admin/uploads/slides/slide_img_2.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="main_slide">
                    <div class="main_slide_box">
                        <div class="main_slide_text">
                            <div class="h3">Закажите готовую здоровую еду и забудьте о постоянной готовке и расчете КБЖУ <!--noindex--><span>-15% на первый заказ</span><!--/noindex--> </div>

                            <a href="#select" class="_btn lg v2">Выбрать программу</a>
                        </div>
                        <div class="main_slide_img">
                            <img src="https://perfectbalance.ru/admin/uploads/slides/slide_img_3.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div class="stock_block">
            <div class="container">
                <div class="stock">
                    <div class="stock_left">
                        <img data-src="https://perfectbalance.ru/admin/uploads/slides/k2LKjsluijnVnKL44VubloX3rWuaLfZ0.png" class="lazyload" src="" alt="">
                    </div>
                    <div class="stock_right">
                        <div class="h2">Закажи со скидкой 15% <i>один пробный дневной</i> <span> рацион из любого меню</span></div>
                        <div class="stock_form">
                            <p>Заполните форму, чтобы получить скидку</p>
                            <form action="amo/call" class="form_inline black sale_form">
                                <div class="input_wrapper">
                                    <input type="text" placeholder="Как вас зовут?" class="req" name="name">
                                    <p class="error_text">Заполните поле</p>
                                </div>
                                <div class="input_wrapper">
                                    <input type="text" autocomplete="off" placeholder="+7 (" class="req" name="phone">
                                    <p class="error_text">Заполните поле</p>
                                </div>
                                <button class="btn black" type="submit"
                                    onclick="return: true;">
                                    Заказать со скидкой 15%</button>
                                <input type="hidden" value="Получить скидку" name="form_name">
                                <input type="hidden" name="utm_source" value="">
                                <input type="hidden" name="utm_medium" value="">
                                <input type="hidden" name="utm_campaign" value="">
                                <input type="hidden" name="utm_term" value="">
                                <input type="hidden" name="utm_content" value="">
                                <input type="hidden" name="ip" value="176.59.211.111">
                                <input type="hidden" name="recaptcha_response" class="recaptchaResponse">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="loader_block">
                <div class="loader_block_after">
                    <div class="lds-spinner">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>



        <div class="select_program_block" id="select" data-city-id="47">
            <div class="container">
                <div class="select_program">

                    <h3>Правильное питание в Санкт-Петербурге </h3>
                    <div class="h2"><span>выберите программу</span></div>
                    <div class="select_program_box">
                        <div class="select_program_left">
                            <p><b>Шаг 1.</b> Выберите рацион</p>
                            <div class="ration_box">
                                <div class="ration_item">
                                    <div class="h5">Похудеть</div>
                                    <p>Slim Balance<span>950–2025 ккал</span></p>
                                    <div class="ration_img">
                                    </div>
                                    <div class="check_icon"></div>
                                </div>
                            </div>

                            <p><b>Шаг 2.</b> Выберите дневную калорийность. Свою норму калорий можно
                                рассчитать с&nbsp;помощью <a href="#calculator_block" class="scroll_to">калькулятора</a></p>
                            <div class="daily_kk check_items">
                                <p>950</p>
                                <p>1150</p>
                                <p class="checked">1350</p>
                                <p>1525</p>
                                <p>2025</p>
                            </div>

                            <p><b>Шаг 3.</b> Выберите число дней доставки</p>
                            <div class="days_count check_items">
                                <p class="checked">1</p>
                            </div>
                        </div>
                        <div class="select_program_right">
                            <div class="my_program">
                                <span>ваша программа</span>
                                <div class="h5 ration_name">Похудеть</div>
                                <p class="ration_info"><i>Slim Balance</i> / <b>1525</b> ккал<span>15 дней</span></p>
                                <div class="h5 price"><strike>16 500 ₽</strike><b>14 320</b><i>- 1 300 ₽</i></div>
                                <p>650.91 ₽ в день</p>

                                <a href="javascript:void(0)"
                                    class="btn w_icon basket get_new_order_btn">
                                    Оформить заказ
                                </a>


                                <a href="javascript:void(0)" class="reset_btn">сбросить параметры</a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu_block" id="menu_block">
            <div class="container">
                <div class="menu">


                    <h4>Доставка правильного питания</h4>
                    <div class="menu_title">
                        <div class="menu_title_inner">
                            <span class="open_popup " data-popup="chose_program_popup">Slim Balance / 1525 ккал</span>
                        </div>
                        <a href="#select" class="scroll_to btn w_icon menu">Заказать это меню</a>
                    </div>



                    <div class="days_slider_box">
                        <div class="days_sly">
                            <div class="days_slider">
                                <div class="day_slide active">25.02 / Пн</div>
                            </div>
                        </div>
                        <div class="days_arrows">
                            <div class="prev"></div>
                            <div class="next"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dishes_slider_box">
                <div class="dishes_sly">
                    <div class="dishes_slider ">
                        <div class="dish_slide">
                            <div class="dish_slide_img">
                            </div>
                            <span>завтрак</span>
                            <p><b>Пшенная каша на молоке с запеченой тыквой5</b></p>
                            <div class="dish_info">
                                <p><span>200</span>кКал</p>
                                <p><span>6 г</span>белков</p>
                                <p><span>3 г</span>жиров</p>
                                <p><span>30 г</span>углеводов</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="scrollbar">
                    <div class="handle"></div>
                </div>
                <p class="attention">*Внешний вид блюд может отличаться от изображения на сайте</p>
            </div>
        </div>


        <div class="calories_calc_block" id="calculator_block">
            <div class="container">
                <div class="calories_calc">
                    <div class="calories_calc_left">
                        <div class="h3">Узнайте свою дневную норму калорий</div>
                        <p>Настройте калькулятор с учетом ваших особенностей и целей</p>
                        <div class="calories_calc_box">
                            <div class="calories_calc_item">
                                <!--SEX-->
                                <div class="sex_toggle_box">
                                    <div class="sex_item">
                                        <p>Мужчина</p>
                                        <div class="sex_item_icon"><img src="new_design/img/man_icon.svg" alt=""></div>
                                    </div>
                                    <div class="sex_toggle"></div>
                                    <div class="sex_item">
                                        <p>Женщина</p>
                                        <div class="sex_item_icon"><img src="new_design/img/woman_icon.svg" alt=""></div>
                                    </div>
                                </div>
                            </div>
                            <div class="calories_calc_item">
                                <!--AGE-->
                                <p>Возраст</p>
                                <div class="my_age my_slider" data-min="16" data-max="70" data-current="35">
                                    <div class="handle ui-slider-handle"></div>
                                </div>
                            </div>
                            <div class="calories_calc_item">
                                <!--My actiivity-->
                                <p>Уровень активности <a href="javascript:void(0)"
                                        data-popup="activity_popup"
                                        class="open_popup">?</a></p>
                                <div class="activity">
                                    <span>Средний</span>
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="Предельный"></label>
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="Высокий"></label>
                                    <input type="radio" checked="checked" id="star3" name="rating" value="3" />
                                    <label for="star3" title="Средний"></label>
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="Низкий"></label>
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="Минимальный"></label>
                                </div>
                            </div>
                            <div class="calories_calc_item">
                                <!--WEIGHT-->
                                <p>Вес</p>
                                <div class="my_weight my_slider" data-min="40" data-max="150" data-current="70">
                                    <div class="handle ui-slider-handle"></div>
                                </div>
                            </div>
                            <div class="calories_calc_item">
                                <!--Target-->
                                <p>Цель</p>
                                <div class="my_target select_box">
                                    <p>Любая</p>
                                    <ul>
                                        <li class="active"><i></i><span>Любая</span></li>
                                        <li><i></i><span>Похудеть</span></li>
                                        <li><i></i><span>Поддержать вес</span></li>
                                        <li><i></i><span>Набрать вес</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="calories_calc_item">
                                <!--HEIGHT-->
                                <p>Рост</p>
                                <div class="my_height my_slider" data-min="150" data-max="200" data-current="180">
                                    <div class="handle ui-slider-handle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="calories_calc_right">
                        <span>ваша норма</span>
                        <div class="h4">2500 кКал</div>
                        <span>вам подходит программа</span>
                        <div class="calc_program_list">
                            <div class="program_item_head">
                                <p>Сохранить вес</p>
                                <span>Daily Balance<br>2475 кКал</span>
                                <img src="https://kzn.perfectbalance.ru/img/program_item_img_1.png" alt="">
                            </div>
                            <div class="program_item_head">
                                <p>Сохранить вес</p>
                                <span>Daily Balance<br>2475 кКал</span>
                                <img src="https://kzn.perfectbalance.ru/img/program_item_img_1.png" alt="">
                            </div>
                        </div>
                        <a href="#select" class="btn">Выберите программу питания</a>
                        <a href="javascript:void(0)" class="reset_calc_btn">сбросить параметры</a>
                        <p><a href="javascript:void(0)" data-popup="help_me_popup" class="open_popup">Остались вопросы?</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="detox_block" id="detox">
            <div class="container"></div>
        </div>

        <div class="why_we_block" id="about_block">
            <div class="container">
                <div class="why_we">
                    <img src="new_design/img/logo_white.svg" alt="">
                    <h2>Absolute Balance — это готовые рационы
                        сбалансированной полезной еды с доставкой на дом </h2>

                    <div class="why_we_box">
                        <div class="why_we_item wow fadeInUp" data-wow-duration="2s" data-wow-delay="0s">
                            <div class="why_we_text">
                                <div class="h3">Делаем с душой</div>
                                <p>Мы готовим полезное питание, поэтому используем только свежие натуральные продукты
                                    и&nbsp;тщательно отбираем поставщиков</p>
                            </div>
                        </div>
                        <div class="why_we_item wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.2s">
                            <img data-src="https://perfectbalance.ru/admin/uploads/crews/why_we_1-min.png" class="lazyload" src="" alt="">
                        </div>



                        <div class="why_we_item wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.4s">
                            <div class="why_we_text">
                                <div class="h3">150+ блюд</div>
                                <p>У нас в меню около 150 блюд и каждый месяц появляются новые.<br>
                                    Наши рационы подходят всем, кто питается с умом и&nbsp;не хочет тратить время на готовку</p>
                            </div>
                        </div>
                        <div class="why_we_item wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.6s">
                            <img data-src="https://perfectbalance.ru/admin/uploads/crews/why_we_2-min.png" class="lazyload" src="" alt="">
                        </div>



                        <div class="why_we_item wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.8s">
                            <div class="why_we_text">
                                <div class="h3">Идеальное КЖБУ</div>
                                <p>Наше меню разрабатывается диетологом и&nbsp;нутрициологом, чтобы у&nbsp;каждого
                                    блюда были идеально подобраны калорийность, содержание белков, жиров и&nbsp;углеводов</p>
                            </div>
                        </div>
                        <div class="why_we_item wow fadeInUp" data-wow-duration="2s" data-wow-delay="1s">
                            <img data-src="https://perfectbalance.ru/admin/uploads/crews/why_we_3-min.png" class="lazyload" src="" alt="">
                        </div>






                    </div>
                </div>
            </div>
        </div>
        <div class="help_block" id="whom_block">
            <div class="container">
                <div class="help">

                    <h5>
                        Правильное питание на каждый день </h5>
                    <div class="h2"><span>Помогаем тем, кто хочет питаться сбалансированно </span>
                        <span>и кому некогда ходить за продуктами и готовить</span>
                    </div>


                    <div class="help_box">
                        <div class="help_item wow fadeInLeft" data-wow-delay="0s" data-wow-duration="1s">
                            <div class="help_icon">
                                <img data-src="https://perfectbalance.ru/admin/uploads/crews/rIxDgRSUc-wnlpU1lojsidea19WaMnxN.svg" class="lazyload" src="" alt="">
                            </div>
                            <div class="h3">Спортсменам</div>
                            <p>Успех от тренировок зависит от питания: невозможно похудеть, питаясь как раньше. Поможем снизить или сохранить вес, нарастить мышечную массу.</p>
                        </div>

                        <div class="help_item wow fadeInLeft" data-wow-delay="0.5s" data-wow-duration="1s">
                            <div class="help_icon">
                                <img data-src="https://perfectbalance.ru/admin/uploads/crews/YchbQhYRMfuuhPjj8VhP3nA2y5afHUbu.svg" class="lazyload" src="" alt="">
                            </div>
                            <div class="h3">Приверженцам ЗОЖ</div>
                            <p>В магазинах большинство пищевых продуктов ненатуральные. Мы знаем, как тяжело найти здоровые продукты, и потому решили эту задачу за вас.</p>
                        </div>

                        <div class="help_item wow fadeInLeft" data-wow-delay="1s" data-wow-duration="1s">
                            <div class="help_icon">
                                <img data-src="https://perfectbalance.ru/admin/uploads/crews/MNTgleQ_VIuDz9fypzBXk8UjRBdolakN.svg" class="lazyload" src="" alt="">
                            </div>
                            <div class="h3">Офисным работникам</div>
                            <p>В рабочее время редко удается как следует поесть. А чем хуже питание, тем менее эффективно вы работаете. Доставка здоровой еды решит проблему.</p>
                        </div>

                        <div class="help_item wow fadeInLeft" data-wow-delay="1.5s" data-wow-duration="1s">
                            <div class="help_icon">
                                <img data-src="https://perfectbalance.ru/admin/uploads/crews/CdHsLJtFe5xx0kKUGF7OH6Pooi8Eyo2n.svg" class="lazyload" src="" alt="">
                            </div>
                            <div class="h3">Молодым мамам</div>
                            <p>Когда дети маленькие, у родителей мало времени на себя; когда большие — сложно уследить за тем, что они едят. Питайтесь правильно всей семьёй и тратьте время на то, что важно.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="start_block">
            <div class="container">
                <div class="start">
                    <div class="h2">Как начать питаться правильно с Absolute Balance</div>
                    <div class="start_box">
                        <div class="start_item">
                            <div class="start_step"></div>
                            <div class="h3">Выбираете рацион и&nbsp;период доставки</div>
                            <p>В нашем меню реализуются <br>7 программ питания под разные цели и DETOX. Выберите программу или позвольте сделать это нам.</p>
                        </div>
                        <div class="start_item">
                            <div class="start_step"></div>
                            <div class="h3">Оплачиваете заказ <br>на сайте</div>
                            <p>Курьер принимает оплату наличными и через банковский терминал. Организации могут оплатить безналом.</p>
                        </div>
                        <div class="start_item">
                            <div class="start_step"></div>
                            <div class="h3">Получаете рационы домой или в&nbsp;офис</div>
                            <p>Доставляем рационы на 1–2 дня (зависит от города) в вечернее время. Заранее спросим адрес <br>и время доставки.</p>
                        </div>
                        <div class="start_item">
                            <div class="start_step"></div>
                            <div class="h3">Питаетесь правильно и&nbsp;достигаете целей</div>
                            <p>А заодно наберетесь сил для новых достижений, укрепите здоровье и&nbsp;будете чувствовать себя на&nbsp;все сто.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="about_menu_block" id="work_block">
            <div class="container">
                <div class="about_menu">
                    <div class="h2">В каждом пакете — всё что нужно для полноценного приёма пищи</div>
                    <div class="about_menu_box_sly">
                        <div class="about_menu_box">
                            <div class="about_menu_item">
                                <div class="about_menu_item_icon">
                                    <img data-src="https://perfectbalance.ru/admin/uploads/crews/nYalpXsXXfh644RQxn30rMzVjSARxODp.png" class="lazyload" src="" alt="">
                                </div>
                                <div class="h6">Меню</div>
                                <p>с описанием, расчетами КБЖУ и советами по приему и хранению пищи</p>
                            </div>
                            <div class="about_menu_item">
                                <div class="about_menu_item_icon">
                                    <img data-src="https://perfectbalance.ru/admin/uploads/crews/XQYkt2zi19Y1qjrZ56MtkKYHjXGctPsh.jpg" class="lazyload" src="" alt="">
                                </div>
                                <div class="h6">Контейнеры с едой</div>
                                <p>от 3 до 6 контейнеров с едой на один-два дня. На каждом контейнере — номер приёма пищи</p>
                            </div>
                            <div class="about_menu_item">
                                <div class="about_menu_item_icon">
                                    <img data-src="https://perfectbalance.ru/admin/uploads/crews/9o08KyIGsTB72lWOrZ72RwPmV7YpMuVb.png" class="lazyload" src="" alt="">
                                </div>
                                <div class="h6">Столовые приборы</div>
                                <p>Одноразовые столовые приборы</p>
                            </div>
                            <div class="about_menu_item">
                                <div class="about_menu_item_icon">
                                    <img data-src="https://perfectbalance.ru/admin/uploads/crews/jX21sZguNNreV6nq7x-XmztdMaFetCzq.png" class="lazyload" src="" alt="">
                                </div>
                                <div class="h6">Удобный пакет</div>
                                <p>для переноски еды в течение дня</p>
                            </div>
                            <div class="about_menu_item">
                                <div class="about_menu_item_icon">
                                    <img data-src="https://perfectbalance.ru/admin/uploads/crews/_OTjjjoVZmzFt3GM3eEVYiQQ5qspJY00.png" class="lazyload" src="" alt="">
                                </div>
                                <div class="h6"></div>
                                <p>Свободное от готовки время и хорошее настроение <b>;-)</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clients_reviews_block" id="reviews_block">
            <div class="container">
                <div class="client_reviews">
                    <div class="h2">Отзывы клиентов</div>
                    <p>Ещё больше отзывов по хештегу <a target="_blank" href="https://www.instagram.com/explore/tags/perfectbalance/">#AbsoluteBalance</a> в <img src="new_design/img/instagram_logo.png" alt=""></p>

                    <div class="client_reviews_box">
                        <div class="client_review">
                            <a href="https://perfectbalance.ru/admin/uploads/reviews/Yap1VGuol52ZEkHIQB6DN8UcnKnTav6-.png"><img data-src="https://perfectbalance.ru/admin/uploads/reviews/Yap1VGuol52ZEkHIQB6DN8UcnKnTav6-.png" class="lazyload" src="" alt=""></a>
                        </div>

                        <div class="client_review">
                            <a href="https://perfectbalance.ru/admin/uploads/reviews/gPNyi5VufCT8XtzEbak1Bbe1t4QIi3Bm.png"><img data-src="https://perfectbalance.ru/admin/uploads/reviews/gPNyi5VufCT8XtzEbak1Bbe1t4QIi3Bm.png" class="lazyload" src="" alt=""></a>
                        </div>

                        <div class="client_review">
                            <a href="https://perfectbalance.ru/admin/uploads/reviews/7jnlsfsyPi0--lYr3OYbUm-oWyH6sQlr.png"><img data-src="https://perfectbalance.ru/admin/uploads/reviews/7jnlsfsyPi0--lYr3OYbUm-oWyH6sQlr.png" class="lazyload" src="" alt=""></a>
                        </div>

                        <div class="client_review">
                            <a href="https://perfectbalance.ru/admin/uploads/reviews/9aeLiA9TvuiiMxjR_u2xSjTaqcPz8bX0.jpg"><img data-src="https://perfectbalance.ru/admin/uploads/reviews/9aeLiA9TvuiiMxjR_u2xSjTaqcPz8bX0.jpg" class="lazyload" src="" alt=""></a>
                        </div>


                    </div>


                </div>
            </div>
        </div>
        <div class="payment_delivery_block" id="delivery">
            <div class="container">
                <div class="seo_text"></div>

                <div class="payment_delivery">
                    <div class="h2">Оплата и доставка</div>
                    <div class="payment">
                        <div class="h6">Способы оплаты</div>
                        <p>Питание оплачивается как абонемент. </p>
                        <div class="payment_box">
                            <div class="payment_item">
                                <div class="payment_icon">
                                    <img data-src="new_design/img/payment_icon_1.svg" class="lazyload" src="" alt="">
                                </div>
                                <div class="h5">
                                    Безналичный расчёт <img data-src="new_design/img/pay_icons.svg" class="lazyload" src="" alt="">
                                </div>
                            </div>
                            <div class="payment_item">
                                <div class="payment_icon">
                                    <img data-src="new_design/img/payment_icon_2.svg" class="lazyload" src="" alt="">
                                </div>
                                <div class="h5">
                                    Наличными курьеру<br>
                                    при получении</div>
                            </div>
                            <div class="payment_item" style="display: none;">
                                <div class="payment_icon">
                                    <img data-src="new_design/img/payment_icon_3.svg" class="lazyload" src="" alt="">
                                </div>
                                <div class="h5">На расчетный счет<br>
                                    (для организаций)</div>
                            </div>
                        </div>
                    </div>
                    <div class="delivery">
                        <div class="h6">Условия доставки</div>
                        <div class="delivery_box">
                            <div class="delivery_item">
                                <p><b>Стоимость</b></p>
                                <p>В пределах города доставка бесплатная.
                                    Доставка в пригород или за город оплачивается отдельно. </p>
                            </div>
                            <div class="delivery_item">
                                <p><b>Дни</b></p>
                                <p>Возможна доставка в день заказа, если сделаете заказ до 12:00. Начать можно в любой день.
                                    Доставка осуществляется ежедневно с воскресенья по пятницу, в субботу у нас выходной, по этому в пятницу доставляем сразу 2 рациона на субботу и воскресенье, в остальные дни каждый вечер доставляем рацион на завтра. </p>
                            </div>
                            <div class="delivery_item">
                                <p><b>Время</b></p>
                                <p>Время приема заказов на сегодняшний день с 8:00 до 12:00
                                    Время приема заказов на завтрашний или любой другой день с 12:00 до 22:00
                                    Время доставки с 19:00 - 24:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <footer>
            <div class="footer_top_block">
                <div class="container">
                    <div class="footer_top">
                        <div class="f_logo">
                            <a href=""><img src="new_design/img/logo.svg" alt=""></a>
                            <span>Ежедневная доставка здорового питания</span>
                        </div>
                        <a href="#top" class="f_up">наверх</a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="footer">
                    <div class="f_left">
                        <a href="tel:+7 (843) 258-08-38" class="f_phone">+7 (843) 258-08-38</a>
                        <p>с 8:00 до 22:00 с вск по пт, с 12:00 до 20:00 в сб</p>
                        <div class="soc_box"><a href="https://t.me/PBkazan" target="_blank" class="soc_item soc_tg"></a>
                            <a href="https://wa.me/79600480838" target="_blank" class="soc_item soc_wa"></a>
                            <a href="https://vk.com/perfectbalancekzn" class="soc_item soc_vk" target="_blank"></a>
                        </div>

                        <div class="pay_box">
                            <p>Принимаем к оплате</p>
                            <img src="new_design/img/pay_icons.svg" alt="">

                        </div>
                    </div>
                    <div class="f_nav_list">
                        <div class="f_nav">
                            <div class="h6">Программы</div>
                            <ul class="foot_menu_nav">
                                <li><a href="#select">Сбросить вес</a></li>
                                <li><a href="#select">Сохранить вес</a></li>
                                <li><a href="#select">Набрать вес</a></li>
                                <li><a href="#select">Detox</a></li>
                            </ul>
                        </div>
                        <div class="f_nav" style="display: none;">
                            <div class="h6">Клиентам</div>
                            <ul>
                                <li><a href="#reviews_block">Отзывы</a></li>
                                <li><a href="#delivery">Доставка и оплата</a></li>
                                <li><a href="">Вопрос-ответ</a></li>
                                <li><a href="">Акции</a></li>
                                <li><a href="">Программа лояльности</a></li>
                            </ul>
                        </div>
                        <div class="f_nav">
                            <div class="h6">Компания</div>
                            <ul>
                                <li><a href="#about_block">О компании</a></li>
                                <li><a href="#whom_block">Для чего</a></li>
                                <li><a href="#work_block">Как работает</a></li>
                                <li><a href="#reviews_block">Отзывы клиентов</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright_block">
                <div class="container">
                    <div class="copyright">
                        <p>© 2018-2025, AbsoluteBalance, все права защищены</p>
                        <!--                <div class="copyright_links">-->
                        <!--                    <a href="/site/privacy">Политика конфиденциальности</a>-->
                        <!--                    <a href="/site/oferta">Оферта</a>-->
                        <!--                </div>-->
                        <div class="copyright_links">
                            <a href="/balance_privacy.pdf" target="_blank" rel="nofollow">Политика конфиденциальности</a>
                            <a href="/balance_oferta.pdf" target="_blank" rel="nofollow">Оферта</a>
                        </div>
                        <p>Сделано в <a href="https://webking.pro" target="_blank">WebKing</a></p>
                    </div>
                </div>
            </div>
        </footer>


        <div class="black_layout"></div>


        <div class="popup_wrapper" id="callback_popup">
            <div class="popup_inner">
                <div class="popup callback_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <div class="h5">Позвоним в течение часа</div>

                    <form action="amo/call.html">
                        <input type="hidden" name="recaptcha_response" class="recaptchaResponse">
                        <div class="input_wrapper gray">
                            <input type="text" placeholder="Ваше имя" class="req" name="name">
                            <p class="error_text">Заполните поле</p>
                        </div>
                        <div class="input_wrapper gray">
                            <input type="tel" placeholder="Номер телефона" autocomplete="off" class="req" name="phone">
                            <p class="error_text">Заполните поле</p>
                        </div>
                        <!--<div class="checkbox_wrapper">
                    <label>
                        <input type="checkbox" name="tg_check">
                        <span>Напишите в Telegram</span>
                    </label>
                </div>-->

                        <button class="btn w_icon phone">Заказать звонок</button>

                        <div class="modals_messenger_box">
                            <p>или напишите нам в мессенджеры</p>
                            <div class="soc_box"><a href="https://t.me/PBkazan" target="_blank" class="soc_item soc_tg"></a>
                                <a href="https://wa.me/79600480838" target="_blank" class="soc_item soc_wa"></a>
                                <a href="https://vk.com/perfectbalancekzn" class="soc_item soc_vk" target="_blank"></a>
                            </div>
                        </div>

                        <p>Нажимая на кнопку, вы соглашаетесь с <a href="site/privacy.html" target="_blank">Политикой конфиденциальности</a></p>
                        <input type="hidden" name="utm_source" value="">
                        <input type="hidden" name="utm_medium" value="">
                        <input type="hidden" name="utm_campaign" value="">
                        <input type="hidden" name="utm_term" value="">
                        <input type="hidden" name="utm_content" value="">
                        <input type="hidden" name="ip" value="176.59.211.111">
                    </form>


                    <div class="loader_block">
                        <div class="loader_block_after">
                            <div class="lds-spinner">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="popup_wrapper" id="help_me_popup">
            <div class="popup_inner">
                <div class="popup help_me_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <div class="h5">Без проблем.</div>
                    <p>Специалист по питанию<br>
                        свяжется с вами в течение часа</p>

                    <form action="amo/call.html"
                        class="help_form">
                        <input type="hidden" name="recaptcha_response" class="recaptchaResponse">
                        <div class="input_wrapper gray">
                            <input type="text" placeholder="Ваше имя" class="req" name="name">
                            <p class="error_text">Заполните поле</p>
                        </div>
                        <div class="input_wrapper gray">
                            <input type="tel" placeholder="Номер телефона" autocomplete="off" class="req" name="phone">
                            <p class="error_text">Заполните поле</p>
                        </div>
                        <!--<div class="checkbox_wrapper">
                    <label>
                        <input type="checkbox" name="tg_check">
                        <span>Напишите в Telegram</span>
                    </label>
                </div>-->

                        <button class="btn w_icon phone">Заказать звонок</button>

                        <div class="modals_messenger_box">
                            <p>или напишите нам в мессенджеры</p>
                            <div class="soc_box"><a href="https://t.me/PBkazan" target="_blank" class="soc_item soc_tg"></a>
                                <a href="https://wa.me/79600480838" target="_blank" class="soc_item soc_wa"></a>
                                <a href="https://vk.com/perfectbalancekzn" class="soc_item soc_vk" target="_blank"></a>
                            </div>
                        </div>

                        <p>Нажимая на кнопку, вы соглашаетесь с <a href="site/privacy.html" target="_blank">Политикой конфиденциальности</a></p>
                        <input type="hidden" name="utm_source" value="">
                        <input type="hidden" name="utm_medium" value="">
                        <input type="hidden" name="utm_campaign" value="">
                        <input type="hidden" name="utm_term" value="">
                        <input type="hidden" name="utm_content" value="">
                        <input type="hidden" name="ip" value="176.59.211.111">
                        <input type="hidden" name="form_name" value="Помощь с выбором программы питания">
                    </form>


                    <div class="loader_block">
                        <div class="loader_block_after">
                            <div class="lds-spinner">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popup_wrapper" id="thanks_popup">
            <div class="popup_inner">
                <div class="popup thanks_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <img src="new_design/img/logo_white.svg" alt="">
                    <div class="h5">Спасибо, что выбрали нас!</div>
                    <p>Перезвоним в ближайшее время.</p>
                </div>
            </div>
        </div>

        <div class="popup_wrapper" id="pay_popup">
            <div class="popup_inner">
                <div class="popup pay_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <div class="h6">Спасибо, что выбрали нас!</div>
                    <p>К оплате принимаются банковские карты Visa, Visa Electron, Mastercard, Maestro, МИР.
                        После подтверждения заказа вы будете пере-направлены на защищенную платежную
                        страницу компании FONDY. (Никаких комиссий или дополнительных платежей при онлайн-оплате
                        не взимается.)</p>
                    <img src="new_design/img/pay_img.png" alt="">

                    <p>Обработка платежа (включая ввод номера карты) происходит на защищенной странице
                        процессинговой компании, прошедшей международную сертификацию, соответствующей
                        всем требованиям безопасности международных платёжных системам Visa и
                        MasterCard в области проведения онлайн-платежей. Ваши конфиденциальные
                        данные (реквизиты карты, регистрационные данные и др.) не поступают в
                        интер-нет-магазин, их обработка полностью защищена и никто, в том числе
                        наш интернет-магазин, не может получить ваши банковские данные.</p>


                    <p> <b>Безопасность платежей</b>
                        При работе с карточными данными применяется стандарт защиты информации, разработанный международными платёжными системами Visa и MasterCard - Payment Card Industry Data Security Standard (PCI DSS), что обеспечивает безопасную обработку реквизитов банковской карты Держателя. Применяемая технология передачи данных гарантирует безопасность по сделкам с банковскими картами путем ис-пользования протоколов Secure Sockets Layer (SSL), Verified by Visa, MasterCard Secure Code, имеющих высшую степень защиты.</p>

                    <p> <b>Отмена платежа</b>
                        Для полного или частичного возврата денежных средств на карту Вам необходимо
                        обратиться по контактам указанным на сайте торговой точки. Денежные средства
                        вернутся на вашу карту в течение 2-3х дней. Точный срок возврата денежных средств
                        зависит от давности размещения заказа и от банка, выпустившего карту (максимальный
                        срок возврата не может превышать 30 дней).</p>
                </div>
            </div>
        </div>

        <div class="popup_wrapper" id="activity_popup">
            <div class="popup_inner">
                <div class="popup activity_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <div class="h5">Как узнать уровень своей активности</div>
                    <table class="activity_table">
                        <thead>
                            <tr>
                                <th>активность</th>
                                <th>работа</th>
                                <th>тренировки</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="activity_type t1">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                    </div>
                                    <p>Минимальная</p>
                                </td>
                                <td>
                                    <p>Сидячая, в офисе или за рулём. Ходите мало и/или недалеко.</p>
                                </td>
                                <td>
                                    <p>Физической нагрузки нет.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="activity_type t2">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                    </div>
                                    <p>Низкая</p>
                                </td>
                                <td>
                                    <p>Небольшой физический труд или долгие пешие прогулки: например, сборка мебели, работа курьером.</p>
                                </td>
                                <td>
                                    <p>Интенсивные, от 20 минут 1–3 раза в неделю: плавание, катание на коньках или велосипеде, бег трусцой.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="activity_type t3">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                    </div>
                                    <p>Средняя</p>
                                </td>
                                <td>
                                    <p>Физическая: занимаетесь погрузкой-разгрузкой, нетяжелой работой на стройке.</p>
                                </td>
                                <td>
                                    <p>Интенсивные, 30 минут до 3–4 раза в неделю. </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="activity_type t4">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                    </div>
                                    <p>Высокая</p>
                                </td>
                                <td>
                                    <p>Тяжёлая и длительная: часто таскаете тяжёлые предметы, строите, работаете с землей или по хозяйству.</p>
                                </td>
                                <td>
                                    <p>Интенсивные силовые упражнения 60–80 минут 4 и более раз в неделю: тяжелая атлетика, борьба.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="activity_type t5">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                        <img src="new_design/img/activity_icon.svg" alt="">
                                    </div>
                                    <p>Предельная</p>
                                </td>
                                <td>
                                    <p>Тяжёлая и длительная: часто погружаете-разгружаете тяжёлые предметы, строите, работаете с землей или по хозяйству.</p>
                                </td>
                                <td>
                                    <p>Интенсивные силовые упражнения от 60 минут 5–7 раз в неделю: тяжелая атлетика, борьба.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="popup_wrapper" id="chose_program_popup">
            <div class="popup_inner">
                <div class="popup chose_program_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <div class="h5">Выберите программу и объем калорий</div>

                    <div class="chose_program_box">
                        <div class="chose_program_list">
                            <p class="active"><i></i><span>Slim Balance</span></p>
                            <p><i></i><span>Detox Menu</span></p>
                            <p><i></i><span>Daily Balance</span></p>
                            <p><i></i><span>Vegetarian Balance</span></p>
                            <p><i></i><span>Athletic Balance</span></p>
                            <p><i></i><span>Vegan Balance</span></p>
                        </div>
                        <div class="chose_calories">
                            <p>950</p>
                            <p class="active">1150</p>
                            <p>1350</p>
                            <p>1525</p>
                            <p>2025</p>
                        </div>

                        <a href="javascript:void(0)" class="go_order_r btn w_icon menu">Посмотреть меню</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="popup_wrapper" id="order_popup">
            <div class="popup_inner">
                <div class="popup order_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <div class="order_popup_box">
                        <div class="order_left">
                            <div class="h5">Проверьте,
                                всё ли правильно</div>
                            <div class="order_program">
                                <span>ваша программа</span>
                                <p class="order_info_text"><b>Похудеть</b>
                                    <span>Slim Balance / 1525 ккал</span>
                                    <i>15 дней</i>
                                </p>
                                <form action="amo/check_promocode.json" class="promocode">
                                    <input type="text" placeholder="Есть промо-код?" name="promocode">
                                    <input type="submit" value="Проверить">

                                    <p id="promocode_error"></p>
                                </form>
                                <span>сумма заказа</span>
                                <p class="order_info_price"><strike></strike><b>14 320 ₽</b>
                                    <span>650.91 ₽ в день</span>
                                    Доставка по городу бесплатная.
                                </p>
                            </div>
                        </div>
                        <div class="order_right">
                            <div class="h5">Оформите заказ,
                                свяжемся в течение часа</div>
                            <form action="amo/order2.html" class="order_form">
                                <input type="hidden" name="recaptcha_response" class="recaptchaResponse">
                                <input type="hidden" name="sum">
                                <input type="hidden" name="tarif">
                                <input type="hidden" name="days">
                                <input type="hidden" name="promo">
                                <input type="hidden" name="sale">
                                <input type="hidden" name="sum_w_s">
                                <div class="input_wrapper gray">
                                    <input type="text" placeholder="Ваше имя" class="req" name="name">
                                    <p class="error_text">Заполните поле</p>
                                </div>
                                <div class="input_wrapper gray">
                                    <input type="tel" class="req" autocomplete="off" name="phone" placeholder="Номер телефона">
                                    <p class="error_text">Заполните поле</p>
                                </div>
                                <div class="input_wrapper gray">
                                    <textarea class="req " data-dadata="" name="address" placeholder="Адрес доставки"></textarea>
                                    <p class="error_text">Заполните поле</p>
                                </div>
                                <!--<div class="checkbox_wrapper">
                        г Санкт-Петербург                            <label>
                                <input type="checkbox" name="tg_check">
                                <span>Напишите в Telegram</span>
                            </label>
                        </div>-->
                                <button class="btn">Оформить заказ</button>

                                <p>Нажимая на кнопку, вы соглашаетесь с <a href="site/privacy.html" target="_blank">Политикой конфиденциальности</a></p>

                                <input type="hidden" name="utm_source" value="">
                                <input type="hidden" name="utm_medium" value="">
                                <input type="hidden" name="utm_campaign" value="">
                                <input type="hidden" name="utm_term" value="">
                                <input type="hidden" name="utm_content" value="">
                                <input type="hidden" name="ip" value="176.59.211.111">
                                <input type="hidden" name="address_extra" value="">
                            </form>
                        </div>
                    </div>
                    <div class="loader_block">
                        <div class="loader_block_after">
                            <div class="lds-spinner">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="popup_wrapper" id="detox_popup">
            <div class="popup_inner">
                <div class="popup order_popup">
                    <a href="javascript:void(0)" class="close_btn"></a>
                    <div class="order_popup_box">
                        <div class="order_left">
                            <div class="h5">Выберите желаемое
                                количество дней</div>

                            <div class="select_c_days">
                                <span class="decrement">&minus;</span>
                                <span class="text" data-sum="1200">
                                    1
                                </span>
                                <span class="increment">&plus;</span>
                            </div>

                            <div class="select_c_days_info">
                                <p>Детокс-меню: <span>1 день</span></p>
                            </div>
                            <div class="order_program">

                                <form action="amo/check_promocode.json" class="promocode">
                                    <input type="text" placeholder="Есть промо-код?" name="promocode">
                                    <input type="submit" value="Проверить">

                                    <p id="promocode_error"></p>
                                </form>
                                <span>сумма заказа</span>
                                <p class="order_info_price_detox"><b>
                                        1 200 ₽</b>
                                    Доставка по городу бесплатная.</p>
                            </div>
                        </div>
                        <div class="order_right">
                            <div class="h5">Оформите заказ,
                                свяжемся в течение часа</div>
                            <form action="amo/order3.html" class="detox_form">
                                <input type="hidden" name="recaptcha_response" class="recaptchaResponse">
                                <div class="input_wrapper gray">
                                    <input type="text" placeholder="Ваше имя" class="req" name="name">
                                    <p class="error_text">Заполните поле</p>
                                </div>
                                <div class="input_wrapper gray">
                                    <input type="text" class="req" autocomplete="off" name="phone" placeholder="+7 (">
                                    <p class="error_text">Заполните поле</p>
                                </div>
                                <div class="input_wrapper gray">
                                    <textarea class="req" name="address" placeholder="Адрес доставки"></textarea>
                                    <p class="error_text">Заполните поле</p>
                                </div>


                                <button class="btn">Оформить заказ</button>
                                <input type="hidden" name="count-detox" value="1">
                                <input type="hidden" name="sum-detox" value='1 200'>

                                <input type="hidden" name="utm_source" value="">
                                <input type="hidden" name="utm_medium" value="">
                                <input type="hidden" name="utm_campaign" value="">
                                <input type="hidden" name="utm_term" value="">
                                <input type="hidden" name="utm_content" value="">
                                <input type="hidden" name="ip" value="176.59.211.111">
                                <input type="hidden" name="promo">
                                <input type="hidden" name="sale">
                                <p>Нажимая на кнопку, вы соглашаетесь с <a href="">Политикой конфиденциальности</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/f5df9c31/jquery%EF%B9%96v=1576658544.js"></script>
    <script src="assets/6fc3164d/yii%EF%B9%96v=1576658544.js"></script>
    <script src="new_design/js/js_plugins%EF%B9%96v=1737715119.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@latest/dist/js/jquery.suggestions.min.js"></script>
    <script src="new_design/js/app%EF%B9%96v=20.03.2.js"></script>
    <script src="https://widget.cloudpayments.ru/bundles/cloudpayments.js"></script>
    <script defer src="https://www.google.com/recaptcha/api.js?render=6Lc61LgUAAAAAM4O_24pDfhzJc0MzdyG4Wt0gvgb"></script>
    <!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '{{ env("SMARTSUPP_KEY") }}';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>
</body>

</html>