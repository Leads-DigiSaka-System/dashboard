<!-- Modal for Viewing Harvest Details -->
<div class="modal fade" id="viewHarvestModal" tabindex="-1" role="dialog" aria-labelledby="viewHarvestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="activity_title">Harvest Details</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <strong>Harvest Information</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><strong>Full Name:</strong> <span id="full_name" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Planting Date:</strong> <span id="planting_date" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Harvesting Date:</strong> <span id="harvesting_date" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Method of Harvesting:</strong> <span id="method_harvesting" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Variety:</strong> <span id="variety" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Seeding Rate:</strong> <span id="seeding_rate" class="font-weight-bold text-muted"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <strong>Yield & Validation</strong>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><strong>Farm Size:</strong> <span id="farm_size" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Total Yield Weight (kg):</strong> <span id="total_yield_weight_kg" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Total Yield Weight (tons):</strong> <span id="total_yield_weight_tons" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Number of Cavans:</strong> <span id="number_of_canvas" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Validator:</strong> <span id="validator" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Validator Signature:</strong> <span id="validator_signature" class="font-weight-bold text-muted"></span></li>
                                        <li><strong>Kgs per Cavan:</strong> <span id="kgs_per_cavan" class="font-weight-bold text-muted"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
