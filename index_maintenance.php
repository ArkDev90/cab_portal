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

        <div align=left width=80%>

            <p align="left"><pre><font size="4">
To all stakeholders:

Please be advised that due to connectivity issues in the premises, the CAB Portal won't be accessible.

We are extending the deadline of operation reports to August 23, 2023 (Wednesday).

Any submission after August 23, 2023 may merit corresponding penalty.

Submission of operational reports and penalties are based on the Resolution No. 40: Guidelines on the Filing of Operational and Financial Reports which was published on 21 September 2020.

For inquiries, you may contact Planning and Research Division at 8854-5996 (loc. 118/119) or email us at cab.prdreport@gmail.com and prdreport@cab.gov.ph.

Thank you.

Best regards,
PLANNING AND RESEARCH DIVISION
</font>
</pre></p>


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