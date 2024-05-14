@extends('layouts.admin')

@section('title')Farmers @endsection

@section('content')
 
           

    <!-- Main content -->
    <section>

      <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('farmers.index')}}">Farmers</a>
                                    </li>
                                    <li class="breadcrumb-item active">Farmers List
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
      </div>
       

        <div class="row">
          <div class="col-12">
            <div class="card data-table">
               <div class="card-header">
                  <div class="heading-text">
                    <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Farmers') }}</h4>
                  </div>

              <!--     <div class="right-side mr-2">



                <a href="{{ route('farmers.create') }}" class="dt-button btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New User</a>

              </div> -->
              </div>
            
              <!-- /.card-header -->
              <div class="card-body">
                <table id="farmersTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th class="filter">Full Name</th>
                    <th class="filter">Phone Number</th>
                    <th  style="width:50px;">Role</th>
                    <th class="filter">Status</th>
                    <th>Registered via App</th>
                    <th name="registered_by" class="filter">Registered by</th>
                    <th>Registered date</th>
                  
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
      <!-- /.container-fluid -->
    </section>  
  

  @push('page_script')

      @include('include.dataTableScripts')   

      <script src="{{ asset('js/pages/farmers/index.js?41233123') }}"></script>

  @endpush

	     
@endsection