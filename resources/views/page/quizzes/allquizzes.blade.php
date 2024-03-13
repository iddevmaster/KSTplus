<x-app-layout>
    <div class="py-10">
        <div class="px-4 max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <p class="fs-2 fw-bold">{{ __('messages.quiz') }}</p>

                <!-- Add quiz Modal -->
                <button data-modal-target="static-modal" data-tooltip-target="tooltip-add" data-modal-toggle="static-modal" class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center " type="button">
                    <i class="bi bi-journal-plus"></i>
                </button>
                <div id="tooltip-add" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    {{ __('messages.add_quiz') }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>

                <!-- Main modal -->
                <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow ">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                <h3 class="text-xl font-semibold text-gray-900 ">
                                    {{ __('messages.add_quiz') }}
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center " data-modal-hide="static-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">{{ __('messages.close') }}</span>
                                </button>
                            </div>
                            <form action="{{ route('quiz.store') }}" method="post">
                                @csrf
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <div class="grid grid-cols-4 mb-4">
                                        <div class="col-span-1 self-center"><p>{{ __('messages.quiz_name') }} :</p></div>
                                        <div class="col-span-3"><input type="text" id="first_name" name="quizname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="{{ __('messages.input_name') }}" required></div>
                                    </div>
                                    <div class="grid grid-cols-4 mb-4">
                                        <div class="col-span-1 self-center"><p>{{ __('messages.time_lim') }} :</p></div>
                                        <div class="col-span-3 flex">
                                            <input type="number" id="first_name" name="timelimit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 " value="{{0}}">
                                            <p class="self-center ms-1">{{ __('messages.minute') }}.</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4 mb-4">
                                        <div class="col-span-1 self-center"><p>{{ __('messages.pass_sc') }} :</p></div>
                                        <div class="col-span-3 flex">
                                            <input type="number" id="first_name" name="passScore" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 " value="{{50}}">
                                            <p class="self-center ms-1">%</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4">
                                        <div class="col-span-1 self-center"></div>
                                        <div class="col-span-3 flex">
                                            <div class="flex items-center mb-2">
                                                <input id="default-checkbox" type="checkbox" name="shuffq" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                                <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.shuff_ques') }}.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4">
                                        <div class="col-span-1 self-center"></div>
                                        <div class="col-span-3 flex">
                                            <div class="flex items-center mb-4">
                                                <input id="default-checkbox" type="checkbox" name="showAns" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                                <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.show_ans') }}.</label>
                                            </div>
                                        </div>
                                    </div>
                                    @if($errors->any())
                                        <div class="alert alert-danger mt-2">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">{{ __('messages.save') }}</button>
                                    <button data-modal-hide="static-modal" type="button" class="ms-3 text-gray-500 hover:text-white hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-red-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">{{ __('messages.cancel') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-white uppercase bg-gray-700 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.title') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.course') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.time_lim') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.pass_sc') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.shuff') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizs as $index => $quiz)
                                <tr class="bg-white border-b  hover:bg-gray-50 ">
                                    <th class="px-6 py-4">
                                        {{ $index+1 }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $quiz->title }}
                                    </th>
                                    <th class="px-6 py-4">
                                        @foreach ($quiz->for_courses as $item)
                                            <p>{{$item}}</p>
                                        @endforeach
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $quiz->time_limit ? $quiz->time_limit : "None" }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $quiz->pass_score }}%
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $quiz->shuffle_quest ? "Yes" : "No" }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" data-modal-target="static-modal{{$quiz->id}}" data-tooltip-target="tooltip-edit" data-modal-toggle="static-modal{{$quiz->id}}" class="text-lg text-blue-400  hover:text-blue-700 hover:underline"><i class="bi bi-pencil-square"></i></a>
                                        <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('messages.edit') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <!-- Main modal -->
                                        <div id="static-modal{{$quiz->id}}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow ">
                                                    <!-- Modal header -->
                                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                                        <h3 class="text-xl font-semibold text-gray-900 ">
                                                            {{ __('messages.edit_quiz') }}
                                                        </h3>
                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center " data-modal-hide="static-modal{{$quiz->id}}">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                            <span class="sr-only">{{ __('messages.cancel') }}</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('quiz.update', ['id' => $quiz->id]) }}" method="post">
                                                        @csrf
                                                        <!-- Modal body -->
                                                        <div class="p-4 md:p-5 space-y-4">
                                                            <div class="grid grid-cols-4 mb-4">
                                                                <div class="col-span-1 self-center"><p>{{ __('messages.quiz_name') }} :</p></div>
                                                                <div class="col-span-3"><input value="{{$quiz->title}}" type="text" id="first_name" name="quizname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="{{ __('messages.input_name') }}" required></div>
                                                            </div>
                                                            <div class="grid grid-cols-4 mb-4">
                                                                <div class="col-span-1 self-center"><p>{{ __('messages.time_lim') }} :</p></div>
                                                                <div class="col-span-3 flex">
                                                                    <input type="number" id="first_name"  name="timelimit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 " value="{{$quiz->time_limit}}">
                                                                    <p class="self-center ms-1">{{ __('messages.minute') }}.</p>
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-4 mb-4">
                                                                <div class="col-span-1 self-center"><p>{{ __('messages.pass_sc') }} :</p></div>
                                                                <div class="col-span-3 flex">
                                                                    <input type="number" id="first_name" name="passScore" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 " value="{{$quiz->pass_score}}">
                                                                    <p class="self-center ms-1">%</p>
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-4">
                                                                <div class="col-span-1 self-center"></div>
                                                                <div class="col-span-3 flex">
                                                                    <div class="flex items-center mb-4">
                                                                        <input id="default-checkbox" type="checkbox" {{$quiz->shuffle_quest ? 'checked' : ''}} name="shuffq" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                                                                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.shuff_ques') }}.</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-4">
                                                                <div class="col-span-1 self-center"></div>
                                                                <div class="col-span-3 flex">
                                                                    <div class="flex items-center mb-4">
                                                                        <input id="default-checkbox" type="checkbox" name="showAns" {{$quiz->showAns ? 'checked' : ''}} value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                                                                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.show_ans') }}.</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($errors->any())
                                                                <div class="alert alert-danger mt-2">
                                                                    <ul>
                                                                        @foreach($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                                                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">{{ __('messages.save') }}</button>
                                                            <button data-modal-hide="static-modal{{$quiz->id}}" type="button" class="ms-3 text-gray-500 hover:text-white hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-red-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">{{ __('messages.cancel') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="#" data-quiz-id="{{$quiz->id}}" data-tooltip-target="tooltip-delete" class="delQuizBtn text-lg text-red-500  hover:text-red-700 hover:underline"><i class="bi bi-trash3"></i></a>
                                        <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('messages.delete') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <a href="{{route('quiz.detail', ['id' => $quiz->id])}}" data-tooltip-target="tooltip-detail" class="text-lg text-purple-500  hover:text-purple-700 hover:underline"><i class="bi bi-box-arrow-in-right"></i></a>
                                        <div id="tooltip-detail" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('messages.detail') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <a href="{{ route('quiz.record', ['qid' => $quiz->id]) }}" data-tooltip-target="tooltip-record" class="text-lg text-emerald-500  hover:text-emerald-700 hover:underline"><i class="bi bi-clipboard2-data"></i></a>
                                        <div id="tooltip-record" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('messages.record') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <a href="#" data-quiz-id="{{$quiz->id}}" data-tooltip-target="tooltip-copy" class="copyQuizBtn text-lg text-yellow-500  hover:text-yellow-700 hover:underline"><i class="bi bi-copy"></i></a>
                                        <div id="tooltip-copy" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            {{ __('copy') }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
                title: "Quiz has not been saved."
            });
            console.log("Error: {{ session('error') }}");
        @endif

        $(document).ready(function() {
            $('.delQuizBtn').click(function() {
                // Get the notification ID from the data attribute
                const delQuizId = $(this).data('quiz-id');
                Swal.fire({
                    title: `{{ __('messages.rusure') }}?`,
                    text: "{!! __('messages.rusure_sub') !!}!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/quiz/delete/' + delQuizId, // You need to define this route in your web.php
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                // You can add some code here to handle a successful response
                                if (response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Quiz has been deleted.',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload()
                                        }
                                    });
                                    console.log("success: ",response.success);
                                } else {
                                    Swal.fire(
                                        'Sorry!',
                                        'Quiz has not deleted.',
                                        'error'
                                    );
                                    console.log("error: ",response.error);
                                };
                                // window.location.reload()
                            },
                            error: function(error) {
                                // You can add some error handling here
                                Swal.fire(
                                    'Sorry!',
                                    'Quiz has not deleted.',
                                    'error'
                                )
                                console.log("error: ",error);
                            }
                        });
                    }
                })

            });

            $('.copyQuizBtn').click(function() {
                // Get the notification ID from the data attribute
                const copyQuizId = $(this).data('quiz-id');
                Swal.fire({
                    title: `{{ __('messages.rusure') }}?`,
                    text: "{!! __('messages.rusure_sub') !!}!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, copy it!',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/quiz/copy/' + copyQuizId, // You need to define this route in your web.php
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                // You can add some code here to handle a successful response
                                if (response.success) {
                                    console.log("success: ",response.success);
                                    Swal.fire(
                                        'Successed!',
                                        'Quiz has been copied.',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload()
                                        }
                                    });
                                } else {
                                    Swal.fire(
                                        'Sorry!',
                                        'Quiz has not copied.',
                                        'error'
                                    );
                                    console.log("error: ",response.error);
                                };
                                // window.location.reload()
                            },
                            error: function(error) {
                                // You can add some error handling here
                                Swal.fire(
                                    'Sorry!',
                                    'Quiz has not copied.',
                                    'error'
                                )
                                console.log("error: ",error);
                            }
                        });
                    }
                })

            });
        });
    });
</script>
