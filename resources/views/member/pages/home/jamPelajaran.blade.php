<section class="design-skills col-md-6 padding_60 padbot_50">
    <div class="section-title bottom_45"><span></span><h2>Informasi JP</h2></div>
    <div id="jpChart"></div>
</section>
<section class="code-skills col-md-6 padding_60">
    <div class="section-title bottom_45"><span></span><h2>Kompetensi</h2></div>
    <ul class="skill-list">
        @if($user['role_id']==2 && isset($jp))
        @foreach($jp['data'] as $kompetensi)
                <li>
                    <h3>{{ $kompetensi['nama'] }}</h3>
                    <div class="progress">
                        <div class="percentage" style="width:{{ $kompetensi['skor'] }}%;"></div>
                    </div>
                </li>
            @endforeach
            @else
            <li>
                <h3>Manajemen Pengawasan Intern</h3>
                <div class="progress">
                    <div class="percentage" style="width:0%;"></div>
                </div>
            </li>
            <li>
                <h3>Pelaksanaan Pengawasan Intern</h3>
                <div class="progress">
                    <div class="percentage" style="width:0%;"></div>
                </div>
            </li>
            <li>
                <h3>Standar Audit</h3>
                <div class="progress">
                    <div class="percentage" style="width:0%;"></div>
                </div>
            </li>

            <li>
                <h3>Tata Kelola</h3>
                <div class="progress">
                    <div class="percentage" style="width:0%;"></div>
                </div>
            </li>


            <li>
                <h3>Manajemen Resiko</h3>
                <div class="progress">
                    <div class="percentage" style="width:0%;"></div>
                </div>
            </li>


            <li>
                <h3>Pengendalian Intern</h3>
                <div class="progress">
                    <div class="percentage" style="width:0%;"></div>
                </div>
            </li>
            @endif


    </ul>
</section>
