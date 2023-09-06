
<?php
class controller extends wc_controller {

	public function __construct() {
		parent::__construct();
		$this->input				= new input();
		$this->notification_model	= new notification_model();
		$this->portal_model			= $this->checkOutModel('home/portal_model');
	}

	public function index() {
		$this->sendNonSubmission();
		$this->sendEndingSubscription(60);
		$this->sendEndingSubscription(90);
	}

	private function sendNonSubmission() {
		$non_submission = $this->notification_model->getNonSubmission();

		echo "<h2>Non-Submission</h2>";
		foreach ($non_submission as $row) {
			$subject = 'Notice for Late Submission of Reportorial Requirements';
			$message = "Please be informed that (<b>{$row->name}</b>) has been either late and/or non-compliant in the submission of the required (<b>{$row->title}</b>) for the period of (<b>{$row->period}</b>) In this connection, please be advised that we are giving you five (5) days from receipt of this notice to conform to the CAB requirement and to avoid further penalty following CAB Resolution No. 39(98). Please feel free to contact the Planning and Research Division at the telephone numbers 853 6761 or 854 5996 (loc. 118 or 119) should you need further information/assistance.
			<br><br>
			Please be informed that this is a late submission for report(<b>{$row->code}</b>) for the month of (<b>{$row->period}</b>). Thank you.";
			$this->portal_model->sendEmail($message, $row->email, $subject);
			echo "<p>$row->name: $row->title</p>";
		}
	}

	private function sendEndingSubscription($interval) {
		$expiring = $this->notification_model->getEndingSubscription($interval);

		echo "<h2>Ending Subcription ($interval)</h2>";
		foreach ($expiring as $row) {
			$subject = 'Notice for Late Submission of Reportorial Requirements';
			$message = "<b>Client Info</b>
			<br>
			<b>Company : </b> {$row->name}
			<br>
			<b>Email : </b> {$row->email}
			<br>
			<br>
			{$row->name}'s permit to operate as <b>{$row->title}</b> with the <b>Civil Aeronautics Board</b> will expire on (<b>".date("d-F-Y",strtotime($row->expdate))."</b>). Please file for renewal on or before (<b>".date("d-F-Y",strtotime($row->noticedate))."</b>). 
			<br>
			<br>
			Filing the application beyond (<b>".date("d-F-Y",strtotime($row->noticedate))."</b>) shall have a penalty of <b>PHP5000.00</b>.
			<br>
			To renew your permit, email us at <a href=\"mailto:acasfad@cab.gov.ph\">acasfad@cab.gov.ph</a>
			";
			$this->portal_model->sendEmail($message, $row->email, $subject);
			echo "<p>$row->name: $row->title</p>";
		}
	}

}