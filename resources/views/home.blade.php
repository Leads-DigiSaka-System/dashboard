@extends('layouts.admin')

@section('title') Dashboard @endsection

@section('content')
  <!-- Dashboard Ecommerce Starts -->
  <section id="dashboard-ecommerce">
    <div class="row match-height">

      <!-- Statistics Card -->
 
                      <div class="col-xl-4 col-sm-4 col-12 mb-2 mb-xl-0">
                        <a href="{{route('farmers.index')}}">
                          <div class="d-flex flex-row colbox bg-success">
                              <div class="avatar bg-light-primary me-2">
                                  <div class="avatar-content">
                                      <i data-feather="user" class="avatar-icon text-success"></i>
                                  </div>
                              </div>
                              <div class="my-auto">
                                  <h4 class="fw-bolder mb-0">{{$users}}</h4>
                                  <p class="card-text  mb-0">Farmers</p>
                              </div>
                          </div>
                        </a>
                      </div>
                         <div class="col-xl-4 col-sm-4 col-12 mb-2 mb-xl-0">
                        <a href="{{route('farms.index')}}">
                          <div class="d-flex flex-row colbox bg-warning">
                              <div class="avatar bg-light-primary me-2">
                                  <div class="avatar-content">
                                      <i data-feather="grid" class="avatar-icon text-warning"></i>
                                  </div>
                              </div>
                              <div class="my-auto">
                                  <h4 class="fw-bolder mb-0">{{$farms}}</h4>
                                  <p class="card-text  mb-0">Farms</p>
                              </div>
                          </div>
                        </a>
                      </div>
                         <div class="col-xl-4 col-sm-4 col-12 mb-2 mb-xl-0">
                        <a href="{{route('survey.index')}}">
                          <div class="d-flex flex-row colbox bg1-primary">
                              <div class="avatar bg-light-primary me-2">
                                  <div class="avatar-content">
                                      <i data-feather="book" class="avatar-icon text-light-primary"></i>
                                  </div>
                              </div>
                              <div class="my-auto">
                                  <h4 class="fw-bolder mb-0">{{$survey}}</h4>
                                  <p class="card-text text-dark  mb-0">Survey</p>
                              </div>
                          </div>
                        </a>
                      </div>

      <!--/ Statistics Card -->
    </div>
    <div class="row mt-5">

            <div class="col-md-6">

                <h4 class="mb-3 earning-title">{{ __('Latest Farmers') }}</h4>

                <div class="table-wrap table-responsive">

                    <table class="table table-bordered">

                        <thead>

                        <th>{{__('ID')}}</th>

                        <th>{{__('Name')}}</th>

                        <th>{{__('Phone')}}</th>

                        <th>{{__('Status')}}</th>

                        </thead>

                        <tbody>

                           @if($latest_farmers)

                            @foreach($latest_farmers as $farmer)

                            <tr>

                                <td>{{$loop->index + 1}}</td>

                                <td>{{$farmer->full_name}}</td>

                                <td>{{$farmer->phone_number}}</td>

                                <td><span class="badge badge-light-{{$farmer->getStatusBadge()}}">{{$farmer->getStatus()}}</span></td>

                            </tr>

                            @endforeach

                           @endif

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="col-md-6">

                <h4 class="mb-3 earning-title">{{ __('Latest Farms') }}</h4>

                <div class="table-wrap table-responsive">

                    <table class="table table-bordered">

                        <thead>

                        <th>{{__('ID')}}</th>

                        <th>{{__('Farmer Name')}}</th>

                        <th>{{__('Farm Id')}}</th>

                        

                        </thead>

                        <tbody>

                        @if($latest_farms)

                            @foreach($latest_farms as $farm)

                            <tr>

                                <td>{{$loop->index + 1}}</td>

                                <td>{{($farm->farmerDetails->full_name)??'N/A'}}</a></td>

                                <td>{{$farm->farm_id}}</td>

                              

                            </tr>

                            @endforeach

                           @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
        @if(!empty($allFarms))
              <div class="row"> 
                     <div class="col-md-12 text-center">
                        <h2>Farm Images</h2>
                        <div id="farm_image" style="height: 400px; width: 100%;"></div>
                            </div>
                </div>
                @endif



  </section>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key={{env('MAP_KEY')}}&callback=initMap"></script>
 <script>
    function toPolygonObj(polygon){
        let coordsList = [];
        let polCoords = polygon.latLngs;
        for(i=0;i<polCoords.length;i++){
            polObj = {};
            polObj.lat = polCoords[i][0];
            polObj.lng = polCoords[i][1];
            coordsList.push(polObj);
        }
        console.log(coordsList);
        return coordsList;
    }
        function initMap() {

            const map = new google.maps.Map(document.getElementById('farm_image'), {

                center: { lat: 12.8797, lng: 121.7740 },

                zoom: 5,

            });

 
         
            
                @foreach ($allFarms as $key=> $value)
                var myVar{{$key}}='';
                var polygon{{$key}} = JSON.parse('{{$value->area_location}}'.replace("&quot;latLngs&quot;","\"latLngs\""));
                coords = toPolygonObj(polygon{{$key}});
                const poly{{$key}} = new google.maps.Polygon({
                    paths: coords,
                    strokeColor: "#FF0000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#FF0000",
                    fillOpacity: 0.35,
                });
                poly{{$key}}.setMap(map);
                @foreach (explode(',',$value->farm_image) as $image)
                myVar{{$key}}+=  '<a href="{{ asset('') }}{{$image}}" target="_blank"><img src="{{ asset('') }}{{$image}}" alt="Farm Image" width="100px" ></a>';
            
                @endforeach
                var marker{{$key}} = new google.maps.Marker({

                    position: { lat: {{ $value->image_latitude }}, lng: {{ $value->image_longitude }} },

                    map: map,

                    title: 'Farm Image',

                });
                

 

                // Optional: Add an info window for each marker to display additional information

                var infoWindow{{$key}} = new google.maps.InfoWindow({

                    content: '<span>{{$value->farm_id}}<div class="map_image">'+myVar{{$key}}+'</div></span>'

                });
                 marker{{$key}}.addListener('click', function() {

                    infoWindow{{$key}}.open(map, marker{{$key}});

                });
                @endforeach
 

               

           
            

        }

    </script>

    
@endsection
