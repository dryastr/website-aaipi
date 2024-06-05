@php
    $nav = [
        [
            'url_name' => 'profile.index',
            'title' => 'Informasi Umum',
            'icon' => 'fas fa-id-card'
        ],
        [
            'url_name' => 'profile.change-password',
            'title' => 'Ubah Password',
            'icon' => 'fas fa-unlock-alt'
        ],
    ];

    if($user['role_id'] != 1){
        array_push($nav, [
            'url_name' => 'profile.aktifasi-keanggotaan',
            'title' => 'Aktifasi Keanggotaan',
            'icon' => 'fas fa-money-bill-wave-alt'
        ]);
    }
@endphp

<ul class="nav nav-pills" id="animateLine" role="tablist">
    @foreach($nav as $item)
    <li class="nav-item" role="presentation">
        <a href="{{route($item['url_name'])}}" @class(['nav-link', 'active' => Route::is($item['url_name'])])>
            <i class="{{$item['icon']}}"></i> {{$item['title']}}
        </a>
    </li>
    @endforeach
</ul>
