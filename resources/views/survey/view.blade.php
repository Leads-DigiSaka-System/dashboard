@extends('layouts.admin')

@section('title') Survey @endsection

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
                                     <li class="breadcrumb-item"><a href="{{route('survey.index')}}">Survey</a>
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
                            <td colspan="1">{{($surveyObj->farmDetails->farm_id)??''}}</a></td>
                              <th>Farmer </th>
                            <td colspan="1">{{($surveyObj->farmerDetails->full_name)??''}}</a></td>
                        </tr>
                         <tr>
                           
                           <th>Created At</th>
                             <td colspan="1">{{$surveyObj->created_at}}</td>
                         </tr>
                          </tbody>
                           </table>
                           <br>
                           <div class="quest-ans">
                            @if(!empty($questions))

                        <a href="{{ route('export_survey_items',$surveyObj->id) }}" class="btn btn-primary">Export Items</a>
                            @php $i=1; @endphp
                            @foreach ($questions->responses as $key => $value) 
                               <h2>Q{{$i++}}. {{$value->question_value}}</h2>
                               @if(!empty($value->answers ))
                               @foreach ($value->answers as $key => $val) 
                                <p><span>Ans.</span> {{($val->text_response)??$val->row_value}}</p>
                                @endforeach
                                @else
                                <p><span>Ans.</span>Respondent skipped this question </p>
                                @endif
                                 @endforeach
                              
                               @endif
                           </div>

                           <div class="row"> 
                            <div class="col-md-12 text-center">
                            <a class="back" id="tool-btn-manage"  class="btn btn-primary text-right" href="{{ url()->previous() }}" title="Back">Back</a>
                           
                            
                            </div>
                </div>


              
              </div>
          
              <!-- /.card-body -->

            </div>



            <!-- /.card -->
        </div>
       </div>   




      
 
</section>



@endsection
