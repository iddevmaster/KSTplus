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
    // const input = document.getElementById('answer');
    const micBtn = document.getElementById('answermicBtn');

    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (SpeechRecognition) {
        const recognition = new SpeechRecognition();
        recognition.lang = 'th-TH'; // หรือ 'en-US' ถ้าต้องการภาษาอังกฤษ
        recognition.continuous = false;
        recognition.interimResults = false;

        micBtn.addEventListener('click', () => {
            recognition.start();
            micBtn.innerText = "🎤 กำลังฟัง...";
            micBtn.disabled = true;
        });

        recognition.onresult = (event) => {
            const transcript = event.results[0][0].transcript;
            const questionId = micBtn.getAttribute('question-id');
            console.log('Question ID: ', questionId);

            const input = document.getElementById('answerbox' + questionId);
            input.value = transcript;

            // แจ้ง Livewire ว่าค่าเปลี่ยนแล้ว
            input.dispatchEvent(new Event('input'));
        };

        recognition.onspeechend = () => {
            recognition.stop();
            micBtn.innerText = "🎤 พูด";
            micBtn.disabled = false;
        };

        recognition.onerror = (event) => {
            console.error("Speech recognition error:", event.error);
            micBtn.innerText = "🎤 พูด";
            micBtn.disabled = false;
        };
    } else {
        micBtn.disabled = true;
        micBtn.innerText = "ไม่รองรับ";
        alert("Browser นี้ยังไม่รองรับ Speech Recognition (แนะนำใช้ Chrome/Edge)");
    }
</script>
