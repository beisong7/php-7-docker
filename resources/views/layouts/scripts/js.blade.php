<!-- Core Vendors JS -->
<script src="{{ asset('assets/js/vendors.min.js') }}"></script>

<!-- page js -->
@yield('vendor_js')

<!-- Core JS -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<script>
    function deleteItem(link){
        var answer = prompt("Are you sure? Type 'yes' to perform the operation!");
        if (answer === "yes") {
            //console.log('you said yes')
            window.location.href = link;
        }else{
            console.log('action ignored')
        }
    }

    function deleteItemDynamic(link, className){
        var answer = prompt("Are you sure? Type 'yes' to perform the operation!");
        if (answer === "yes") {
            //console.log('you said yes')
            window.location.href = link;
        }else{
            console.log('action ignored')
        }
    }
</script>
