<div class="bg-white p-4 rounded shadow-sm min-w-full">
    <div class="flex flex-wrap justify-between mb-3 gap-4">
        <div>
            <p class="text-2xl font-bold"><i class="bi bi-backpack"></i>{{ __('messages.All Test') }}</p>
            <form action="{{ route('test.export') }}" method="get" target="_blank">
                @csrf
                <input type="hidden" name="searchData" value="{{ json_encode($formData) }}">
                <button
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-500 rounded-lg border border-blue-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>
        </div>
        <div class="flex-auto">
            <form wire:submit.prevent="searchTest">
                <div class="flex gap-2 mb-2">
                    <select id="small" wire:model="formData.filter_user"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>ผู้ใช้ทั้งหมด</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <select id="small" wire:model="formData.filter_brn" aria-label="Filter brn"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>สาขาทั้งหมด</option>
                        @foreach ($branches as $brn)
                            <option value="{{ $brn->id }}">{{ $brn->name }}</option>
                        @endforeach
                    </select>
                    <select id="small" wire:model="formData.filter_quiz" aria-label="Filter quiz"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>แบบทดสอบทั้งหมด</option>
                        @foreach ($quizzes as $quiz)
                            <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <input type="date" id="startDate" wire:model="formData.filter_sdate"
                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Start date" />
                    <input type="date" id="endDate" wire:model="formData.filter_edate"
                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                        placeholder="End date" />

                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-hover " id="test-datatable">
            <thead class="table-dark text-start">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"> {{ __('messages.Quiz') }}</th>
                    <th scope="col">{{ __('messages.User') }}</th>
                    <th scope="col">{{ __('messages.Branch') }}</th>
                    <th scope="col">{{ __('messages.Score') }}</th>
                    <th scope="col">{{ __('messages.Date') }}</th>
                </tr>
            </thead>
            <tbody class="text-start">
                @if ($tests->count() > 0)
                    @php
                        $page = $tests->currentPage();
                    @endphp
                    @foreach ($tests as $index => $test)
                        <tr>
                            <td>{{ (($page -1) * 20) + $index+1 }}</td>
                            <td class="text-nowrap" data-toggle="tooltip" data-placement="top"
                                title="{{ optional($test->getQuiz)->title }}">{{ optional($test->getQuiz)->title }}
                            </td>
                            <td>{{ optional($test->getTester)->name }}</td>
                            <td>{{ optional(optional($test->getTester)->getBrn)->name ?? "-" }}</td>
                            <td>{{ $test->score }} / {{ $test->totalScore }}</td>
                            <td>{{ Carbon\Carbon::parse($test->start)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center"><span
                                class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-pink-400">ไม่พบข้อมูล</span>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $tests->links() }}
    </div>
</div>
