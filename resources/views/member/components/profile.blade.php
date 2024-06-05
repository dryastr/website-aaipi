<div class="profile">
    <div class="profile-name">
        <img src="/assets/img/logo/logo-aaipi-member-area.png" style="width: 70%;" alt="AAIPI Logo">
    </div>
    <div class="profile-name">
        <span class="name">{{ $user['fullname'] }}</span><br>
        <span class="job">{{ isset($user['role']['name']) ? $user['role']['name'] : '' }}</span>
    </div>
    <figure class="profile-image">
        <img src="{{ asset($user['avatar_url'] ?? 'src/member/images/profile.jpg') }}" alt="Profile Image">
    </figure>
    <ul class="profile-information">
        <li></li>
        <li><p><span>NIP/NRP:</span> {{ $user['nip'] ?? $user['nrp'] ?? "-" }} <i class="fa fa-copy" style="margin-left: 10%"></i></p></li>
        <li><p><span>Jabatan:</span>  {{ $user['nama_jenjang_jabatan'] ?? "-" }}</p></li>
        <li><p><span>Unit Kerja:</span> {{ $user['nama_unit'] ?? "-" }}</p></li>
        <li><p><span>Email:</span> {{ $user['email'] }}</p></li>
        <li><p><span>Phone:</span> {{ $user['mobile'] ?? "-" }}</p></li>
    </ul>
    <div class="col-md-12">
        @if($user['role_id'] == 2)
          <a href="{{ route("member.change-profile.index") }}" class="site-btn icon">Lihat Profile <i class="fa fa-user" aria-hidden="true"></i></a>
        @else
            <a href="{{ route("member.change-profile.index") }}" class="site-btn icon">Ubah Profile <i class="fa fa-user" aria-hidden="true"></i></a>
        @endif

        <a href="{{route("member.change-password.index")}}" class="site-btn icon">Ubah Password <i class="fa fa-lock" aria-hidden="true"></i></a>
        @if($user['role_id'] != 2)
        <a href="{{route("member.riwayat-pendidikan.index")}}" class="site-btn icon">Riwayat Pendidikan <i class="fa fa-graduation-cap" aria-hidden="true"></i></a>
        <a href="{{route("member.riwayat-pekerjaan.index")}}" class="site-btn icon">Riwayat Pekerjaan <i class="fa fa-briefcase" aria-hidden="true"></i></a>
        @endif
        <a href="{{route("member.auth.logout")}}" class="site-btn icon">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
    </div>
</div>
