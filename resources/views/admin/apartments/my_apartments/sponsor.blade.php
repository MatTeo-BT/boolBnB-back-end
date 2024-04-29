<section class="container">
    <div class="row">
        <div class="col 6">
            <div id="dropin-container"></div>
            <button type="button" id="submit-button" class="button button--small button--green">Purchase</button>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let button = document.querySelector('#submit-button');

        braintree.dropin.create({
            authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
            selector: '#dropin-container'
        }, function (err, instance) {
            button.addEventListener('click', function () {
                instance.requestPaymentMethod(function (err, payload) {
                    // Invia payload.nonce al tuo server Laravel
                });
            })
        });
    });
</script>

