<!-- Modal content -->
<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
        <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">
            
        </h3>
        <button id="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">{{__('Close modal')}}</span>
        </button>
    </div>
    <!-- Modal body -->
    <form action = "{{ $payment->id ? route('payment.update', $payment) : route('payment.store') }}" class="p-4 md:p-5" id="formModal" method="POST" enctype="multipart/form-data">
        @if($payment->id)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $payment->id }}">
        @endif
        @csrf
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2 sm:col-span-1">
                <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Paciente')}}</label>
                <select id="patient_id" name="patient_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $payment->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Ciudad')}}</label>
                <input type="text" name="city" id="city" value="{{ $payment->id ? $payment->city : '' }}" placeholder="Type your city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2">
                <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Estado')}}</label>
                <input type="text" name="state" id="state" value="{{ $payment->id ? $payment->state : '' }}" placeholder="Type your state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2">
                <label for="postal_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Codigo Postal')}}</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ $payment->id ? $payment->postal_code : '' }}" placeholder="Type your postal_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Metodo de Pago')}}</label>
                <input type="text" name="payment_method" id="payment_method" value="{{ $payment->id ? $payment->payment_method : '' }}" placeholder="Credit Card" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Monto')}}</label>
                <input type="number" name="amount" id="amount" value="{{ $payment->id ? $payment->amount : '' }}" step="10.0" min="10" placeholder="10" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
        </div>
        <button id="btnSave" onclick="save()" class="cursor-pointer text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
            <span id="buttonText"></span>
        </button>
    </form>
</div>