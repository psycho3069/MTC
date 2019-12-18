<script>
    $(document).ready(function () {
        $('button').click(function (e) {
            e.preventDefault()



            var debit = [];
            var debit_id = [];
            var credit = [];

            // var users = $('input:text.debit').serialize();
            // console.log(users)

            var result = { };
            $.each($('form').serializeArray(), function() {
                result[this.name] = this.value;
            });



            $("input[name^='debit']").map(function () {
                // console.log(ele.name+':'+$(this).val());
                debit.push({
                    value: $(this).val()
                })
            })

            $('#debit_id').map(function () {
                debit_id.push({
                    key: $(this).val()
                })
            })
            $("input[name^='credit']").map(function () {
                credit.push({
                    value: $(this).val()
                })
            })

            console.log(debit)
            console.log(credit)


            $('input[name^="debit"]').each(function() {

                debit.push($(this).val())

            });

            console.log(debit)

            var debit = $('input[name="debit[]"]').val()
            alert(debit)
            var debit = []
             debit = $('.debit').val()
            $('.debit').each(function () {
                var d_amount =$(this).find('input[name="debit"]').eq(index).val()
                debit.push({
                    index: d_amount
                })
            })
            console.log(debit)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
                }
            })

            $.ajax({
                url: '{{ route("balance.validation") }}',
                method: 'post',
                data: {
                    debit: $('')
                }
            })
        })
    })


    $(document).ready(function(){
        $('#create_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"{{ route('storeHeadline') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    if (data == 'success')
                    {
                        sessionStorage.setItem("new_success", "success");
                        window.location = "{{ route('headline') }}";
                    }
                },
                error : function (request, status, error)
                {

                    if(request.responseJSON.errors.headline)
                    {
                        toastr.error('You Got Error', request.responseJSON.errors.headline, {timeOut: 5000})
                    }

                }
            })
        });
    });
</script>



<script>
    $(document).ready(function () {

        var _token = $("input[name='_token']").val()



        $('button').click(function (e) {
            e.preventDefault()

            var debit_all = {};

            var data = $('.debit')

            for (var i = 0; i < data.length; i++){
                debit_all[data[i].name] = data[i].value;
            }

            console.log(typeof(debit_all))

            $.ajax({

                type:'POST',
                url:'{{ route("balance.check") }}',
                data:{_token:_token, debit: debit_all },
                success:function(data){
                    console.log(data)
                }

            });



            {{--$.ajax({--}}
            {{--    url: "{{ route('balance.validation') }}",--}}
            {{--    method: 'post',--}}
            {{--    data: data,--}}
            {{--    success: function (data) {--}}
            {{--        console.log(data)--}}
            {{--    }--}}
            {{--})--}}
        })
    })
</script>
