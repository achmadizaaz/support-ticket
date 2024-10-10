<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Ticket</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body{
            font-size: 12px;
            font-family: "Poppins", sans-serif;
            margin: 0
        }

        .container{
            position: relative;
            width: 1200px;
            margin: 0 auto;
        }

        .navbar {
            background: #dddcdc;
            height: 80px;
            margin-bottom: 10px;
        }

        .navbar .title {
            position: absolute;
            font-size: 24px;
            font-weight: 500;
            top:18px;
        }

        .navbar .back {
            position: absolute;
            right: 140px;
            top: 20px;
            padding: 10px 15px;
        }

        .navbar .btn-back {
            background: #4c4d4c;
            background-image: -webkit-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: -moz-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: -ms-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: -o-linear-gradient(top, #4c4d4c, #2b2d2b);
            background-image: linear-gradient(to bottom, #4c4d4c, #2b2d2b);
            -webkit-border-radius: 13;
            -moz-border-radius: 13;
            border-radius: 13px;
            font-family: Arial;
            color: #ffffff;
            font-size: 14px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }

        .navbar .print {
            position: absolute;
            right: 0;
            top: 20px;
            padding: 10px 15px;
        }
        .navbar .btn-print {
            background: #45e868;
            background-image: -webkit-linear-gradient(top, #27de4e, #35c441);
            background-image: -moz-linear-gradient(top, #27de4e, #35c441);
            background-image: -ms-linear-gradient(top, #27de4e, #35c441);
            background-image: -o-linear-gradient(top, #27de4e, #35c441);
            background-image: linear-gradient(to bottom, #27de4e, #35c441);
            -webkit-border-radius: 13;
            -moz-border-radius: 13;
            border-radius: 13px;
            font-family: Arial;
            color: #ffffff;
            font-size: 14px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }

        .navbar a.btn-print {
            text-color:#fff;
            text-decoration: none;
        }

        .navbar .btn-print:hover {
            background: #3cfc76;
            background-image: -webkit-linear-gradient(top, #3cfc76, #1ad251);
            background-image: -moz-linear-gradient(top, #3cfc76, #1ad251);
            background-image: -ms-linear-gradient(top, #3cfc76, #1ad251);
            background-image: -o-linear-gradient(top, #3cfc76, #1ad251);
            background-image: linear-gradient(to bottom, #3cfc76, #1ad251);
            text-decoration: none;
        }
        .header {
            position: relative;
            width: 1200px;
            height: 60px;
            padding: 30px 0;
            margin-bottom: 30px;
            border-bottom: 1px solid #cecece;
        }
        .logo {
            position: absolute;
            top:10px;
            left:0;

        }
        .header-body {
            float: left;
            width: 100%;
            text-align: center;
            line-height: 1.6em;

        }

        .header-title {
            font-size: 22px;
            font-weight: 600;
        }

        .headline {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .flex-info {
            display: flex;
            flex-wrap: wrap;
            font-size: 12px;
        }
        .flex-info td:first-child{
            width: 100px;
        }
        .flex-info-left {
            flex: 50%;
            text-align: left;
        }
        .flex-info-right {
            flex: 50%;
            text-align: left;
        }
        table.table-data {
            border-collapse: collapse;
        }
        .table-data{
            width: 100%;
        }
        .table-data th {
            text-align: left;
            padding:4px 8px;
        }
        .table-data td {
            text-align: left;
            padding:4px 8px;
        }
        .thead-data {
            display: none
        }

        .footer {
            text-align: right;
            margin-top:30px;
            padding: 10px 0;
        }

        @media print {
            body {
                margin: 0.1cm 0.1cm 0.1cm 0.1cm;
            }

            #navbar {
                display: none;

            }
            .header {
                width: 100%
            }
            
            .header-body{
                font-size:11px;
            }

            .container {
                width:100%;
                margin-top: 10px;
            }

        }


    </style>
</head>
<body>
    @php
        $option = \App\Models\Option::whereIn('name', ['favicon'])->get()->keyBy('name'); 
    @endphp

    <div class="navbar" id="navbar">
        <div class="container">
            <div class="title">
                Report Support Ticket
            </div>
            <div class="back">
                <a href="{{ route('report.ticket') }}" class="btn-back">
                    Kembali
                </a>
            </div>
            <div class="print">
                <a href="#print" class="btn-print" onclick="window.print()">
                    Cetak Halaman
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Start Header Report -->
        <div class="header" id="header">
            <div class="logo">
                <img src="{{ asset($option['favicon']->value ? 'storage/'. $option['favicon']->value : 'assets/images/laravel.png') }}" alt="logo-sm" width="85" height="85">
            </div>
            <div class="header-body">
                <div class="header-title" style="margin-bottom:5px">
                    Universitas Merdeka Pasuruan
                </div>
                <div class="header-address">
                    Jl. Ir. H. Juanda No.68, Tapaan, Kec. Bugul Kidul, Kota Pasuruan, Jawa Timur 67129
                </div>
                <div class="header-contact">
                    Website : unmerpas.ac.id / e-Mail : humas@unmerpas.ac.id / Telepon : (0343) 413619
                </div>
            </div>
        </div>
        <!-- End Header Report -->
        <br>

        <div class="headline">
            Report Support Ticket
        </div>

        <!-- Start Info -->
        <div class="flex-info">
            <div class="flex-info-left">
               <table>
                    <tr>
                        <td style="width: 100px">Status</td>
                        <td>:</td>
                        <td>{{ ucwords($status) }}</td>
                    </tr>
                    <tr>
                        <td >Role</td>
                        <td>:</td>
                        <td>{{ ucwords($role) }}</td>
                    </tr>
               </table>
            </div>
            <div class="flex-info-right">
                <table>
                    <tr>
                        <td>Date</td>
                        <td>:</td>
                        <td>
                            @if ($start_date == $end_date)
                                {{ $start_date }}
                                @else
                                {{ $start_date }} s/d  {{ $end_date }}
                            @endif
                        </td>
                    </tr>
               </table>
            </div>
        </div>
        <!-- End Info -->
        <br>

        <!-- Start Data User -->
        <table border="1" class="table-data">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Subject</th>
                {{-- <th>Message</th> --}}
                <th>Status</th>
                <th>Created at</th>
            </thead>
            <tbody>
                @if ($reports->count() == 0)
                    <tr>
                        <td colspan="8" style="background: #fff8a8">Data tidak ditemukan</td>
                    </tr>
                @endif
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ $report->subject }}</td>
                        <td>{{ $report->status }}</td>
                        <td>{{ $report->created_at }}</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
        <!-- End Data User -->
        {{-- \Carbon\Carbon::now()->translatedFormat --}}
        <div class="footer">
            <div class="foot-date">
                Pasuruan, {{ now()->translatedFormat('d F Y') }}
            </div>
            <div class="foot-name">
                Universitas Merdeka Pasuruan
            </div>
        </div>
    </div> <!-- End Container   -->

</body>
</html>