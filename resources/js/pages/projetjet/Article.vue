<template>
<div class="content">
  <card>
    <template slot="header">
      <h5 class="title">Consulter les demandes</h5>
      <div class="row filtre">
        <div class="col-xl-4">
          <base-input  label="Filtrer par gouvernorat">
            <select class="form-control " @change="onFiltreGouvernoratChange($event)"
            >
                <option v-for="(gouvernorat, index) in gouvernorats"
                        :value="gouvernorat.fr" 
                        :key="index"
                        >{{gouvernorat.fr}}</option>
            </select>
          </base-input>
        </div>
         <div class="col-xl-3" v-if="parseInt(user.role) == 1 || parseInt(user.role) == 2">
              <base-button style="    margin-top: 23px;" type="secondary" fill v-on:click="onFiltreSelf()">Mes demandes</base-button>
        </div>
         <div class="col-xl-2">
              <base-button style="    margin-top: 23px;" type="warning" fill v-on:click="onFiltreAll()">Voir tous</base-button>
        </div>
         <div class="col-xl-3" v-if="parseInt(user.role) == 1 || parseInt(user.role) == 2">
              <base-button    style="   margin-top: 23px;" type="success" fill v-on:click="actionNewArticle()">Ajouter une nouvelle demande</base-button>
        </div>
      </div>
    </template>
        <div class="table-responsive">
        <table class="table tablesorter text-left">
            <thead class="text-primary">
            <tr>
                <slot nom="columns">
                <th>Nom</th>
                <th>Description</th>
                <th>Gouvernorat</th>
                <th>Date</th>
                <th>Demandeur</th>
                <th>&nbsp;</th>
                </slot>
            </tr>
            </thead>
            <tbody >
              <tr v-if="loading">
                <td colspan="7" >
                  <div class="login text-center"><i class="tim-icons  icon-refresh-02 rotating"></i></div>
                </td>
              </tr>
            <tr v-for="(article, index) in filtredArticles"
                        :key="index"
                        >
                <td>{{article.nom}}</td>
                <td>{{article.description}}</td>
                <td>{{article.user.gouvernorat}}</td>
                <td>{{article.created_at}}</td>
                <td><base-button simple type="primary" v-on:click="selectActeur(article.user)">Demandeur</base-button></td>

                <td class="td-actions text-right" v-if="article.user_id == user.id || parseInt(user.role) == 3">
                    <base-button type="success" size="sm" icon v-on:click="selectArticle(article)">
                     <i class="tim-icons icon-settings"></i>
                    </base-button>
                    <base-button type="danger" size="sm" icon v-on:click="selectedArticle = article.id; modals.deleteArticle = true;">
                      <i class="tim-icons icon-simple-remove"></i>
                </base-button>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    <template slot="footer">
      <!-- <base-button type="success" fill v-on:click="saveDon()">Entregistrer</base-button> -->
    </template>
  </card>
  	<modal :show.sync="modals.acteurModal">
		<template slot="header">
			Demandé par
		</template>
        <template>
             <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Type d'acteur:</span>
                  {{this.selectedActeur.role == 1 ? 'UTSS' : 'CRCC'}}
               </p>
            </div>

			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Nom et prénom:</span>
                  {{this.selectedActeur.lastname}} {{this.selectedActeur.name}}
                 </p>
            </div>
			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Gouvernorat:</span>
                  {{this.selectedActeur.gouvernorat}}
                 </p>
            </div>
            	<div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Téléphone:</span>
                  {{this.selectedActeur.telephone}}
               </p>
            </div>

        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.acteurModal = false;"
				>Fermer</base-button
			>
		</template>
	</modal>
  	<modal :show.sync="modals.deleteArticle">
		<template slot="header">
			Supprimer 
		</template>

        Etes-vous sûr de supprimer cette demande

  
		<template slot="footer">
			<base-button type="secondary" @click="modals.deleteArticle = false;"
				>Annuler</base-button
			>
			<base-button type="danger" @click="deleteArticle()"
				>Supprimer</base-button
			>
		</template>
	</modal>
	<modal :show.sync="modals.newArticle"  class="text-left">
		<template slot="header">
			Ajouter une nouvelle demande
		</template>

        <template>
            <base-input label="Nom : "
                  v-model="newArticle.nom"
                  type="text"
                  placeholder="Nom :">
             </base-input>
            <base-input label="Description :"
                  v-model="newArticle.description"
                  type="text"
                  placeholder="Description">
             </base-input>

        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.newArticle = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="actionArticle"
				>{{this.action == 'create'? 'Ajouter' : 'Update'}}</base-button
			>
     
		</template>
  
	</modal>
 </div>
 
</template>
<script>
import {
  Card,
  BaseInput
} from "../../components/index";

import BaseButton from '../../components/BaseButton';
import BaseTable from "../../components/BaseTable";
import { Modal } from "../../components/index";
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
            newArticle: false,
            deleteArticle: false
        },
      loading: true,
      selectedDon: {
        adresse:{

        }
      },
      selectedActeur: {
        adresse:{

        }
      },
      newArticle:{
      },
      action: 'create',
      selectedArticle: 0
    }
 },
 methods:{
     saveDon(){
         if(this.modal.nom != '' || this.modal.adresse != '' || this.modal.description != '')
         this.$store.dispatch('newDon', this.model)
           .then(response => {
               //console.log(response);
            //    this.acteur = response;
               this.modals.donModal = true;
           })
             
         },
        onEtatChange(event, donId) {
         this.$store.dispatch('updateEtatDon', {
           donId: donId,
           etat: event.target.value
         })
           .then(response => {
               //console.log(response);
               //Notifier
           })
        },
        actionArticle(){
        if(this.action == 'create'){
            this.newArticle['userId'] = this.user.id;
            this.$store.dispatch('newArticle', this.newArticle)
           .then(response => {
               //console.log(response);
		  	this.$notify({
				icon: "tim-icons icon-bell-55",
				horizontalAlign: 'right',
				verticalAlign: 'top',
				type: 'success',
				timeout: 4000,
				message: 'Nouvelle demande crée!'
            });
            this.modals.newArticle = false;
           })
        }else if (this.action == 'update'){
     
            this.$store.dispatch('updateArticle', {
                articleId: this.newArticle.id,
                article: this.newArticle
            })
           .then(response => {
               //console.log(response);
			this.$notify({
				icon: "tim-icons icon-bell-55",
				horizontalAlign: 'right',
				verticalAlign: 'top',
				type: 'primary',
				timeout: 4000,
				message: 'Demande modifiée!'
            });
            this.modals.newArticle = false;
           })          
        }

        },
        deleteArticle(){
            this.$store.dispatch('deleteArticle', this.selectedArticle)
           .then(response => {
            //console.log(response);
          this.$notify({
            icon: "tim-icons icon-bell-55",
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'danger',
            timeout: 4000,
            message: 'Demande supprimée!'
                });   
             this.modals.deleteArticle = false; 
           })
        },

        selectDon(article){
          this.selectedDon = article;
          this.modals.donModal = true;
        },
        selectArticle(article){
          this.action = 'update';
          this.newArticle = article;
          //console.log(this.newArticle );
          this.modals.newArticle = true;
        },
        actionNewArticle(){
          this.action = 'create';
          this.newArticle = {adresse:{}};
          this.modals.newArticle=true;
        },
        selectActeur(acteur){
          this.selectedActeur = acteur;
          this.modals.acteurModal = true;
        },



        onFiltreGouvernoratChange(event){
          this.filtredArticles = this.articles.filter(function (el) {
            return el.user.gouvernorat == event.target.value
          });
        },
        onFiltreSelf(){
          self = this;
          this.filtredArticles = this.articles.filter(function (el) {
            return el.user_id == self.user.id;
          });
        },
        onFiltreAll(){
          this.filtredArticles = this.articles;
         }
        
        
     },
    mounted(){
        this.$store.dispatch('getArticles')            
            .then((response)=>{
              this.loading = false;
            });
    },
    computed:{
        user(){
            return this.$store.getters.user;
          },
      articles: {
           get(){
            return this.$store.getters.articles;
           },
        },
      filtredArticles: {
           get(){
            return this.$store.getters.filtredArticles;
           },
           set(value) { this.$store.commit('setFiltredArticles', JSON.stringify(value)); },
        },
        gouvernorats(){
          return this.$store.getters.gouvernorats
        }

    }
}
</script>
<style scoped>

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
