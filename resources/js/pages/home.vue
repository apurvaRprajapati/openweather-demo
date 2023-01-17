<template>
  <div class="row">
    <div class="col-lg-10 m-auto">
      <b-modal
            id="fetch-weather"
            :title=modalTitle
            ref="fetch-weather-modal"
            hide-footer
          > 
            <div>
                <b-alert :show="validationBlock" variant="danger">
                    <p class="mb-0" v-for="(value, key, index) in validations" :key="index">
                       {{value}}
                    </p>
                </b-alert>
            </div>
            <b-form ref="form" @submit="onSubmit">
                <b-form-group label="City" class="mt-1" label-for="city">
                    <b-form-input id="city" v-model="form.city" required></b-form-input>
                </b-form-group>
                <div style="margin-top: 10px;">
                  <b-button type="submit" variant="primary" style="float:right">Submit</b-button>
                </div>
            </b-form>
          </b-modal>

          <b-modal
            id="fetch-forecast"
            title="Fetch weather forecst of city"
            ref="fetch-forecast-modal"
            hide-footer
          > 
            <div>
                <b-alert :show="validationBlock" variant="danger">
                    <p class="mb-0" v-for="(value, key, index) in validations" :key="index">
                       {{value}}
                    </p>
                </b-alert>
            </div>
            <b-form ref="form" @submit="onSubmitForecast">
                <b-form-group label="City" class="mt-1" label-for="city">
                    <b-form-input id="city" v-model="form.city" required></b-form-input>
                </b-form-group>
                <div style="margin-top: 10px;">
                  <b-button type="submit" variant="primary" style="float:right">Submit</b-button>
                </div>
            </b-form>
          </b-modal>
          <div>
            <b-button variant="outline-primary" @click="openFetchForecastModal" style="margin-top:10px;margin-bottom:10px;">Get forecast of five days</b-button>
            <b-button variant="outline-primary" @click="openFetchWeatherModal" style="margin-top:10px;margin-bottom:10px;float:right">Get todays weather</b-button>
            <b-table hover :fields="fields" :items="items"></b-table>
          </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  middleware: 'auth',

  data: () => ({
      items: [],
      showAlert: false,
      variant:'success',
      alertContent: 'Success',
      modalShow:false,
      modalTitle:"Fetch weather of city",
      validationBlock:false,
      validations:[],
      form: {
        city:'',
      },
      fields : [],
      forecastFields:[
          { key: 'datetime', label: 'Date Time'},
          { key: 'name', label: 'City Name'},
          { key: 'openweather_id', label: 'City Id'},
          { key: 'main', label: 'Main'},
          { key: 'description', label: 'Description'},
          { key: 'visibility', label: 'Visibility'},
          { key: 'temp', label: 'Temp'},
          { key: 'pressure', label: 'Pressure'},
          { key: 'humidity', label: 'Humidity'},
      ],
      weatherFields: [     
                  { key: 'name', label: 'City Name'},
                  { key: 'openweather_id', label: 'City Id'},
                  { key: 'main', label: 'Main'},
                  { key: 'description', label: 'Description'},
                  { key: 'visibility', label: 'Visibility'},
                  { key: 'temp', label: 'Temp'},
                  { key: 'pressure', label: 'Pressure'},
                  { key: 'humidity', label: 'Humidity'},
              ],
        
    }),
  mounted() {
    this.fetchDefaultData()
    this.fields = this.weatherFields
  },
  metaInfo () {
    return { title: this.$t('home') }
  },
  methods: {
    openFetchWeatherModal() {
      this.form.city = ""
      this.$refs['fetch-weather-modal'].show()
    },
    openFetchForecastModal() {
      this.form.city = ""
      this.$refs['fetch-forecast-modal'].show()
    },
    fetchDefaultData() {
      axios.get(`/api/fetchDefaultData/`).then((result) => {
          this.items = result.data.data
          this.fields = this.weatherFields
         }).catch((err) => {
                
         })
    },
    onSubmit(event) {
      event.preventDefault()
       axios.get(`/api/fetchWeather/${this.form.city}`).then((result) => {
          console.log("result")        
          console.log(result)
          this.$refs['fetch-weather-modal'].hide()
          this.items = result.data.data
          this.form.city = ""
          this.fields = this.weatherFields
         }).catch((err) => {
                
         })
    },
    onSubmitForecast(event) {
      event.preventDefault()
       axios.get(`/api/fetchForecast/${this.form.city}`).then((result) => {
          this.$refs['fetch-forecast-modal'].hide()
          this.items = result.data.data
          this.form.city = ""
          this.fields = this.forecastFields
         }).catch((err) => {
                
         })
    }
  }
}
</script>
