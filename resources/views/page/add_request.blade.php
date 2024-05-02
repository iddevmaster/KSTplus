<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">เพิ่มคำขอ</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row bg-white">
                <form action="{{ route('store-req') }}" method="POST">
                    @csrf
                    <div class="my-4">
                        <label for="select-beast" class="form-label">For:</label>
                        <select class="form-select" id="select-beast" required name="target" placeholder="Select a person...">
                            <option value="">Select a person...</option>
                            <option value="-">-</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a person
                        </div>
                    </div>
                    <div class="d-flex gap-4 my-4">
                        <label for="select-beast" class="form-label">Type:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="course" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Course
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value="content">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Message
                            </label>
                        </div>
                    </div>
                    <div class="my-4" id="content-select">
                        <label for="content" class="form-label">Message:</label>
                        <textarea class="form-control" id="content" name="message" rows="3" placeholder="Please enter a message"></textarea>
                        <div class="invalid-feedback">
                            Please enter a message.
                        </div>
                    </div>
                    <div class="my-4" id="course-select">
                        <label for="select-state" class="form-label">Course:</label>
                        <select id="select-state" name="course[]" multiple placeholder="Select a state...">
                            <option value="">Select a state...</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->code }} :: {{ $course->title }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select some course.
                        </div>
                    </div>
                    <div class="py-3">
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                        <a href="{{ route('request.all') }}"><button type="button" class="btn btn-outline-danger">Cancel</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <link href="https://fastly.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://fastly.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        var user_select = new TomSelect("#select-beast",{
            create: true,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        var course_select = new TomSelect("#select-state",{

        });


        $(document).ready(function() {
            // Hide the course initially
            $('#content-select').hide();

            // Listen for radio button changes
            $('input[name="type"]').change(function() {
                // Check the value of the selected radio button
                var selectedValue = $('input[name="type"]:checked').val();

                // Hide/show content and course based on the selected radio button
                if (selectedValue === 'content') {
                    $('#content-select').show();
                    $('#course-select').hide();
                } else if (selectedValue === 'course') {
                    $('#content-select').hide();
                    $('#course-select').show();
                }
            });
        });
    </script>
</x-app-layout>
