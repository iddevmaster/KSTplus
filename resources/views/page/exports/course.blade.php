<!DOCTYPE html>
<html lang="th">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        :root {
            font-size: 16px;
        }
        body {
            font-family: 'THSarabunNew';
            width: 794px;
            height: 1123px;
        }
        header {
            text-align: center;
        }
        header > h3 {
            margin-top: 5px;
            margin-bottom: 0px;
        }
        header > p {
            margin-top: 5px;
        }
        section {
            display: flex;
            justify-content: center;
        }
        section > table {
            width: 90%;
            border-collapse: collapse;
            text-align: start;
        }
        section > table > thead > tr > th {
            border: 1px solid black;
            padding: 5px;
            background-color: #f1f1f1;
        }
        section > table > tbody > tr > td {
            border: 1px solid black;
            padding: 5px;
        }
        footer {
            margin-top: 0px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="/img/logo.png" width="100" alt="">
        <h3>ศูนย์ฝึกอบรมเทรนนิ่งเซนเตอร์</h3>
        <p>รายงานหลักสูตร</p>
    </header>
    <section>
        <table>
            <thead>
                <tr>
                    <th>รหัสหลักสูตร</th>
                    <th>ชื่อหลักสูตร</th>
                    <th>{{ __('messages.Lecturer') }}</th>
                    <th>{{ __('messages.Dpm') }}</th>
                    <th>{{ __('messages.student') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    @php
                        $total_student = App\Models\user_has_course::where('course_id', $course->id)->count();
                    @endphp
                    <tr>
                        <td>{{ $course->code }}</td>
                        <td>
                            {{ $course->title }}</td>
                        <td>{{ optional($course->getTeacher)->name }}</td>
                        <td>{{ optional($course->getDpm)->name }}</td>
                        <td>{{ $total_student }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <footer>
        <p>Printed from <u>https://smarthub.trainingzenter.com</u> at {{ now() }}</p>
    </footer>
</body>
</html>
