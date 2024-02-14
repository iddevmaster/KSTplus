<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight d-flex justify-content-between">
            <p>{{$quiz->title}}</p>
        </div>
    </x-slot>
    <div class="container pt-5">
        <div class="max-w-7xl mx-auto">
            <form action="{{ route('quiz.quest.store', ['id' => $id]) }}" method="post">
                @csrf
                <div class="card px-4 py-4">
                    <p class="fw-bold text-2xl mb-4">{{ __('messages.add_ques') }}</p>
                    <div class="mb-4 border-b border-gray-200 ">
                        <div class="grid grid-cols-8 mb-3">
                            <p class="self-center col-span-8 sm:col-span-2 md:col-span-2 lg:sm:col-span-1 text-lg">{{ __('messages.ques_title') }}: </p>
                            <div class="col-span-8 sm:col-span-6 block w-full">
                                <textarea name="title"  id="myeditorinstance"></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-8 mb-3">
                            <p class="self-center text-xs sm:text-lg ">{{ __('messages.ques_score') }}: </p>
                            <input type="number" id="score" min="1" max="100" name="score" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " value="{{1}}">
                            <p class="self-center text-xs ms-2 text-gray-400">{{ __('messages.number') }} 1 - 100</p>
                        </div>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-8 mb-3">
                            <p class="self-center text-lg"></p>
                            <div class="flex items-center mb-4">
                                <input id="shuff" name="shuffle" type="checkbox" checked value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                <label for="shuff" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.shuff_choice') }}</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-8 mb-3">
                            <p class="self-center text-xs sm:text-lg">{{ __('messages.ans_type') }}:</p>
                            <div class="flex gap-4 col-span-2">
                                <div class="flex items-center">
                                    <input checked id="default-radio-1" type="radio" value="1" name="ansType" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                    <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.ans_choice') }}</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="default-radio-2" type="radio" value="0" name="ansType" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                                    <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.ans_text') }}</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mt-4">
                            <p class="text-lg">{{ __('messages.answer') }}:</p>
                            <p class="text-xs mb-2 text-yellow-500">{{ __('messages.note') }}: {{ __('messages.pls_add_ans') }}</p>
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="flex inline-block p-2 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                        <svg class="w-4 h-4 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 1h10M6 5h10M6 9h10M1.49 1h.01m-.01 4h.01m-.01 4h.01"/>
                                        </svg>
                                        {{ __('messages.ans_choice') }}
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="flex inline-block p-2 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 " id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                                        <svg class="w-4 h-4 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279"/>
                                        </svg>
                                        {{ __('messages.ans_text') }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="default-tab-content">
                        <div class="flex flex-wrap hidden p-2 ps-5 rounded-lg bg-gray-50 " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="grow">
                                <ol class="list-decimal" id="choiceList">
                                    <li class="mb-2">
                                        <div class="flex gap-4">
                                            <input type="text" id="choice1" maxlength="1000" name="choice1" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input choice text" />
                                            <div class="flex items-center">
                                                <input id="default-checkbox1" name="answer1" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                                <label for="default-checkbox1" class="ms-2 text-xs sm:text-sm font-medium text-gray-900 ">{{ __('messages.answer') }}</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mb-2">
                                        <div class="flex gap-4">
                                            <input type="text" id="choice2" maxlength="1000" name="choice2" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input choice text"/>
                                            <div class="flex items-center">
                                                <input id="default-checkbox2" name="answer2" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                                <label for="default-checkbox2" class="ms-2 text-xs sm:text-sm font-medium text-gray-900 ">{{ __('messages.answer') }}</label>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                                <input type="hidden" name="choices" id="lastChoice" value="2">
                            </div>
                            <div class="p-4 flex justify-center">
                                <button type="button" id="addAns" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 "><i class="bi bi-plus-lg"></i> {{ __('messages.add') }}</button>
                            </div>
                        </div>
                        <div class="hidden p-4 rounded-lg bg-gray-50 " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <input type="text" id="choice2" name="writing" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input answer" />
                        </div>
                    </div>
                    <div class="mt-20">
                        <button type="submit" class="transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">
                            {{ __('messages.save') }}
                        </button>
                        <a href="{{route('quiz.detail', ['id' => $id])}}">
                            <button type="button" class="transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">
                                {{ __('messages.cancel') }}
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.tiny.cloud/1/4vdoimdjlqj1524p4qwd6k1jg1w71ys0syull57gnp048kgf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                'media', 'table', 'emoticons', 'template'
            ],
            // toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table emoticons fullscreen',
            toolbar: false,
            height: 200,
            menubar: 'file edit view insert format table',
        });
    </script>
</x-app-layout>
<script>
    $(document).ready(function() {
        var count = $('#choiceList li').length;
        $('#addAns').on('click', function() {
            count++;

            // Append the new li
            $('#choiceList').append(`
                <li class="mb-2">
                    <div class="flex gap-4">
                        <input type="text" id="choice${count}" name="choice${count}" maxlength="1000" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input choice text"/>
                        <div class="flex items-center">
                            <input id="default-checkbox${count}" name="answer${count}" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                            <label for="default-checkbox${count}" class="ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.answer') }}</label>
                        </div>
                    </div>
                </li>
            `);

            // Update the lastChoice value
            updateLastChoice();
        });

        // Function to update the lastChoice value
        function updateLastChoice() {
            $('#lastChoice').val(count);
        }
    });

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
                title: "Question has not been saved."
            });
            console.log("Error: {{ session('error') }}");
        @endif
    });
</script>
<style>
    .course-menu {
        position: absolute;
        top: 0;
        right: 0;
        width: fit-content;
        /* display: none; */
        transition: 1s;
    }
    .addtopic-btn > p {
        display: none;
    }
    .addtopic-btn:hover > p {
        display: unset;
    }
</style>
