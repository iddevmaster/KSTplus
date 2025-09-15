<x-app-layout>
    <div class="container py-5">
        {{-- <div class="text-center text-4xl font-bold uppercase mb-5">
            ออกรายงาน
        </div> --}}
        <div class="row justify-center">
            <div class="card" id="printableArea">
                <div class="flex flex-col items-center">
                    <p class="text-lg font-bold">{{ Auth::user()->agnName->name }}</p>
                    <p class="text-lg font-bold">รายงานผลการทดสอบ</p>
                </div>
                <div class="grid grid-cols-3 py-3">
                    <p class="text-md col-span-3">{{ __('messages.quiz') }}: {{ $quiz->title }}</p>
                    <p class="text-sm">ผู้ทดสอบ: {{ $tester_name }}</p>
                    <p class="text-sm">วันที่ทดสอบ: {{ $startDate }}</p>
                    <p class="text-sm">เวลาที่ใช้: {{ $timeUsege->format('%i ชม. %s นาที') }}</p>
                    <p class="text-sm">คะแนน: {{ $scores }}/{{ $totalScore }}</p>
                    <p class="text-sm">ผลการทดสอบ:
                        {{ $scores > ($totalScore * $quiz->pass_score) / 100 ? 'ผ่าน' : 'ไม่ผ่าน' }}</p>
                </div>

                <div class="mb-2">
                    <table>
                        <thead>
                            <tr class="text-center">
                                <th>ข้อที่</th>
                                <th>คำถาม</th>
                                <th>คำตอบ</th>
                                <th>คะแนน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quests as $qindex => $quest)
                                <tr>
                                    <td class="text-center">{{ $qindex + 1 }}</td>
                                    <td class="text-sm">{!! strip_tags($quest->title, '<img><br>') !!}</td>
                                    <td class="text-sm">
                                        @if ($quest->type)
                                            (C)
                                            @foreach ($quest->answer as $aindex => $choice)
                                                @if ($choice['id'] == $answers[$quest->id]['ans'])
                                                    {{ $aindex + 1 }}. {{ $choice['text'] }}
                                                @endif
                                            @endforeach
                                        @else
                                            (T)
                                            {{ $answers[$quest->id]['ans'] }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $answers[$quest->id]['status'] == 1 ? $quest->score : '0' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer class="flex justify-between">
                        <p class="text-xs">*T = คำตอบแบบอัตนัย , C = คำตอบแบบปรนัย</p>
                        <p class="text-xs">Printed from <u>https://kstplus.iddrives.co.th</u> at {{ now() }}</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    window.onload = function () {
        window.print();
    }
</script>
<style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
    }

    #printableArea {
        font-family: 'THSarabunNew';
        width: 210mm;
        min-height: 260mm;
        padding: 1cm;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        margin: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: start;
        font-size: 14px;
    }

    table>thead>tr>th {
        border: 1px solid black;
        padding: 5px;
        background-color: #f1f1f1;
    }

    table>tbody>tr>td {
        border: 1px solid black;
        padding: 5px;
    }

    /* #printableArea > footer {
        margin-top: 0px;
        text-align: end;
        font-size: 10px;
    } */

    @media print {
        body * {
            visibility: hidden;
        }

        #printableArea, #printableArea * {
            visibility: visible;
        }

        #printableArea {
            position: absolute;
            left: 0;
            top: 0;
            box-shadow: none !important;
            border: none !important;
            width: 100%;
        }
    }

</style>
