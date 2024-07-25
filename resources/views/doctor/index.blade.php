<x-app-layout>
    <x-slot name="header">
        <h5 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Doctors') }}
        </h5>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="card-body p-4">
                        @can('doctor-create')
                        <div class="flex justify-between items-center mb-4">
                            <button class="btn btn-primary cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="btnAdd">
                                <i class="fas fa-plus"></i> Nuevo Doctor
                            </button>
                        </div>
                        @endcan
                        @can('doctor-list')
                        <div class="mt-2 table-responsive card-body">
                            <div class="table-striped table-hover table-sm">
                                {{$dataTable->table()}}
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal" tabindex="-1" aria-hidden="true" class="hidden bg-opacity-60 bg-black overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="modal-content relative p-4 w-full max-w-md max-h-full">
        </div>
    </div> 
    @push('scripts')
    {{$dataTable->scripts()}}
    <script>
        function showModal() {
            $('#modal').removeClass('hidden').addClass('flex');
            $('#closeModal').on('click', function() {
                $('#modal').removeClass('flex').addClass('hidden');
            });
        }
        function hideModal() {
            $('#modal').removeClass('flex').addClass('hidden');
        }
        $('#table-list').on('click', '.action', function() {
            let data = $(this).data();
            let id = data.id;
            let op = data.action;
            if (op == 'edit') {
                $.ajax({
                    method: 'GET',
                    url: `{{ url('doctor') }}/${id}/edit`,
                    success: function(res) {
                        $('#modal').find('.modal-content').html(res);
                        $("#modalTitle").text("{{__('Actualizar Doctor')}}");
                        $("#buttonText").text("{{ __('Update') }}");
                        showModal();
                    }
                });
            }
            if (op == 'delete') {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Este cambio no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'DELETE',
                            url: `{{ url('doctor') }}/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                window.LaravelDataTables["table-list"].ajax.reload();
                                Swal.fire({
                                    icon: response.status,
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                });
                            }
                        });
                    }
                });
            }
        });

        $('#btnAdd').on('click', function() {
            $.ajax({
                method: 'GET',
                url: `{{url('doctor/create')}}`,
                success: function(res) {
                    $('#modal').find('.modal-content').html(res);
                    $("#modalTitle").text("{{__('Registrar Doctor')}}");
                    $("#buttonText").text("{{__('Save')}}");
                    showModal();
                }
            });
        });

        function save() {
            $('#formModal').on('submit', function(e) {
                e.preventDefault();
                const _form = this;
                const formData = new FormData(_form);
                const url = this.getAttribute('action');
                $.ajax({
                    method: 'POST',
                    url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        hideModal();
                        window.LaravelDataTables["table-list"].ajax.reload();
                        Swal.fire({
                            icon: res.status,
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(res) {
                        let errors = res.responseJSON?.errors;
                        $(_form).find(`[name]`).removeClass('is-invalid');
                        $(_form).find('.invalid-feedback').remove();
                        if (errors) {
                            for (const [key, value] of Object.entries(errors)) {
                                $(_form).find(`[name='${key}']`).addClass('is-invalid')
                                $(_form).find(`#msg_${key}`).parent().append(`<span class="invalid-feedback">${value}</span>`);
                            }
                        }
                    }
                });
            })
        }
    </script>
    @endpush
</x-app-layout>
