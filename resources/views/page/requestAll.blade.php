<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">{{ __('messages.Request All') }}</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end">
                <a href="{{ route('add-req') }}"><button class="btn btn-success" id="addBtn"><i class="bi bi-plus-lg"></i>{{ __('messages.Add') }}</button></a>
            </div>

            <div class="sm:rounded-lg p-4 row gap-3 justify-center">

            </div>
        </div>
    </div>

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
                title: 'Sorry, something wrong!'
            });
            console.log("Error: {{ session('error') }}");
        @endif

        $(document).ready(function() {
            $('.finishBtn').click(function() {
                // Get the notification ID from the data attribute
                var notificationId = $(this).data('alert-id');

                // Send an AJAX request to mark the notification as read
                $.ajax({
                    url: '/notifications/mark-as-finish/' + notificationId, // You need to define this route in your web.php
                    type: 'GET',
                    success: function(response) {
                        // You can add some code here to handle a successful response
                        console.log(response['response']);
                    },
                    error: function(error) {
                        // You can add some error handling here
                        console.log(error);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.failBtn').click(function() {
                // Get the notification ID from the data attribute
                var notificationId = $(this).data('alert-id');

                // Send an AJAX request to mark the notification as read
                $.ajax({
                    url: '/notifications/mark-as-fail/' + notificationId, // You need to define this route in your web.php
                    type: 'GET',
                    success: function(response) {
                        // You can add some code here to handle a successful response
                        console.log(response['response']);
                    },
                    error: function(error) {
                        // You can add some error handling here
                        console.log(error);
                    }
                });
            });
        });
    </script>
</x-app-layout>
