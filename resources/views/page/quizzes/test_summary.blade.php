<x-app-layout>
    <div class="container py-5">
        <div class="text-center text-4xl font-bold uppercase mb-5">
            {{ __('messages.test_summ') }}
        </div>
        <div class="row justify-center">
            <div class="card p-4 pb-2 mb-4">
                <p class="text-2xl font-bold">{{ __('messages.quiz') }} :: {{$quiz->title}}</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 py-4">
                    <div class="card p-2 rounded-xl flex flex-row bg-gradient-to-br from-cyan-400 via-cyan-500 to-cyan-600 border-0 text-white shadow">
                        <div class="flex justify-center items-center px-2">
                            <svg class="w-8 h-8 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                            </svg>
                        </div>
                        <div class="px-2">
                            <p class="text-xs">{{ __('messages.time_use') }}</p>
                            <p class="text-3xl font-bold">{{$timeUsege->format('%i.%s')}} min.</p>
                        </div>
                    </div>
                    <div class="card p-2 rounded-xl flex flex-row bg-gradient-to-br from-green-400 via-green-500 to-green-600 border-0 text-white shadow">
                        <div class="flex justify-center items-center px-2">
                            <svg class="w-6 h-6 lg:h-8 lg:h-8 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </div>
                        <div class="px-2">
                            <p class="text-xs">{{ __('messages.score') }}</p>
                            <p class="text-3xl font-bold">{{$scores}}/{{$totalScore}}</p>
                        </div>
                    </div>
                    <div class="card p-2 rounded-xl flex flex-row bg-gradient-to-br from-pink-400 via-pink-500 to-pink-600 border-0 text-white shadow">
                        <div class="flex justify-center items-center px-2">
                            @if ($scores > ($totalScore * $quiz->pass_score / 100))
                                <svg class="w-8 h-8 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="px-2">
                            <p class="text-xs">{{ __('messages.result') }}</p>
                            <p class="text-3xl font-bold">{{ $scores > ($totalScore * $quiz->pass_score / 100) ? 'PASS' : 'FAIL' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card p-2 mb-2 bg-gray-100 border-0">
                    <div class="mb-2">
                        <p>{{ __('messages.answer') }}:</p>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($answers as $index => $answer)
                            <button type="button" disabled class="text-white {{$answer['status'] ? 'bg-green-500' : 'bg-red-500'}} border border-gray-800 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-xs py-2 px-3 text-center">
                                {{$count}}
                            </button>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </div>
                </div>

                <div class="mt-2">
                    <a href="{{route('course.detail', ['id' => $cid])}}">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2   focus:outline-none ">
                            {{ __('messages.back_2_course') }}
                        </button>
                    </a>
                </div>
            </div>

            @if ($quiz->showAns)
                <div class="card p-4">
                    <div class="flex justify-between flex-wrap mb-4">
                        <p class="text-2xl font-bold">{{ __('messages.answer') }}:</p>
                        <div>
                            <p class="flex items-center text-sm"><span class="flex w-3 h-3 me-3 bg-green-500 rounded-full"></span> {{ __('messages.currect') }}</p>
                            <p class="flex items-center text-sm"><span class="flex w-3 h-3 me-3 bg-red-500 rounded-full"></span> {{ __('messages.incurrect') }}</p>
                        </div>
                    </div>

                    @foreach ($quests as $qindex => $quest)
                        <div class="card py-2 px-4 mb-3 {{$answers[$quest->id]['status'] ? 'bg-green-100' : 'bg-red-100'}}">
                            <div class="flex gap-2">
                                @if ($answers[$quest->id]['status'])
                                    <svg class="w-6 h-6 text-green-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-red-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                @endif
                                <p class="mb-2">{{$qindex+1}}. {!! $quest->title !!}</p>
                            </div>

                            @if ($quest->type)
                                <div class="flex lg:gap-x-20 gap-3.5 bg-gray-200 p-2 mt-2 flex-wrap rounded">
                                    @foreach ($quest->answer as $aindex => $choice)
                                        <p class="
                                            {{$choice['id'] == $answers[$quest->id]['ans'] ? ($answers[$quest->id]['status'] ? 'text-green-500' : 'text-red-500') : ($choice['answer'] ? 'text-green-500' : '')}}
                                        ">{{$aindex+1}}. {{$choice['text']}}</p>
                                    @endforeach
                                </div>
                            @else
                                <p class="mb-2"><b>{{ __('messages.answer') }}:</b> &nbsp;
                                    <span class="{{ $answers[$quest->id]['status'] ? 'text-green-500' : 'text-red-500' }} bg-gray-200 px-2 py-1 rounded">{{$answers[$quest->id]['ans']}}</span>
                                    <span class="text-green-500 bg-green-100 px-2 rounded py-1 {{$answers[$quest->id]['status'] ? 'hidden' : ''}}">{{$quest->answer[0]['answer']}}</span>
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
<script>

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
