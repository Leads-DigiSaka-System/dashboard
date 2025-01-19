<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


<!-- Details Modal (Large) -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalActivityName"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- DataTable -->
        <table class="table table-striped" id="detailsTable">
          <thead>
            <tr>
              <th>Farmer Name</th>
              <th>Product Used Quantity</th>
              <th>Disease Quantity</th>
              <th>Date of Activity</th>
              <th>Activity Name</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<!-- Modal Structure -->
<div id="imageModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="imageGrid" class="row">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
  /* Add this CSS for zoom effect */
  .zoom-image {
    transition: transform 0.2s ease;
  }

  .zoom-image:hover {
    transform: scale(1.5); /* Adjust the zoom level */
  }

  /* Center the imageModal vertically and horizontally */
  #imageModal .modal-dialog {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 80%; /* Optional: Adjust modal width as needed */
    margin: 0;
  }

  #imageModal .modal-content {
    width: 100%; /* Ensures the modal content takes up the full width of the dialog */
  }

</style>