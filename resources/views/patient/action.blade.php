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
    <form action="{{ $patient->id ? route('patient.update', $patient) : route('patient.store') }}" class="p-4 md:p-5" id="formModal" method="POST" enctype="multipart/form-data">
        @if($patient->id)
            @method('PUT')
            <input type="hidden" name="id" value="{{ $patient->id }}">
        @endif
        @csrf
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Names')}}</label>
                <input type="text" name="name" id="name" value="{{ $patient->id ? $patient->name : '' }}" placeholder="John Smith" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2">
                <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Lastname')}}</label>
                <input type="text" name="lastname" id="lastname" value="{{ $patient->id ? $patient->lastname : '' }}" placeholder="Johnson" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Email')}}</label>
                <input type="email" name="email" id="email" value="{{ $patient->id ? $patient->email : '' }}" placeholder="{{__('YourEmail@mail.com')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Phone')}}</label>
                <input type="number" name="phone" id="phone" value="{{ $patient->id ? $patient->phone : '' }}" placeholder="965874123" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Gender')}}</label>
                <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0" {{ (isset($patient->id) && $patient->gender == 0) ? "selected" : ""}}>{{__('Femenino')}}</option>
                    <option value="1" {{ (isset($patient->id) && $patient->gender == 1) ? "selected" : ""}}>{{__('Masculino')}}</option>
                </select>
            </div>
            {{-- <div class="col-span-2 sm:col-span-1">
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="$2999" required="">
            </div> --}}
            <div class="col-span-2 sm:col-span-1">
                <label for="documentType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Document Type')}}</label>
                <select id="documentType" name="documentType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="0" {{ (isset($patient->id) && $patient->type_document == 0) ? "selected" : ""}}>DNI</option>
                    <option value="1" {{ (isset($patient->id) && $patient->type_document == 1) ? "selected" : ""}}>{{__('Passport')}}</option>
                </select>
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="documentNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('N. Document')}}</label>
                <input type="number" name="documentNumber" id="documentNumber" value="{{ $patient->id ? $patient->document : '' }}" placeholder="74125863" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Birthdate')}}</label>
                <input type="date" name="birthdate" id="birthdate" value="{{ $patient->id ? $patient->date_birth : '' }}" placeholder="04/02/2003" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
            </div>
            <div class="col-span-2 sm:col-span-1">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Status')}}</label>
                <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="1" {{ (isset($patient->id) && $patient->status == 0) ? "selected" : ""}}>{{__('Activo')}}</option>
                    <option value="0" {{ (isset($patient->id) && $patient->status == 0) ? "selected" : ""}}>{{__('Inactivo')}}</option>
                </select>
            </div>
            <div class="col-span-2">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Address')}}</label>
                <textarea id="address" name="address" rows="2" placeholder="64397 Kuvalis Locks Apt. 124" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $patient->id ? $patient->address : '' }}</textarea>                    
            </div>
        </div>
        <button id="btnSave" onclick="save()" class="cursor-pointer text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            {{-- <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg> --}}
            <span id="buttonText"></span>
        </button>
    </form>
</div>