 <?php require_once "common/header.php";?> 

<!-- <div class="container-fluid px-5">  -->
<!-- px-4 = horizontal padding only -->
<div class="container-fluid px-md-5 px-0">
  <!-- Full height, shadow, and inner padding -->
  <div class="shadow rounded bg-white p-4 min-vh-100">
      <!-- Back Button -->
    <div class="row">
        <div class="shadow rounded" style="background-color: #daf2f7;">
            <h1 class="my-4 text-center col-12">Questionnaire Entry</h1>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-6">
            <a href="<?= base_url('/') ?>" class="btn btn-secondary form-control">
              <i class="bi bi-arrow-left-circle"></i> Back to Home
            </a>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6">
            <!-- Button to trigger the modal -->
            <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#newEntryModal" onclick="$.fn.openModal()">
              New Entry
            </button>
        </div>
    </div>
    <br>

    <!-- Responsive Table -->
    <div class="table-responsive">
      <table class="table table-bordered" id="entryTable">
        <thead>
          <tr>
            <th>Tarehe</th>
            <th>Kituo</th>
            <th>MaxScore</th>
            <th>Scored</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- New Entry Modal -->
<div class="modal fade" id="newEntryModal" tabindex="-1" aria-labelledby="newEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newEntryModalLabel">New Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row pre-details">
                   <div class="col-lg-4">
                    <label class="fw-bold">Region:</label>
                       <select class="form-control" id="region">
                           <option value="">--select--</option>
                           <?php foreach ($region as $region): ?>
                               <option value="<?= $region['id']?>">
                                    <?= $region['name']?>
                                </option>
                           <?php endforeach ?>
                       </select>
                   </div> 
                   <div class="col-lg-4">
                        <label class="fw-bold">Council:</label>
                       <select class="form-control" id="council">
                           <option value="">--select--</option>
                           <?php foreach ($council as $council): ?>
                               <option value="<?= $council['id']?>">
                                    <?= $council['name']?>
                                </option>
                           <?php endforeach ?>
                       </select>
                   </div> 
                   <div class="col-lg-4">
                        <label class="fw-bold">Facility:</label>
                       <select class="form-control" id="facility">
                           <option value="">--select--</option>
                           <?php foreach ($facility as $facility): ?>
                               <option value="<?= $facility['id']?>">
                                    <?= $facility['name']?>
                                </option>
                           <?php endforeach ?>
                       </select>
                   </div> 
                </div><br>
                <div id="newEntryModal-body-load"></div>
                <div id="newEntryModal-content" class="row">
                    <!-- Dynamic content will be inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close</button>
                <button type="button" class="btn btn-primary" id="save">Save Entry</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function () {

    $('#newEntryModal').on('hidden.bs.modal', function () { 
      $('.pre-details').find("select").prop('selectedIndex', 0);
    });

    $.fn.openModal = function(action) {
        $('#newEntryModal').modal({ show: true });

        const $modalBody = $('#newEntryModal-content');
        const $modalloadBody = $('#newEntryModal-body-load');
        const $overlay = $(`
                    <div class="loading-overlay">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>`);
        $modalloadBody.append($overlay); // Show loading spinner

        if (!action) { action = 2; }

        $.ajax({
            // url: "<?= base_url('questions/') ?>" + action,
            url: "<?= base_url('questions/') ?>",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $overlay.remove(); // Remove the loading spinner
                if (response) {
                    // Clear previous modal content
                    $modalBody.empty();

                    response.forEach(function(qst, idx) {
                        // Dynamically creating main question label
                        const mainQuestionMarkup = `
                            <div class="question-container">
                                <label class="form-label text-center w-100 fw-bold">Kigezo (${idx + 1})</label>
                                <p class="text-center">${qst.name}</p>
                        `;
                        $modalBody.append(mainQuestionMarkup);

                        // Loop through sub-questions for each main question
                        qst.items.forEach(function(sub, subIdx) {

                            let selectOptions = '';
                            for (let i = 0; i <= sub.maxScore; i++) {
                                selectOptions += `<option value="${i}">${i}</option>`;
                            }

                            const subQuestionMarkup = `
                                <div>
                                    <label class="text-center fw-bold">Kipengele ${idx + 1}.${subIdx + 1}: ${sub.name}</label>
                                    <p class="fst-italic">"${sub.evidence}"</p>
                                    <input type="hidden" id="maxScore" value="${sub.maxScore}">
                                    <select class="form-select mb-3" id="subQuestion${sub.id}Score">
                                        <option value="" disabled selected>-- Chagua Alama --</option>
                                        ${selectOptions}
                                    </select>
                                    <textarea class="form-control mb-3" id="subQuestion${sub.id}Comments" 
                                        placeholder="Maoni (Andika vitu vilivyo kosekana)"></textarea>
                                </div>
                            `;
                            $modalBody.append(subQuestionMarkup);
                        });

                        // Close main question div
                        $modalBody.append("</div>");
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to fetch questions:", error);
                $overlay.remove(); // Remove loading spinner on error
            }
        });
    };



  fetchEntries();
  function fetchEntries() {

    $.ajax({
      url: '<?= base_url('fetchEntry') ?>',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        const tbody = $('#entryTable tbody');
        tbody.empty(); // Clear previous rows
        if (Array.isArray(response) && response.length > 0) {
          response.forEach(function(item) {

              let button = `
                    <span class="btn btn-sm btn-outline-primary" type="button" class="fas fa-pen text-primary" onclick="$.fn.editDiagnosis(${item.id})" data-toggle="modal" data-target="#modal-editDiagnosis">Edit</span>
                    <span class="btn btn-sm btn-outline-danger" style="text-decoration: none;" type="button"  onclick="$.fn.deleteDiagnosis(${item.id})" data-toggle="modal" data-target="#DeLeTe-mOdal">Delete</span>`;

            const row = `
              <tr>
                <td>${item.date}</td>
                <td>${item.facility}</td>
                <td class="text-right">${item.maxScore}</td>
                <td class="text-right">${item.score}</td>
                <td class="text-center">${button}</td>
              </tr>
            `;
            tbody.append(row);
          });
        } else{
            const row = `
              <tr>
                <td class="text-center" colspan="6">No request Found In Database</td>
              </tr>
            `;
            tbody.append(row);
        }
      },
      error: function(xhr, status, error) {
        console.error("Failed to fetch transactions:", error);
      }
    });
  }





    $('#save').click(function () {
        $("#save").prop("disabled", true);

        const formData = {
            entries: [],
            region: $("#region").val(),
            council: $("#council").val(),
            facility: $("#facility").val(),
        };

        const addedIds = new Set();

        $('[id^=subQuestion]').each(function () {
            const idMatch = this.id.match(/subQuestion(\d+)(Score|Comments)/);
            if (idMatch) {
                const checklistId = idMatch[1];
                const type = idMatch[2];
                let entry = formData.entries.find(e => e.checklistId === checklistId);

                if (!entry) {
                    entry = {
                        checklistId: checklistId,
                        results: null,
                        maxScore: $(`#subQuestion${checklistId}Score`).closest('div').find('#maxScore').val(),
                        comment: ''
                    };
                    formData.entries.push(entry);
                }

                if (type === 'Score') {
                    entry.results = $(this).val();
                } else if (type === 'Comments') {
                    entry.comment = $(this).val();
                }
            }
        });

        // Send formData via POST
        $.ajax({
            url: "<?= base_url('entrySave') ?>",
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            dataType: 'JSON',
            success: function (response) {
                if (response.statusCode == 200) {
                    toastFunction('success', response.message);
                    $('#newEntryModal').modal('hide');
                      fetchEntries();
                } else {
                    toastFunction('error', response.message);
                }
                $("#save").prop("disabled", false);
            },
            error: function (xhr, status, error) {
                toastFunction('error', "Imeshindikana kuhifadhi taarifa. Tafadhali jaribu tena.");
                $("#save").prop("disabled", false);
            }
        });
    });

});

</script>

 <?php require_once "common/footer.php";?>

