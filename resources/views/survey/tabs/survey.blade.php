<div class="tab-pane fade active show" id="nav-survey">
  <div class="row">
    <div class="col-12">
      <div class="card data-table">
         <div class="card-header">
            <div class="heading-text">
              <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Survey') }}</h4>
            </div>

        <!--     <div class="right-side mr-2">



          <a href="{{ route('farmers.create') }}" class="dt-button btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New User</a>

        </div> -->
        </div>
      
        <!-- /.card-header -->
        <div class="card-body">
          <table id="surveyTable" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>S.No</th>
              <th>Users</th>
              <th>Farm Id</th>
              <th>Date</th>
               <th>Status</th>
            
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
