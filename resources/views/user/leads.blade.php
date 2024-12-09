@extends('layouts.admin')

@section('title')Leads/LGU @endsection

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
                                    <li class="breadcrumb-item active">Leads/LGU List
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
                    <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Leads/LGU') }}</h4>
                  </div>

              <!--     <div class="right-side mr-2">




              </div> -->
              </div>
            
              <!-- /.card-header -->
              <div class="card-body">
                <table id="farmersTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th class="filter">Full Name</th>
                    <th class="">Email</th>
                    <th class="filter">Phone Number</th>
                    <th>Role</th>
                    <th class="filter">Status</th>
                     <th>Registered via App</th>
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

      <script src="{{ asset('js/pages/farmers/index2.js?14312') }}"></script>

  @endpush

	     
@endsection