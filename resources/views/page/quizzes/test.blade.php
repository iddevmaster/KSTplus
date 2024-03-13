<x-app-layout>
    <div class="py-10">
        <div class="px-4 max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <p class="fs-2 fw-bold">Quizzes</p>
            </div>

            @livewire('test', ['testId' => $qzid, 'courseId' => $cid, 'ques_num' => $ques_num])

        </div>
    </div>
</x-app-layout>
<script>

</script>
