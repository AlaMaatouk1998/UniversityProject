<template>
	<modal :show.sync="modals.DeployMessenger">
		<template slot="header">
			Déployer sur Messenger
		</template>
        <template>
            <template>
            <div>
                <ul>
                    <li v-for="(page, index) in facebookPages" :key="index" class="tweet" :class="selectedPage.id == page.id ? 'selected' : ''" v-on:click.prevent="selectPage(page)">
                                <img src="https://www.shareicon.net/data/128x128/2016/09/01/822711_user_512x512.png">
                                {{ page.name }}
                    </li>
                </ul>
            </div>
            </template>
        	<base-button v-if="showLoginButton" type="success" @click="AuthProvider('facebook')"
				>Se connecter sur Facebook</base-button
			>  

			 
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.DeployMessenger = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="Deploy()"
				>Enregistrer</base-button
			>
		</template>
	</modal>
</template>
<script>
import { Modal, BaseInput } from "../../components/index";

export default {
	data(){
		return{
           radio:{
               page : ''
           },
           facebookPages : [],
           showLoginButton : true,
           selectedPage: {},
		}
	},
	components: {
		Modal,
        BaseInput
	},
	props: [
		"modals",
	],
	computed: {},
	methods:{
		AuthProvider(provider) {
              var self = this
              this.$auth.authenticate(provider).then(response =>{
                self.SocialLogin(provider, response)
 
                }).catch(err => {
                    console.log({err:err})
                })
            },
 
            SocialLogin(provider, response){
                console.log(response);
                this.$http.post('/sociallogin/'+provider, response).then(response => {
                    let accessToken = response.data.token;
               
                    this.$store.dispatch('getFacebookPages', {
                        accessToken: accessToken,
                    })
                    .then(response => {
                        
                        this.facebookPages = response;
                        this.showLoginButton = false;
                    })
 
                }).catch(err => {
                    console.log({err:err})
                })
            },
            Log(){
                console.log(this.radio);
            },
            selectPage(page){
                this.selectedPage = page;
            },
            Deploy(){
                this.$store.dispatch('DeployOnMessenger',{
                    accessToken: this.selectedPage.access_token,
                    id: this.selectedPage.id
                }).then(response =>{
                    console.log(response);
                }).catch(err =>{
                     console.log({err:err})
                });
                
            }   
	},
	mounted(){
        this.facebookPages = this.$store.getters.facebookPages;
        if(this.facebookPages.length > 0){
            this.showLoginButton = false;
        }
	},
	watch: {
   
  }
};
</script>
<style  scoped>
ul{
    list-style: none;
    padding-left: 0px;
}
.tweet {
  background-color: #fff;
  color: #373737;
  box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
  padding: 10px;
  position: relative;
  transition: all 1s;
  cursor: pointer;
}
.tweet:hover{
    background-color: #dfe6e9;
}
.selected{
    background-color: #78e08f;
}

.tweet + .tweet {
  margin-top: 20px;
}
.tweet .media {
  display: -webkit-box;
  display: flex;
}
.tweet img {
  width: 32px;
  margin-right: 15px;
}
.tweet small {
  font-size: 14px;
  color: #657786;
}
.delete{
    position: absolute;
    right:4px;
    top:-2px;
}
.delete > a > i {
    color :#9aa2a8;
    font-size: 12px;
}
.delete > a > i:hover{
    color :#080808;
  
}
</style>
