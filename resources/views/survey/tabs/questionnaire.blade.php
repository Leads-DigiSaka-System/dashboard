<div class="tab-pane fade" id="nav-questionnaire">
  <div class="row">
    <div class="col-12">
      <div class="card data-table">
        
        <div class="card-header">
          <div class="heading-text">
            <h4 class="m-0"><i class="fas fa-book mr-2"></i>&nbsp;{{ __('Questionnaires') }}</h4>
          </div>
        
          <div class="right-side mr-2">
                    <a href="{{ route('questionnaires.create') }}" class="dt-button btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Questionnaire</a>
                </div>
        </div>
        <!-- /.card-header -->
        
        <div class="card-body">
          <table id="questionnaire_table" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Description</th>
              <th>Date Created</th>
              <th>Date Revised</th>
              <th>Link</th>
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