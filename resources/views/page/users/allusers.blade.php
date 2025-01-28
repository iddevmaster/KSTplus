<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">{{ __('messages.All Users') }}</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-2 flex justify-end mx-2">
                <button
                    class="btn btn-success"
                    id="addBtn"
                    data-bs-toggle="modal"
                    data-bs-target="#addUserModal"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-title="Add user"><i class="bi bi-person-plus-fill"></i></button>

                <!-- Modal -->
                <div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header ">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('messages.Add User') }}</h1>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.register') }}" method="post">
                                    @csrf
                                    <div class="d-flex gap-2 mb-2">
                                        <p>{{ __('messages.Name') }}</p>
                                        <input type="text" class="form-control form-control-sm" value="{{ old('name') }}" name="name" required>
                                    </div>
                                    <div class="d-flex gap-2 mb-2">
                                        <p>{{ __('messages.Username') }}</p>
                                        <input type="text" class="form-control form-control-sm" value="{{ old('username') }}" name="username" required>
                                    </div>
                                    <div class="d-flex gap-2 mb-2">
                                        <p>{{ __('messages.Password') }}</p>
                                        <input type="password" class="form-control form-control-sm" name="password" required>
                                    </div>
                                    <div class="d-flex gap-2 mb-2">
                                        <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('agn') }}" name="agn" required>
                                            <option selected disabled>{{ __('messages.Agency') }}</option>
                                            @foreach ($agns as $agn)
                                                <option value="{{ $agn->id }}">{{ $agn->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('brn') }}" name="brn" required>
                                            <option selected disabled>{{ __('messages.Branch') }}</option>
                                            @foreach ($brns as $brn)
                                                <option value="{{ $brn->id }}">{{ $brn->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex gap-2 mb-2">
                                        <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('dpm') }}" name="dpm" required>
                                            <option selected disabled>{{ __('messages.Department') }}</option>
                                            @foreach ($dpms as $dpm)
                                                <option value="{{ $dpm->id }}">{{ $dpm->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('role') }}" name="role" required>
                                            <option selected disabled>{{ __('messages.Role') }}</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="my-4">
                                        <p>{{ __('messages.Course') }}</p>
                                        <select class="form-select" id="small-select2-options-multiple-field" aria-label="Small select example" multiple name="courses[]">
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('messages.Cancel') }}</button>
                                        <button type="submit" class="btn btn-outline-primary">{{ __('messages.Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sm:rounded-lg p-4 row">
                <div class="bg-light p-4 rounded ">
                    <table class="table table-sm table-hover" id="users-datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('messages.Name') }}</th>
                                <th scope="col">{{ __('messages.Role') }}</th>
                                <th scope="col">{{ __('messages.Dpm') }}</th>
                                <th scope="col">{{ __('messages.Course') }}</th>
                                <th scope="col">{{ __('messages.OwnCourse') }}</th>
                                <th scope="col">{{ __('messages.Lifetime') }}</th>
                                <th scope="col">{{ __('messages.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ optional($user->dpmName)->name }}</td>
                                    @php
                                        if (is_array($user->courses)) {
                                            $total_course = count($user->courses ?? []);
                                        } else {
                                            $total_course = count(json_decode($user->courses ?? '') ?? []);
                                        }
                                    @endphp
                                    <td>{{ $total_course }}</td>
                                    <td>
                                        @php
                                            echo App\Models\course::where('teacher', $user->id)->count();
                                        @endphp
                                    </td>
                                    <td>
                                        @if ($user->startlt)
                                            @php
                                                $dateString = $user->startlt;

                                                // Create a DateTime object from your date string
                                                $yourDate = DateTime::createFromFormat('Y-m-d', $dateString);

                                                // Get the current DateTime
                                                $now = new DateTime();

                                                // Calculate the difference between the dates
                                                $difference = $yourDate->diff($now);
                                            @endphp
                                            @if ($difference->invert == 0)
                                                <p class="text-red-400">expired</p>
                                            @else
                                                <p class="text-sky-500">{{ $difference->y > 0 ? $difference->y.'y ' : ''  }}{{ $difference->m > 0 ? $difference->m.'m ' : ''  }}{{ $difference->d >= 0 ? $difference->d.'d ' : ''  }}</p>
                                            @endif
                                        @else
                                            Forever
                                        @endif
                                    </td>
                                    @if (($user->role == 'admin'))
                                        <td>
                                            @if ((Auth::user()->role == 'admin'))
                                                <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail" href="{{ url('/users/detail/'. $user->id ) }}"><i class="bi bi-file-person-fill"></i></a>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete this user." id="delBtn" value="{{ $user->id }}"><i class="bi bi-trash"></i></button>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail" href="{{ url('/users/detail/'. $user->id ) }}"><i class="bi bi-file-person-fill"></i></a>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete this user." id="delBtn" value="{{ $user->id }}"><i class="bi bi-trash"></i></button>
                                            @if ($user->role == 'new')
                                                <button class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Renew." id="renewBtn" value="{{ $user->id }}" oldVal="{{ $user->startlt }}"><i class="bi bi-calendar2-plus"></i></button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
    $(document).ready(function() {
        $('#users-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: false,     // Enables column ordering
            info: false,         // 'Showing x to y of z entries' string
            lengthChange: false, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    $( '#small-select2-options-multiple-field' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        closeOnSelect: false,
        selectionCssClass: 'select2--small',
        dropdownCssClass: 'select2--small',
    } );

    const delBtns = document.querySelectorAll('#delBtn');
    delBtns.forEach((delbtn) => {
        delbtn.addEventListener('click', () => {
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
                    const delId = delbtn.value;

                    return fetch('/user/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId})
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
                    )
                }
            })
        })
    })

    const rewBtns = document.querySelectorAll('#renewBtn');
    rewBtns.forEach((btn) => {
        const doldDay = btn.getAttribute('oldVal');
        btn.addEventListener('click', () => {
            Swal.fire({
                title: 'Choose dayleft',
                html: `<input type="date" id="datepicker" class="swal2-input" value="${doldDay}">`,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const uId = btn.value;
                    const date = document.getElementById('datepicker').value;
                    return fetch('/user/renew', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ uid: uId, date: date })
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
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                    'Successed!',
                    'User has been renewed.',
                    'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()
                        }
                    });
                }
            })
        })
    })
</script>

<style>

</style>
