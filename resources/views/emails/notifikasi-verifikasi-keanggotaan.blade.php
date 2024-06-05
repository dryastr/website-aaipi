@if ($status_approval == 'ditolak')
    <p>Halo,</p>
    <p>Akun anda telah diperiksa oleh tim layanan keanggotaan dengan keputusan ditolak. Dengan alasan {{$catatan}} </p>
    <p>Mohon untuk registrasi ulang akun anda.</p>
@else
    <p>Hore! Akun anda telah diverifikasi oleh tim layanan keanggotaan</p>
    <p>Silakan login ke akun Anda dan mulailah menikmati layanan keanggotaan kami. <a href="{{$link}}" class="button" target="_blank">Link Tautan</a></p>
    <p>Jangan lupa untuk membayar iuran keanggotaan Anda agar tetap dapat menikmati manfaat layanan kami</p>
    <p>Jika Anda memerlukan bantuan atau informasi lebih lanjut mengenai pembayaran iuran, jangan ragu untuk menghubungi tim layanan keanggotaan.</p>
    <p>Terima kasih sudah bergabung dengan kami!</p>
@endif

<p>Salam,</p>
<p>Tim Layanan Keanggotaan</p>
