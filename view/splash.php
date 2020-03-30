<html>
    <head>
        <meta charset="utf-8" />
        <title>Mobile-CU</title>
        <link rel="stylesheet" href="splash.css">
        <link href="vendor/css/splash.css" rel="stylesheet" media="all">
        <link href="vendor/css/animate.css" rel="stylesheet" media="all">
    </head>
    <body>

        <section class="intro" id="all">
            <div class="inner">
                <div id="logo" style="animation-duration: 1.5s;" class="content animated slideInDown">
                    <img  class="" src="view/images/icon/logo2.png" alt=""/>
                </div>
                <div id="slog" style="animation-duration: 1s; animation-delay: 1s;" class="slog-container animated bounceInLeft">
                    <span class="slogan">"Putting People First !"</span>
                </div>
                <div style="animation-duration: 1s; animation-delay: 2s;" class="animated fadeInUp" id="circle">
                    <img style="height: 150px; width: 200px;" src="view/images/icon/load.gif" alt="">
                </div>
            </div>
        </section>

        <script src="vendor/jquery-3.2.1.min.js"></script>
        <script>

            (function () {
                var preload = document.getElementById('logo');
                var preload1 = document.getElementById('slog');
                var loading = 0;
                var id = setInterval(frame, 114);

                function frame() {
                    if (loading == 100) {
                        clearInterval(id);
                        window.open("index.php", "_self");
                    } else {
                        loading = loading + 1;
                        if (loading == 90) {
                            preload.className = "animated bounceOut";
                        }
                    }
                }
            })();
        </script>
    </body>

</html>