@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('vendor.voyager.bread.edit-add')

@section('javascript')
    @parent
    <script>
        $(document).ready(function() {
            $('#quantity input, #rate input').on('keyup', function() {
                const quantity = $('#quantity input').val();
                const rate = $('#rate input').val();
                if (quantity && rate) {
                    $('#amount input').val(quantity * rate);
                } else {
                    $('#amount input').val('');
                }
            });
            $('#amount input').attr('readonly', true);

            let years = [];
            for(let i = new Date().getFullYear(); i > 1970; i--) {
                $('#expense_year select').append(`<option>${i}</option>`)
            }
        });

    </script>
@endsection
