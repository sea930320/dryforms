<template>
  <div class="card" style="min-height: 100vh;">
    <div class="card-body text-center">
      <form-header></form-header> 
      <h4 class="mb-2">{{ $route.meta.title }}</h4>
      <div class="dropdown-divider"></div>
      <form-banner class="mt-2"></form-banner>
      <div class="dropdown-divider"></div>
      <b-row v-for="item in equipments" :key="item.name">
        <b-col class="text-left">
          <p>
            <span style="font-weight:bold;">{{ item.name }}: </span>
            <span>&nbsp;-&nbsp;{{ item.info }}</span>
          </p>
        </b-col>        
      </b-row>
      <b-row>
        <b-col cols="6">
          <h5>Air Mover - Dry Air Tempest</h5>
          <table class="text-left mt-2">
            <tr>
              <th>Equipment #</th>
              <th>Set Date</th>
              <th>P/U Date</th>
            </tr>
            <tr v-for="item in airMovers" :key="item.id">
              <th>{{ item.id }}</th>
              <th>{{ item.setDate }}</th>
              <th>{{ item.pickDate }}</th>
            </tr>
          </table>
        </b-col>
        <b-col cols="6">
          <h5>Dehumidifier - Dri-Eaz LGR 7000XLi</h5>
          <table class="text-left mt-2">
            <tr>
              <th>Equipment #</th>
              <th>Set Date</th>
              <th>P/U Date</th>
            </tr>
            <tr v-for="item in dehumidifiers" :key="item.id">
              <th>{{ item.id }}</th>
              <th>{{ item.setDate }}</th>
              <th>{{ item.pickDate }}</th>
            </tr>
          </table>
        </b-col>
      </b-row>
      <notes class="mt-3"></notes>
      <footer-text class="mt-3"></footer-text>
      <signature class="mt-3"></signature>
    </div>
  </div>
</template>

<script type="text/babel">
  import FormHeader from './FormHeader'
  import FormBanner from './FormBanner'
  import Notes from './Notes'
  import FooterText from './FooterText'
  import Signature from './Signature'

  export default {
    components: { FormHeader, FormBanner, Notes, FooterText, Signature },
    data () {
      return {
        equipments: [
          {
            name: 'Air Movers',
            info: 'Air movers are designed to increase the rate of evaporation by changing water from a liquid into a vapor.'
          },
          {
            name: 'Dehumidifiers',
            info: 'Dehumidifiers are designed to reduce the humidity in the air. This helps increase the rate of drying.'
          },
          {
            name: 'Equipment Responsibility',
            info: 'By signing below the customer certifies that they have been informed and understand that they are responsible for loss or theft of the equipment while it is in their care and custody. This also certifies that the customer agrees to allow a company technician access to the property during normal business hours to monitor the equipment.'
          },
          {
            name: 'Safety and Health',
            info: ' If air movers and/or dehumidifiers must be moved, they must be shut off and unplugged as it may be hazardous to move while they are in operation. Exposed tackless strip is a danger even when covered. Please take care when walking near tackless strip. The floors may be slippery when wet. Please take extreme care if walking on or from wet flooring materials.'
          }
        ],
        airMovers: [
          {
            id: '#A0001',
            setDate: '9/23/2017',
            pickDate: '9/23/2017'
          },
          {
            id: '#A0002',
            setDate: '9/23/2017',
            pickDate: '9/23/2017'
          },
          {
            id: '#A0002',
            setDate: '9/23/2017',
            pickDate: '9/23/2017'
          }
        ],
        dehumidifiers: [
          {
            id: '#D0001',
            setDate: '9/23/2017',
            pickDate: '9/23/2017'
          },
          {
            id: '#D0002',
            setDate: '9/23/2017',
            pickDate: '9/23/2017'
          },
          {
            id: '#D0002',
            setDate: '9/23/2017',
            pickDate: '9/23/2017'
          }
        ]
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
  table {
    width: 100%;
  }
</style>