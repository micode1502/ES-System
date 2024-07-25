<!-- Modal content -->
<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
        <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">

        </h3>
        <button id="closeModal" type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-toggle="crud-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">{{ __('Close modal') }}</span>
        </button>
    </div>
    <!-- Modal body -->
    <form action = "{{ $availability->id ? route('availability.update', $availability) : route('availability.store') }}"
        class="p-4 md:p-5" id="formModal" method="POST" enctype="multipart/form-data">
        @if ($availability->id)
            @method('PUT')
            <input type="hidden" name="id" value="{{ $availability->id }}">
        @endif
        @csrf
<div class="grid gap-4 mb-4 grid-cols-2">
    <div class="col-span-1">
        <div class="grid gap-4 grid-cols-1">
            <div>
                <label for="doctor_id"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Doctor') }}</label>
                <select id="doctor_id" name="doctor_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ $availability->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
            <label for="day"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Day') }}</label>
                <select id="day" name="day"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @php
                        $days = [
                            '0' => 'Domingo',
                            '1' => 'Lunes',
                            '2' => 'Martes',
                            '3' => 'Miércoles',
                            '4' => 'Jueves',
                            '5' => 'Viernes',
                            '6' => 'Sabado'
                        ];
                    @endphp
                    @foreach ($days as $key => $day)
                        <option value="{{ $key }}" {{ $availability->day == $key ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-span-1">
        <div class="grid gap-4 grid-cols-1">
            <div>
                <label for="hour_start"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Hora Inicio') }}</label>
                    <input type="time" name="hour_start" id="hour_start" 
                        value="{{ $availability->id ? $availability->hour_start : '' }}" 
                        placeholder="Ingresar Hora de Inicio"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        onchange="validateTime(this)"
                        required="">
            </div>
            <div>
                <label for="duration"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Duración') }}</label>
                <input type="number" name="duration" id="duration"
                    value="{{ $availability->id ? $availability->duration : '' }}"
                    placeholder="10"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required="">
            </div>
        </div>
    </div>
</div>

        <button id="btnSave" onclick="save()"
            class="cursor-pointer text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd"></path>
            </svg>
            <span id="buttonText"></span>
        </button>
    </form>
</div>

<script>
    function validateTime(input) {
        var startTime = "07:30";
        var endTime = "18:00";
        var inputTime = input.value;
        if (inputTime < startTime || inputTime > endTime) {
            alert("La hora debe estar entre las 07:30 y las 18:00.");
            input.value = '';
        }
    }
</script>