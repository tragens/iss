 <?php require_once "common/header.php";?>
<!--     .btn {
      font-size: 18px;
      margin: 10px;
      padding: 15px 30px;
    }
 -->

  <div class="container">
    <h1 class="display-4 mb-4">Welcome to the Dashboard</h1>

    <div class="d-flex justify-content-center">
      <!-- Entry Button -->
      <a type="button" href="<?=base_url('entry') ?>" class="btn btn-primary btn-lg">Entry</a>
      
      <!-- Reports Button -->
      <button type="button" class="btn btn-secondary btn-lg">Reports</button>
      
      <!-- Setups Button -->
      <button type="button" class="btn btn-success btn-lg">Setups</button>
    </div>
  </div>

 <?php require_once "common/footer.php";?>
