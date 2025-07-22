<?php require_once "common/header.php"; ?>

<!-- Remove default body margin with Bootstrap's spacing utility -->
<div class="container-fluid p-0 m-0">
  <div class="d-flex min-vh-100 justify-content-center align-items-center flex-column text-center overflow-hidden">
      <h1 class="display-4 mb-4">Welcome to the Dashboard</h1>

      <div>
          <a href="<?=base_url('entry') ?>" class="btn btn-primary btn-lg m-2">Entry</a>
          <a href="<?=base_url('report') ?>" class="btn btn-secondary btn-lg m-2">Reports</a>
          <a href="<?=base_url('setup') ?>" class="btn btn-success btn-lg m-2">Setups</a>
      </div>
  </div>
</div>

<?php require_once "common/footer.php"; ?>
