@extends('layouts.admin')

@section('title') Farm @endsection

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
                                     <li class="breadcrumb-item"><a href="{{route('farms.index')}}">Farm</a>
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
              
                        
                           <th>Famd Id</th>
                            <td colspan="1">{{$farmObj->farm_id}}</a></td>
                              <th>Address</th>
                            <td colspan="1">{{$farmObj->area_location}}</a></td>
                        </tr>
                         <tr>
                           
                           <th>Created At</th>
                                    <td colspan="1">{{$farmObj->created_at}}</td>
                                    <th>Profile Image</th>
                                    @if(!empty($farmObj->farmerDetails->profile_image))
                                    <td><a href="{{ asset('') }}{{$farmObj->farmerDetails->profile_image}}" target="_blank"><img src="{{ asset('') }}{{$farmObj->farmerDetails->profile_image}}" height="70px" width="70px"></td></a>
                                    @else
                                    <td><img src="{{ asset('') }}upload/images/default.png" height="70px" width="70px"></td>
                                    @endif
                           
                          </tr>
                                  

                                    
                               </tbody>

                           </table>
                           <br>
                           <div>
                            @if(isset($farmObj->farm_image))
                            @foreach(explode(',',$farmObj->farm_image) as $key=>$value)
                               <a href="{{ asset('') }}{{$value}}" target="_blank"><img src="{{ asset('') }}{{$value}}" height="70px" width="70px"></a>
                               @endforeach
                               @endif
                           </div>

                           <div class="row"> 
                            <div class="col-md-12 text-center">
                            <a id="tool-btn-manage"  class="btn btn-primary text-right" href="{{ url()->previous() }}" title="Back">Back</a>
                           
                            
                            </div>
                </div>



              
              </div>
          
              <!-- /.card-body -->

            </div>
             <div class="row"> 
                     <div class="col-md-12 text-center">
                        <h2>Farm Address</h2>
                        <div id="map" style="height: 400px; width: 100%;"></div>
                            </div>
                </div>
                 <div class="row"> 
                     <div class="col-md-12 text-center">
                        <h2>Farm Images</h2>
                        <div id="farm_image" style="height: 400px; width: 100%;"></div>
                            </div>
                </div>
        



            <!-- /.card -->
        </div>
       </div> 
       </section>
       <section>
        <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top mt-2">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="{{route('survey.index')}}">Survey</a>
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
              <div class="card-body">
                @if($surveys->count() > 0)
                     <table id="w0" class="table table-striped table-bordered detail-view">
                      <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                             <th>S.No</th>
                            <th>Farmer Name</th>
                            <th>Farm Id</th>
                             <th>Status</th>
                             <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         
                        @foreach ($surveys as $key => $survey)

                            <tr data-entry-id="{{ $survey->id }}">
                                <td>{{$key+1}}</td>
                                <td>{{$survey->farmerDetails ? $survey->farmerDetails->full_name : 'N/A'}}</td>
                                <td>{{ $survey->farmDetails ? $survey->farmDetails->farm_id : 'N/A'}}</td>
                              
                                <td><span class="badge badge-light-{{$survey->getStatusBadge()}}">{{$survey->getStatus()}}</span></td>
                                <td><a href="{{route('survey.show', encrypt($survey->id))}}" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paginate-records">
                     {{$surveys->links()}} 
                </div>
                 @else
                <h3 class="text-center mt-2">No data found</h3>
                @endif           

                 


              
              </div>
          
              <!-- /.card-body -->

            </div>
        




            <!-- /.card -->  
<?php 
$images=explode(',',$farmObj->farm_image);
?>
</section>



 
 
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&callback=initMap"></script>
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&callback=initMap2"></script> -->
 <script>
        // Your latitude and longitude array representing the boundary of the area
             
        const coordinates = [
           
            @foreach ($farm_address->latLngs as $val)
            { lat: {{$val[0]}}, lng: {{$val[1]}} }, // Example points, replace with your own
            @endforeach
            
        ];
        

        console.log(coordinates)
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 37.774929, lng: -122.419418 }, // Set your initial map center
                zoom: 13, // Adjust the zoom level as needed
                mapTypeId: 'satellite'
            });

            // Construct the polygon using the provided coordinates
            const areaPolygon = new google.maps.Polygon({
                paths: coordinates,
                strokeColor: "#FF0000", // Color of the border
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000", // Color of the fill
                fillOpacity: 0.35,
            });

            // Add the polygon to the map
            areaPolygon.setMap(map);

            // Optionally, fit the map to the polygon bounds
            const bounds = new google.maps.LatLngBounds();
            coordinates.forEach(({ lat, lng }) => bounds.extend(new google.maps.LatLng(lat, lng)));
            map.fitBounds(bounds);
            initMap2();
        }
    </script>
    <script>

        function initMap2() {

            const map = new google.maps.Map(document.getElementById('farm_image'), {

                center: { lat: 0, lng: 0 },

                zoom: 2,

            });

 
           var myVar='';
            @foreach ($images as $image)
            myVar+=  '<a href="{{ asset('') }}{{$image}}" target="_blank"><img src="{{ asset('') }}{{$image}}" alt="Farm Image" width="100px" ></a>';
         
             @endforeach
              

                var marker = new google.maps.Marker({

                    position: { lat: {{ $farmObj->image_latitude }}, lng: {{ $farmObj->image_longitude }} },

                    map: map,

                    title: 'Farm Image',

                });

 

                // Optional: Add an info window for each marker to display additional information

                var infoWindow = new google.maps.InfoWindow({

                    content: '<span>{{$farmObj->farm_id}}'+myVar+'</span>'

                });

 

                marker.addListener('click', function() {

                    infoWindow.open(map, marker);

                });

           
            

        }

    </script>


    


@endsection
