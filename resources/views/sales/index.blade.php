@extends('layouts.admin')

@section('title')
    Sales Team
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
                            <li class="breadcrumb-item active">Sales Team
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
                    <h4 class="m-0"><i class="fas fa-users mr-2"></i>&nbsp;{{ __('Sales Team') }}</h4>
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
      <script src="{{ asset('js/pages/sales/index.js?time=12345') }}"></script>

      <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const handleViewProfile = (encrypted_id) => {
            $.ajax({
                url: site_url + "/getProfile/" + encrypted_id,
                method: "GET",
                success: function(data) {
                    // console.log(data);
                    $("#full_name").empty().append("Name: " + data.full_name);
                    $("#phone_number").empty().append("Mobile No.: " + data.phone_code + "" +data.phone_number);
                    $("#dob").empty().append("Birthdate: " + data.dob);

                    $("#address").empty().append(`
                      <span>Region: ${data.region_name}</span><br>
                      <span>Province: ${data.province_name}</span><br>
                      <span>Municipality/City: ${data.municipality_name}</span><br>
                      <span>Barangay: ${data.brgy_name}</span><br>
                    `);
                    
                    $("#viewProfileModal").modal("show");
                }
            });
        }

        const handleContactProfile = (encrypted_id) => {
          window.location.assign('contacts?added_by=' + encrypted_id);
        }
      </script>


  @endpush

	     
@endsection