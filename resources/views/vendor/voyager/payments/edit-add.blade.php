@extends('vendor.voyager.bread.edit-add')

@section('javascript')
    @parent
    <script>

        $('#invoice_id select').on('change', function() {
            const saleID = $(this).val();
            let url = '/admin/sales/' + saleID + '/get/payment';
            if (saleID) {
                $.get(url, function(response) {
                    if (response.status) {
                        $('#invoice_id label').html('Invoice # <a href="/admin/sales/' + saleID + '/invoice" target="_blank">(View)</a>');
                        $('#amount input').prop('max', Number('{{ $dataTypeContent->amount }}') +  Number(response.data.remainingAmount));
                        $('.total-amount, .paid, .remaining').empty();
                        $('#amount').append('<span class="badge-amount total-amount badge badge-warning">Total: '+ response.data.totalAmount +'</span>');
                        if(response.data.totalPayment) {
                            $('#amount').append('<span class="paid badge-amount badge badge-success">Paid: '+ response.data.totalPayment  +'</span>');
                            if(response.data.remainingAmount) {
                                $('#amount').append('<span class="remaining badge-amount badge badge-danger">Due: '+ response.data.remainingAmount  +'</span>');
                            }
                        }
                    }
                })
            }
        });


        $('#invoice_id select').trigger('change');

    </script>
@endsection
