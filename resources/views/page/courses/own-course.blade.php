<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">{{ __('messages.own_course') }}</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row">
                <div class="flex justify-end">
                    <button class="btn btn-success" onclick="showAddCourseAlert()">
                        <i class="bi bi-plus-circle-fill"></i> {{ __('messages.add_course') }}
                    </button>
                </div>

                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">All</button>
                        </li>
                        @if ($groups)
                            @foreach ($groups as $index => $group)
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="group-{{ $group->id }}-tab" data-tabs-target="#group{{ $group->id }}" type="button" role="tab" aria-controls="group{{ $group->id }}" aria-selected="false">{{ $group->name }}</button>
                                </li>
                            @endforeach
                        @endif
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="addGroup-tab" data-tabs-target="#addGroup" type="button" role="tab" aria-controls="addGroup" aria-selected="false">
                                <svg class="w-6 h-6 text-green-600 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5.757v8.486M5.757 10h8.486M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>

                <div id="default-tab-content">
                    <div class="hidden p-4 rounded-lg" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <livewire:own-all-course />
                    </div>
                    @if ($groups)
                        @foreach ($groups as $index => $group)
                            <div class="hidden p-2 rounded-lg" id="group{{ $group->id }}" role="tabpanel" aria-labelledby="group-{{ $group->id }}-tab">
                                <livewire:own-group-course :gid="$group->id"/>
                            </div>
                        @endforeach
                    @endif
                    <div class="hidden p-4 rounded-lg" id="addGroup" role="tabpanel" aria-labelledby="addGroup-tab">
                        <form action="{{ route('courses.add.group') }}" method="post">
                            @csrf
                            <div class="mb-6">
                                <label for="gname" class="block mb-2 text-sm font-medium text-gray-900">{{ __('messages.Name') }}</label>
                                <input type="gname" id="gname" maxlength="100" name="gname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Enter group name" required>
                            </div>
                            <div class="my-4">
                                {{-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.."> --}}
                                <div class="my-5 flex justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">{{ __('messages.choose_course') }}:</h3>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="text" maxlength="50" onkeyup="myFunction()" id="myInput" class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search...">
                                    </div>
                                </div>
                                <ul class="grid w-full gap-6 md:grid-cols-3" id="myUL">
                                    @if ($courses)
                                        @foreach ($courses as $index => $course)
                                            <li>
                                                <input type="checkbox" id="react-option{{ $index }}" value="{{ $course->id }}" name="selected_course[]" class="hidden peer">
                                                <label for="react-option{{ $index }}" class="inline-flex items-center justify-between w-full text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50">
                                                    <div class="card w-full" style="height: 200px">
                                                        <div class="card-header" style="height: 100px; background-image: url('{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}'); background-size: cover; background-position:center;">
                                                        </div>
                                                        <div class="card-body gray-800" style="border-radius: 0px 0px 5px 5px">
                                                            <h5 class="card-title fw-bold mb-2"><span>{{ $course->code }}</span>:: {{ $course->title }}</h5>
                                                        </div>
                                                    </div>
                                                </label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <input type="reset" class="btn btn-outline-secondary mx-2" value="{{ __('messages.Cancel') }}"/>
                                <button type="submit" class="btn btn-outline-primary mx-2">{{ __('messages.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    @if(session('success'))
        Swal.fire({
            icon: "success",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            title: "{{ session('success') }}"
        });
    @elseif (session('error'))
        Swal.fire({
            icon: "error",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            title: "{{ session('error') }}"
        });
        console.log("Error: {{ session('error') }}");
    @endif

    function myFunction() {
        // Declare variables
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById('myInput');
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            p = li[i].getElementsByTagName("h5")[0];
            txtValue = p.textContent || p.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            } else {
            li[i].style.display = "none";
            }
        }
    }


    $( '.multiselector' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        closeOnSelect: false,
        selectionCssClass: 'select2--small',
        dropdownCssClass: 'select2--small',
    } );

    function showAddCourseAlert() {
        Swal.fire({
            title: 'เพิ่มหลักสูตร',
            html: `
                <div class="mb-3">
                    <label for="topic" class="form-label text-start">ชื่อหลักสูตร</label>
                    <input type="text" class="form-control" id="topic">
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">คำอธิบาย</label>
                    <textarea class="form-control" id="desc" rows="2"></textarea>
                </div>

                <p class="mb-3">สิทธิ์การเข้าถึง</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="allPer" value="option1">
                    <label class="form-check-label" for="allPer">หลักสูตรสาธารณะ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="dpmPer" value="option2">
                    <label class="form-check-label" for="dpmPer">หลักสูตรเฉพาะ</label>
                </div>
                <div class="flex items-center justify-center w-full mt-2">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50   hover:bg-gray-100   ">
                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                            <p class="mb-2 font-bold">รูปภาพหน้าปก</p>
                            <p class="text-sm text-gray-500 "><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 ">jpeg,png  (MAX 10Mb size)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const topic = document.getElementById('topic').value;
                const desc = document.getElementById('desc').value;
                const allPer = document.getElementById('allPer').checked;
                const dpmPer = document.getElementById('dpmPer').checked;
                const fileInput = document.getElementById('dropzone-file');

                if (!topic) {
                    Swal.showValidationMessage("Topic is required");
                    return;
                }
                const formData = new FormData();
                formData.append('title', topic);
                formData.append('desc', desc);
                formData.append('allPerm', allPer);
                formData.append('dpmPerm', dpmPer);
                formData.append('cimg', fileInput.files[0]);

                // Add your CSRF token
                formData.append('_token', '{{ csrf_token() }}');

                return fetch('/course/add', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        console.log("Error: ", response)
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    console.log(error)
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });

    }

    const delBtn = document.querySelectorAll(".delete-btn");
    delBtn.forEach((btn) => {
        const delId = btn.value;
        btn.addEventListener('click', function () {
            Swal.fire({
                title: `Are you sure?`,
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
                        body: JSON.stringify({ delid: delId, deltype:'course'})
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
                            window.location.reload();
                        }
                    })
                }
            })
        });
    });

    const delGr = document.querySelectorAll(".delGroup");
    delGr.forEach((btn) => {
        const delId = btn.value;
        btn.addEventListener('click', function () {
            Swal.fire({
                title: `Are you sure?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(`/course/group/delete/${delId}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
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
                            window.location.reload();
                        }
                    })
                }
            })
        });
    });

    const editBtn = document.querySelectorAll(".edit-btn");
    editBtn.forEach((ebtn) => {
        const editId = ebtn.value;
        const etitle = ebtn.getAttribute('ctitle');
        const edesc = ebtn.getAttribute('cdesc');
        const eall = ebtn.getAttribute('allPerm');
        const edpm = ebtn.getAttribute('dpmPerm');
        ebtn.addEventListener('click', function () {
            Swal.fire({
                title: 'Edit Course',
                html: `
                    <div class="mb-3">
                        <label for="topic" class="form-label text-start">ชื่อหลักสูตร</label>
                        <input type="text" class="form-control" id="topic" value="${etitle}">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">คำอธิบาย</label>
                        <textarea class="form-control" id="desc" rows="2">${edesc}</textarea>
                    </div>

                    <p class="mb-3">สิทธิ์การเข้าถึง</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="allPer" value="option1" ${eall === 'true' ? 'checked' : ''}>
                        <label class="form-check-label" for="allPer">หลักสูตรสาธารณะ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dpmPer" value="option2" ${edpm === 'true' ? 'checked' : ''}>
                        <label class="form-check-label" for="dpmPer">หลักสูตรเฉพาะ</label>
                    </div>
                    <div class="flex items-center justify-center w-full mt-2">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50   hover:bg-gray-100   ">
                            <div class="flex flex-col items-center justify-center pt-2 pb-2">
                                <p class="mb-2 font-bold">Course image</p>
                                <p class="text-sm text-gray-500 "><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 ">jpeg,png  (MAX 10Mb size)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" />
                        </label>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Save",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const topic = document.getElementById('topic').value;
                    const desc = document.getElementById('desc').value;
                    const allPer = document.getElementById('allPer').checked;
                    const dpmPer = document.getElementById('dpmPer').checked;
                    const fileInput = document.getElementById('dropzone-file');

                    if (!topic) {
                        Swal.showValidationMessage("Topic is required");
                        return;
                    }

                    const formData = new FormData();
                    formData.append('title', topic);
                    formData.append('desc', desc);
                    formData.append('allPerm', allPer);
                    formData.append('dpmPerm', dpmPer);
                    formData.append('courseId', editId);
                    formData.append('cimg', fileInput.files[0]);

                    // Add your CSRF token
                    formData.append('_token', '{{ csrf_token() }}');

                    return fetch('/course/update', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json', // This tells the server you expect JSON in return
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        console.log(error);
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
                    'Success!',
                    'Your change has been saved.',
                    'success'
                    ).then((res) => {
                        window.location.reload()
                    })
                }
            });
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
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .course-menu {
        position: absolute;
        top: 0;
        right: 0;
        width: fit-content;
        display: none;
        transition: 1s;
    }
    @keyframes fin {
        0% {
            transform: scale(0.5);

        }
        50% {transform: scale(1);}
        100% {transform: scale(1);}
    }
    .course-card:hover > .course-menu {
        animation: fin 1s;
        display: unset;
    }
    .coursebg {
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
    }
</style>
