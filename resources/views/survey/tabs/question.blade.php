<div class="tab-pane fade" id="nav-question">
  <div class="row">
    <div class="col-12">
      <div class="card data-table">
        <div class="card-header">
          <div class="heading-text">
            <h4 class="m-0"><i class="fas fa-book mr-2"></i>&nbsp;{{ __('Questions') }}</h4>
          </div>
        
          <div class="right-side mr-2">
                    <a href="{{ route('questions.create') }}" class="dt-button btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Question</a>
                </div>
        </div>
        <!-- /.card-header -->
        
        <div class="card-body">
          <table id="question_table" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Field Name</th>
              <th>Field Type / Sub Question</th>
              <th>Sub-Field Type / Choices Option</th>
              <th>Date Created</th>
              <th data-orderable="false">Status</th>
              <th data-orderable="false">Action</th>
            </tr>
            </thead>

          </table>
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->
    </div>
  </div>
</div>