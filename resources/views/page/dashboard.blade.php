<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mt-5 px-2">
            <p class="fs-1 fw-bold">{{ __('messages.Dashboard') }}</p>
            @php
                $seriesList = [];
                $dpmList= [];
                foreach ($dpms as $key => $dpm) {
                    $seriesList[] = App\Models\course::where('dpm', $dpm->id)->count();
                    $dpmList[] = $dpm->name;
                };

                $totaltest = count($tests ?? []);
                $passtest = 0;
                foreach ($tests as $key => $test) {
                    $passScore = ($test->totalScore) * (optional($test->getQuiz)->pass_score) / 100;
                    if ($test->score >= $passScore) {
                        $passtest++;
                    }
                }
                $testData = [$passtest, $totaltest - $passtest]

            @endphp

            {{-- Tabs Bar --}}
            <div class="border-b border-gray-200 mb-4">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    @can('dCourse')
                        <li class="me-2">
                            <a href="#course" id="course-tab" data-tabs-target="#course" type="button" role="tab" aria-controls="course" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300  group">
                                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                    <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"/>
                                </svg>
                                {{ __('messages.Course') }}
                            </a>
                        </li>
                    @endcan
                    @can('dQuiz')
                        <li class="me-2">
                            <a href="#test" id="test-tab" data-tabs-target="#test" type="button" role="tab" aria-controls="test" aria-selected="false" class="inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active group" aria-current="page">
                                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                    <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM5 12a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-3a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-3a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm10 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2Zm0-3H9a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Zm0-3H9a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"/>
                                </svg>
                                {{ __('messages.Test') }}
                            </a>
                        </li>
                    @endcan
                    @can('dLog')
                        <li class="me-2">
                            <a href="#log" id="log-tab" data-tabs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300  group">
                                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 15">
                                    <path d="M1 13a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H1v7Zm5.293-3.707a1 1 0 0 1 1.414 0L8 9.586V8a1 1 0 0 1 2 0v1.586l.293-.293a1 1 0 0 1 1.414 1.414l-2 2a1 1 0 0 1-1.416 0l-2-2a1 1 0 0 1 .002-1.414ZM17 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1Z"/>
                                </svg>
                                {{ __('messages.Log') }}
                            </a>
                        </li>
                    @endcan
                    @can('dHistory')
                        <li class="me-2">
                            <a href="#history" id="history-tab" data-tabs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300  group">
                                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                                </svg>
                                {{ __('messages.History') }}
                            </a>
                        </li>
                    @endcan
                    @role('admin')
                        <li class="me-2">
                            <a href="#manage" id="manage-tab" data-tabs-target="#manage" type="button" role="tab" aria-controls="manage" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300  group">
                                <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z"/>
                                </svg>
                                {{ __('messages.Manage') }}
                            </a>
                        </li>
                    @endrole
                </ul>
            </div>
            {{-- End Tabs Bar --}}

            {{-- Tabs Contents --}}
            <div id="default-tab-content">

                {{-- course Content --}}
                <div class="hidden p-2 rounded-lg bg-gray-50" id="course" role="tabpanel" aria-labelledby="course-tab">
                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="sm:rounded-lg p-2">
                                <div class="mb-4">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-journal-bookmark"></i>{{ __('messages.All Course') }}</p>
                                    </div>
                                    <canvas id="myChart"></canvas>
                                </div>
                                <div class="bg-white p-4 rounded shadow-sm min-w-full">
                                    <div class="flex flex-wrap justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i>{{ __('messages.All Course') }}</p>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="table table-hover" id="allcourse-datatable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">{{ __('messages.Code') }}</th>
                                                    <th scope="col" >{{ __('messages.Name') }}</th>
                                                    <th scope="col">{{ __('messages.Lecturer') }}</th>
                                                    <th scope="col">{{ __('messages.Dpm') }}</th>
                                                    <th scope="col">{{ __('messages.student') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-start">
                                                @foreach ($courses as $course)
                                                    <tr>
                                                        <td>{{ $course->code }}</td>
                                                        <td class="text-nowrap" data-toggle="tooltip" data-placement="top" title="{{ $course->title }}">{{ $course->title }}</td>
                                                        <td>{{ optional($course->getTeacher)->name }}</td>
                                                        <td>{{ optional($course->getDpm)->name }}</td>
                                                        <td>{{ count($course->studens ?? []) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- test content --}}
                <div class="hidden p-4 rounded-lg bg-gray-50" id="test" role="tabpanel" aria-labelledby="test-tab">
                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="sm:rounded-lg p-2">
                                <div class="mb-4">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-file-earmark-check"></i>{{ __('messages.Test Summary') }}</p>
                                    </div>
                                    <div  class="flex justify-center items-center flex-wrap">
                                        <div class=" md:h-80 w-1/2">
                                            <canvas id="testChart"></canvas>
                                        </div>
                                        <div>
                                            <p class="text-xl">{{ __('messages.Average') }}</p>
                                            <p class="text-5xl sm:text-7xl md:text-9xl">{{ intval( ($totaltest != 0) ? ($passtest * 100 /  $totaltest) : 0 ) }}%</p>
                                            <p class="text-xl">{{ __('messages.Pass from') }}</p>
                                            <p class="text-xl">{{ __('messages.Total') }} <b>{{$totaltest}}</b> {{ __('messages.times') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white p-2 rounded shadow-sm min-w-full">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-list-check"></i> {{ __('messages.All Test') }}</p>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="table table-hover " id="test-datatable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col"> {{ __('messages.Quiz') }}</th>
                                                    <th scope="col">{{ __('messages.User') }}</th>
                                                    <th scope="col">{{ __('messages.Score') }}</th>
                                                    <th scope="col">{{ __('messages.Date') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-start">
                                                @foreach ($tests as $index => $test)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="text-nowrap" data-toggle="tooltip" data-placement="top" title="{{ optional($test->getQuiz)->title }}">{{ optional($test->getQuiz)->title }}</td>
                                                        <td>{{ optional($test->getTester)->name }}</td>
                                                        <td>{{ $test->score }} / {{ $test->totalScore }}</td>
                                                        <td>{{ Carbon\Carbon::parse($test->start)->format('d-m-Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- log content --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 " id="log" role="tabpanel" aria-labelledby="log-tab">
                    <div class="relative overflow-x-auto sm:rounded-lg">
                        <table class="w-full table-hover text-sm text-left rtl:text-right text-gray-500" id="log-table">
                            <thead class="text-xs text-white uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('messages.User') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('messages.Module') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('messages.Action') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('messages.Note') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('messages.Date') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activitys as $index => $log)
                                    <tr class="bg-white">
                                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{$index + 1}}
                                        </th>
                                        <td class="px-6 py-2">
                                            {{ optional($log->getUser)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $log->module }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $log->note }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $log->content }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $log->created_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- history content --}}
                <div class="hidden p-4 rounded-lg " id="history" role="tabpanel" aria-labelledby="history-tab">
                    {{-- Course Deleted --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-20 bg-gray-50">
                        <p class="font-bold text-2xl my-2">{{ __('messages.Course Deleted') }}</p>
                        <table class="w-full table-hover text-sm text-left rtl:text-right text-gray-500" id="courseDel-table">
                            <thead class="text-xs text-white uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('messages.Title') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Teacher') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Dpm') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Delete_at') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courseDel as $index => $course)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{$index + 1}}
                                        </th>
                                        <td class="px-6 py-2 text-nowrap" data-toggle="tooltip" data-placement="top" title="{{ $course->title }}">
                                            {{ $course->code }} : {{ $course->title }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ optional($course->getTeacher)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ optional($course->getDpm)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ Carbon\Carbon::parse($course->deleted_at)->format('d-m-Y') }}
                                        </td>
                                        <td class="">
                                            <button type="button" data-res-id="{{$course->id}}" data-res-type="course" class="restoreBtn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 me-2 my-2 focus:outline-none">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Quiz Deleted --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-gray-50">
                        <p class="font-bold text-2xl my-2">{{ __('messages.Quiz Deleted') }}</p>
                        <table class="w-full table-hover text-sm text-left rtl:text-right text-gray-500" id="quizDel-table">
                            <thead class="text-xs text-white uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('messages.Title') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Create_By') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Pass Score') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Delete_at') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        {{ __('messages.Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizDel as $index => $quiz)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{$index + 1}}
                                        </th>
                                        <td class="px-6 py-2 text-nowrap" data-toggle="tooltip" data-placement="top" title="{{ $quiz->title }}">
                                            {{ $quiz->title }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ optional($quiz->getCreated)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $quiz->pass_score }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ Carbon\Carbon::parse($quiz->deleted_at)->format('d-m-Y') }}
                                        </td>
                                        <td class="">
                                            <button type="button" data-res-id="{{$quiz->id}}" data-res-type="quiz" class="restoreBtn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 me-2 my-2 focus:outline-none">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Manage content --}}
                <div class="hidden p-4 rounded-lg " id="manage" role="tabpanel" aria-labelledby="manage-tab">
                    <div class="text-center mt-2">
                        <p class="fs-1 fw-bold">{{ __('messages.Agency Data') }}</p>
                    </div>
                    <div class="py-10">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="sm:rounded-lg p-4 row justify-center">
                                <div class="p-4 rounded-lg row">
                                    <div class="col-6 ">
                                        <div class="bg-white p-4 shadow rounded-lg">
                                            <div class="flex justify-between mb-3">
                                                <p class="text-2xl font-bold"><i class="bi bi-buildings"></i> {{ __('messages.Agency') }}</p>
                                                <button class="btn btn-success" onclick="addAgn()" ><i class="bi bi-plus-lg"></i></button>
                                            </div>
                                            <div class="overflow-auto">
                                                <table class="table table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th scope="col">{{ __('messages.Action') }}</th>
                                                            <th scope="col">{{ __('messages.Name') }}</th>
                                                            <th scope="col">{{ __('messages.Address') }}</th>
                                                            <th scope="col">{{ __('messages.Contact') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                        @foreach ($agns as $agn)
                                                            <tr>
                                                                <td>
                                                                    <div class="flex gap-1">
                                                                        <button class="btn btn-sm btn-danger" id="delBtn" deltype="agn" value="{{ $agn->id }}"><i class="bi bi-trash"></i></button>
                                                                        <button
                                                                            class="btn btn-sm btn-info text-white"
                                                                            id="editBtn"
                                                                            edittype="agn"
                                                                            value="{{ $agn->id }}"
                                                                            agnName="{{$agn->name}}"
                                                                            agnAddr="{{$agn->address ?? ''}}"
                                                                            agnCont="{{$agn->contact ?? ''}}">
                                                                                <i class="bi bi-gear"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <td class="text-nowrap">{{$agn->name}}</td>
                                                                <td class="text-nowrap">{{$agn->address?? ""}}</td>
                                                                <td class="text-nowrap">{{$agn->contact?? ""}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-white p-4 shadow rounded-lg">
                                            <div class="flex justify-between mb-3">
                                                <p class="text-2xl font-bold"><i class="bi bi-building"></i> {{ __('messages.Branch') }}</p>
                                                <button class="btn btn-success" onclick="addBrn()"><i class="bi bi-plus-lg"></i></button>
                                            </div>
                                            <div class="overflow-auto">
                                                <table class="table table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th scope="col">{{ __('messages.Action') }}</th>
                                                            <th scope="col">{{ __('messages.Name') }}</th>
                                                            <th scope="col">{{ __('messages.Agency') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                        @foreach ($brns as $brn)
                                                            <tr>
                                                                <td>
                                                                    <div class="flex gap-1">
                                                                        <button class="btn btn-sm btn-danger" id="delBtn" deltype="brn" value="{{ $brn->id }}"><i class="bi bi-trash"></i></button>
                                                                        <button
                                                                            class="btn btn-sm btn-info text-white"
                                                                            id="editBtn"
                                                                            edittype="brn"
                                                                            brnName="{{$brn->name}}"
                                                                            brnAgn="{{$brn->agency}}"
                                                                            value="{{ $brn->id }}">
                                                                                <i class="bi bi-gear"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <td class="text-nowrap">{{$brn->name}}</td>
                                                                <td class="text-nowrap">{{ optional($brn->agencyName)->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white p-4 rounded-lg mb-5 shadow">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-house-door"></i> {{ __('messages.Department') }}</p>
                                        <button class="btn btn-success" onclick="addDpm()"><i class="bi bi-plus-lg"></i></button>
                                    </div>
                                    <div class="overflow-auto">
                                        <table class="table table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">{{ __('messages.Action') }}</th>
                                                    <th scope="col">{{ __('messages.Name') }}</th>
                                                    <th scope="col">{{ __('messages.Prefix') }}</th>
                                                    <th scope="col">{{ __('messages.Personnel') }}</th>
                                                    <th scope="col">{{ __('messages.Agency') }}</th>
                                                    <th scope="col">{{ __('messages.Branch') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                @foreach ($dpms as $dpm)
                                                    <tr>
                                                        <td>
                                                            <div class="flex gap-1">
                                                                <button class="btn btn-sm btn-danger" id="delBtn" deltype="dpm" value="{{ $dpm->id }}"><i class="bi bi-trash"></i></button>
                                                                <button class="btn btn-sm btn-info text-white"
                                                                    id="editBtn"
                                                                    edittype="dpm"
                                                                    dpmName="{{$dpm->name}}"
                                                                    dpmPrefix="{{$dpm->prefix}}"
                                                                    dpmBrn="{{$dpm->branch}}"
                                                                    value="{{ $dpm->id }}">
                                                                        <i class="bi bi-gear"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        <td>{{$dpm->name}}</td>
                                                        <td>{{$dpm->prefix}}</td>
                                                            @php
                                                                $numPers = App\Models\User::where('dpm', $dpm->id)->count();
                                                            @endphp
                                                        <td>{{$numPers}}</td>
                                                        <td>{{optional($dpm->brnName->agencyName)->name}}</td>
                                                        <td>{{optional($dpm->brnName)->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="w-4/5 h-0.5 mx-auto border-0 rounded bg-gray-700">

                    <div class="text-center mt-5">
                        <p class="fs-1 fw-bold">{{ __('messages.Roles') }}</p>
                    </div>
                    <div class="py-10">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="sm:rounded-lg p-4 row justify-center">
                                <div class="p-4 rounded-lg row">
                                    <div class="bg-white p-4 shadow rounded-lg">
                                        <div class="flex justify-between mb-3">
                                            <p class="text-2xl font-bold"><i class="bi bi-person-square"></i> {{ __('messages.Roles') }}</p>
                                            <button class="btn btn-success" onclick="addRole()" ><i class="bi bi-plus-lg"></i></button>
                                        </div>
                                        <div class="overflow-auto">
                                            <table class="table table-hover">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">{{ __('messages.Name') }}</th>
                                                        <th scope="col">{{ __('messages.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    @foreach ($roles as $index => $role)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td class="text-nowrap">{{$role->name}}</td>
                                                            <td>
                                                                @if ($role->name !== 'admin')
                                                                    <button class="btn btn-sm btn-primary" id="editBtn" edittype="role" value="{{ $role->name }}"><i class="bi bi-gear"></i></button>
                                                                    <button class="btn btn-sm btn-danger" id="delBtn" deltype="role" value="{{ $role->name }}"><i class="bi bi-trash"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <hr class="w-4/5 h-0.5 mx-auto border-0 rounded bg-gray-700">

                    <div class="text-center mt-5">
                        <p class="fs-1 fw-bold">{{ __('messages.Permissions') }}</p>
                    </div>
                    <div class="py-10">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="sm:rounded-lg p-4 row justify-center">
                                <div class="rounded-lg row gap-2">
                                    @foreach ($roles as $index => $role)
                                        <div class="p-4 bg-white shadow rounded-lg">
                                            <h3 class="mb-4 text-start font-semibold text-xl text-gray-900">{{ $role->name }}</h3>
                                            <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                                @foreach ($permissions as $perm)
                                                    <li class="px-3 border border-gray-200 sm:border-b-0 sm:border-r">
                                                        <div class="flex items-center">
                                                            <input id="{{ $role->name }}-check-{{ $perm->name }}" type="checkbox" name="{{ $perm->name }}" value="{{ $role->name }}" class="permission-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                                            <label for="{{ $role->name }}-check-{{ $perm->name }}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 ">{{ __('messages.perm-' . $perm->name) }}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Tabs Contents --}}
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');
    const testch = document.getElementById('testChart');
    const seriesList = @json($seriesList); // Converts the PHP array to a JSON string that JavaScript can read
    const dpmList = @json($dpmList);

    const testData = @json($testData);

    new Chart(testch, {
        type: 'doughnut',
        data: {
            labels: [
                'PASS',
                'FAIL'
            ],
            datasets: [{
                label: 'Amount',
                data: testData,
                backgroundColor: [
                    '#4ade80',
                    'rgb(255, 99, 132)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            }
        },
    });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dpmList,
            datasets: [{
                label: 'course amount',
                data: seriesList,
                borderWidth: 1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            }
        }
    });

    $(document).ready(function() {
        var currentDate = new Date();
        var dateString = currentDate.getDate() + "/"
                        + (currentDate.getMonth()+1)  + "/"
                        + currentDate.getFullYear() + " "
                        + currentDate.getHours() + ":"
                        + currentDate.getMinutes() + ":"
                        + currentDate.getSeconds();

        $('#allcourse-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                'excel',
                {
                    extend: 'print',
                    autoPrint: true,
                    title: '{{auth()->user()->agnName->name ?? "Knowledge Service Training"}}',
                    messageTop: 'All Course',
                    messageBottom: 'Printed on ' + window.location.href + ' by {{auth()->user()->name}} at ' + dateString,
                    customize: function (doc) {
                        // Prepend an image to the title (doc.title is empty so we prepend to doc.content[1].table)
                        var imgContainer = $('<div/>').css({
                            'text-align': 'center',
                            'margin-bottom': '10px' // Space below the image
                        });
                        var img = new Image();
                        img.src = 'data:image/png;base64,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';
                        $(img).css({
                            'margin': '0 auto', // Center the image within the div
                            'display': 'block', // Ensure the image is a block-level element
                            'width': '50px',    // Set your desired width
                            'height': 'auto'    // Maintain aspect ratio
                        });

                        imgContainer.append(img);

                        $(doc.document.body)
                            .prepend(imgContainer);  // Adjust this if the image needs to go somewhere specific

                        // Apply your styles to the title and message
                        $(doc.document.body).find('h1').first().css({
                            'text-align': 'center',
                            'font-weight': 'bold',
                            'font-size': '20px',
                            'margin-bottom': '5px'
                        });
                        $(doc.document.body).find('h1').next().css({
                            'text-align': 'center',
                            'font-weight': 'bold',
                            'margin-bottom': '10px'
                        });

                        // Apply styles to the footer
                        $(doc.document.body).find('div').last().css({
                            'text-align': 'end',
                            'font-size': '10px'
                        });
                    }
                },
            ]
        });
    });

    $(document).ready(function() {
        var currentDate = new Date();
        var dateString = currentDate.getDate() + "/"
                        + (currentDate.getMonth()+1)  + "/"
                        + currentDate.getFullYear() + " "
                        + currentDate.getHours() + ":"
                        + currentDate.getMinutes() + ":"
                        + currentDate.getSeconds();

        $('#test-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 5,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                'excel',
                {
                    extend: 'print',
                    autoPrint: true,
                    title: '{{auth()->user()->agnName->name ?? "Knowledge Service Training"}}',
                    messageTop: 'All Test ',
                    messageBottom: 'Printed on ' + window.location.href + ' by {{auth()->user()->name}} at ' + dateString,
                    customize: function (doc) {
                        // Prepend an image to the title (doc.title is empty so we prepend to doc.content[1].table)
                        var imgContainer = $('<div/>').css({
                            'text-align': 'center',
                            'margin-bottom': '10px' // Space below the image
                        });
                        var img = new Image();
                        img.src = 'data:image/png;base64,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';
                        $(img).css({
                            'margin': '0 auto', // Center the image within the div
                            'display': 'block', // Ensure the image is a block-level element
                            'width': '50px',    // Set your desired width
                            'height': 'auto'    // Maintain aspect ratio
                        });

                        imgContainer.append(img);

                        $(doc.document.body)
                            .prepend(imgContainer);  // Adjust this if the image needs to go somewhere specific

                        // Apply your styles to the title and message
                        $(doc.document.body).find('h1').first().css({
                            'text-align': 'center',
                            'font-weight': 'bold',
                            'font-size': '20px',
                            'margin-bottom': '5px'
                        });
                        $(doc.document.body).find('h1').next().css({
                            'text-align': 'center',
                            'font-weight': 'bold',
                            'margin-bottom': '10px'
                        });

                        // Apply styles to the footer
                        $(doc.document.body).find('div').last().css({
                            'text-align': 'end',
                            'font-size': '10px'
                        });
                    }
                },
            ]
        });
    });

    $(document).ready(function() {
        var currentDate = new Date();
        var dateString = currentDate.getDate() + "/"
                        + (currentDate.getMonth()+1)  + "/"
                        + currentDate.getFullYear() + " "
                        + currentDate.getHours() + ":"
                        + currentDate.getMinutes() + ":"
                        + currentDate.getSeconds();

        $('#log-table').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                'excel',
                {
                    extend: 'print',
                    autoPrint: true,
                    title: '{{auth()->user()->agnName->name ?? "Knowledge Service Training"}}',
                    messageTop: 'Activity Log',
                    messageBottom: 'Printed on ' + window.location.href + ' by {{auth()->user()->name}} at ' + dateString,
                    customize: function (doc) {
                        // Prepend an image to the title (doc.title is empty so we prepend to doc.content[1].table)
                        var imgContainer = $('<div/>').css({
                            'text-align': 'center',
                            'margin-bottom': '10px' // Space below the image
                        });
                        var img = new Image();
                        img.src = 'data:image/png;base64,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';
                        $(img).css({
                            'margin': '0 auto', // Center the image within the div
                            'display': 'block', // Ensure the image is a block-level element
                            'width': '50px',    // Set your desired width
                            'height': 'auto'    // Maintain aspect ratio
                        });

                        imgContainer.append(img);

                        $(doc.document.body)
                            .prepend(imgContainer);  // Adjust this if the image needs to go somewhere specific

                        // Apply your styles to the title and message
                        $(doc.document.body).find('h1').first().css({
                            'text-align': 'center',
                            'font-weight': 'bold',
                            'font-size': '20px',
                            'margin-bottom': '5px'
                        });
                        $(doc.document.body).find('h1').next().css({
                            'text-align': 'center',
                            'font-weight': 'bold',
                            'margin-bottom': '10px'
                        });

                        // Apply styles to the footer
                        $(doc.document.body).find('div').last().css({
                            'text-align': 'end',
                            'font-size': '10px'
                        });
                    }
                },
            ]
        });
    });

    $(document).ready(function() {
        $('#courseDel-table').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
        });
    });

    $(document).ready(function() {
        $('#quizDel-table').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function() {
            $('.restoreBtn').click(function() {
                // Get the notification ID from the data attribute
                const resId = $(this).data('res-id');
                const resType = $(this).data('res-type');
                Swal.fire({
                    title: `Are you sure?`,
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore it!',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/restore/${resType}/${resId}`, // You need to define this route in your web.php
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                // You can add some code here to handle a successful response
                                if (response.success) {
                                    Swal.fire(
                                        'Success!',
                                        `${response.success} has been restore.`,
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
                                        `${response.success} has not restore.`,
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
                                    'Data has not restore.',
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

    addAgn = () => {
        Swal.fire({
            title: '{{ __('messages.Add Agency') }}',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="addr" class="form-label">{{ __('messages.Address') }}</label>
                    <input type="text" class="form-control" id="addr">
                </div>
                <div class="mb-3">
                    <label for="cont" class="form-label">{{ __('messages.Contact') }}</label>
                    <input type="text" class="form-control" id="cont">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "{{ __('messages.Save') }}",
            preConfirm: () => {
                const agnname = document.getElementById('name').value;
                const addr = document.getElementById('addr').value;
                const cont = document.getElementById('cont').value;

                if (!agnname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addAgency', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: agnname, address:addr, contact:cont })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your data was saved successfully.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload()
                    }
                });
            }
        });
    }

    addBrn = () => {
        Swal.fire({
            title: '{{ __('messages.Add Branch') }}',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name">
                </div>

                <label for="agn" class="form-label">{{ __('messages.Agency') }}</label>
                <select class="form-select" aria-label="Default select example" id="agn">
                    @foreach ($agns as $agn)
                        <option value="{{$agn->id}}">{{$agn->name}}</option>
                    @endforeach
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: "{{ __('messages.Save') }}",
            preConfirm: () => {
                const brnname = document.getElementById('name').value;
                const agn = document.getElementById('agn').value;

                if (!brnname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addBranch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: brnname, agency:agn })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your data was saved successfully.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload()
                    }
                });
            }
        });
    }

    addRole = () => {
        Swal.fire({
            title: '{{ __('messages.Add Role') }}',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "{{ __('messages.Save') }}",
            preConfirm: () => {
                const rname = document.getElementById('name').value;

                if (!rname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addRole', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: rname })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your data was saved successfully.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload()
                    }
                });
            }
        });
    }

    addDpm = () => {
        Swal.fire({
            title: '{{ __('messages.Add Department') }}',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name">
                </div>

                <div class="mb-3">
                    <label for="prefix" class="form-label">{{ __('messages.Prefix') }}</label>
                    <input type="text" class="form-control" id="prefix">
                </div>

                <label for="brn" class="form-label">{{ __('messages.Branch') }}</label>
                <select class="form-select" aria-label="Default select example" id="brn">
                    @foreach ($brns as $brn)
                        <option value="{{$brn->id}}">{{$brn->name}}</option>
                    @endforeach
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: '{{ __('messages.Save') }}',
            showLoaderOnConfirm: true,
            preConfirm: (name) => {
                const dpmname = document.getElementById('name').value;
                const prefix = document.getElementById('prefix').value;
                const brn = document.getElementById('brn').value;

                if (!dpmname || !prefix ) {
                    Swal.showValidationMessage("Name or prefix is required");
                    return;
                }

                return fetch('/manage/addDpm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: dpmname, branch:brn, prefix:prefix })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was added successfully.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload()
                    }
                });
            }
        })

    }


    const delBtns = document.querySelectorAll('#delBtn');
    delBtns.forEach((delbtn) => {
        delbtn.addEventListener('click', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const delId = delbtn.value;
                    const delType = delbtn.getAttribute('deltype');

                    return fetch('/manage/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId, type:delType })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        })
    })

    const editBtns = document.querySelectorAll('#editBtn');
    editBtns.forEach((editbtn) => {
        const eid = editbtn.value;
        const etype = editbtn.getAttribute('edittype');

        if (etype == 'agn') {
            const ename = editbtn.getAttribute('agnName');
            const eaddr = editbtn.getAttribute('agnAddr');
            const econt = editbtn.getAttribute('agnCont');
            editbtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Edit Agency',
                    html: `
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="${ename}">
                        </div>
                        <div class="mb-3">
                            <label for="addr" class="form-label">Address</label>
                            <input type="text" class="form-control" id="addr" value="${eaddr}">
                        </div>
                        <div class="mb-3">
                            <label for="cont" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="cont" value="${econt}">
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    preConfirm: () => {
                        const agnname = document.getElementById('name').value;
                        const addr = document.getElementById('addr').value;
                        const cont = document.getElementById('cont').value;

                        if (!agnname) {
                            Swal.showValidationMessage("Name is required");
                            return;
                        }

                        return fetch('/manage/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: agnname, address:addr, contact:cont, agnid: eid, editType: etype})
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed`
                            )
                        })
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result.value);
                        Swal.fire(
                            'Saved!',
                            'Your changed was saved successfully.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload()
                            }
                        });
                    }
                });
            })
        } else if (etype == 'brn') {
            const brnName = editbtn.getAttribute('brnName');
            const brnAgn = editbtn.getAttribute('brnAgn');
            editbtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Add Branch',
                    html: `
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="${brnName}">
                        </div>

                        <label for="agn" class="form-label">Agency</label>
                        <select class="form-select" aria-label="Default select example" id="agn" value="${brnAgn}">
                            @foreach ($agns as $agn)
                                <option value="{{$agn->id}}">{{$agn->name}}</option>
                            @endforeach
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    preConfirm: () => {
                        const brnname = document.getElementById('name').value;
                        const agn = document.getElementById('agn').value;

                        if (!brnname) {
                            Swal.showValidationMessage("Name is required");
                            return;
                        }

                        return fetch('/manage/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: brnname, agency:agn,  brnid: eid, editType: etype})
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed`
                            )
                        })
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result.value);
                        Swal.fire(
                            'Saved!',
                            'Your changed was saved successfully.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload()
                            }
                        });
                    }
                });
            })
        } else if (etype == 'dpm') {
            const dpmName = editbtn.getAttribute('dpmName');
            const dpmPrefix = editbtn.getAttribute('dpmPrefix');
            const dpmBrn = editbtn.getAttribute('dpmBrn');
            editbtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Add Department',
                    html: `
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="${dpmName}">
                        </div>

                        <div class="mb-3">
                            <label for="prefix" class="form-label">Prefix</label>
                            <input type="text" class="form-control" id="prefix" value="${dpmPrefix}">
                        </div>

                        <label for="brn" class="form-label">Branch</label>
                        <select class="form-select" aria-label="Default select example" id="brn" value="${dpmBrn}">
                            @foreach ($brns as $brn)
                                <option value="{{$brn->id}}">{{$brn->name}}</option>
                            @endforeach
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    showLoaderOnConfirm: true,
                    preConfirm: (name) => {
                        const dpmname = document.getElementById('name').value;
                        const prefix = document.getElementById('prefix').value;
                        const brn = document.getElementById('brn').value;

                        if (!dpmname || !prefix ) {
                            Swal.showValidationMessage("Name or prefix is required");
                            return;
                        }

                        return fetch('/manage/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ name: dpmname, branch:brn, prefix:prefix, dpmid: eid, editType: etype })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed`
                            )
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result.value);
                        Swal.fire(
                            'Saved!',
                            'Your changed was saved successfully.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload()
                            }
                        });
                    }
                });
            })
        } else if (etype == 'role') {
            editbtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Edit Role',
                    html: `
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.Name') }}</label>
                            <input type="text" value="${eid}" class="form-control" id="name">
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "{{ __('messages.Save') }}",
                    preConfirm: () => {
                        const rname = document.getElementById('name').value;

                        if (!rname) {
                            Swal.showValidationMessage("Name is required");
                            return;
                        }

                        return fetch('/manage/editRole', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ newName: rname , oldName: eid})
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed`
                            )
                        })
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result.value);
                        Swal.fire(
                            'Saved!',
                            'Role was saved successfully.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload()
                            }
                        });
                    }
                });
            });
        }

    })

    $(document).ready(function () {
        $('.permission-checkbox').change(function () {
            // Get checkbox details
            var checkbox = $(this);
            var rname = checkbox.val();
            var pname = checkbox.attr('name');
            var checked = checkbox.prop('checked');

            // Prepare data for AJAX request
            var data = {
                role_name: rname,
                perm_name: pname,
                check: checked
            };

            // Send data to the controller using AJAX
            $.ajax({
                url: '/add-permission-to-role',
                method: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Handle success response if needed
                    console.log(response);
                },
                error: function (error) {
                    // Handle error if needed
                    console.error(error);
                }
            });
        });
    });
</script>

<style>

</style>
