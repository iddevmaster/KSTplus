<div class="bg-white p-4 rounded shadow-sm min-w-full">
    <div class="flex flex-wrap justify-between mb-3 gap-x-3">
        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i>{{ __('messages.All Course') }}</p>
        <form wire:submit.prevent="filterLearning">
            <div class="flex gap-2">
                <select id="small" wire:model="filter_user" aria-label="Filter quiz"
                    class="w-60 block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" selected>ผู้ใช้ทั้งหมด</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <select id="small" wire:model="filter_course" aria-label="Filter quiz"
                    class="w-60 block p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" selected>หลักสูตรทั้งหมด</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
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
    <div class="overflow-x-auto">
        <table class="table table-hover" id="course-datatable">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">หลักสูตร</th>
                    <th scope="col">{{ __('messages.Progress') }}</th>
                    <th scope="col">{{ __('messages.Enroll date') }}</th>
                </tr>
            </thead>
            <tbody class="text-start">
                @if (count($course_progreses ?? []) > 0)
                    @foreach ($course_progreses as $index => $course_progres)
                        @php
                            $prog_finish = $course_progres->learned_lesson;
                            $less_all = App\Models\lesson::where('course', $course_progres->course_id)->count();
                            if ($less_all != 0) {
                                $prog_avg = intval(($prog_finish * 100) / $less_all);
                            } else {
                                $prog_avg = 0;
                            }
                        @endphp
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ optional($course_progres->user)->name }}</td>
                            <td data-toggle="tooltip" data-placement="top" title="adwadawdawdaw">
                                {{ Str::limit(optional($course_progres->course)->title, 60) }}</td>
                            <td class="text-center">
                                {{ $prog_finish }} / {{ $less_all }} ({{ $prog_avg }}%)
                                {{-- <div class="progress" role="progressbar" aria-label="Example with label"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success" style="width: {{ $prog_avg }}%">
                                        {{ $prog_avg }}%</div>
                                </div> --}}
                            </td>
                            <td class="text-end">
                                {{ $course_progres->last_learned_at ? Carbon\Carbon::parse($course_progres->last_learned_at)->thaidate('j M Y') : '-' }}
                            </td>
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
    </div>
</div>
