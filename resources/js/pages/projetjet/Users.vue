<template>
<div class="content">
  <card>
    <template slot="header">
      <h5 class="title">Consulter les acteurs</h5>
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
        <div class="col-xl-3">
          <base-input  label="Filtrer par role">
            <select class="form-control " @change="onEtatChange($event)"
            >
                <option value="0">Téléoperateur</option>
                <option value="1">UTSS</option>
                <option value="2">CRCC</option>
                <option value="3">Admin ministere</option>
            </select>
          </base-input>
        </div>
         <div class="col-xl-2">
              <base-button  style="    margin-top: 23px;" type="warning" fill v-on:click="onFiltreAll()">Voir tous</base-button>
        </div>
         <div class="col-xl-3">
              <base-button v-show="parseInt(user.role) == 3" class="addBtnClass" style=" margin-top: 23px;" type="success" fill v-on:click="actionNewUser()">Ajouter un nouvel Acteur</base-button>
        </div>
      </div>
    </template>
        <div class="table-responsive">
        <table class="table tablesorter text-left">
            <thead class="text-primary">
            <tr>
                <slot name="columns">
                <th>Nom</th>
                <th>Prenom</th>
                
                <!-- <th>Adresse</th> -->
                <th>Gouvernorat</th>
                <th>Telephone</th>
                <th>Email</th>
                <!-- <th>Affecté à</th>
                <th>Plus d'informations</th> -->
                <th>Type</th>
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
            <tr v-for="(userp, index) in filtredUsers"
                        :key="index"
                        >
                <td>{{userp.name}}</td>
                <td>{{userp.lastname}}</td>
                
                <!-- <td>{{user.adresse.adresse}}</td> -->
                <td>{{userp.gouvernorat}}</td>
                <td>{{userp.telephone}}</td>
                <td>{{userp.email}}</td>
                <!-- <td><base-button simple type="primary" v-on:click="selectActeur(user.user)">Affecté à</base-button></td>
                <td><base-button simple type="primary" v-on:click="selectDon(user)">Plus d'informations</base-button></td> -->
                 <td>  
                   {{userp.role == 0 ? 'Téléoperateur' : userp.role == 1 ? 'UTSS' : userp.role == 2 ? 'CRCC' : 'Admin ministère'}}    

                </td>

                <td class="td-actions text-right" v-show="parseInt(user.role) == 3"> 
                    <base-button type="success" size="sm" icon v-on:click="selectActeur(userp)">
                     <i class="tim-icons icon-settings"></i>
                    </base-button>
                    <base-button type="danger" size="sm" icon v-on:click="selectedUser = userp.id; modals.deleteUser = true;">
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
  	<modal :show.sync="modals.donModal">
		<template slot="header">
			Plus d'informations
		</template>
        <template>
			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Type du user:</span>
                  {{this.selectedDon.type_don}}
                 </p>
            </div>
			       <div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Description:</span>
                  {{this.selectedDon.description}}
                 </p>
            </div>
            	<div class="typography-line text-left">
               <p>
                  <span style="bottom: unset; line-height: unset;">Adresse:</span>
                  {{this.selectedDon.adresse.adresse}}
               </p>
            </div>
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.donModal = false;"
				>Fermer</base-button
			>

		</template>
	</modal>
  	<modal :show.sync="modals.deleteUser">
		<template slot="header">
			Supprimer 
		</template>

        Etes-vous sûr de supprimer cet utilisateur ?

  
		<template slot="footer">
			<base-button type="secondary" @click="modals.deleteUser = false;"
				>Annuler</base-button
			>
			<base-button type="danger" @click="deleteUser()"
				>Supprimer</base-button
			>
		</template>
	</modal>
	<modal :show.sync="modals.newUser"  class="text-left">
		<template slot="header">
			Ajouter un nouvel acteur
		</template>
        <template>
            <base-input label="Nom : "
                  v-model="newUser.name"
                  type="text"
                  placeholder="Nom :">
             </base-input>
            <base-input label="Prénom :"
                  v-model="newUser.lastname"
                  type="text"
                  placeholder="Prénom">
             </base-input>
             <base-input label="Téléphone :"
                  v-model="newUser.telephone"
                  type="number"
                  placeholder="Téléphone">
             </base-input>  
             <base-input label="Email :"
                  v-model="newUser.email"
                  type="email"
                  placeholder="Email">
             </base-input>  
            <base-input label="Gouvernorat">
                <select class="form-control" v-model="newUser.gouvernorat">
                    <option v-for="(gouvernorat, index) in gouvernorats"
                                :value="gouvernorat.fr" 
                                :key="index"
                                >{{gouvernorat.fr}}</option>
                </select>
            </base-input> 
              <base-input label="Adresse :  "
                  v-model="newUser.adresse.adresse"
                  type="text"
                  placeholder="Adresse">
             </base-input>
          <base-input  label="Role :">
            <select class="form-control " v-model="newUser.role"
            >
                <option value="0" >Téléoperateur</option>
                <option value="1">UTSS</option>
                <option value="2">CRCC</option>
                <option value="3">Admin ministere</option>
            </select>
          </base-input>
           <base-input :label="action == 'create' ? 'Mot de passe :' : 'Nouveau Mot de passe' "
                  v-model="newUser.password"
                  type="password"
                  placeholder="Mot de passe">
             </base-input>
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.newUser = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="actionUser()"
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
            newUser: false,
            deleteUser: false
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
      newUser:{
        adresse:{

        }
      },
      action: 'create',
      selectedUser: 0
    }
 },
 methods:{
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
        actionUser(){

          if(this.verifierFormulaire()){
            if(this.action == 'create'){
                  this.$store.dispatch('newUser', this.newUser)
                .then(response => {
                    //console.log(response);
                this.$notify({
                  icon: "tim-icons icon-bell-55",
                  horizontalAlign: 'right',
                  verticalAlign: 'top',
                  type: 'success',
                  timeout: 4000,
                  message: 'nouvel utilisateur crée!'
                  });
                  this.modals.newUser = false;
                })
              }else if (this.action == 'update'){
                  this.$store.dispatch('updateUser', {
                      userId: this.newUser.id,
                      user: this.newUser
                  })
                .then(response => {
                    //console.log(response);
                this.$notify({
                  icon: "tim-icons icon-bell-55",
                  horizontalAlign: 'right',
                  verticalAlign: 'top',
                  type: 'success',
                  timeout: 4000,
                  message: 'Utilisateur modifié!'
                  });
                  this.modals.newUser = false;
                }); 
          }
        }
        },
        verifierFormulaire(){
          //console.log(this.newUser);
          if(this.newUser.name == '' || this.newUser.lastname == '' || this.newUser.telephone  == '' || this.newUser.email == '' || this.newUser.adresse.adresse == '')
            {
                this.$notify({type: 'danger', timeout: 4000, message: 'Veuillez remplir tous les champs!', icon: "tim-icons icon-bell-55", horizontalAlign: 'right', verticalAlign: 'top'});
                return false;
            }
          if(!this.checkEmail(this.newUser.email)){
              return false;
            }
          if(!this.checkPhone(this.newUser.telephone)){
            return false
          }
        return true;
        },
        checkEmail(email){
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if(re.test(email)){
              return true;
            }else{
              this.$notify({type: 'danger', timeout: 4000, message: 'Email invalide', icon: "tim-icons icon-bell-55", horizontalAlign: 'right', verticalAlign: 'top'});
              return false;
            }
        },
        checkPhone(phone){
          var strPhone = phone + '';
            //console.log(strPhone.length);
            //console.log(parseInt(strPhone[0]));
            if(strPhone.length == 8 && (parseInt(strPhone[0]) == 2 || parseInt(strPhone[0]) == 4 || parseInt(strPhone[0]) == 5 || parseInt(strPhone[0]) == 9 || parseInt(strPhone[0]) == 7)){
              return true;
            }else{
              this.$notify({type: 'danger', timeout: 4000, message: 'Numéro de téléphone invalide!', icon: "tim-icons icon-bell-55", horizontalAlign: 'right', verticalAlign: 'top'});
              return false;
           }
        },
        deleteUser(){
            this.$store.dispatch('deleteUser', this.selectedUser)
           .then(response => {
            //console.log(response);
            this.$notify({
            icon: "tim-icons icon-bell-55",
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success',
            timeout: 4000,
            message: 'Utilisateur supprimé!'
            });    
            this.modals.deleteUser = false;
           })
        },

        selectDon(user){
          this.selectedDon = user;
          this.modals.donModal = true;
        },
        selectActeur(acteur){
          this.action = 'update';
          this.newUser = acteur;
          //console.log(this.newUser );
          this.modals.newUser = true;
        },
        actionNewUser(){
          this.action = 'create';
          this.newUser = {
            name: '',
            email: '',
            telephone:'',
            adresse:'',
            role: 0, 
            gouvernorat: 'Ariana',
            adresse:{
            }
            };
          this.modals.newUser=true;
        },



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
          this.filtredUsers = this.users;
         }
        
        
     },
    mounted(){

        this.$store.dispatch('getUsers')
        .then((response)=>{
          this.loading = false;
        });
    },
    computed:{
      user: {
           get(){
            return this.$store.getters.user;
           },
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
