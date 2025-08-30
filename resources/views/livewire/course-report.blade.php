<div class="bg-white p-4 rounded shadow-sm min-w-full">
    <div class="flex flex-wrap justify-between mb-3">
        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i>{{ __('messages.All Course') }}</p>
        <div class="flex items-center">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="simple-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                    placeholder="Search..." required wire:model="search" wire:keydown="searchCourse" />
            </div>
            <button type="button" wire:click="searchCourse"
                class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
            </button>
            <form action="{{ route('course.export') }}" method="GET" target="_blank">
                @csrf
                <input type="hidden" name="search" value="{{ $search }}">
                <button
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-gray-600 rounded-lg border border-blue-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                    </svg>
                    <span class="sr-only">Print to PDF</span>
                </button>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-hover" id="allcourse-datatable">
            <thead class="table-dark text-start">
                <tr>
                    <th scope="col">{{ __('messages.Code') }}</th>
                    <th scope="col">{{ __('messages.Name') }}</th>
                    <th scope="col">{{ __('messages.Lecturer') }}</th>
                    <th scope="col">{{ __('messages.Dpm') }}</th>
                    <th scope="col">{{ __('messages.student') }}</th>
                </tr>
            </thead>
            <tbody class="text-start">
                @if (count($courses ?? []) > 0)
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->code }}</td>
                            <td class="text-nowrap" data-toggle="tooltip" data-placement="top"
                                title="{{ $course->title }}">
                                {{ $course->title }}</td>
                            <td>{{ optional($course->getTeacher)->name }}</td>
                            <td>{{ optional($course->getDpm)->name }}</td>
                            <td>{{ count($course->studens ?? []) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center"><span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border border-pink-400">ไม่พบข้อมูล</span></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
