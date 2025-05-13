@if(session('error'))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="mb-4 flex bg-red-100 border-l-8 border-red-500 text-red-700 px-4 py-3 rounded"
>
    <div class="flex-1 pl-4">
        <strong>¡Ups!</strong> {{ session('error') }}
    </div>
</div>
@endif

@if(session('success'))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="mb-4 bg-green-200 border-l-8 border-green-500 text-green-700 px-4 py-3 rounded"
>
    <div class="flex-1 pl-4">
        <strong>¡Éxito!</strong> {{ session('success') }}
    </div>
</div>
@endif
