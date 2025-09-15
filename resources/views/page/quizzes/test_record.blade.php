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
                                <th scope="col" class="px-6 py-3">
                                    ดำเนินการ
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
                                    <td class="px-6 py-4">
                                        <a href="{{ route('test.history.show', ['testid' => $test->id]) }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                            <i class="bi bi-list"></i>
                                        </a>
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
    var currentDate = new Date();
    var dateString = currentDate.getDate() + "/"
                    + (currentDate.getMonth()+1)  + "/"
                    + currentDate.getFullYear() + " "
                    + currentDate.getHours() + ":"
                    + currentDate.getMinutes() + ":"
                    + currentDate.getSeconds();
    var url = new URL(window.location.href);

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
                    messageTop: 'ประวัติการทำแบบทดสอบ {{ $quiz->title }}' ,
                    messageBottom: 'Printed on ' + url.origin + ' by {{auth()->user()->name}} at ' + dateString,
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
</script>
<style>
    @media print {
        th:last-child,
        td:last-child {
            display: none;
        }
    }
</style>
