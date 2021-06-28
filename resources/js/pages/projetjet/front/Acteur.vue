<template>
<div class="content">
  <card>
    <template slot="header">
      <h5 class="title">{{!ar ?'Acteurs&nbsp;etat' : 'قائمة&nbsp;الجهات&nbsp;الحكومية'}}</h5>
      <div class="row filtre">
        <div class="col-sm-4">
          <base-input  :label="!ar ? 'Filtrer par gouvernorat' : ' تصفية حسب الولاية'">
            <select class="form-control " @change="onFiltreGouvernoratChange($event)" v-model="filtre"
            >
                <option v-for="(gouvernorat, index) in gouvernorats"
                        :value="gouvernorat.fr" 
                        :key="index"
                        >{{!ar ? gouvernorat.fr : gouvernorat.ar}}</option>
            </select>
          </base-input>
        </div>
         <div class="col-sm-8">
              <base-button style="    margin-top: 23px;" type="warning" fill v-on:click="onFiltreAll()">{{!ar ? 'Afficher tous' : 'إظهار الكل'}}</base-button>
        </div>
      </div>
    </template>
        <div class="table-responsive">
        <table class="table tablesorter text-left">
            <thead class="text-primary">
            <tr>
                <slot name="columns">
                <th>{{!ar ? 'Nom' : 'الاسم'}}</th>
                <!-- <th>{{!ar ? 'Prénom' : 'اللقب'}}</th> -->
                
                <!-- <th>Adresse</th> -->
                <th>{{!ar ? 'Gouvernorat' : 'الولاية'}}</th>
                <th>{{!ar ? 'Téléphone' : 'الهاتف'}}</th>
                <th>{{!ar ? 'Email' : 'البريد الإلكتروني'}}</th>
                <!-- <th>Affecté à</th>
                <th>Plus d'informations</th> -->
                <!-- <th>{{!ar ? 'Type' : 'المهنة'}}</th> -->
                
                </slot>
            </tr>
            </thead>
            <tbody >
              <tr v-if="loading">
                <td colspan="7" >
                  <div class="login text-center"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                </td>
              </tr>
            <tr v-for="(userp, index) in filtredUsers"
                        :key="index"
                        >
                <td>{{userp.name}} {{userp.lastname}}</td>
                <!-- <td></td> -->
                
                <!-- <td>{{user.adresse.adresse}}</td> -->
                <td>{{userp.gouvernorat}}</td>
                <td>{{userp.telephone}}</td>
                <td>{{userp.email}}</td>
                <!-- <td><base-button simple type="primary" v-on:click="selectActeur(user.user)">Affecté à</base-button></td>
                <td><base-button simple type="primary" v-on:click="selectDon(user)">Plus d'informations</base-button></td> -->
                 <!-- <td>  
                   {{userp.role == 0 ? 'Téléoperateur' : userp.role == 1 ? 'UTSS' : userp.role == 2 ? 'CRCC' : 'Admin ministère'}}    
                </td> -->

            </tr>
            </tbody>
        </table>
        </div>
    <template slot="footer">
      <!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
    </template>
  </card>
 </div>
 
</template>
<script>
import {
  Card,
  BaseInput
} from "../../../components/index";

import BaseButton from '../../../components/BaseButton';
import BaseTable from "../../../components/BaseTable";
import { Modal } from "../../../components/index";
export default{
  components:{
    Card,
    BaseInput,
    BaseButton,
    BaseTable,
    Modal
  },
  data() {
    return {
        modals:{
            donModal: false,
            acteurModal: false,
            newUser: false,
            deleteUser: false
        },
      loading: true,
      filtre: ''
    }
 },
 methods:{

        onFiltreGouvernoratChange(event){
          this.filtredUsers = this.users.filter(function (el) {
            return el.gouvernorat == event.target.value
          });
        },
        onEtatChange(event){
          this.filtredUsers = this.users.filter(function (el) {
            return el.role == event.target.value
          });
        },
        onFiltreAll(){
          this.filtre = '';
          this.filtredUsers = this.users;
         }
        
        
     },
    mounted(){
        this.$store.dispatch('getActeurs')
        .then((response)=>{
          this.loading = false;
        });
    },
    computed:{
        ar() {
          if(this.$route.query.ar)
            return this.$route.query.ar
          return '';
       },
      users: {
           get(){
            return this.$store.getters.users;
           },
        },
      filtredUsers: {
           get(){
            return this.$store.getters.filtredUsers;
           },
           set(value) { this.$store.commit('setfiltredUsers', JSON.stringify(value)); },
        },
        gouvernorats(){
          return this.$store.getters.gouvernorats
        }

    }
}
</script>
<style scoped>
@media screen and (min-width: 768px){
.content{
    padding : 120px;
}
}
.noneBg{
  background: transparent !important;
}
.traite{
    background: #32ff7e;
}
.encours{
    background: #18dcff;
}
.nontraite{
    background: #ff8d72;
}

.tim-icons .icon-single-02 {
    color:black !important;
}
.input-group-append, .input-group-prepend .input-group-text, .input-group-prepend .input-group-text {
    border-color: rgba(29, 37, 59, 0.5)!important;
}
</style>
