@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('vendor.voyager.bread.edit-add')

@section('javascript')
    @parent
    <script>
        $(document).ready(function() {
            @if($add)
                $('#customer input').val('Walking Customer');
                $('#rate input').val('{{ setting('admin.rate') }}')
            @endif
			
			$("#ticket-type select").on("change", function() {
				const type = $(this).val();
				$('#person label').text(`Number of ${type}`);
			});
            $('#person input, #rate input').on('keyup', function() {
                const person = $('#person input').val();
                const rate = $('#rate input').val();
                if (person && rate) {
                    $('#amount input').val(person * rate);
                } else {
                    $('#amount input').val('');
                }
            });
            $('#amount input').attr('readonly', true);
            $('.save').text('save and print');
			$('#ticket-type select').trigger('change');
        });

    </script>
@endsection
