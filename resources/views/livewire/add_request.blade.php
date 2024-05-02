<div>
    <div class="flex justify-between">
        <button class="btn btn-danger" wire:click="switchToReqMode" >{{ __('messages.cancel') }}</button>
        <button class="btn btn-success" id="addBtn">{{ __('messages.save') }}</button>
    </div>
            <h1>Req Mode</h1>
    <div class="sm:rounded-lg p-4 row">
        <select id="select-beast" placeholder="Select a person..." autocomplete="off">
            <option value="">Select a person...</option>
            <option value="4">Thomas Edison</option>
            <option value="1">Nikola</option>
            <option value="3">Nikola Tesla</option>
            <option value="5">Arnold Schwarzenegger</option>
        </select>
        <link href="https://fastly.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://fastly.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
        <script>
            document.addEventListener('livewire:load', function () {
                new TomSelect("#select-beast", {
                    create: true,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });
        </script>
    </div>
</div>
