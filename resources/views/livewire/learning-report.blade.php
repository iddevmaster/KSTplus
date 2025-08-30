<div class="bg-white p-4 rounded shadow-sm min-w-full">
    <div class="flex flex-wrap justify-between mb-3">
        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i>{{ __('messages.All Course') }}</p>
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
                @if (count($user_courses ?? []) > 0)
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($user_courses as $user_course)
                        @php
                            $prog_finish = App\Models\progress::where('user_id', $user_course->user_id)
                                ->where('course_id', $user_course->course_id)
                                ->count();
                            $less_all = App\Models\lesson::where('course', $user_course->course_id)->count();
                            if ($less_all != 0) {
                                $prog_avg = intval(($prog_finish * 100) / $less_all);
                            } else {
                                $prog_avg = 0;
                            }
                        @endphp
                        <tr>
                            <th scope="row">{{ $index }}</th>
                            <td>{{ optional($user_course->getUser())->name }}</td>
                            <td data-toggle="tooltip" data-placement="top" title="adwadawdawdaw">
                                {{ Str::limit(optional($user_course->getCourse())->title, 60) }}</td>
                            <td>
                                <div class="progress" role="progressbar" aria-label="Example with label"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success" style="width: {{ $prog_avg }}%">
                                        {{ $prog_avg }}%</div>
                                </div>
                                {{-- {{$prog_avg}}%
                        <div class="w-full bg-gray-200 rounded-full h-2.5 ">
                            <div class="bg-green-600 h-2.5 rounded-full " style="width: {{$prog_avg}}%"></div>
                        </div> --}}
                            </td>
                            <td>
                                {{ $user_course->created_at ?? '' }}
                            </td>
                        </tr>
                        @php
                            $index++;
                        @endphp
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
