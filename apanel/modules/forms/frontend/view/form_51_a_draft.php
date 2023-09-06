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
    .apanel_deco_title_header {
        border-left-width: 1px;
        border-right-width: 1px;
        border-top-width: 1px;
        border-bottom: 3px dotted #005CB9;
        font-family: arial;
        font-size: 10pt;
        color: #005CB9;
        font-weight: 600;
        text-align:center;
        margin-top: 4%;
        margin-left: 30%;
        margin-right: 30%;
    }


</style>
<div class="panel panel-primary br-xs" style="width: 98%;">
	<div class="panel-heading bb-colored text-center">
    FORM 51-A : Traffic Flow - Quarterly Report on Scheduled International Services
	</div><br>
    <div class = "row" style = "padding: 1% 0% 0% 0%">
        <div class = "col-md-offset-2 col-md-3" style="font-weight: bold; font-size: 14px; color: #5a5aAA;">
         REPORT DATE
         </div>
         <div class = "col-md-offset-2 col-md-3" style="font-weight: bold; font-size: 14px; color: #5a5aAA;">
         ACTION
         </div>
    </div><br>
    <table align="center" cellspacing="0" border="0" width="100%" class="arial9" style="border:none;" id="drafttable">
    
    <tbody>
    
    </tbody>
    
    </table>
<!--     
    <div class="row">
    <div class = "col-md-offset-4 col-md-12" style="color: #AA0000; font-size: 14px; font-weight: bold">- NO DRAFT REPORTS - </div>
    
    </div> -->

    <div class = "row" style = "padding: 1% 0% 0% 0%">
    <div class = "col-md-3 col-md-offset-8">
   <a href="" data-toggle="back_page" style="color: #5a5aAA;font-size: 14px;"> ← Back to List</a>
    </div>
</div><div class="row">&nbsp;</div>

</div>


<script>
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_draft_list', ajax, function(data) {
			$('#drafttable tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();
</script>