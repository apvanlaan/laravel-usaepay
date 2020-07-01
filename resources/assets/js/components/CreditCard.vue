<template>
    <div>
        <label for="paymentCardContainer">Credit/Debit Card</label>
        <div id="paymentCardContainer">
        </div>
        <div id="paymentCardErrorContainer"role="alert">
           {{errormsg}}
        </div>
    </div>
</template>

<script>

export default {
    props: ['publickey','styling'],
    data() {
        return {
            errormsg:'',
            client:null,
            paymentCard:null,
            paymentkey:'',
        }
    },
    
    methods: {

    },
    watch:{
        
    },
    computed: {
        
    },
    mounted: function(){
        // Instantiate Client with Public API Key
        this.client = new usaepay.Client(this.publickey);
        // Instantiate Payment Card Entry
        this.paymentCard = this.client.createPaymentCardEntry();
        this.paymentCard.generateHTML();
        
        this.paymentCard.addHTML('paymentCardContainer');        
        // listen for errors so that you can display error messages
        this.paymentCard.addEventListener('error', errorMessage => {
            self.errormsg = errorMessage;
        });

       
    }
}

</script>