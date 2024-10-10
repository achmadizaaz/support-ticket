@extends('layouts.guest')

@section('title', 'Terms of use')

@push('head')
    <style>
        .paragraph {
            font-size: 16px;
        }
        ul.ordering li{
            font-size: 16px;
        }
    </style>
@endpush

@section('content')
<div class="container" style="max-width: 720px">
    <div class="mb-3 text-end fst-italic">
        Last Updated: 10 Oktober 2024
    </div>

    <h4>1. Ketentuan Penggunaan</h4>
    <p class="paragraph">
        Dengan mengakses dan menggunakan Sistem Tiket Dukungan (<i>Support Ticket</i>) ini, pengguna setuju untuk mematuhi dan terikat dengan Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan salah satu syarat yang disebutkan, Anda tidak diizinkan untuk menggunakan sistem ini.
    </p>
   

    <h4>2. Deskripsi Layanan</h4>
    <p class="paragraph">
        Sistem Tiket Dukungan (<i>Support Ticket</i>) adalah sistem yang digunakan untuk mengelola dan memantau permintaan dukungan dari pengguna (<i>Support Ticket</i>) Universitas Merdeka Pasuruan. Sistem ini bertujuan untuk memastikan setiap permintaan bantuan atau masalah teknis ditangani dengan baik oleh tim yang berwenang.
    </p>

    <h4>3. Kewajiban Pengguna</h4>
    <p class="paragraph">
        <ul class="ordering">
            <li>Pengguna bertanggung jawab untuk memastikan bahwa semua informasi yang diberikan dalam sistem tiket adalah akurat, jelas, dan lengkap.</li>
            <li>Pengguna dilarang memberikan informasi yang menyesatkan, tidak pantas, atau melanggar hukum.</li>
            <li> Pengguna diharuskan menjaga kerahasiaan akun pengguna mereka dan bertanggung jawab atas semua aktivitas yang dilakukan melalui akun mereka.</li>
        </ul>
    </p>

    
    <h4>4. Penggunaan yang Dilarang</h4>
    <p class="paragraph">
        Pengguna setuju untuk tidak:
        <ul class="ordering">
            <li>Menggunakan sistem untuk keperluan selain urusan dukungan (<i>Support Ticket</i>).</li>
            <li>Menggunakan bahasa kasar, tidak sopan, atau menyinggung dalam tiket yang diajukan.</li>
            <li>Menggunakan sistem untuk mengirimkan materi yang bersifat ilegal, pornografi, kekerasan, atau materi yang melanggar hak pihak ketiga.</li>
        </ul>
    </p>

    <h4>5. Kerahasiaan</h4>
    <p class="paragraph">
        Semua data yang dimasukkan ke dalam sistem ini bersifat rahasia dan hanya digunakan untuk keperluan (<i>Support Ticket</i>). Pengguna dilarang membagikan informasi terkait tiket kepada pihak ketiga tanpa izin.
    </p>

    <h4>6. Batasan Tanggung Jawab</h4>
    <p class="paragraph">
        Universitas Merdeka Pasuruan tidak bertanggung jawab atas kerugian yang mungkin timbul akibat penggunaan sistem ini, termasuk namun tidak terbatas pada:
        <ul class="ordering">
            <li>Keterlambatan dalam menangani tiket..</li>
            <li>Kesalahan atau kelalaian dalam pengolahan tiket.</li>
            <li>Gangguan teknis atau kegagalan sistem.</li>
        </ul>
    </p>

    <h4>7. Perubahan Ketentuan Penggunaan</h4>
    <p class="paragraph">
        Universitas Merdeka Pasuruan berhak untuk mengubah atau memperbarui Syarat dan Ketentuan ini sewaktu-waktu. Pengguna akan diinformasikan tentang perubahan yang dilakukan, dan penggunaan sistem setelah perubahan dianggap sebagai persetujuan pengguna terhadap Syarat dan Ketentuan yang baru.
    </p>

    <h4>8. Penutupan Akun</h4>
    <p class="paragraph">
        Universitas Merdeka Pasuruan berhak menangguhkan atau menghapus akun pengguna yang melanggar Syarat dan Ketentuan ini atau menggunakan sistem dengan cara yang tidak semestinya.
    </p>

    <h4> 9. Kontak </h4>
    <p class="paragraph">
        Jika Anda memiliki pertanyaan mengenai Syarat dan Ketentuan ini, Anda dapat menghubungi tim dukungan (<i>Support Ticket</i>) melalui achmadizaaz@unmerpas.ac.id.
    </p>
</div>
@endsection