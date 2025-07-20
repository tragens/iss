 <?php require_once "common/header.php";?> 

  <div class="container">
    <!-- Back Button -->
    <a href="index.html" class="btn btn-secondary btn-back">
      <i class="bi bi-arrow-left-circle"></i> Back to Home
    </a>

    <h1 class="my-4">Questionnaire Entry Form</h1>

    <!-- Button to trigger the modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newEntryModal" onclick="$.fn.openModal()">
      New Entry
    </button>

    <!-- Responsive Table -->
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Kituo</th>
            <th>MaxScore</th>
            <th>Scored</th>
            <th>Tarehe</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

    <!-- New Entry Modal -->
<!-- New Entry Modal -->
<div class="modal fade" id="newEntryModal" tabindex="-1" aria-labelledby="newEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newEntryModalLabel">New Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="newEntryModal-body-load">
                <!-- Dynamic content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save">Save Entry</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function () {

$.fn.openModal = function(action) {
    $('#newEntryModal').modal({ show: true });

    const $modalBody = $('#newEntryModal-body-load');
    const $overlay = `
        <div class="loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `;
    $modalBody.append($overlay); // Show loading spinner

    if (!action) { action = 2; }

    $.ajax({
        // url: "<?= base_url('questions/') ?>" + action,
        url: "<?= base_url('questions/') ?>",
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // $overlay.remove(); // Remove the loading spinner
              // $modalBody.html('');
            if (response) {
                // Clear previous modal content
                $modalBody.empty();

                response.forEach(function(qst, idx) {
                    // Dynamically creating main question label
                    const mainQuestionMarkup = `
                        <div class="question-container">
                            <label class="form-label text-center">Kigezo (${idx + 1})</label>
                            <p class="text-center">${qst.name}</p>
                    `;
                    $modalBody.append(mainQuestionMarkup);

                    // Loop through sub-questions for each main question
                    qst.items.forEach(function(sub, subIdx) {
                        const subQuestionMarkup = `
                            <div>
                                <label class="form-label">Kipengele ${idx + 1}.${subIdx + 1}: ${sub.name}</label>
                                <p>${sub.evidence}</p>
                                <input type="number" class="form-control mb-3" id="subQuestion${sub.id}Score" 
                                    placeholder="Alama alizopata (Score)" min="0" max="${sub.maxScore}">
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


});

</script>

 <?php require_once "common/footer.php";?>

