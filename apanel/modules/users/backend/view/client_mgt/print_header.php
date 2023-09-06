<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $this->title ?></title>
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/cabcustom.css">
	<style>
		body {
			padding: 15px;
		}
		@media print {
			body {
				padding: 0;
			}
		}
		.visible-print {
			display: block !important;
		}
		.hidden-print {
			display: none;
		}
		.content-wrapper {
			min-width: 980px;
			margin: auto;
		}
		.table-responsive {
			padding: 5px;
			overflow-x: visible;
			overflow-y: visible;
		}
		table {
			width: 100%;
		}
		.text-center {
			text-align: center;
		}
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
		.text-left {
			text-align: left;
		}
		.report_name {
			padding: 5px 0;
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}
		.panel {
			border: 1px solid black;
		}
		.panel-heading.bb-colored {
			border-bottom: 1px solid black !important;
		}
		.row:after, .row:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before {
			display: table;
			content: " ";
			clear: both;
		}
		.blue_text {
			color: #003366 !important;
		}
	</style>
	<script src="<?= BASE_URL ?>assets/js/jquery-2.2.3.min.js"></script>
</head>
<body>
	<div class="content-wrapper">
		<div class="content-body">