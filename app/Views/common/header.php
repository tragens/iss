<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entry Page</title>
  <!-- Bootstrap 5.3.7 CDN -->
  <link href="<?= base_url('assets/bootstrap-5.3.7-dist/css/bootstrap.min.css')?>" rel="stylesheet">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.min.css') ?>">
  <script src="<?= base_url('assets/jquery/jquery.min.js') ?>"></script>
  <!-- Daterange picker -->
    <script src="<?= base_url('assets/plugins/moment/moment.min.js') ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker/daterangepicker.css') ?>">
    <script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>

  <link rel="stylesheet" href="<?= base_url('assets/custom/css/custom-select.css') ?>">
<script src="<?= base_url('assets/plugins/html2pdf/html2pdf.bundle.js')?>"></script>

  <style>
    body {
      background-color: #f8f9fa;
      /*margin: 20px;*/
    }
  
.loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.6); /* translucent white */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050; /* higher than modal content */
}

  .modal-body-wrapper {
    position: relative; /* ensure positioning context for overlay */
  }
  .rounded-bottom-5 {
    border-bottom-left-radius: 3rem !important;
    border-bottom-right-radius: 3rem !important;
  }  

    .spinner-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      min-height: 200px;  /* You can adjust this value */
    }


  </style>

</head>

<body>
