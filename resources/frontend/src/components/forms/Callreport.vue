<template>
  <div class="card mb-3">
    <div class="card-body text-center">
      <form-header></form-header>
      <h4 class="mb-2">{{ title }}</h4>
      <div class="dropdown-divider"></div>
      <b-row>
        <b-col class="text-left">
          <b-row>
            <b-col class="text-center"><h5>Job Site</h5></b-col>
          </b-row>
          <b-form-checkbox-group v-model="selectedCustomerType" class="mt-3 mb-3">
            <b-row>
              <b-col v-for="item in customerTypes" :key="item.value" class="col-md-6" >
                <b-form-checkbox :value="item.value">{{ item.text }}</b-form-checkbox>
              </b-col>
            </b-row>
          </b-form-checkbox-group>
          <div v-for="item in inputGroup1" :key="item.label">
            <label >{{ item.label }}</label>
            <b-form-input v-model="formModel1[item.model]"></b-form-input>
          </div>
          <b-form-checkbox-group v-model="selectedJobType" class="mt-3 mb-3">
            <b-row>
              <b-col v-for="item in jobTypes" :key="item.value" class="col-md-6" >
                <b-form-checkbox :value="item.value">{{ item.text }}</b-form-checkbox>
              </b-col>
            </b-row>
          </b-form-checkbox-group>
          <div v-for="item in inputGroup2" :key="item.label">
            <label >{{ item.label }}</label>
            <b-form-input v-model="formModel2[item.model]"></b-form-input>
          </div>
        </b-col>
        <b-col class="text-left">
          <b-row class="mt-2">
            <b-col class="text-center"><h5>Owner/Insured Information</h5></b-col>
          </b-row>
          <div v-for="item in inputGroup3" :key="item.label">
            <label >{{ item.label }}</label>
            <b-form-checkbox v-model="sameJobAddress" v-if="item.model == 'address'" id="copy_address">Same as job address</b-form-checkbox>
            <b-form-checkbox v-model="sameContactName" v-if="item.model == 'ownerName'" id="copy_name">Same as contact name</b-form-checkbox>
            <b-form-input v-model="formModel3[item.model]"></b-form-input>
          </div>
          <b-row>
            <b-col class="text-center"><h5>Insurance Information</h5></b-col>
          </b-row>
          <div v-for="item in inputGroup4" :key="item.label">
            <label >{{ item.label }}</label>
            <b-form-input v-model="formModel4[item.model]"></b-form-input>
          </div>
        </b-col>
      </b-row>
      <notes></notes>
    </div>
  </div>
</template>

<script type="text/babel">
  import FormHeader from './FormHeader'
  import Notes from './Notes'

  export default {
    components: { FormHeader, Notes },
    props: ['title'],
    data () {
      return {
        customerTypes: [
          { text: 'Residential', value: 'residential' },
          { text: 'Commercial', value: 'commercial' },
          { text: 'Owner/Insured', value: 'owner' },
          { text: 'Tenant', value: 'tenant' }
        ],
        selectedCustomerType: [],
        inputGroup1: [
          { label: 'Contact Name:', model: 'contactName' },
          { label: 'Contact Phone:', model: 'contactPhone' },
          { label: 'Site Phone:', model: 'sitePhone' },
          { label: 'Date Contacted:', model: 'contactedDate' },
          { label: 'Time Contacted:', model: 'contactedTime' },
          { label: 'Date of Loss:', model: 'lossDate' },
          { label: 'Point of Loss:', model: 'lossPoint' },
          { label: 'Date Completed:', model: 'completedDate' }
        ],
        formModel1: {
          contactName: null,
          contactPhone: null,
          sitePhone: null,
          contactedDate: null,
          contactedTime: null,
          lossDate: null,
          lossPoint: null,
          completedDate: null
        },
        jobTypes: [
          { text: 'Water', value: 'water' },
          { text: 'Sewage', value: 'sewage' },
          { text: 'Mold', value: 'mold' },
          { text: 'Fire', value: 'fire' }
        ],
        selectedJobType: [],
        inputGroup2: [
          { label: 'Category:', model: 'category' },
          { label: 'Class:', model: 'class' },
          { label: 'Job Address:', model: 'jobAddress' },
          { label: 'City:', model: 'city' },
          { label: 'State:', model: 'state' },
          { label: 'Zip Code:', model: 'zipcode' },
          { label: 'Cross Streets:', model: 'crossStreet' },
          { label: 'Apartment Name:', model: 'apartmentName' },
          { label: 'Building #', model: 'buildingNumber' },
          { label: 'Apartment #', model: 'apartmentNumber' },
          { label: 'Gate Code:', model: 'gateCode' },
          { label: 'Assigned to:', model: 'assignedTo' }
        ],
        formModel2: {
          category: null,
          class: null,
          jobAddress: null,
          city: null,
          state: null,
          zipcode: null,
          crossStreet: null,
          apartmentName: null,
          buildingNumber: null,
          apartmentNumber: null,
          gateCode: null,
          assignedTo: null
        },
        sameJobAddress: false,
        sameContactName: false,
        inputGroup3: [
          { label: 'Owner/Insured Name:', model: 'ownerName' },
          { label: 'Billing Address:', model: 'address' },
          { label: 'City:', model: 'city' },
          { label: 'State:', model: 'state' },
          { label: 'Zip Code:', model: 'zipcode' },
          { label: 'Home Phone:', model: 'homePhone' },
          { label: 'Cell Phone:', model: 'cellPhone' },
          { label: 'Work Phone:', model: 'workPhone' },
          { label: 'Email:', model: 'email' },
          { label: 'Fax:', model: 'fax' }
        ],
        formModel3: {
          ownerName: null,
          address: null,
          city: null,
          state: null,
          zipcode: null,
          homePhone: null,
          cellPhone: null,
          workPhone: null,
          email: null,
          fax: null
        },
        inputGroup4: [
          { label: 'Claim #', model: 'claimNumber' },
          { label: 'Insurance Company:', model: 'insurance' },
          { label: 'Policy #', model: 'policy' },
          { label: 'Deductible:', model: 'deductible' },
          { label: 'Insurance Adjuster:', model: 'adjuster' },
          { label: 'Address', model: 'address' },
          { label: 'City:', model: 'city' },
          { label: 'State:', model: 'state' },
          { label: 'Zip Code:', model: 'zipcode' },
          { label: 'Work Phone:', model: 'workPhone' },
          { label: 'Cell Phone:', model: 'cellPhone' },
          { label: 'Email:', model: 'email' },
          { label: 'Fax:', model: 'fax' }
        ],
        formModel4: {
          claimNumber: null,
          insurance: null,
          policy: null,
          deductible: null,
          adjuster: null,
          address: null,
          city: null,
          state: null,
          zipcode: null,
          workPhone: null,
          cellPhone: null,
          email: null,
          fax: null
        }
      }
    },
    watch: {
      sameJobAddress: function () {
        if (this.sameJobAddress) {
          this.formModel3.address = this.formModel2.jobAddress
          this.formModel3.city = this.formModel2.city
          this.formModel3.state = this.formModel2.state
          this.formModel3.zipcode = this.formModel2.zipcode
        } else {
          this.formModel3.address = ''
          this.formModel3.city = ''
          this.formModel3.state = ''
          this.formModel3.zipcode = ''
        }
      },
      sameContactName: function () {
        if (this.sameContactName) {
          this.formModel3.ownerName = this.formModel1.contactName
        } else {
          this.formModel3.ownerName = ''
        }
      }
    }
  }
</script>