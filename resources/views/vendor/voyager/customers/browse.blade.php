@extends('vendor.voyager.bread.browse')

@section('javascript')
    @parent
    <script>
        let customersList = [];
        loadCustomers();
        function loadCustomers() {
            let customers = [];
            $.get('/admin/load-relations', function(response) {
                customers = response.customers;
                customersList = response.customers
                let _html = '<ul class="customers-list">';
                customers.forEach(customer => {
                    _html += '<li>' + customer.route.route_name + '</li>';
                });
                _html += '</ul>'
                $('.input-group').append(_html)
            })
        }

       /* $('.input-group input').on('keyup', function() {
            const search_key = $('#search_key').val();
            const value = $(this).val();
            if (search_key && search_key === 'route_id' && value.length) {
                let customers = customersList.filter(x => x.indexOf(value) )
              //  console.log('customers', customers)
                $('.customers-list').show();
            } else {
                $('.customers-list').hide();
            }
        })*/
    </script>
@endsection
