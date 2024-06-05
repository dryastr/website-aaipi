<p>Halo,</p>
@if ($status == 'ditolak')
<p>Bukti pembayaran keanggotaan anda telah diperiksa oleh tim layanan keanggotaan dengan keputusan ditolak. Dengan alasan {{$catatan}} </p>
<p>Mohon untuk mengirimkan kembali bukti pembayaran ke halaman yang telah disediakan.</p>
@else
<p>Bukti pembayaran keanggotaan anda telah diverifikasi oleh tim layanan keanggotaan.</p>
<p>Terima kasih!</p>
@endif

<p>Salam,</p>

<p>Tim Layanan Keanggotaan</p>
