<template>
    <div class="container">
        <br><br>
        <div v-if="validation" class="alert" :class="[validationStatus === 'error' ? 'alert-danger' : 'alert-success']" role="alert">
            <p v-for="message in validation">{{message}}</p>
        </div>
        <div class="row">
            <label for="currency">Please select currency: </label>
            <div class="input-group col-sm mb-3">
                <select id="currency" class="custom-select" v-model="currencySelected" @change="calculateAmount()">
                    <option
                        v-for="currency in currencies"
                        :value="currency">{{currency}}</option>
                </select>
            </div>
            <label for="amount">Amount: </label>
            <div class="input-group col-sm mb-3">
                <input
                    v-model="amount"
                    @keyup="calculateAmount()"
                    class="form-control"
                    placeholder="Enter the amount"
                    aria-label="Username"
                    type="number"
                    id="amount">
            </div>
        </div>
        <br><br>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Selected currency</th>
                <th scope="col">Amount</th>
                <th scope="col">Result in USD</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{currencySelected}}</td>
                <td>{{amount}}</td>
                <td>{{result}}</td>
            </tr>
            </tbody>
        </table>
        <br><br>
        <div>
            <div class="input-group col-sm">
                <button @click="makeOrder()" type="button" class="btn btn-primary">Purchase</button>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'App',
    methods: {
        getCurrencies() {
            axios.post('/api/get-values').then(response => {
                this.currencies = response.data.currencies;
            })
        },
        calculateAmount() {
            if (this.currencySelected !== '' && this.amount !== '') {
                axios.post('/api/calculate-with-surcharge', {currency: this.currencySelected, amount: this.amount}).then(response => {
                    this.result = Math.round(( response.data.amount + Number.EPSILON) * 100) / 100;
                });
            }
        },
        setUpErrorNotification(status, messages) {
            this.validation = messages;
            this.validationStatus = status;
        },
        makeOrder() {
            let $self = this;
            axios.post('/api/make-exchange-order', {currency: this.currencySelected, amount: this.amount})
                .then(response => {
                this.order = response.data;
                this.amount = '';
                this.currencySelected = '';
                this.result = '';
                $self.setUpErrorNotification('successful', [response.data.message]);
            }).catch(function (error) {
                if (error.response) {
                    $self.setUpErrorNotification('error', error.response.data.errors);
                }
            })
        }
    },
    created() {
        this.getCurrencies();
    },
    data() {
        return {
            currencySelected: '',
            currencies: '',
            amount: '',
            result: '',
            order: '',
            validation: '',
            validationStatus: ''
        }
    }
}
</script>

