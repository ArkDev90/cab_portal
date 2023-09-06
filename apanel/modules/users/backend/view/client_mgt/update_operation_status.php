<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CLIENT'S INFORMATION
    </div>
    <div class = "row" style = "padding: 3% 3% 0% 0%">
        <div class = "col-md-5" style = "text-align:right">
            Client Name :
        </div>
        <div class = "col-md-7">
            <b>101 New York Logistics Corporation</b> [ AF-285 ]
        </div>
    </div>
    <div class = "row" style = "padding: 1% 3% 0% 0%">
        <div class = "col-md-5" style = "text-align:right">
            Address :
        </div>
        <div class = "col-md-7">
            No.11A Sunblest compound KM 23 West Service Road Cupang Muntinlupa City, Philippines
        </div>
    </div>
    <div class = "row" style = "padding: 1% 3% 1% 0%">
        <div class = "col-md-5" style = "text-align:right">
            Email Address :
        </div>
        <div class = "col-md-7">
            aie.sobrecarey2015@gmail.com
        </div>
    </div>
    <div class = "row navhead">
        <ul style = "list-style-type: none">
            <li><a href = "<?php echo MODULE_URL ?>listing">[ Back to Main ]</a></li>
            <li><a href = "<?php echo MODULE_URL ?>client_info">[ Client Info ]</a></li>  
            <li><a href = "<?php echo MODULE_URL ?>users">[ Users ]</a></li> 
            <li><a href = "<?php echo MODULE_URL ?>add_operation">[ Add Nature of Operation ]</a></li> 
            <li><a href = "<?php echo MODULE_URL ?>change_status">[ Change Status ]</a></li>
            <li><a href = "<?php echo MODULE_URL ?>reports">[ View All Reports ]</a></li> 
            <li><a href = "<?php echo MODULE_URL ?>history">[ View History Listing ]</a></li>
        </ul>
    </div>
    <div class = "row operation_title" style = "padding-top:5%">
        International Airfreight Forwarders
    </div>
    <div class = "row" style = "padding: 5% 5% 0% 5%">
        <div class="panel panel-primary br-xs">
                <div class="panel-heading bb-colored text-center">
                    MANAGE PERMIT EXPIRATION
                </div>
                <div class = "row" style = "padding: 3% 1% 1% 1%">
                    <div class = "col-md-12">
                        <div class = "col-md-4" style = "text-align:right">
                            Permit Expiry :
                        </div>
                        <div class = "col-md-3">
                            <?php
                                echo $ui->formField('text')
                                ->setName('year')
                                ->setId('year')
                                ->setPlaceholder('NOT SET')
                                ->draw();
                            ?>
                        </div>
                    </div>
                    <div class = "col-md-12">
                        <div class = "col-md-4">

                        </div>
                        <div class = "col-md-2">
                             <?php
                                echo $ui->formField('dropdown')
                                ->setList(array('January', 'February', 'March'))
                                ->setName('month')
                                ->setId('month')
                                ->draw();
                            ?>
                        </div>
                        <div class = "col-md-2" style = "padding-left:0px">
                            <?php
                                echo $ui->formField('dropdown')
                                ->setList(array('1', '2', '3'))
                                ->setName('date')
                                ->setId('date')
                                ->draw();
                            ?>
                        </div>
                        <div class = "col-md-2" style = "padding-left:0px">
                            <?php
                                echo $ui->formField('text')
                                ->setName('year')
                                ->setId('year')
                                ->setPlaceholder('Year')
                                ->draw();
                            ?>
                        </div>
                        <div class = "row">
                            <div class = "col-md-12" style = "padding: 2% 5% 2% 0%; text-align:center">
                                <button type = "button" class = "btn btn-sm btn-default">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>





            