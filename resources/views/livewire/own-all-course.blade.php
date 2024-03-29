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
                    <button class="btn btn-info btn-sm edit-btn text-white" value="{{$course->id}}" ctitle="{{ $course->title }}" cdesc="{{ $course->description}}" allPerm="{{ json_decode($course->permission)->all ?? '' }}"  dpmPerm="{{ json_decode($course->permission)->dpm ?? '' }}"><i class="bi bi-gear"></i></button>
                    <button class="btn btn-danger btn-sm delete-btn" value="{{$course->id}}"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        @endforeach
    @else
        <div class="flex justify-center fw-bold"><span class="bg-yellow-100 text-yellow-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded ">{{ __('messages.course_not') }}</span></div>
    @endif
</div>
