@extends('layouts.admin')

@section('title') User @endsection

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
                                     <li class="breadcrumb-item"><a href="{{route('farmers.index')}}">User</a>
                                    </li>
                                    <li class="breadcrumb-item active">View
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
              </div>



        <div class="row">
          <div class="col-12">
            <div class="card">
  
              <!-- /.card-header -->
              <div class="card-body">

                     <table id="w0" class="table table-striped table-bordered detail-view">
                      <tbody>
                        <tr>
              
                          <th>Full Name</th>
                          <td colspan="1">{{$userObj->full_name}}</td>
                           <th>Email</th>
                            <td colspan="1"><a @if($userObj->email) href="mailto:test@gmail.com" @endif>{{$userObj->email ?? "Not Set"}}</a></td>
                        </tr>
                         <tr>
                            <th>Phone Number</th>
                            <td colspan="1">{{$userObj->phone_number}}</a></td>
                            <th>Status</th>
                            <td colspan="1"><span class="badge badge-light-{{$userObj->getStatusBadge()}}">{{$userObj->getStatus()}}</span>
                           
                          </tr>
                                  <tr>
                    
                                    <th>Role</th>
                                    <td colspan="1">{{$userObj->getRole()}}</td>
                                      <th>Created At</th>
                                    <td colspan="1">{{$userObj->created_at}}</td>
                                    
                                  </tr>

                                    
                               </tbody>
                           </table>
                           <br>

                           <div class="row"> 
                            <div class="col-md-12 text-center">
                            <a id="tool-btn-manage"  class="btn btn-primary text-right" href="{{ url()->previous() }}" title="Back">Back</a>
                           
                            <a href="{{route('farmer.changeStatus',encrypt($userObj->id))}}" class="active_status btn btn-{{($userObj->status ==1)?'danger':'primary'}}"  data-id = {{encrypt($userObj->id)}} title="Manage">{{($userObj->status == 1)?"Inactive":"Active"}}</i></a>
                            </div>
                </div>


              
              </div>
          
              <!-- /.card-body -->

            </div>
      </section>
      <section>
        <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="{{route('farms.index')}}">Farms</a>
                                    </li>
                                    <li class="breadcrumb-item active">List
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
              </div>
            <div class="row">
          <div class="col-12">
            <div class="card">
  
              <!-- /.card-header -->
              <div class="card-body pt-0">
                     @if($farms->count() > 0)
                    <a href="{{ route('export.items',$userObj->id) }}" class="btn btn-primary">Export Items</a>
                    
                      <table id="example" class="table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Farmer Name</th>
                            <th>Farm Id</th>
                            <th>Address</th>
                             <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         
                        @foreach ($farms as $key => $farm)

                            <tr data-entry-id="{{ $farm->id }}">
                                <td>{{$key+1}}</td>
                                <td>{{$farm->farmerDetails->full_name ? $farm->farmerDetails->full_name : 'N/A' }}</td>
                                <td>{{ $farm->farm_id ? $farm->farm_id : 'N/A'}}</td>
                                
                                <td>{{ $farm->area_location ?? '' }}</td>
                                <td><a href="{{route('farms.show', encrypt($farm->id))}}" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paginate-records">
                     {{$farms->links()}}
                </div>
                           

                 
                
                @else
                <h3 class="text-center mt-2">No data found</h3>
                @endif
              
              </div>
          
              <!-- /.card-body -->

            </div>
         </div>
    </div>
</div>




            <!-- /.card -->  



       
       




      
 
</section>
 


@endsection
