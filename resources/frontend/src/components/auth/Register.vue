<template>
  <div class="card text-center">
    <div class="card-header">
      <h4>Sign Up</h4>
    </div>
    <div class="card-body text-left">
      <b-row align-h="center">
        <b-col cols="3"><button class="social-sign facebook" @click="fbLogin()">Log in with Facebook</button></b-col>
        <b-col cols="3"><button class="social-sign google" @click="gLogin()">Log in with Google+</button></b-col>
      </b-row>
      <form class="form text-right mt-3">
        <div class="form-group row">
          <label class="col-md-3 col-form-label">First Name</label>
          <input type="text" class="form-control col-md-6" v-model="user.first_name">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Last Name</label>
          <input type="text" class="form-control col-md-6" v-model="user.last_name">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Street Address</label>
          <input type="text" class="form-control col-md-6" v-model="user.address">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">City</label>
          <input type="text" class="form-control col-md-6" v-model="user.city">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">State</label>
          <input type="text" class="form-control col-md-6" v-model="user.state">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Zip Code</label>
          <input type="text" class="form-control col-md-6" v-model="user.zip">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Phone</label>
          <input type="text" class="form-control col-md-6" placeholder="555-123-1223" v-model="user.phone">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Email address</label>
          <input type="email" class="form-control col-md-6" placeholder="Enter email" v-model="user.email">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Password</label>
          <input type="password" class="form-control col-md-6" placeholder="Password" v-model="user.password">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Password Confirmation</label>
          <input type="password" class="form-control col-md-6" placeholder="Password" v-model="user.password_confirmation">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Coupon</label>
          <input type="text" class="form-control col-md-6" v-model="user.coupon">
        </div>
        <div class="text-center">
          <h6>Payment information</h6>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Card Number</label>
          <input type="text" class="form-control col-md-6" v-model="user.card_number">
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Expiration Date</label>
          <div class="col-md-6 row">
            <input type="text" class="form-control col-md-3 mr-2" placeholder="mm" v-model="user.card_month">
            <input type="text" class="form-control col-md-3" placeholder="yyyy" v-model="user.card_year">  
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">CVV</label>
           <div class="col-md-6 row">
            <input type="text" class="form-control col-md-3" placeholder="XXX" v-model="user.card_cvv">
          </div> 
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label">Postal Code</label>
           <div class="col-md-6 row">
            <input type="text" class="form-control col-md-3" v-model="user.card_cvv">
          </div> 
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <b-checkbox v-model="agreement">I have read and agree to the <a href="#">terms and conditions</a> of DryFormsPlus.com</b-checkbox>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer text-muted">
      <b-button variant="primary" :disabled="!agreement || clicked" @click.prevent="register()" @click.nativ="clicked = true">Subscribe</b-button>
    </div>
  </div>
</template>

<script type="text/babel">
  import authorization from '../../mixins/authorization'

  export default {
    name: 'Register',
    mixins: [authorization],
    data() {
      return {
        agreement: false,
        clicked: false,
        user: {}
      }
    },
    methods: {
      fbLogin () {},
      gLogin () {}
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
  .social-sign {
    width: 100%;
    border: none;
    border-radius: 2px;
    font-weight: 500;
    color: white;
    padding: 5px;
    cursor: pointer;
    transition: .2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0 , 0.4);
    &:hover, &:focus {
      box-shadow: 0 2px 4px rgba(0, 0, 0 , 0.4);
      transition: .2s ease;
    }
    &:active {
      box-shadow: 0 1px 2px rgba(0, 0, 0 , 0.4);
      transition: .2s ease;  
    }
  }
  .facebook {
    background-color: #32508E;
  }
  .google {
    background-color: #DD4B39
  }
</style>
