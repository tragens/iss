 <?php require_once "common/header.php";?> 

<style>
  
@media print {
  .printableArea {
    font-size: 12pt !important;
    transform: none !important;
    box-shadow: none !important;
    -webkit-font-smoothing: antialiased !important;
  }
}

/*  @media (max-width: 767.98px) {
    .no-padding-xs {
      padding-left: 0 !important;
      padding-right: 0 !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
  }*/
</style>

<!-- <div class="container-fluid px-5">  -->
<!-- px-4 = horizontal padding only -->
<div class="container-fluid px-md-5 px-0">
<!-- <div class="container-fluid px-5 no-padding-xs"> -->
  <!-- Full height, shadow, and inner padding -->
  <div class="shadow rounded bg-white p-4 min-vh-100">
      <!-- Back Button -->
    <div class="row">
        <div class="shadow rounded" style="background-color: #daf2f7;">
            <h1 class="my-4 text-center col-12">ISS Report</h1>
        </div>
    </div>
    <br>

    <div class="row">
      <div class="col-lg-2 col-md-3 col-sm-6">
          <a href="<?= base_url('/') ?>" class="btn btn-secondary form-control">
            <i class="bi bi-arrow-left-circle"></i> Back to Home
          </a>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-12">
          <input type="text" class="form-control" id="pickupRange" />
      </div>
      <div class="col-lg-2 col-md-3 col-sm-6">
          <!-- Button to trigger the modal -->
          <button type="button" class="btn btn-success form-control" onclick="$.fn.fetchReport()">
            Submit
          </button>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-6">
          <button type="button" class="btn btn-info form-control" id="printToPDF">
              <i class="bi bi-file-earmark-pdf"></i> Print to PDF
          </button>
      </div>


    </div>
    <br>
    <div class="printableArea">
      <!-- Responsive Table -->
      <h3 class="text-center">Supportive Supervistion Report <br><u><span id="from"></span><span id="to"></span></u></h3> 

      <div class="table-responsive" id="table_summary">
        <br>
        <caption><h3>Summary Report</h3> </caption>
        <table class="table table-bordered" id="summaryTable">
        </table>
      </div>

      <div class="table-responsive" id="table_report">
        <br>
        <caption><h3>Detail Report</h3> </caption>
        <table class="table table-bordered table-sm" id="facilityTable">
          <thead>
            <tr>
              <th>Kituo</th>
              <th class="text-right">MaxScore</th>
              <th class="text-right">Scored</th>
              <th class="text-right">Scored %</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>


  </div>
</div>

<script type="text/javascript">

$(document).ready(function () {

$.fn.fetchReport = function () {
  const input = $("#pickupRange");
  const picker = input.data('daterangepicker');

  const startDate = picker.startDate.format('YYYY-MM-DD');
  const endDate = picker.endDate.format('YYYY-MM-DD');

  if (!startDate || !endDate) {
    toastFunction('warning', 'Please select a date range.');
    return;
  }

  $.ajax({
    url: '<?= base_url('fetchReport') ?>',
    method: 'GET',
    dataType: 'json',
    data: { startDate, endDate },
    success: function (response) {
      $("#from").html(startDate);
      $("#to").html(` - ${endDate}`);

      const items = response.items || [];
      const totalFacility = response.totalFacility || 0;
      const participateFacilities = response.participateFacilities || 0;

      const tbody = $('#table_report tbody');
      tbody.empty();

      let passedCount = 0;
      let failedCount = 0;
      let highestScore = -1;
      let lowestScore = 101;
      let topFacility = '';
      let bottomFacility = '';

      const enrichedItems = items.map(item => {
        const scorePercent = (item.maxScore > 0)
          ? ((item.score / item.maxScore) * 100)
          : 0;
        return {
          ...item,
          scorePercent: scorePercent.toFixed(2)
        };
      });

      enrichedItems.sort((a, b) => b.scorePercent - a.scorePercent);

      if (enrichedItems.length > 0) {
        enrichedItems.forEach(item => {
          const scorePercent = parseFloat(item.scorePercent);

          const status = scorePercent > 50 ? 'Passed' : 'Failed';
          if (scorePercent > 50) passedCount++;
          else failedCount++;

          if (scorePercent > highestScore) {
            highestScore = scorePercent;
            topFacility = item.facility;
          }

          if (scorePercent < lowestScore) {
            lowestScore = scorePercent;
            bottomFacility = item.facility;
          }

          const row = `
            <tr>
              <td>${item.facility}</td>
              <td class="text-right">${item.maxScore}</td>
              <td class="text-right">${item.score}</td>
              <td class="text-right">${item.scorePercent}%</td>
              <td>${status}</td>
            </tr>
          `;
          tbody.append(row);
        });
      } else {
        const row = `<tr><td class="text-center" colspan="5">No report Found In Database</td></tr>`;
        tbody.append(row);
      }

      // --- Summary Section ---
      const percentParticipated = totalFacility > 0
        ? ((participateFacilities / totalFacility) * 100).toFixed(0) + '%'
        : '0%';

      const percentPassed = participateFacilities > 0
        ? ((passedCount / participateFacilities) * 100).toFixed(0) + '%'
        : '0%';

      const percentFailed = participateFacilities > 0
        ? ((failedCount / participateFacilities) * 100).toFixed(0) + '%'
        : '0%';

      const highestScoreDisplay = highestScore >= 0 ? `${highestScore}%` : 'N/A';
      const lowestScoreDisplay = lowestScore <= 100 ? `${lowestScore}%` : 'N/A';
      const topFacilityDisplay = topFacility || 'N/A';
      const bottomFacilityDisplay = bottomFacility || 'N/A';

      const summaryRows = `
        <tr><th>Jumla Ya Vituo</th><td>${totalFacility}</td><td>100%</td></tr>
        <tr><th>Vituo Vilivyo shiriki</th><td>${participateFacilities}</td><td>${percentParticipated}</td></tr>
        <tr><th>Vituo Vilivyo Faulu 50% ></th><td>${passedCount}</td><td>${percentPassed}</td></tr>
        <tr><th>Vituo Vilivyo feli 50% <</th><td>${failedCount}</td><td>${percentFailed}</td></tr>
        <tr><th>Ufaulu wa juu</th><td>${highestScoreDisplay}</td><td>${topFacilityDisplay}</td></tr>
        <tr><th>Ufaulu wa Chini</th><td>${lowestScoreDisplay}</td><td>${bottomFacilityDisplay}</td></tr>
      `;

      $('#table_summary table').html(summaryRows);
    },
    error: function (xhr, status, error) {
      console.error("Failed to fetch report:", error);
    }
  });
};



$('#printToPDF').click(function () {
    const element = document.querySelector('.printableArea');
  
    const input = $("#pickupRange");
    const picker = input.data('daterangepicker');

    const startDate = picker.startDate.format('DD MMMM');  // e.g., "01 June"
    const endDate = picker.endDate.format('DD MMMM, YYYY'); // e.g., "31 July, 2023"

    const displayName = `ISS_Report ${startDate} - ${endDate}.pdf`;

html2pdf(element, {
  margin: [5, 10, 5, 10], // inches, slightly narrower margins
  filename: displayName,
  image: { type: 'png', quality: 1.0 },
  html2canvas: { scale: 4, logging: true, dpi: 300, letterRendering: true },
  jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
});


});


});

</script>

 <?php require_once "common/footer.php";?>

