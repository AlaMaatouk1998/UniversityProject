<template>
<div class="content">
            <card type="secondary"
                  header-classes="bg-white pb-5"
                  body-classes="px-lg-5 py-lg-5"
                  class="border-0 mb-0">

                <template>
                    <div class="text-center text-muted mb-4">
                        <small>Se connecter</small>
                    </div>
                    <form action="#" role="form" @submit.prevent="login">
                        <base-input alternative
                                    class="mb-3"
                                    placeholder="Email"
                                    addon-left-icon="tim-icons inputIcons icon-single-02"
                                    v-model="username"
                                    type="email"
                                    >
                        </base-input>
                        <base-input alternative
                                    type="password"
                                    placeholder="Password"
                                    addon-left-icon="tim-icons inputIcons icon-lock-circle"
                                    v-model="password"
                                    >
                        </base-input>
                        <base-checkbox>
                            Se rappeler de moi
                        </base-checkbox>
                        <div class="text-center">
                            <base-button nativeType="submit" class="my-4">Se connecter</base-button>
                        </div>
                    </form>
                     <div class="login" v-if="loading"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                     <div class="error">{{error}}</div>
                </template>
            </card>
    
</div>
</template>
<script>

import {
  Modal, BaseInput, Card, BaseButton
} from "../components/index";

 export default {
   name :'login',
   components: {
     Modal,
     BaseInput,
     Card,
     BaseButton
   },
   data(){
       return{
        loginModal : true,
        username : '',
        password : '',
        error:'',
        loading: false
       }
   },
   methods:{
       login(){
           if(this.username !='' && this.password !=''){
            this.loading = true;
             this.$store.dispatch('retrieveToken', {
               username: this.username,
               password: this.password
                })
                .then(response => {
                        console.log(response)
                        // localStorage.removeItem('associations');
                        // localStorage.removeItem('dons');
                        // localStorage.removeItem('users');
                        this.$router.push('/gerer/universites')
                    
                })
                .catch(error =>{
                    this.loading = false;
                    this.error = "Veuillez vérifier vos identifiants";
                    console.log(error)
                })             
           }

       },
        AuthProvider(provider) {
              var self = this
              this.$auth.authenticate(provider).then(response =>{
                self.SocialLogin(provider, response)
 
                }).catch(err => {
                    console.log({err:err})
                })
            },
 
            SocialLogin(provider, response){
                var self = this
                this.$http.post('/sociallogin/'+provider, response).then(response => {
                    let accessToken = response.data.token;
                    console.log(accessToken);
                    self.$store.dispatch('socialLogin', {
                         accessToken: accessToken,
                         provider: provider
                    })
                    .then(response => {
                        this.$router.push('/gerer/universites')
                    })
                    
 
                }).catch(err => {
                    console.log({err:err})
                })
            },
   },
   mounted(){

   }
 }
</script>
<style scoped>
@-webkit-keyframes rotating /* Safari and Chrome */ {
  from {
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes rotating {
  from {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.rotating {
  -webkit-animation: rotating 2s linear infinite;
  -moz-animation: rotating 2s linear infinite;
  -ms-animation: rotating 2s linear infinite;
  -o-animation: rotating 2s linear infinite;
  animation: rotating 2s linear infinite;
}

.login{
    font-size: 22px;  
    color: #2ed573;
}
.error{
    color: #ff7675
}
@media screen and (min-width: 768px){
  .content{
      padding : 120px;
  }
}
.tim-icons .icon-single-02 {
    color:black !important;
}
.input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
    border-color: rgba(29, 37, 59, 0.5)!important;
}
</style>