<style>
	td {
		font-size: 10px !important;
	}
	td a {
		color:black;
	}
	td a:hover {
		color:#003366;
		text-decoration:underline;
	}
	th {
		font-size: 10px !important;
		text-align:center;
	}
    .nav_link {
        text-align:center;
        padding:2%;
    }
    .nav_link a {
        font-weight: normal;
        text-align:center;
        font-size:9px;
        color:black;
    }
    .nav_link a:hover {
        color:#003366;
        text-decoration:underline;
    }
    .errmsg {
    font-family: arial;
    font-size: 8pt;
    color: #D60707;
    font-weight: 500;
}
</style>
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		REPORT CONTROLLER
	</div>

	<?php foreach($report as $row){
		echo '<a href="'.BASE_URL.'report_ctrl/view/'.$row->id.'">'.'&nbsp;» '. $row->title.'</a><br>';
	}
	?>
	
		
	
</div>




