<div class="tab-pane fade" id="nav-survey-set">
  <div class="row">
    <div class="col-12">
      <div class="card data-table">
        <div class="card-header">
          <div class="heading-text">
            <h4 class="m-0"><i class="fas fa-book mr-2"></i>&nbsp;{{ __('Survey Set') }}</h4>
          </div>
        
          <div class="right-side mr-2">
                    <a href="{{ route('survey_set.create') }}" class="dt-button btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Survey Set</a>
                </div>
        </div>
        <!-- /.card-header -->
        
        <div class="card-body">
          <div class="table-responsive">
              <table id="survey_set_table" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Description</th>
              <th>Date Created</th>
              <th style="min-width: 450px;">Link</th> 
              <th data-orderable="false">Status</th>
              <th data-orderable="false">Action</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->
    </div>
    </div> 
</div>