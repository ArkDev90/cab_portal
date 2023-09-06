<!doctype html>

<title>CAB Maintenance</title>

<style>

  body { text-align: center; padding: 100px; }

  h1 { font-size: 50px; }

  body { font: 20px Helvetica, sans-serif; color: #333; }

  article { display: block; text-align: center; width: 650px; margin: 0 auto; }

  article p{ text-align: left; }

  a { color: #dc8100; text-decoration: none; }

  a:hover { color: #333; text-decoration: none; }

</style>

<link rel="stylesheet" href="https://my.oojeema.com/view/html/css/flipclock.css">

<script src="https://my.oojeema.com/view/html/js/jquery-1.10.2.min.js"></script>

<script src="https://my.oojeema.com/view/html/js/flipclock.min.js"></script>



<body>

   

    <article>

        <h1>We&rsquo;ll be back soon!</h1>

        <div>

            <p>Sorry for the inconvenience, but we&rsquo;re performing some maintenance at the moment. You may still <a href="mailto:cab.prdreport@gmail.com">contact us</a> if needed.</p>


        </div>

        <hr/>

        <div class="clock " style="margin:2em;"></div>

    </article>



    

</body>

<script>

    var clock;

			

    $(document).ready(function() {

        var date = new Date();



        clock = $('.clock').FlipClock(date, {

            clockFace: 'TwelveHourClock'

        });

    });

</script>

<?php exit(); ?>