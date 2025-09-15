<div class="card p-4">
    <div class="bg-gray-200 px-4 py-3 mb-4 rounded">
        <p>{{$questNum}}. {!! $question->title !!}</p>
    </div>

    @if ($question->type)
        <div class="grid sm:grid-cols-2 grid-cols-1 gap-2 px-2 mb-4">
            @php
                $choices = $question->answer;
                if ($question->shuffle_ch) {
                    $finChoices = collect($choices)->shuffle();
                } else {
                    $finChoices = $choices;
                }
            @endphp
            @foreach ($finChoices as $index => $choice)
                <div class="flex items-center ps-4 border border-gray-200 rounded ">
                    <input id="bordered-radio-{{$question->id.$choice['id']}}" type="radio" wire:model="answers.{{ $question->id }}" value="{{ $choice['id'].$choice['answer'] }}" name="bordered-radio" class="cursor-pointer w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2 ">
                    <label for="bordered-radio-{{$question->id.$choice['id']}}" class="cursor-pointer py-3 ms-2 text-sm font-medium text-gray-900 ">{{$index + 1}}. {{$choice['text']}}</label>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-wrap gap-2 px-2 mb-4">
            <p><b>Answer:</b></p>
            <div class="flex w-full">
                <input type="text" id="answerbox{{ $question->id }}" wire:model="answers.{{ $question->id }}" maxlength="1000" name="choice1"
                    class="answer-box block w-100 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder="Input text" />
                <button type="button" id="answermicBtn" question-id="{{ $question->id }}" class="btn btn-outline-primary">🎤 พูด</button>
            </div>
        </div>
    @endif

    <div class="flex justify-between">
        <button wire:click="gotoPreviousQuestion" {{$questNum <= 1 ? 'disabled' : ''}} type="button" class="flex text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2   focus:outline-none ">
            <svg class="w-4 h-4 me-1 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4m6-8L7 5l4 4"/>
            </svg>
            Previous
        </button>
        <p class="hidden self-center sm:block md:block lg:block">Question: <b>{{$questNum}}</b> / {{$total}}</p>
        @if ($questNum >= $total)
            <button wire:click="gotoNextQuestion" type="button" class="flex text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                Submit
            </button>
        @else
            <button wire:click="gotoNextQuestion" type="button" class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 me-2 mb-2   focus:outline-none ">
                Next
                <svg class="w-4 h-4 ms-1 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
                </svg>
            </button>
        @endif
    </div>
</div>
