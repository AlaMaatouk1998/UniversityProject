<template>
<div class="content">
  <card>
    <template slot="header">
      <h5 class="title">{{!ar ?'Associations' : 'قائمة&nbsp;الجمعيات'}}</h5>
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
                <slot nom="columns">
                <th>{{!ar ? 'Nom' : 'الاسم'}}</th>
                <th>{{!ar ? 'Telephone' : 'الهاتف'}}</th>
                <th>{{!ar ? 'Email' : 'البريد الإلكتروني'}}</th>
                <th>{{!ar ? 'Gouvernorat' : 'الولاية'}}</th>
                </slot>
            </tr>
            </thead>
            <tbody >
              <tr v-if="loading">
                <td colspan="7" >
                  <div class="login text-center"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                </td>
              </tr>
            <tr v-for="(association, index) in filtredAssociations"
                        :key="index"
                        >
                <td>{{association.nom}}</td>
                <td>{{association.telephone}}</td>

                <td>{{association.adresse.adresse}}</td>
                <td>{{association.adresse.gouvernorat}}</td>

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
            newAssociation: false,
            deleteAssociation: false
        },
      loading: true,
      filtre: ''
    }
 },
 methods:{
        onFiltreGouvernoratChange(event){
          this.filtredAssociations = this.associations.filter(function (el) {
            return el.adresse.gouvernorat == event.target.value
          });
        },
        onEtatChange(event){
          this.filtredAssociations = this.associations.filter(function (el) {
            return el.role == event.target.value
          });
        },
        onFiltreAll(){
          this.filtre = '';
          this.filtredAssociations = this.associations;
         }


     },
    mounted(){
        this.$store.dispatch('getAssociations')
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
      associations: {
           get(){
            return this.$store.getters.associations;
           },
        },
      filtredAssociations: {
           get(){
            return this.$store.getters.filtredAssociations;
           },
           set(value) { this.$store.commit('setFiltredAssociations', JSON.stringify(value)); },
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
