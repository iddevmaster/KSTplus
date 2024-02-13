<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">{{ __('messages.user_manual') }}</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            <div style="width: 21cm; height:29cm;">
                @role('new')
                    <iframe src= "umkstnew.pdf" width="100%" height="100%">
                @endrole
                @role('employee')
                    <iframe src= "umkstemp.pdf" width="100%" height="100%">
                @endrole
                @role('teacher')
                    <iframe src= "umkstteacher.pdf" width="100%" height="100%">
                @endrole
                @role('staff')
                    <iframe src= "umkststaff.pdf" width="100%" height="100%">
                @endrole
                @role('admin')
                    <iframe src= "userManualKstplus.pdf" width="100%" height="100%">
                @endrole
            </div>
        </iframe>
        </div>
    </div>
</x-app-layout>
