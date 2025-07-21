  
  <!-- Bootstrap 5.3.7 JS (Optional for interactivity) -->
  <script src="<?= base_url('assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js')?>"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
  function toastFunction(type,message) {
    var Toast = Swal.mixin({
      toast: true,
      // position: 'top-end',
      position: 'top',
      showConfirmButton: false,
      timer: 7000
    });
    Toast.fire({
      icon: type,
      title: message
    })
  }
</script>
  
</body>

</html>
