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
  <style>
    body {
      background-color: #f8f9fa;
      /*margin: 20px;*/
    }
/*    .table th, .table td {
      vertical-align: middle;
    }*/
/*    .modal-body {
      max-height: 400px;
      overflow-y: auto;
    }*/
/*    .btn-back {
      margin-bottom: 20px;
    }
    .form-label {
      font-weight: bold;
    }*/
    /* Customizing table */
/*    .table-responsive {
      overflow-x: auto; /* Makes the table scrollable horizontally *
    }
*/
  
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

  </style>
</head>

<body>
