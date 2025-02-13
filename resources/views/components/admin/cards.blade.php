    <div class="col-xl-4 col-md-4">
        <div class="card  text-white mb-4 p-2">        
            <div class="card-body ">
                <div class="row d-flex align-items-center ">
                    <div class="col-6 ">
                        <i class="{{ $icon }}" style="font-size: 3rem;"></i>
                    </div>
                    <div class="col-6  text-end">
                        <h3>{{ $value }}</h3>
                        <h5>{{ $heading }}</h5>
                    </div>  
                </div>
            </div> 
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{$route}}">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>