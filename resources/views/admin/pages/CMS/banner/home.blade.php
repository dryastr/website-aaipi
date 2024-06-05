<!-- <div class="row layout-top-spacing">
    <div class="widget-heading">
        <div class="task-action d-flex justify-content-end">
            @can('CMS.banner.create')
            <a href="{{route('CMS.banner.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>
                Tambah</a>
            @endcan
        </div>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table id="table-data" class="table table-bordered table-striped dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>URL</th>
                        <th>Gambar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div> -->

<form id="form-data" method="POST">
    <div class="row my-5">
        <div class="col-sm-6">
            <label for="title">Beranda Kontak</label>
            <div class="multiple-file-upload">
                <input type="file" accept="image/png, image/jpeg, image/gif" class="filepond file-upload"
                    name="beranda_kontak" id="beranda_kontak" data-allow-reorder="true" data-max-file-size="3MB"
                    data-max-files="5" data-image-url="beranda_slider">
            </div>
            <p>Masukkan image 1920 x 1280, max 3MB</p>
            <div id="feedback-beranda_kontak" class="feedback-image"></div>
        </div>
        <div class="col-sm-6">
            <label for="title">Beranda Kursus</label>
            <div class="multiple-file-upload">
                <input type="file" accept="image/png, image/jpeg, image/gif" class="filepond file-upload"
                    name="beranda_kursus" id="beranda_kursus" data-allow-reorder="true" data-max-file-size="3MB"
                    data-max-files="5" data-image-url="url_gambar2.jpg">
            </div>
            <p>Masukkan image 1920 x 1280, max 3MB</p>
            <div id="feedback-beranda_kursus" class="feedback-image"></div>
        </div>
    </div>
</form>