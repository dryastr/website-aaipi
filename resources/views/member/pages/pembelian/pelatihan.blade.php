<section class="services line graybg col-md-12 padding_50 padbot_50">
    <div class="section-title bottom_45">
        <span></span>
        <h2>Rekomandasi Pelatihan</h2>
    </div>
    <div class="row equal">
        @if(isset($pelatihan))
            @foreach($pelatihan as $item)
            {{-- dd --}}
                <div class="col-md-3 col-sm-6 col-xs-12" style="height: 100%; margin-top:30px;">
                    <div class="service full-width" style="height: 250px; display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="icon">
                            
                            @if(isset($item['image']))
                                <img src="{{ $item['image'] }}" alt="" class="avatar">
                            @else
                                <img src="default_avatar.jpg" alt="Default Avatar" class="avatar">
                            @endif
                            {{-- <i class="flaticon-html"></i> --}}
                        </div>
                
    
                        <a href="{{ $item['link'] }}" target="_BLANK">
                            <p class="title_pelatihan">{{ Str::limit($item['title'], 50) }}</p>
                        </a>
    
                        <div>
                            @if($item['teacher'])
                                <p class="little-text-teacher">{{ $item['teacher']['full_name'] }}</p>
                            @else
                                <p class="little-text-teacher">Teacher Name Not Available</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    
    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center pagination-custom">
            {{ $pelatihan->render('vendor.pagination.bootstrap-4') }}
        </ul>
    </nav>

    <style>
        .little-text-teacher {
            margin-top: 10px;
            font-weight: bold;
        }
        .title_pelatihan {
            font-size: 13px;
            color: #4c4c4c;
            line-height: 20px;
            margin-top: 10px;
        }
        .pagination-custom {
            margin-top: 20px;
        }

        .pagination-custom .page-link {
            color: black;
            background-color: #f8f9fa; 
            border-color: #dee2e6;
        }

        .pagination-custom .page-link:hover {
            background-color: #e9ecef; 
        }

        .pagination-custom .page-item.active .page-link {
            background-color: black;
            border-color: black;
            color: white;
        }
        .avatar {
             width: 100px; 
             height: 100px; 
             border-radius: 20%;
             object-fit: cover; 
        }




    </style>
</section>
