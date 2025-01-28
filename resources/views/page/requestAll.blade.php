<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">{{ __('messages.Request All') }}</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end">
                <a href="{{ route('add-req') }}"><button class="btn btn-success" id="addBtn"><i class="bi bi-plus-lg"></i>{{ __('messages.Add') }}</button></a>
            </div>

            <div class="sm:rounded-lg p-4 row gap-3 justify-center">
                @foreach ($requests as $index => $req)
                    <div class="max-w-sm p-6 border-sm  border-gray-200 rounded-lg shadow {{ $req->status === '1' ? 'bg-green-200' : ($req->status === '2' ? 'bg-red-200' : 'bg-white') }}">
                        @if ($req->type === 'course')
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">คำขอเพิ่มหลักสูตร</h5>
                            </a>
                        @else
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">คำขออื่นๆ</h5>
                            </a>
                        @endif
                        <div class="">
                            <p class="font-normal text-gray-700">จาก: {{ $req->getUser->name }}</p>
                            @if ($req->target === '-')
                                <p class="font-normal text-gray-700">ให้: {{ $req->target }}</p>
                            @else
                                <p class="font-normal text-gray-700">ให้: {{ optional($req->getTarget)->name }}</p>
                            @endif
                            <p class="font-normal text-gray-700">เมื่อ: {{ Carbon\Carbon::parse($req->created_at)->setTimezone('Asia/Bangkok')->locale('th')->thaidate('j M Y') }}</p>
                        </div>
                        <div class="mb-3">
                            @if ($req->type === 'course')
                                <p class="font-normal text-gray-700">หลักสูตร:</p>
                                @foreach ((App\Models\course::whereIn('id', json_decode($req->content, true))->pluck('code', 'title') ?? []) as $title => $code)
                                    <p class="font-normal text-gray-700 ms-4">- {{ $code }} :: {{ $title }}</p>
                                @endforeach
                            @else
                                <p class="font-normal text-gray-700">ข้อความ:</p>
                                <p class="font-normal text-gray-700 ms-4">{{ $req->content }}</p>
                            @endif
                        </div>

                        @if ($req->status === '0')
                            @hasanyrole('staff|admin')
                                <a href="#" data-alert-id="{{ $req->id }}" class="finishBtn inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                                    สำเร็จ
                                </a>
                                <a href="#" data-alert-id="{{ $req->id }}" class="failBtn inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800">
                                    ไม่สำเร็จ
                                </a>
                            @else
                                <p class="w-100 justify-center inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-500 rounded-lg">
                                    กำลังดำเนินการ
                                </p>
                            @endhasanyrole
                        @elseif ($req->status === '1')
                            <button data-tooltip-target="tooltip-default" type="button" class="w-100 justify-center inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg">
                                ดำเนินการสำเร็จ
                            </button>
                            <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                ผู้ดำเนินการ: {{ optional($req->getFinish)->name }} <br>
                                วันที่ดำเนินการ: {{ Carbon\Carbon::parse($req->created_at)->setTimezone('Asia/Bangkok')->locale('th')->thaidate('j M Y') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @else
                            <button data-tooltip-target="tooltip-default" type="button" class="w-100 justify-center inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg">
                                ดำเนินการไม่สำเร็จ
                            </button>
                            <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                ผู้ดำเนินการ: {{ optional($req->getFinish)->name }} <br>
                                วันที่ดำเนินการ: {{ Carbon\Carbon::parse($req->created_at)->setTimezone('Asia/Bangkok')->locale('th')->thaidate('j M Y') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        @if(session('success'))
        Swal.fire({
            icon: "success",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            title: "{{ session('success') }}"
        });
        @elseif (session('error'))
            Swal.fire({
                icon: "error",
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                title: 'Sorry, something wrong!'
            });
            console.log("Error: {{ session('error') }}");
        @endif

        $(document).ready(function() {
            $('.finishBtn').click(function() {
                // Get the notification ID from the data attribute
                var notificationId = $(this).data('alert-id');

                // Send an AJAX request to mark the notification as read
                $.ajax({
                    url: '/notifications/mark-as-finish/' + notificationId, // You need to define this route in your web.php
                    type: 'GET',
                    success: function(response) {
                        // You can add some code here to handle a successful response
                        console.log(response['response']);
                    },
                    error: function(error) {
                        // You can add some error handling here
                        console.log(error);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.failBtn').click(function() {
                // Get the notification ID from the data attribute
                var notificationId = $(this).data('alert-id');

                // Send an AJAX request to mark the notification as read
                $.ajax({
                    url: '/notifications/mark-as-fail/' + notificationId, // You need to define this route in your web.php
                    type: 'GET',
                    success: function(response) {
                        // You can add some code here to handle a successful response
                        console.log(response['response']);
                    },
                    error: function(error) {
                        // You can add some error handling here
                        console.log(error);
                    }
                });
            });
        });
    </script>
</x-app-layout>
