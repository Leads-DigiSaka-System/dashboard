<div class="tab-pane fade show" id="content6" style="padding-right: 10px;">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <a href="https://ee-brybaltazar.projects.earthengine.app/view/climate-visual-2" target="_blank">
                        <img class="w-100" style="height:800px;" src="{{ asset('images/Rice-Yield.png') }}" alt="Rice Yield">
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <a href="https://ee-brybaltazar.projects.earthengine.app/view/philippine-sugarcane-area" target="_blank">
                        <img class="w-100" style="height:800px;" src="{{ asset('images/SugarCane.png') }}" alt="Sugar Cane">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <a href="https://ee-brybaltazar.projects.earthengine.app/view/philippine-maize" target="_blank">
                        <img class="w-100" style="height:800px;" src="{{ asset('images/Maize_Area.png') }}" alt="Sugar Cane">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <a href="https://ee-brybaltazar.projects.earthengine.app/view/philippine-crop-viewer" target="_blank">
                        <img class="w-100" style="height:800px;" src="{{ asset('images/Combined.png') }}" alt="Combined">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <a href="https://prism.philrice.gov.ph/dataproducts/" target="_blank">
                        <img class="w-100" style="height:800px;" src="{{ asset('images/Prism_area.png') }}" alt="Rice Area">
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="tab-pane fade show" id="content11" style="padding-right: 10px;">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <a href="https://data.humdata.org/dataset/world-bank-agriculture-and-rural-development-indicators-for-philippines" target="_blank">
                        <img class="w-100" style="height:800px;" src="{{ asset('images/WorldBank.png') }}" alt="World Bank">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <a href="https://www.psa.gov.ph/infographics?field_sector_value=Agriculture+and+Fisheries" target="_blank">
                        <img class="w-100" style="height:800px;" src="{{ asset('images/PSA.png') }}" alt="PSA">
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="tab-pane fade show" id="content12" style="padding-right: 10px;">
    <div class="row">
        <div class="col-md-12 col-lg-3">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <img class="w-100 zoom"  src="{{ asset('images/info-4.jpg') }}" alt="Infographics 4">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-3">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <img class="w-100 zoom"  src="{{ asset('images/info-3.jpg') }}" alt="Infographics 4">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-3">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <img class="w-100 zoom"  src="{{ asset('images/info-2.jpg') }}" alt="Infographics 4">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-3">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    <img class="w-100 zoom"  src="{{ asset('images/info-1.jpg') }}" alt="Infographics 4">
                </div>
            </div>
        </div>
    </div>
</div>



<div class="tab-pane fade show" id="content13" style="padding-right: 10px;">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 shadow-sm">
                <div class="card-body">
                    @if($webinar)
                        <div class="webinar-status">
                            <span class="active-now">Active Now</span>
                            <h3 class="webinar-title">{{ $webinar->title }}</h3>
                        </div>
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0"></script>
                        <div class="fb-video" data-href="{{ $webinar->link }}" data-width="500" data-show-text="false"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .webinar-status {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .active-now {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        margin-right: 10px;
    }
    .webinar-title {
        font-size: 1.5rem;
        margin: 0;
    }
    .card {
        margin-top: 20px;
    }
</style>


