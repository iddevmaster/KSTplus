<x-app-layout>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 px-4 flex justify-between items-center flex-wrap">
                <p class="fs-2 fw-bold">{{ __('messages.cenrolled') }}</p>
                <div class="basis-full sm:basis-1/2 lg:basis-1/4">
                    <div class="relative w-full">
                        <input type="search" id="search-courses" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="{{ __('messages.search') }}">
                        <button type="submit" class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="sm:rounded-lg p-4">
                <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 gap-4" id="course-results">
                    @if (count($courses) > 0)
                        @foreach ($courses as $course)
                            @php
                                $prog_finish = App\Models\progress::where('user_id', auth()->user()->id)
                                    ->where('course_id', $course->id)
                                    ->count();
                                $less_all = App\Models\lesson::where('course', $course->id)->count();
                                if ($less_all != 0) {
                                    $prog_avg = intval(($prog_finish * 100) / $less_all);
                                } else {
                                    $prog_avg = 0;
                                }
                            @endphp
                            <a href="{{ route('course.detail', ['id' => $course->id]) }}">
                                <div class="card" style="height: 350px">
                                    <div class="card-header" style="background-image: url('{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}')">
                                        {{-- course Img --}}
                                    </div>
                                    <div class="card-body" style="border-radius: 0px 0px 5px 5px">
                                        <div class="p-2 pt-0">
                                            <p class="card-title fw-bold mb-0 text-xs">{{ __('messages.dpm') }}: {{ optional($course->getDpm)->name }}</p>
                                            <h5 class="card-title fw-bold text-xl mb-2">{{ $course->code }} : {{ Str::limit($course->title, 60) }}</h5>
                                            <p class="card-text text-gray-600 text-sm">{{ Str::limit($course->description, 100) }}</p>
                                        </div>
                                        <div class="progress mt-2" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: {{ $prog_avg }}%; font-size: 10px">{{ $prog_avg }}% ({{ $prog_finish }}/{{ $less_all }})</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="flex justify-center fw-bold"><span class="bg-yellow-100 text-yellow-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded ">Course not found</span></div>
                    @endif
                </div>
                <div>
                    {{ $courses->appends(request()->input())->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function applyCardStyles() {
        const colors = ['#98FF98', '#f8f9fa', '#a2d2ff', '#FFD1DC', '#fffdd0', '#d3d3d3', '#F0F8FF', '#ff7f50', '#E1A95F', '#D0F0C0', '#B0E0E6', '#F08080'];
        const cards = document.querySelectorAll('.card-header');

        cards.forEach((card, index) => {
            card.style.backgroundColor = colors[index % colors.length];
        });
    }

    // Run the function on initial page load
    applyCardStyles();

    $(document).ready(async function() {
        $('#search-courses').on('keyup', async function() {
            var value = $(this).val();

            // Show loading indicator
            $('#course-results').html('<div class="d-flex justify-content-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            try {
                const response = await $.ajax({
                    type: "GET",
                    url: "{{ route('courses.search.enrolled') }}",
                    data: {'search': (value ? value : '!all!')},
                });

                // Hide loading indicator
                $('#course-results').empty(); // Clear loading message

                $('#course-results').html(response);
                applyCardStyles();
            } catch (error) {
                // Handle errors here (optional)
                console.error("Error fetching courses:", error);
                // Hide loading indicator
                $('#course-results').empty(); // Clear loading message
            }
        });
    });

</script>
<style>
    .course-card {
        border: unset;
    }
    .course-card:hover{
        outline: 4px solid pink;
        cursor: pointer;
    }
    .card-header {
        height: 180px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
    }
</style>
