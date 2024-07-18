@extends('layouts.admin')

@section('title')
    Contacts
@endsection

@section('content')
 @php $ab='all';
 @endphp
           
    <section>

      <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Contacts
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
                    <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Contacts') }}</h4>
                  </div>

              {{-- <div class="right-side mr-2">
                <a href="{{ route('farmers.create') }}" class="dt-button btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New User</a>
              </div> --}}

              </div>
            
              <!-- /.card-header -->
              
              <div class="card-body">
                  {{-- <a href="{{ route('export.items',$ab) }}" class="btn btn-primary">Export Items</a> --}}
                  <table id="salesTeamTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Registered via App</th>
                    <th>Registered date</th>
                    <th>Added by</th>
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
      @include('sales.modal.profile')
    </section>  



  @push('page_script')

      @include('include.dataTableScripts')   
      <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY') }}&loading=async&&libraries=geometry">
      </script>
      <script src="{{ asset('js/pages/contacts/index.js?time=12345') }}"></script>

      <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      </script>


  @endpush

	     
@endsection