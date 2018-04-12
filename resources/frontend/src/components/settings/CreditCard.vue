<template>
    <div class="settings-credit-card">
        <div class="card text-center">
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="">
                    <form @submit.prevent="subscribe">
                        <div class="form-group row justify-content-end">
                            <label class="col-md-3 col-form-label text-right">Card Number</label>
                            <div class="col-md-9 row justify-content-start">
                              <card-number class='stripe-element card-number col-md-8 p-0'
                                ref='cardNumber'
                                :stripe='stripe'
                                :options='stripeOptions'
                                @change="change($event, 'number')"
                              />
                            </div>
                            <div class="card-err col-md-9 float-right" role="alert" v-text="cardError.number"></div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <label class="col-md-3 col-form-label text-right">Expiration Date</label>
                            <div class="col-md-9 row justify-content-start">
                              <card-expiry class='stripe-element card-expiry col-md-4 p-0'
                                ref='cardExpiry'
                                :stripe='stripe'
                                :options='stripeOptions'
                                @change="change($event, 'expiry')"
                              />
                            </div>
                            <div class="card-err col-md-9 float-right" role="alert" v-text="cardError.expiry"></div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <label class="col-md-3 col-form-label text-right">CVC</label>
                            <div class="col-md-9 row justify-content-start">
                              <card-cvc class='stripe-element card-cvc col-md-2 p-0'
                                ref='cardCvc'
                                :stripe='stripe'
                                :options='stripeOptions'
                                @change="change($event, 'cvc')"
                              />
                            </div>
                            <div class="card-err col-md-9 float-right" role="alert" v-text="cardError.cvc"></div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <label class="col-md-3 align-items-center text-right">Postal Code</label>
                            <div class="col-md-9 row justify-content-start">
                              <postal-code class='stripe-element postal-code col-md-2 p-0'
                                ref='postalCode'
                                :stripe='stripe'
                                :options='stripeOptions'
                                @change="change($event, 'postal')"
                              />
                            </div>
                            <div class="card-err col-md-9 float-right" role="alert" v-text="cardError.postal"></div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-md-7">
                              <input type="submit" class="btn btn-sm btn-primary" value="Update" :disabled="pending"/>
                            </div>
                        </div>
                    </form>
                </b-container>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import { CardNumber, CardExpiry, CardCvc, PostalCode, createToken } from 'vue-stripe-elements-plus'
import apiAccount from '../../api/account'
import ErrorHandler from '../../mixins/error-handler'

export default {
  mixins: [ErrorHandler],
  name: 'credit-card',
  components: {
    CardNumber, CardExpiry, CardCvc, PostalCode
  },
  data() {
    return {
      complete: false,
      pending: false,
      cardInfo: {
        number: false,
        expiry: false,
        cvc: false,
        postal: false
      },
      cardError: {
        number: '',
        expiry: '',
        cvc: '',
        postal: ''
      },
      stripe: '',
      stripeOptions: {
        style: {
          base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Raleway", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#dc3545',
            iconColor: '#dc3545'
          },
          complete: {
            color: 'green'
          }
        }
      }
    }
  },
  created() {
    this.stripe = this.$config.get('stripe_key')
  },
  methods: {
    change (event, label) {
      this.cardInfo[label] = event.complete
      this.cardError[label] = event.error ? event.error.message : ''
      this.complete = this.cardInfo.number && this.cardInfo.expiry && this.cardInfo.cvc && this.cardInfo.postal
    },

    subscribe() {
      this.pending = true
      let self = this
      createToken().then(data => {
        if (data.error) {
          self.pending = false
          return
        }
        var token = data.token
        apiAccount.subscribe({'stripeToken': token.id})
          .then(response => {
            self.$notify({
              type: 'info',
              title: response.data.message
            })
            self.pending = false
            this.$router.push({name: 'Company'})
          })
          .catch(err => {
            self.handleErrorResponse(err)
            self.pending = false
          })
      })
    }
  }
}
</script>
<style type="text/css" lang="scss" rel="stylesheet/scss">
    .settings-credit-card {
        .StripeElement {
          background-color: white;
          height: 31px;
          padding: 6px 8px;
          border-radius: 0.25rem;
          border: 1px solid #ced4da;
          -webkit-transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
          transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .StripeElement--focus {
          color: #495057;
          background-color: #fff;
          border-color: #80bdff;
          outline: 0;
          box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .StripeElement--invalid {
          border-color: #dc3545;
        }

        .StripeElement--webkit-autofill {
          background-color: #fefde5 !important;
        }

        .card-err {
          color: #dc3545;
        }

        label {
          padding: 3px 12px !important;
        }
    }
</style>
