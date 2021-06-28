<template>
<div class="content">
  <card type="user" class="floating">
    <div class="author">
      <div class="block block-one"></div>
      <div class="block block-two"></div>
      <div class="block block-three"></div>
      <div class="block block-four"></div>
      <a href="#">
        <img class="avatar" src="../../assets/img/anime3.png" alt="...">
        <h5 class="title">{{ this.user.lastname }} {{ this.user.name }}</h5>
      </a>
      <p class="description">
        {{this.user.role == 0 ? 'Téléoperateur' : this.user.role == 1 ? 'UTSS' : this.user.role == 2 ? 'CRCC' : 'Admin ministère'}} <br>
        {{this.user.gouvernorat}} 
      </p>
    </div>
    <div slot="footer" class="button-container">
 <base-button  type="secondary" fill v-on:click="modals.mdp=true;">Modifier mon mot de passe</base-button>
    </div>
  </card>
  	<modal :show.sync="modals.mdp">
		<template slot="header">
		Changer mon mot de passe
		</template>
        <template>
            <base-input label="Nouveau mot de passe : "
                  v-model="password"
                  type="password"
                  placeholder="Nouveau mot de passe">
             </base-input>
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.mdp = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="changerPassword()"
				>Changer</base-button
			>
		</template>
	</modal>
</div>
</template>
<script>
import { Card, BaseInput, Modal } from "../../components/index";

import BaseButton from "../../components/BaseButton";


export default {
  components: {
    Card,
    BaseButton,
    BaseInput,
    Modal
  },
  data() {
    return {
        modals:{
            mdp: false,
        },
        password: '',
    }
 },
 methods:{
     changerPassword(){
            if(this.password != '')
  			this.$store
				.dispatch("updatePassword", {password: this.password, userId: this.user.id})
				.then(response => {
					//console.log(response);
					this.$notify({
						icon: "tim-icons icon-bell-55",
						horizontalAlign: "right",
						verticalAlign: "top",
						type: "success",
						timeout: 4000,
						message: "Votre mot de passe à été changé!"
					});
					this.modals.mdp = false;
				});       
     }
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
<style>
</style>
