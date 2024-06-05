<div class="blog-comments">
    <h3 class="title-comment">Comments (0)</h3>
    <div class="blog-comments-wrapper">
        <ul>
            <li class="blog-comments-single flex-column">
                <div class="blog-comments-content">
                    <h5>Kecia</h5>
                    <span><i class="far fa-clock"></i> May 24, 2023</span>
                    <p>long time no see</p>
                    <a href="#" class="btn-replay"><i class="far fa-reply"></i> Reply</a>
                </div>
                <ul class="ps-4">
                    <li class="blog-comments-single">
                        <div class="blog-comments-content" style="width: 100%">
                            <h5>Kecia</h5>
                            <span><i class="far fa-clock"></i> May 24, 2023</span>
                            <p>long time no see</p>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
        {{-- <div class="blog-comments-single flex-column">
            <div class="blog-comments-content">
                <h5>Kecia A. Parada</h5>
                <span><i class="far fa-clock"></i> May 24, 2023</span>
                <p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
                <a href="#"><i class="far fa-reply"></i> Reply</a>
            </div>
        </div>
        <div class="blog-comments-single blog-comments-reply">
            <div class="blog-comments-content">
                <h5>Thomas A. Lindsey</h5>
                <span><i class="far fa-clock"></i> May 24, 2023</span>
                <p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
                <a href="#"><i class="far fa-reply"></i> Reply</a>
            </div>
        </div>
        <div class="blog-comments-single">
            <div class="blog-comments-content">
                <h5>Mary R. Lujan</h5>
                <span><i class="far fa-clock"></i> May 24, 2023</span>
                <p>There are many variations of passages the majority have suffered in some injected humour or randomised words which don't look even slightly believable.</p>
                <a href="#"><i class="far fa-reply"></i> Reply</a>
            </div>
        </div> --}}
    </div>
    <div class="blog-comments-form">
        <h3>Leave A Comment</h3>
        <form id="comment-news" action="#">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <input type="hidden" name="news_id" value="{{$item['pid']}}"/>
            <input type="hidden" name="nama" value="{{auth()->user()->fullname}}"/>
            <input type="hidden" name="email" value="{{auth()->user()->email}}"/>
            <div class="row">
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" name="nama" placeholder="Your Name*">
                        <p id="feedback-nama"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Your Email*">
                        <p id="feedback-email"></p>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" name="komentar" placeholder="Your Comment*"></textarea>
                        <p id="feedback-komentar"></p>
                    </div>
                    <button type="submit" class="theme-btn btn-submit">Post Comment <i class="far fa-paper-plane"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('js')
@parent

<script>
    $(document).ready(function(){
        getData();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var form = $('#comment-news');
        var btnSubmit = $('.btn-submit');

        form.on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(form[0]);
            postData(formData);
        })

        function postData(data){
            $.ajax({
                url: '{{route('news.comments.post', )}}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function(){
                    btnSubmit.html('Loading...').attr('disabled', true)
                    $('.invalid-feedback').removeClass('invalid-feedback d-block').html('')
                },
                success: function(res){
                    form[0].reset()
                    btnSubmit.html('Post Comment <i class="far fa-paper-plane"></i>').attr('disabled', false)
                    getData()
                },
                error: function(res){
                    var response = res.responseJSON;
                    btnSubmit.html('Post Comment <i class="far fa-paper-plane"></i>').attr('disabled', false)
                    // main.notification(response.message, NOTIFICATION_COLOR.DANGER)
                    if(typeof res.responseJSON.errors === 'object'){
                        Object.keys(response.errors).map((i) => {
                            var message = response.errors[i];
                            $(`#feedback-${i}`).addClass('invalid-feedback d-block').html(message)
                        })
                    }
                }
            })
        }

        function getData(){
            var elm = $('.blog-comments-wrapper')
            $.ajax({
                method: 'GET',
                url: '{{route('news.comments.get', $item['pid'])}}',
                beforeSend: function(){
                    elm.html('<div class="text-center">Loading</div>');
                },
                success: function(res){
                    var html = '<ul>';
                    res.data.map((item) => {
                        html += `<li class="blog-comments-single flex-column">
                <div class="blog-comments-content">
                    <h5>${item.nama}</h5>
                    <span><i class="far fa-clock"></i> ${item.publish_date}</span>
                    <p>${item.komentar}</p>

                </div>

            </li>`;
                    });
                    html += '</ul>';
                    $('.title-comment').html(`Comments (${res.data.length})`)
                    $('.news-comment-top').html(`${res.data.length} Comments`)
                    elm.html(html);
                }

            })
        }
    })
</script>

@endsection
