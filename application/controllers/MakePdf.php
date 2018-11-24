<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MakePdf extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			//$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('M_patient');
			$this->load->model('Common');
	}
	public function pdf($req,$pid)
	{

		$data = $this->Common->get_Details('requests',array('req_id' => $req));
		if ($data->num_rows() > 0) {
			$doctor = $data->row()->doctor_id;
			$doc = $this->M_patient->getDoctorName($doctor);
			$doc->stream = $this->M_patient->get_stream($doctor)->stream_name;
			$special = $this->M_patient->get_special($doctor);
			$specialization = '';
			foreach ($special as $key) {
				$specialization = $specialization.$key->special_name.',';
			}
			$doc->special = rtrim($specialization,',');
			$p_id = $data->row()->patient_id;
			$history = $this->M_patient->getHistoryDetails($pid);
			$history->date = date("d/m/Y", strtotime($history->date));
			$patient = $this->M_patient->getPatientDetails($p_id);

			if ($patient->gender == 'm') {
				$patient->gender = 'Male';
			}
			elseif ($patient->gender == 'f') {
				$patient->gender = 'Female';
			}
			else {
				$patient->gender = 'Other';
			}
			if ($patient->dob != '0000-00-00') {
				$today = date('Y-m-d');
				$dob = $patient->dob;
				$start = new DateTime($dob);
				$end = new DateTime($today);
				$interval = $end->diff($start)->format('%y');
				$patient->age = $interval;
			}
			else {
				$patient->age = 'Not given';
			}
			$medicines = $this->Common->get_details('medicines',array('prescription_id' =>$history->prescription_id ))->result();
			 $i=1;
			 $table = '';
			 foreach ($medicines as $medicine) {
				 $table =$table."<tr><td>".$i."</td><td>".$medicine->medicine."</td><td>".$medicine->usages."</td><td>".$medicine->days."</td></tr>";
			   $i++;
		 	 }
			$html = "<!doctype html>
			<html>
			<head>
			<meta charset='utf-8'>
			<title>Prescription</title>
			</head>
			<style>

			div {
			    display: block;
			}

			page {
				position: relative;
			  background: white;
			  display: block;
			  margin: 0 auto;
			  margin-bottom: 0.5cm;
			}

			@media print {
			  body, page {
			    margin: 0;
			    box-shadow: 0;
			  }
			}

				.container-fluid{
					padding-right: 15px;
			    	padding-left: 15px;
			    	margin-right: auto;
			    	margin-left: auto;
				}
				.container {
			    	width: 90%;
				}
				.container {
			    padding-right: 15px;
			    padding-left: 15px;
			    margin-right: auto;
			    margin-left: auto;
			}
				.row {
					width: 100%;
			    -webkit-box-flex: 1;
			    -ms-flex: 1;
			    flex: 1;
			    display: -webkit-box;
			    display: -ms-flexbox;
			    display: flex;
			    -webkit-box-orient: horizontal;
			    -webkit-box-direction: normal;
			    -ms-flex-direction: row;
			    flex-direction: row;
				}
				.clearfix::after {
			    content: '';
			    clear: both;
			    display: table;
			}
				.clearfix:after, .dl-horizontal dd:after, .container:after, .container-fluid:after, .row:after, .form-horizontal .form-group:after, .btn-toolbar:after, .btn-group-vertical>.btn-group:after, .nav:after, .navbar:after, .navbar-header:after, .navbar-collapse:after, .pager:after, .panel-body:after, .modal-header:after, .modal-footer:after {
			    clear: both;
			}
				.clearfix:before, .clearfix:after, .dl-horizontal dd:before, .dl-horizontal dd:after, .container:before, .container:after, .container-fluid:before, .container-fluid:after, .row:before, .row:after, .form-horizontal .form-group:before, .form-horizontal .form-group:after, .btn-toolbar:before, .btn-toolbar:after, .btn-group-vertical>.btn-group:before, .btn-group-vertical>.btn-group:after, .nav:before, .nav:after, .navbar:before, .navbar:after, .navbar-header:before, .navbar-header:after, .navbar-collapse:before, .navbar-collapse:after, .pager:before, .pager:after, .panel-body:before, .panel-body:after, .modal-header:before, .modal-header:after, .modal-footer:before, .modal-footer:after {
			    content: ' ';
			    display: table;
			}
				.col-1{
					width: 8.333333%;
				}
				.col-2{
					width: 16.66666667%;
				}
				.col-3{
					width: 25%;
				}
				.col-4{
					width: 33.333333%;
				}
				.col-5{
					width: 41.6666667%;
				}
				.col-6{
					width: 50%;
				}
				.col-7{
					width: 58.333333%;
				}
				.col-8{
					width: 66.666666%;
				}
				.col-9{
					width: 75%;
				}
				.col-10{
					width: 83.333333%;
				}
				.col-11{
					width: 91.66666%;
				}
				.col-12{
					width:100%;
				}
				.text-center{
					text-align: center;
				}
				.mt10{
					margin-top: 10px;
				}
				.mt20{
					margin-top: 20px;
				}
				.mt30{
					margin-top: 30px;
				}
				.mt40{
					margin-top: 40px;
				}
				.mt50{
					margin-top: 50px;
				}
				.mt60{
					margin-top: 60px;
				}
				.p0{
					padding: 0 !important;
				}
				.pt10{
					padding-top: 10px;
				}
				.pt20{
					padding-top: 20px;
				}
				.pt30{
					padding-top: 30px;
				}
				.pt40{
					padding-top: 40px;
				}
				.pt50{
					padding-top: 50px;
				}
				.pt60{
					padding-top: 60px;
				}
				.pb30{
					padding-bottom: 30px;
				}
				.pb20{
					padding-bottom: 20px;
				}
				.img-responsive{
			    	display: block;
			    	max-width: 100%;
			    	height: auto;
				}
				.pull-right{
					float: right;
				}
				h3{font-size: 21px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;color:#797979;}
				h4{font-size: 18px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;color:#797979;}
				p{font-size: 15px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; line-height: 24px;color:#797979;}
			  .table{font-size: 15px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;color:#797979;}
				.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
			    position: relative;
			    min-height: 1px;
			    padding-left: 15px;
			    padding-right: 15px;
				}
				.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
					float: left;
				}
				.border1{
					border-top: 1px solid #797979;
				}
				footer{
			  		position:absolute;
			  		bottom:0;
			  		width:100%;
			  		height:auto;
					padding-bottom: 20px;
				}
			</style>
			<body>
				<section>
					<page size='A4'>
						<section class='pt30'>
						<div class='container-fluid'>
							<div class='row'>
								<div class='col-12'>
									<img src='dist/img/pres_head.jpg' class='img-responsive'>
								</div>
							</div>
						</div>
						</section>
						<section class='pt50'>
						<div class='container'>
							<div class='row text-center'>
								<div class='col-12' style='padding-top:50px;'>
									<h3>$doc->name,$doc->stream</h3>
			            <h3>$doc->special</h3>
									<h3>$doc->place</h3>
								</div>
							</div>
						</div>
						</section>
					<section class='pt30 pb30'>
						<div class='container'>
							<div class='row'>
								<div class='col-6'>
									<p>Patient Name:<strong>$patient->patient_name</strong></p>
									<p>Age : <strong>$patient->age</strong></p>
									<p>Gender : <strong>$patient->gender</strong></p>
								</div>
								<div class='col-6'>
									<p class='pull-right'>Date : <strong>$history->date</strong></p>
								</div>
							</div>
						</div>
					</section>
					<section class=' '>
						<div class='container border1 pt30'>
							<div class='row'>
								<div class='col-12'>
									<h4 class='pb20'>Provisional  Diagnosis:</h4>
									<p>$history->pro_diagonosis</p>
								</div>
							</div>
						</div>
					</section>
					<section class='pt30'>
						<div class='container'>
							<div class='row'>
								<div class='col-md-12'>
									<img src='dist/img/ps.jpg' class='img-responsive' width='50'>
								</div>
							</div>
							<div class='row pt30'>
								<div class='col-12'>
									<table class='table' style='width:60%'>".$table."
			            </table>
								</div>
							</div>
						</div>
					</section>
					<footer class='pt30'>
						<div class='container'>
							<div class='row pt30 pb30'>
								<div class='col-12'>
			            <p class='pull-right'><img src='".$doc->signature."' height='40px' width='100px'></p>
								</div>
							</div>
							<div class='row pt10 border1'>
								<div class='col-12'>
									<p class='text-center'>For queries please mail to help@dofody.com or visit www.dofody.com</p>
								</div>
							</div>
						</div>
					</footer>

					</page>
				</section>
			</body>
			</html>
";
							$document_name = $patient->patient_name . rand(1000,10000).'.pdf';
							$this->load->library('pdf');
					 		$dompdf = new Dompdf\Dompdf();
					 		// Set Font Style
					 		$dompdf->set_option('defaultFont', 'Courier');
					 		$dompdf->loadHtml($html);
					 		// To Setup the paper size and orientation
					 		//$dompdf->setPaper('A4', 'landscape');
					 		// Render the HTML as PDF
					 		$dompdf->render();
					 		// Get the generated PDF file contents
					 		//$pdf = $dompdf->output();
					 		// Output the generated PDF to Browser
					 		//$dompdf->stream("My.pdf");
							$contxt = stream_context_create([
							    'ssl' => [
							        'verify_peer' => FALSE,
							        'verify_peer_name' => FALSE,
							        'allow_self_signed'=> TRUE
							    ]
							]);
							$dompdf->setHttpContext($contxt);
							$dompdf->output(['isRemoteEnabled' => true]);
					 		$dompdf->stream($document_name,array('Attachment'=>1));
							echo $html;

		}
		else {
			redirect('patient/ongoing_history_view/'.$request_id);
		}
	}
	public function ChatPdf($req,$pres_id)
	{

		$data = $this->Common->get_Details('requests',array('req_id' => $req));
		if ($data->num_rows() > 0) {
			$doctor = $data->row()->doctor_id;
			$doc = $this->M_patient->getDoctorName($doctor);
			$doc->stream = $this->M_patient->get_stream($doctor)->stream_name;
			$special = $this->M_patient->get_special($doctor);
			$specialization = '';
			foreach ($special as $key) {
				$specialization = $specialization.$key->special_name.',';
			}
			$doc->special = rtrim($specialization,',');
			$p_id = $data->row()->patient_id;
			$history = $this->M_patient->getHistoryDetailsChat($pres_id);
			$patient = $this->M_patient->getPatientDetails($p_id);

			if ($patient->gender == 'm') {
				$patient->gender = 'Male';
			}
			elseif ($patient->gender == 'f') {
				$patient->gender = 'Female';
			}
			else {
				$patient->gender = 'Other';
			}
			if ($patient->dob != '0000-00-00') {
				$today = date('Y-m-d');
				$dob = $patient->dob;
				$start = new DateTime($dob);
				$end = new DateTime($today);
				$interval = $end->diff($start)->format('%y');
				$patient->age = $interval;
			}
			else {
				$patient->age = 'Not given';
			}
			$medicines = $this->Common->get_details('medicines',array('prescription_id' =>$history->prescription_id ))->result();
			 $i=1;
			 $table = '';
			 foreach ($medicines as $medicine) {
				 $table = $table."<tr><td>".$i."</td><td>".$medicine->medicine."</td><td>".$medicine->usages."</td><td>".$medicine->days."</td></tr>";
			   $i++;
		 	 }
			$html = "<!doctype html>
			<html>
			<head>
			<meta charset='utf-8'>
			<title>Prescription</title>
			</head>
			<style>

			div {
			    display: block;
			}

			page {
				position: relative;
			  background: white;
			  display: block;
			  margin: 0 auto;
			  margin-bottom: 0.5cm;
			}

			@media print {
			  body, page {
			    margin: 0;
			    box-shadow: 0;
			  }
			}

				.container-fluid{
					padding-right: 15px;
			    	padding-left: 15px;
			    	margin-right: auto;
			    	margin-left: auto;
				}
				.container {
			    	width: 90%;
				}
				.container {
			    padding-right: 15px;
			    padding-left: 15px;
			    margin-right: auto;
			    margin-left: auto;
			}
				.row {
					width: 100%;
			    -webkit-box-flex: 1;
			    -ms-flex: 1;
			    flex: 1;
			    display: -webkit-box;
			    display: -ms-flexbox;
			    display: flex;
			    -webkit-box-orient: horizontal;
			    -webkit-box-direction: normal;
			    -ms-flex-direction: row;
			    flex-direction: row;
				}
				.clearfix::after {
			    content: '';
			    clear: both;
			    display: table;
			}
				.clearfix:after, .dl-horizontal dd:after, .container:after, .container-fluid:after, .row:after, .form-horizontal .form-group:after, .btn-toolbar:after, .btn-group-vertical>.btn-group:after, .nav:after, .navbar:after, .navbar-header:after, .navbar-collapse:after, .pager:after, .panel-body:after, .modal-header:after, .modal-footer:after {
			    clear: both;
			}
				.clearfix:before, .clearfix:after, .dl-horizontal dd:before, .dl-horizontal dd:after, .container:before, .container:after, .container-fluid:before, .container-fluid:after, .row:before, .row:after, .form-horizontal .form-group:before, .form-horizontal .form-group:after, .btn-toolbar:before, .btn-toolbar:after, .btn-group-vertical>.btn-group:before, .btn-group-vertical>.btn-group:after, .nav:before, .nav:after, .navbar:before, .navbar:after, .navbar-header:before, .navbar-header:after, .navbar-collapse:before, .navbar-collapse:after, .pager:before, .pager:after, .panel-body:before, .panel-body:after, .modal-header:before, .modal-header:after, .modal-footer:before, .modal-footer:after {
			    content: ' ';
			    display: table;
			}
				.col-1{
					width: 8.333333%;
				}
				.col-2{
					width: 16.66666667%;
				}
				.col-3{
					width: 25%;
				}
				.col-4{
					width: 33.333333%;
				}
				.col-5{
					width: 41.6666667%;
				}
				.col-6{
					width: 50%;
				}
				.col-7{
					width: 58.333333%;
				}
				.col-8{
					width: 66.666666%;
				}
				.col-9{
					width: 75%;
				}
				.col-10{
					width: 83.333333%;
				}
				.col-11{
					width: 91.66666%;
				}
				.col-12{
					width:100%;
				}
				.text-center{
					text-align: center;
				}
				.mt10{
					margin-top: 10px;
				}
				.mt20{
					margin-top: 20px;
				}
				.mt30{
					margin-top: 30px;
				}
				.mt40{
					margin-top: 40px;
				}
				.mt50{
					margin-top: 50px;
				}
				.mt60{
					margin-top: 60px;
				}
				.p0{
					padding: 0 !important;
				}
				.pt10{
					padding-top: 10px;
				}
				.pt20{
					padding-top: 20px;
				}
				.pt30{
					padding-top: 30px;
				}
				.pt40{
					padding-top: 40px;
				}
				.pt50{
					padding-top: 50px;
				}
				.pt60{
					padding-top: 60px;
				}
				.pb30{
					padding-bottom: 30px;
				}
				.pb20{
					padding-bottom: 20px;
				}
				.img-responsive{
			    	display: block;
			    	max-width: 100%;
			    	height: auto;
				}
				.pull-right{
					float: right;
				}
				h3{font-size: 21px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;color:#797979;}
				h4{font-size: 18px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;color:#797979;}
				p{font-size: 15px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; line-height: 24px;color:#797979;}
			  .table{font-size: 15px; margin: 0; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;color:#797979;}
				.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
			    position: relative;
			    min-height: 1px;
			    padding-left: 15px;
			    padding-right: 15px;
				}
				.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
					float: left;
				}
				.border1{
					border-top: 1px solid #797979;
				}
				footer{
			  		position:absolute;
			  		bottom:0;
			  		width:100%;
			  		height:auto;
					padding-bottom: 20px;
				}
			</style>
			<body>
				<section>
					<page size='A4'>
						<section class='pt30'>
						<div class='container-fluid'>
							<div class='row'>
								<div class='col-12'>
									<img src='dist/img/pres_head.jpg' class='img-responsive'>
								</div>
							</div>
						</div>
						</section>
						<section class='pt50'>
						<div class='container'>
							<div class='row text-center'>
								<div class='col-12' style='padding-top:50px;'>
									<h3>$doc->name,$doc->stream</h3>
			            <h3>$doc->special</h3>
									<h3>$doc->place</h3>
								</div>
							</div>
						</div>
						</section>
					<section class='pt30 pb30'>
						<div class='container'>
							<div class='row'>
								<div class='col-6'>
									<p>Patient Name:<strong>$patient->patient_name</strong></p>
									<p>Age : <strong>$patient->age</strong></p>
									<p>Gender : <strong>$patient->gender</strong></p>
								</div>
								<div class='col-6'>
									<p class='pull-right'>Date : <strong>$history->date</strong></p>
								</div>
							</div>
						</div>
					</section>
					<section class=' '>
						<div class='container border1 pt30'>
							<div class='row'>
								<div class='col-12'>
									<h4 class='pb20'>Provisional  Diagnosis:</h4>
									<p>$history->pro_diagonosis</p>
								</div>
							</div>
						</div>
					</section>
					<section class='pt30'>
						<div class='container'>
							<div class='row'>
								<div class='col-md-12'>
									<img src='dist/img/ps.jpg' class='img-responsive' width='50'>
								</div>
							</div>
							<div class='row pt30'>
								<div class='col-12'>
									<table class='table' style='width:60%'>".$table."
			            </table>
								</div>
							</div>
						</div>
					</section>
					<footer class='pt30'>
						<div class='container'>
							<div class='row pt30 pb30'>
								<div class='col-12'>
			            <p class='pull-right'><img src='".$doc->signature."' height='40px' width='100px'></p>
								</div>
							</div>
							<div class='row pt10 border1'>
								<div class='col-12'>
									<p class='text-center'>For queries please mail to help@dofody.com or visit www.dofody.com</p>
								</div>
							</div>
						</div>
					</footer>

					</page>
				</section>
			</body>
			</html>
";
							$document_name = $patient->patient_name . rand(1000,10000).'.pdf';
							$this->load->library('pdf');
					 		$dompdf = new Dompdf\Dompdf();
					 		// Set Font Style
					 		$dompdf->set_option('defaultFont', 'Courier');
					 		$dompdf->loadHtml($html);
					 		// To Setup the paper size and orientation
					 		//$dompdf->setPaper('A4', 'landscape');
					 		// Render the HTML as PDF
					 		$dompdf->render();
					 		// Get the generated PDF file contents
					 		//$pdf = $dompdf->output();
					 		// Output the generated PDF to Browser
					 		//$dompdf->stream("My.pdf");
							$contxt = stream_context_create([
							    'ssl' => [
							        'verify_peer' => FALSE,
							        'verify_peer_name' => FALSE,
							        'allow_self_signed'=> TRUE
							    ]
							]);
							$dompdf->setHttpContext($contxt);
							$dompdf->output(['isRemoteEnabled' => true]);
					 		$dompdf->stream($document_name,array('Attachment'=>1));
							echo $html;

		}
		else {
			redirect('patient/ongoing_history_view/'.$request_id);
		}
	}

}

?>
