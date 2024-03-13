<x-app-layout>
    <div class="py-10">
        <div class="px-4 max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <p class="fs-2">{{ __('messages.test_rec') }}:: <b>{{ $quiz->title }}</b></p>
            </div>

            <div>
                <div class="relative shadow-md sm:rounded-lg bg-white p-4 rounded">
                    <table class="w-full text-sm text-left text-gray-500 " id="test-datatable">
                        <thead class="text-xs text-white uppercase bg-gray-700 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.user_name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.score') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.status') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.time_use') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('messages.date') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testes as $index => $test)
                                @php
                                    $startDate = Carbon\Carbon::parse($test->start);
                                    $endDate = Carbon\Carbon::parse($test->end);

                                    $timeUsage = $endDate->diff($startDate);
                                @endphp
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th class="px-6 py-4">
                                        {{ $index+1 }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ optional($test->getTester)->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $test->score }} / {{ $test->totalScore }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($test->score >= ($test->totalScore * $test->getQuiz->pass_score / 100))
                                            <p class="text-green-500">{{ __('messages.pass') }}</p>
                                        @else
                                            <p class="text-red-500">{{ __('messages.fail') }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ( $timeUsage->h )
                                            {{ $timeUsage->format('%h:%i:%s') }}
                                        @else
                                            {{ $timeUsage->format('%i:%s min') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $startDate->format('d-m-Y') }}
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
$(document).ready(function() {
    $('#test-datatable').DataTable({
        paging: true,       // Enables pagination
        searching: true,    // Enables the search box
        ordering: true,     // Enables column ordering
        info: true,         // 'Showing x to y of z entries' string
        lengthChange: true, // Allows the user to change number of rows shown
        pageLength: 5,      // Set number of rows per page
    });
});
</script>
