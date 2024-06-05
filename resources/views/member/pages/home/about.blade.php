<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<link rel="stylesheet" href="{{asset('src/plugins/src/filepond/filepond.min.css')}}">
<link rel="stylesheet" href="{{asset('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
<link href="{{asset('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{asset('src/assets/css/light/apps/blog-create.css')}}">

<section class="about-me line col-md-12 padding_30 padbot_45">

    <div class="row">
        <div class="col-md-6">
            <div class="section-title bottom_30"><span></span>
                <h2>{{ $title }}</h2>
            </div>
        </div>
        <div class="col-md-6" style="text-align: right">
            <!-- Tambahkan tombol kembali -->
            <div class="edit-icon btn btn-danger" onclick="toggleEditForm()"><i class="fa fa-pencil"></i> Ubah</div>
        </div>
    </div>
    <div id="about-content" class="top_30">
        <!-- <p>Started earnest brother believe an exposed so. Me he believing daughters if forfeited at furniture. Age again and stuff downs spoke. Late hour new nay able fat each sell. Nor themselves age introduced frequently use unsatiable devonshire get. They why quit gay cold rose deal park. One same they four did ask busy. Reserved opinions fat him nay position. Breakfast as zealously incommode do agreeable furniture. One too nay led fanny allow plate.

Quick six blind smart out burst. Perfectly on furniture dejection determine my depending an to. Add short water court fat. Her bachelor honoured perceive securing but desirous ham required. Questions deficient acuteness to engrossed as. Entirely led ten humoured greatest and yourself. Besides ye country on observe. She continue appetite endeavor she judgment interest the met. For she surrounded motionless fat resolution may.</p> -->
        <p><?php 
                if (isset($item['desc_member']) && !empty($item['desc_member'])) { 
                    echo $item['desc_member']; 
                } else { 
                    echo 'Tentang Anda'; 
                } 
            ?>

        
        </p>
    </div>

    <!-- Formulir Edit (Awalnya Tersembunyi) -->
    <div id="edit-form" style="display: none; margin-top: 2rem;">
        <form id="form-data" action="{{ route('member.actions') }}" method="post" enctype="multipart/form-data"
            novalidate>
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <textarea id="editor-desc_member" class="desc" name="desc_member">
            <?php 
                if (isset($item['desc_member']) && !empty($item['desc_member'])) { 
                    echo $item['desc_member']; 
                } else { 
                    echo 'Tentang Anda'; 
                } 
            ?>
        </textarea>
                    <div id="feedback-desc_member" class=""></div>
                </div>
            </div>
            <div class="col-xxl-2 col-sm-2 col-2 mt-3">
                <button type="submit" class="btn site-btn btn-kirim">Simpan</button>
            </div>
        </form>
</section>

<style>
    .title span {
        /* Atur gaya untuk elemen span jika diperlukan */
    }

    .title h2 {
        margin-left: 10px;
        /* Sesuaikan jarak antara ikon dan judul */
    }

    #edit-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        resize: vertical;
    }

    .desc {
        border: none;
        border-bottom: 1px solid #DEDEDE;
    }

</style>

<script>
    function toggleEditForm() {
        var editForm = document.getElementById("edit-form");
        var aboutContent = document.getElementById("about-content");

        if (editForm.style.display === "none") {
            editForm.style.display = "block";
            aboutContent.style.display = "none";

            document.getElementById("edited-content").value = aboutContent.innerHTML;
        } else {
            editForm.style.display = "none";
            aboutContent.style.display = "block";
        }
    }

    function saveEditedContent() {
        var editedContent = document.getElementById("edited-content").value;
        document.getElementById("about-content").innerHTML = editedContent;

        document.getElementById("edit-form").style.display = "none";
        document.getElementById("about-content").style.display = "block";
    }

</script>
