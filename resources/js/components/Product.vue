<template>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-default">
                    <div class="card-header" v-text="product.name"></div>

                    <div class="card-body" v-text="'Kikiáltási ár: ' + product.price + ' Huf'"></div>

                    <div>
                        <h5>Legutolsó licit:</h5>
                        <h1 v-if="highestBid">{{ highestBid | addCurrency }}</h1>
                        <p v-else>Még nem volt bid, legyél te az első</p>
                    </div>

                    <div>
                        <button @click="bid" :disabled="! bidButtonActive">
                            licitálok...
                        </button>

                        <button @click="whisper">
                            whisper...
                        </button>
                    </div>
                </div>
            </div>

            <div v-show="bids.length" class="col-md-3">
                <h5>Eddigi licitek</h5>
                <ul>
                    <li v-for="bid in bids">
                        {{ bid.amount | addCurrency}} {{ bid.created_at}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['product'],

        filters: {
            addCurrency: function (value) {
                return value + ' HUF';
            }
        },

        mounted() {

            axios.get(`/bids/${this.product.id}`)
                .then(response => {
                    this.bids = response.data.bids;
                    this.highestBid = response.data.highestBid;
                })
                .catch(error => console.log(error));


            // public channel
            // Echo.channel('bid-channel')
            //     .listen('BidHasCreated', (e) => {
            //         this.bids.push(e.bid);
            //         this.highestBid = e.bid.amount;
            //     });

            // better public channel but with security problems
            // Echo.channel(`bid-channel.${this.product.id}`)
            //     .listen('BidHasCreated', (e) => {
            //         this.bids.push(e.bid);
            //         this.highestBid = e.bid.amount;
            //     });

            // private channel with better security
            // Echo.private(`bid-channel.${this.product.id}`)
            //     .listen('BidHasCreated', ({bid}) => {
            //         this.bids.push(bid);
            //         this.highestBid = bid.amount;
            //     });



            // Echo.join(`bid-channel.${this.product.id}`)
            //     .listen('BidHasCreated', ({bid}) => {
            //         this.bids.push(bid);
            //         this.highestBid = bid.amount;
            //     }).here((users) => {
            //     console.log(users);
            // }).joining((user) => {
            //     console.log(user.name);
            // }).leaving((user) => {
            //     console.log(user.name);
            // }).listenForWhisper('typing', () => console.log('without touching the server'));
        },

        data: function(){
            return {
                bidButtonActive: true,
                highestBid: undefined,
                bids: []
            }
        },

        methods: {

            whisper(){
                // Echo.join(`bid-channel.${this.product.id}`)
                //     .whisper('typing');
            },

            bid(){

                this.bidButtonActive = false;

                let bid = {
                    productId: this.product.id,
                    amount: this.calculateBidPrice()
                };

                axios.post('/bids', bid)
                    .then(response => {
                        this.bids.push(response.data);
                        this.highestBid = response.data.amount;
                        this.bidButtonActive = true;
                    })
                    .catch(error => {
                        this.bidButtonActive = true;
                        console.log(error);
                    });
            },

            calculateBidPrice(){
                return this.highestBid ? this.highestBid + 100 : this.product.price;
            },
        }
    }
</script>
