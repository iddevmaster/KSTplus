<div class="overflow-y-auto mb-4" style="height: 520px">
    @if (count($courses) > 0)
        @foreach ($courses as $course)
            {{-- course card --}}
            <div class="shadow-sm card mb-3 course-card">
                <a href="{{route('course.detail', ['id' => $course->id])}}">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex align-items-center coursebg" style="background-image: url('{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}')">
                            {{-- <img src="{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}" class="img-fluid rounded-start object-fit-cover" alt="..."> --}}
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-0 fs-4">{{ $course->title }}</h5>
                                <p class="card-text fw-bold mb-2">{{ __('messages.id') }}: {{ $course->code }} &nbsp;&nbsp; {{ __('messages.by') }}: {{ optional($course->getDpm)->name }}</p>
                                <p class="card-text text-secondary text-truncate" style="text-indent: 1em">{{ $course->description}}</p>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="course-menu">
                    <button
                        class="btn btn-success btn-sm"
                        id="addBtn{{ $course->id }}"
                        data-bs-toggle="modal"
                        data-bs-target="#addUser2Course{{ $course->id }}"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-title="Add user">
                            <i class="bi bi-person-plus-fill"></i>
                    </button>

                    <button class="btn btn-info btn-sm edit-btn text-white" value="{{$course->id}}" ctitle="{{ $course->title }}" cdesc="{{ $course->description}}" allPerm="{{ json_decode($course->permission, true)->all ?? '' }}"  dpmPerm="{{ json_decode($course->permission, true)->dpm ?? '' }}"><i class="bi bi-gear"></i></button>
                    <button class="btn btn-danger btn-sm delete-btn" value="{{$course->id}}"><i class="bi bi-trash"></i></button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addUser2Course{{ $course->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">เพิ่มนักเรียนในหลักสูตร {{ $course->code }}</h1>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('enroll-list') }}">
                                @csrf
                                <div>
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <p>เลือกผู้ใช้ที่ต้องการเพิ่ม</p>
                                    <select class="form-select" id="multiselector{{ $course->id }}" aria-label="Small select example" multiple name="users[]">
                                        @foreach ($user_list as $each_user)
                                            <option value="{{ $each_user->id }}">{{ $each_user->name }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        $( '#multiselector{{ $course->id }}' ).select2( {
                                            theme: "bootstrap-5",
                                            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                                            placeholder: $( this ).data( 'placeholder' ),
                                            closeOnSelect: false,
                                            selectionCssClass: 'select2--small',
                                            dropdownCssClass: 'select2--small',
                                        } );
                                    </script>
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
            </div> <!-- End Modal -->
        @endforeach
    @else
        <div class="flex justify-center fw-bold"><span class="bg-yellow-100 text-yellow-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded ">{{ __('messages.course_not') }}</span></div>
    @endif
</div>
