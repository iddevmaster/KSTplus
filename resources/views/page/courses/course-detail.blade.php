<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight d-flex justify-content-between">
            <p>{{ $course->title }}</p>
            @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                <button class="badge btn btn-secondary" disabled>{{ __('messages.own') }}</button>
            @elseif ($course->studens[Auth::user()->id] ?? false)
                <button class="badge btn btn-success" disabled>{{ __('messages.enrolled') }}</button>
            @else
            <a href="{{ route('enroll', ['cid' => $course->id]) }}"><button class="badge btn" style="background-color: var(--primary-color)" >{{ __('messages.enroll') }}</button></a>
            @endif
        </div>
    </x-slot>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-lg-10 col-sm-12 col-md-8 mb-4">
                <div class="card py-2 px-4 mb-4">
                    <p class="fw-bold fs-5">{{ __('messages.desc') }}</p>
                    <p class="ps-4" style="text-indent: 1.5em">{{ $course->description }}</p>
                </div>

                @if (($course->studens[Auth::user()->id] ?? false) || ($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                    @foreach ($lessons as $lesson)
                        <div class="card p-4 mb-4">
                            <p class="fw-bold fs-5">{{ $lesson->topic }}</p>
                            <div class="ps-4">
                                <p class="mb-3" style="text-indent: 1.5em">{!! $lesson->desc !!}</p>
                                @php
                                    $strSubless = $lesson->sub_lessons;
                                    $sublesson = json_decode($strSubless, true);
                                    @endphp
                                @if (!is_null($sublesson))
                                    @foreach ($sublesson as $index => $sls)
                                            @php
                                                dd("type", $sls->type);
                                            @endphp
                                        @if ($sls->type === 'text')
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    <p class="fw-bold">{{ $sls->label }}</p>
                                                    <p>{!! $sls->content !!}</p>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif ($sls->type == 'file')
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    <i class="bi bi-file-earmark bg-secondary rounded-circle p-1 text-light"></i>
                                                    <a
                                                        class="text-primary viewFilebtn cursor-pointer chapter"
                                                        data-file-path="{{ asset('uploads/sublessons/' . $sls->content) }}"
                                                        data-cid="{{ $course->id }}"
                                                        data-lessid="{{ $lesson->id }}"
                                                        value="{{$sls->content}}"
                                                    >
                                                        {{ $sls->label }}
                                                        <span class="text-secondary" style="font-size: 12px">{{ __('messages.update') }} {{ $sls->date }} ({{ $sls->type }})</span>
                                                    </a>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif ($sls->type == 'embed')
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    <i class="bi bi-code-slash bg-secondary rounded-circle p-1 text-light"></i>
                                                    <a
                                                        class="text-primary viewEmbed cursor-pointer chapter"
                                                        value="1"
                                                        data-cid="{{ $course->id }}"
                                                        data-lessid="{{ $lesson->id }}"
                                                        embedTitle="{{$sls->label}}"
                                                        embedCode="{{$sls->content}}"
                                                    >
                                                        {{ $sls->label }}
                                                        <span class="text-secondary" style="font-size: 12px">{{ __('messages.update') }} {{ $sls->date }} ({{ $sls->type }})</span>
                                                    </a>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif ($sls->type == 'quiz')
                                            @php
                                                $quiz = App\Models\quiz::find($sls->content);
                                                $quesnum = App\Models\question::where('quiz', $sls->content)->count();
                                            @endphp
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    <i class="bi bi-list-check bg-secondary rounded-circle p-1 text-light"></i>
                                                    <a
                                                        class="text-primary preQuiz cursor-pointer chapter"
                                                        qTitle="{{ $quiz->title ?? 'unknow'}}"
                                                        cid="{{$course->id ?? '0'}}"
                                                        qid="{{$sls->content ?? '0'}}"
                                                        pass="{{$quiz->pass_score ?? '0'}}"
                                                        qBy="{{$quiz->getCreated->name ?? 'unknow'}}"
                                                        quesNum = "{{($sls->num_quest ?? false) ? ($sls->num_quest > 0 ? $sls->num_quest : $quesnum) : $quesnum}}"
                                                    >
                                                        {{ $sls->label }}
                                                        <span class="text-secondary" style="font-size: 12px">{{ __('messages.update') }} {{ $sls->date }} ({{ $sls->type }})</span>
                                                    </a>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    @if ($sls->type == 'link')
                                                        <i class="bi bi-link bg-secondary rounded-circle p-1 text-light"></i>
                                                    @elseif ($sls->type == 'video')
                                                        <i class="bi bi-play-fill bg-secondary rounded-circle p-1 text-light"></i>
                                                    @endif
                                                    <a href="{{ $sls->content }}"
                                                        target="_BLANK"
                                                        class="text-primary chapter"
                                                        data-cid="{{ $course->id }}"
                                                        data-lessid="{{ $lesson->id }}">{{ $sls->label }} <span class="text-secondary" style="font-size: 12px">{{ __('messages.update') }} {{ $sls->date }} ({{ $sls->type }})</span>
                                                    </a>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                <div class="course-menu">
                                    <button id="dropdownMenuIconButton{{ $lesson->id }}" data-dropdown-toggle="dropdownDots{{ $lesson->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none " type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div id="dropdownDots{{ $lesson->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                                        <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownMenuIconButton{{ $lesson->id }}">
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100 addSubText"  addType="text" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Text</button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100  addSubLink" addType="link" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Link</button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100  addSubLink" addType="video" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Video</button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100  addSubLink" addType="embed" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Embed<></button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100  addSubFile" addType="file" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> File</button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100  addQuiz" addType="quiz" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Quiz</button>
                                            </li>
                                        </ul>
                                        <div class="py-2">
                                            <button class="w-100 text-start px-4 py-2 text-sm text-gray-700 hover:bg-sky-300 editLessBtn" data-bs-toggle="modal" data-bs-target="#editless{{$lesson->id}}"><i class="bi bi-gear"></i> {{ __('messages.edit') }}</button>
                                            <button class="w-100 text-start px-4 py-2 text-sm text-gray-700 hover:bg-red-300 delete-btn" value="{{$lesson->id}}" delType="lesson"><i class="bi bi-trash3"></i> {{ __('messages.delete') }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- edit lesson modal --}}
                        <div class="modal fade" id="editless{{$lesson->id}}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addTopicLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark">
                                    <div class="modal-header">
                                        <h1 class="modal-title text-light fs-5" id="addTopicLabel">{{ __('messages.edit') }} {{ __('messages.lesson') }}</h1>
                                    </div>
                                    <form method="POST" action="{{ route('lesson.update') }}">
                                        @csrf
                                        <input type="hidden" value="{{$lesson->id}}" name="lessid">
                                        <div class="modal-body bg-light text-dark">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="topic" value="{{ $lesson->topic }}" id="topic" required>
                                                    <label for="topic">Topic</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="desc" value="{{ $lesson->desc }}" id="desc">
                                                    <label for="desc">{{ __('messages.desc') }}</label>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex justify-center text-red-500"><p>{{ __('messages.please') }} <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded   border border-yellow-300">{{ __('messages.enroll') }}</span>{{ __('messages.itrs') }}</p></div>
                @endif


                @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                    <div class="d-flex justify-content-center text-success ">
                        <div class="bg-success rounded-pill align-self-center w-100 mx-4" style="height: 5px"></div>

                        <!-- Modal -->
                        <div class="d-flex btn btn-success rounded-pill addtopic-btn" data-bs-toggle="modal" data-bs-target="#addTopic">
                            <i class="bi bi-plus-circle fs-5"></i>
                            <p class="text-nowrap align-self-center ms-2 ">{{ __('messages.add_section') }}</p>
                        </div>

                        <div class="modal fade" id="addTopic" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addTopicLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark">
                                    <div class="modal-header">
                                        <h1 class="modal-title text-light fs-5" id="addTopicLabel">{{ __('messages.add_section') }}</h1>
                                    </div>
                                    <form method="POST" action="{{ route('lesson.add') }}">
                                        @csrf
                                        <input type="hidden" value="{{$id}}" name="courseid">
                                        <div class="modal-body bg-light text-dark">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="topic" id="topic" placeholder="name@example.com" required>
                                                    <label for="topic">Topic</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="desc" id="desc" maxlength="10000">
                                                    <label for="desc">{{ __('messages.desc') }}</label>
                                                </div>
                                                {{-- <div>
                                                    <textarea id="editor" name="desc"></textarea>
                                                    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
                                                    <script>
                                                        ClassicEditor
                                                            .create( document.querySelector( '#editor' ) )
                                                            .catch( error => {
                                                                console.error( error );
                                                            } );
                                                    </script>
                                                </div> --}}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="bg-success rounded-pill align-self-center w-100 mx-4" style="height: 5px"></div>
                    </div>
                @endif
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="card p-4">
                    <p class="text-center fw-bold fs-5 mb-4">{{ __('messages.feature') }}</p>
                    <p><b>{{ __('messages.cid') }}: </b> {{ $course->code }}</p>
                    <p><b>{{ __('messages.Lecturer') }}: </b> {{ optional($course->getTeacher)->name }}</p>
                    <p><b>{{ __('messages.dpm') }}: </b> {{ optional($course->getDpm)->name }}</p>
                    <p><b>{{ __('messages.lesson') }}: </b> {{ $lessons->count() }}</p>
                    @php
                        $updatetime = new DateTime($course->updated_at);
                        $update = $updatetime->format('Y-m-d');

                        $createtime = new DateTime($course->updated_at);
                        $create = $createtime->format('Y-m-d');
                    @endphp
                    <p><b>{{ __('messages.update') }}: </b> {{ $update }}</p>
                    <p><b>{{ __('messages.create') }}: </b> {{ $create }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.tiny.cloud/1/4vdoimdjlqj1524p4qwd6k1jg1w71ys0syull57gnp048kgf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    $(document).ready(function() {
        $('.chapter').click(function() {
            // Get the notification ID from the data attribute
            var cid = $(this).data('cid');
            var lessid = $(this).data('lessid');
            var url = '/progress/add/?_token=' + '&cid=' + encodeURIComponent(cid) + '&lessid=' + encodeURIComponent(lessid);
            // Send an AJAX request to mark the notification as read
            $.ajax({
                url: url, // You need to define this route in your web.php
                type: 'GET',
                success: function(response) {
                    // You can add some code here to handle a successful response
                    console.log(response['message']);
                },
                error: function(error) {
                    // You can add some error handling here
                    console.log('Error ',error);
                }
            });
        });
    });

    const delBtn = document.querySelectorAll(".delete-btn");
    delBtn.forEach((btn) => {
        const delId = btn.value;
        const delType = btn.getAttribute('delType');
        btn.addEventListener('click', function () {
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
                    return fetch('/course/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId, deltype: delType})
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
                    'Your file has been deleted.',
                    'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        });
    });


    const delSubBtn = document.querySelectorAll(".deleteSubBtn");
    delSubBtn.forEach((subbtn) => {
        const delId = subbtn.value;
        const dellessid = subbtn.getAttribute('lessIdVal');
        subbtn.addEventListener('click', function () {
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
                    return fetch('/lesson/sublesson/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId, lessId: dellessid })
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
                    'Your file has been deleted.',
                    'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        });
    });

    const addText = document.querySelectorAll(".addSubText");
    addText.forEach((btn) => {
        const lessid = btn.getAttribute('lessId');
        const addType = btn.getAttribute('addType')
        btn.addEventListener('click', function () {
            Swal.fire({
                title: 'Add text',
                html:
                    '<input id="swal-input1" class="swal2-input" placeholder="Enter label">' +
                    '<textarea id="subTextContent" class="w-100" rows="5" placeholder="Enter text content" value=" "> </textarea>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const label = document.getElementById('swal-input1').value;
                    let content = tinymce.get('subTextContent').getContent();

                    if (!label) {
                        Swal.showValidationMessage("Label is required!");
                        return;
                    } else {
                        // Check if content is null or undefined and set a default value
                        if (content == null || content.trim() === '') {
                            content = '-'; // Replace with a suitable default string
                        }
                        return fetch('/lesson/sublesson/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ label: label, content: content, lessId: lessid, addType: addType})
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
                },
                allowOutsideClick: () => !Swal.isLoading(),
                onOpen: () => {
                    tinymce.init({
                        selector: 'textarea#subTextContent', // Replace this CSS selector to match the placeholder element for TinyMCE
                        plugins: 'lists textcolor fontsize',
                        toolbar: 'fontsize  | bold italic underline | forecolor backcolor | bullist numlist | alignleft aligncenter alignright |',
                        menubar: false,
                        height: 200,
                    });
                },
                onClose: () => {
                    tinymce.get('subTextContent').remove(); // Remove TinyMCE instance when SweetAlert is closed
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Success!',
                        'Your sublesson has been saved.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        });
    });

    const addLink = document.querySelectorAll(".addSubLink");
    addLink.forEach((btn) => {
        const lessid = btn.getAttribute('lessId')
        const addType = btn.getAttribute('addType')
        btn.addEventListener('click', function () {
            Swal.fire({
                title: `Add ${addType}`,
                html:
                    '<input id="swal-input1" class="swal2-input" placeholder="Enter label">' +
                    '<input id="content" class="swal2-input" placeholder="Enter embed code or link">',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const label = document.getElementById('swal-input1').value;
                    const content = document.getElementById('content').value;

                    if (!label) {
                        Swal.showValidationMessage("Label is required!");
                        return;
                    } else if (!content) {
                        Swal.showValidationMessage("Content is required!");
                        return;
                    } else {
                        return fetch('/lesson/sublesson/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ label: label, content: content, lessId: lessid, addType: addType})
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
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Success!',
                        'Your sublesson has been saved.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        });
    });

    const addQuiz = document.querySelectorAll(".addQuiz");
    addQuiz.forEach((btn) => {
        const lessid = btn.getAttribute('lessId')
        const addType = btn.getAttribute('addType')
        btn.addEventListener('click', function () {
            Swal.fire({
                title: `Add ${addType}`,
                html:`<input id="swal-input1" class="swal2-input" placeholder="Enter label">
                <select id="selQuiz" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                        <option selected disabled value="e">Please select quiz</option>
                    @foreach ($quizzes as $quiz)
                        <option value="{{$quiz->id}}">{{$quiz->title}}</option>
                    @endforeach
                </select>
                <input id="numofques" min="1" type="number" class="mt-3" placeholder="number of questions">
                <p class="text-xs text-yellow-600">*หากไม่กรอกจำนวนคำถาม จะใช้คำถามทั้งหมด</p>
                `,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const label = document.getElementById('swal-input1').value;
                    const content = document.getElementById('selQuiz').value;
                    const numOfQuest = document.getElementById('numofques').value;
                    const quizzes = @json($quizzes);
                    let max_ques = 0;
                    quizzes.forEach(quiz => {
                        if (quiz.id == content) {
                            max_ques = quiz.ques_num;
                        }
                    })

                    if (!label) {
                        Swal.showValidationMessage("Label is required!");
                        return;
                    } else if (content == 'e') {
                        Swal.showValidationMessage("Please select quiz!");
                        return;
                    } else if (numOfQuest > max_ques || numOfQuest < 0) {
                        Swal.showValidationMessage("Number of questions must between 0 to " + max_ques);
                        return;
                    } else {
                        return fetch('/lesson/sublesson/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ label: label, content: content, lessId: lessid, addType: addType, numQuest: numOfQuest ? numOfQuest : 0})
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
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Success!',
                        'Your sublesson has been saved.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        });
    });


    const addFile = document.querySelectorAll(".addSubFile");
    addFile.forEach((btnf) => {
        const lessId = btnf.getAttribute('lessId')
        const addType = btnf.getAttribute('addType')
        btnf.addEventListener('click', function () {
            Swal.fire({
                title: 'Add File',
                html:`  <input id="labelInput" class="swal2-input" placeholder="Enter label">
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50   hover:bg-gray-100 ">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 "><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 ">jpeg,png,pdf,svg,doc,docx,xls,xlsx,ppt,pptx,txt,mp4,zip,rar <br> (MAX 120MB size)</p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" />
                            </label>
                        </div>
                     `,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const label = document.getElementById('labelInput').value;
                    const fileInput = document.getElementById('dropzone-file');
                    const fileSize = fileInput.files[0] ? fileInput.files[0].size : 0;
                    const fileName = fileInput.files[0] ? fileInput.files[0].name : '';

                    // Ensure a file was selected
                    if (!label) {
                        Swal.showValidationMessage("Label is required!");
                        return;
                    } else if (!fileInput.files || fileInput.files.length === 0) {
                        Swal.showValidationMessage("กรุณาอัพโหลดไฟล์");
                        return;
                    } else if (fileSize > 120 * 1024 * 1024) {
                        Swal.showValidationMessage("ขนาดไฟล์เกินขีดจำกัด (สูงสุด 120MB)!");
                        return;
                    } else {
                        // Display file name and size
                        Swal.update({
                            title: 'กำลังอัพโหลดไฟล์',
                            html: `<b>${fileName}</b><br>ขนาด: ${(fileSize / (1024 * 1024)).toFixed(2)} MB`,
                        });

                        // Delay the fetch request
                        return new Promise((resolve, reject) => {
                            setTimeout(() => {
                                const formData = new FormData();
                                formData.append('label', label);
                                formData.append('content', fileInput.files[0]);
                                formData.append('lessId', lessId);
                                formData.append('addType', addType);

                                // Add your CSRF token
                                formData.append('_token', '{{ csrf_token() }}');

                                fetch('/lesson/sublesson/add', {
                                    method: 'POST',
                                    body: formData // Send formData without setting Content-Type header
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(response.statusText)
                                    }
                                    return response.json()
                                })
                                .then(data => {
                                    resolve(data); // Resolve the promise with fetched data
                                })
                                .catch(error => {
                                    reject(`Request failed: ${error}`); // Reject the promise with error message
                                });
                            }, 4000); // Delay for 4 seconds (4000 milliseconds)
                        });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Success!',
                        'Your sublesson has been saved.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        });
    });

    const pdfButtons = document.querySelectorAll('.viewFilebtn');
    pdfButtons.forEach((pdfbtn) => {
        const fileNameValue = pdfbtn.value;
        pdfbtn.addEventListener('click', function () {
            const pdfUrl = this.getAttribute('data-file-path');
            Swal.fire({
                title: fileNameValue,
                width: '50%',
                html: `<div style="height: 500px;">
                            <iframe src="${pdfUrl}" style="width: 100%; height: 100%;object-fit:cover" frameborder="0"></iframe>
                        </div>
                    `,
            })
        });
    });

    const viewEmbed = document.querySelectorAll('.viewEmbed');
    viewEmbed.forEach((embbtn) => {
        const embedTitle = embbtn.getAttribute('embedTitle');
        const embedCode = embbtn.getAttribute('embedCode');
        embbtn.addEventListener('click', function () {
            const pdfUrl = this.getAttribute('data-file-path');
            Swal.fire({
                title: embedTitle,
                width: '50%',
                html: `<div class="flex justify-center items-center" >
                            ${embedCode}
                        </div>
                    `,
                    didOpen: () => {
                        // Use a media query to adjust the width and height on smaller screens
                        const swalModal = Swal.getPopup();
                        if (window.matchMedia('(max-width: 650px)').matches) {
                        swalModal.style.width = '90%'; // Example for screens smaller than 600px
                        swalModal.style.height = '70%';
                        }
                    }
            })
        });
    });

    const preQuiz  = document.querySelectorAll('.preQuiz ');
    preQuiz .forEach((qzbtn) => {
        const cid = qzbtn.getAttribute('cid');
        const qid = qzbtn.getAttribute('qid');
        const qTitle = qzbtn.getAttribute('qTitle');
        const qpass = qzbtn.getAttribute('pass');
        const qBy = qzbtn.getAttribute('qBy');
        const quesNum = qzbtn.getAttribute('quesNum');
        qzbtn.addEventListener('click', function () {
            const pdfUrl = this.getAttribute('data-file-path');
            Swal.fire({
                title: `Quiz::${qTitle}`,
                html: `<p>By: ${qBy}</p>
                <p>Pass Score: ${qpass}%</p>
                <p class="mb-2">Qurstions: ${quesNum}</p>
                <hr>
                <p class="my-2">History</p>
                <div class="relative h-40 overflow-x-auto overflow-y-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                            <tr>
                                <th scope="col" class="px-6 py-2">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Quiz
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Score
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-2">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tested as $index => $test)
                                <tr class="bg-white border-b  ">
                                    <td class="px-3 py-2">
                                        {{$index +1}}
                                    </td>
                                    <th scope="row" class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap ">
                                        {{$test->getQuiz->title}}
                                    </th>
                                    <td class="px-3 py-2">
                                        {{$test->score}}/{{$test->totalScore}}
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($test->score >= ($test->totalScore * $test->getQuiz->pass_score / 100))
                                            <p class="text-green-500">PASS</p>
                                        @else
                                            <p class="text-red-500">FAIL</p>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        {{$test->created_at->format('d-m-Y')}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    `,
                showCancelButton: true,
                confirmButtonText: 'Start',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/test/start/${cid}/${qid}/${quesNum}`; // Replace 'startQuiz' with your route name
                }
            });
        });
    });
</script>
<style>
    .course-menu {
        position: absolute;
        top: 0;
        right: 0;
        width: fit-content;
        /* display: none; */
        transition: 1s;
    }
    .addtopic-btn > p {
        display: none;
    }
    .addtopic-btn:hover > p {
        display: unset;
    }
</style>
