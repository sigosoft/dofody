<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dofody';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin-login'] = 'admin_login';
$route['admin-login/logout'] = 'admin_login/logout';
$route['doctor-login'] = 'doctor_login';
$route['contact-us'] = 'contact_us';
$route['register-doctor'] = 'register_doctor';
$route['register-doctor/upload'] = 'register_doctor/upload';
$route['register-doctor/verfify-phone'] = 'register_doctor/verify_phone';
$route['register-doctor/identity-upload'] = 'register_doctor/identity_upload';
$route['register-doctor/degree-certificate'] = 'register_doctor/degree_certificate';
$route['register-doctor/registration-certificate'] = 'register_doctor/registration_certificate';
$route['register-doctor/bank-details'] = 'register_doctor/bank_details';
$route['register-doctor/signature'] = 'register_doctor/signature';
$route['register-doctor/registration-complete'] = 'register_doctor/registration_complete';
$route['register-doctor/change-password'] = 'register_doctor/change_password';

$route['doctor-login'] = 'doctor_login';
$route['doctor-login/logout'] = 'doctor_login/logout';

$route['patient-register'] = 'patient_register';
$route['patient-register/verify'] = 'patient_register/verify';
$route['register-patient/change-password'] = 'patient_register/change_password';

$route['patient/medical-records'] = 'patient/medical_records';
$route['patient/record-gallery'] = 'patient/record_gallery';
$route['patient/consult'] = 'patient/consult_now';
$route['patient/add-member'] = 'patient/add_profile';

$route['doctor/consult'] = 'doctor/consult_now';

$route['refund/(:any)'] = 'API/refund/$1';
$route['feedback/(:any)'] = 'API/feedback/$1';