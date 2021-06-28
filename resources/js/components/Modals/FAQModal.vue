<template>
	<modal :show.sync="modals.newFAQModal" centered modalClasses="modal-lg">
		<template slot="header">
			Ajouter des Questions et réponses
		</template>
        <template>
            <base-input label="Nom : "
                  v-model="FAQ.nom"
                  type="text"
                  placeholder="Attribuer à ces questions et réponses un nom">
            </base-input>
            <div class="row">
                <div class="col-md-6">
                    <base-input label="Ce que l'utilisateur peut dire"
                        v-model="newValues.newQuestion"
                        type="text"
                        placeholder="Ecrire une question ici"
                        @keyup.enter.native="addNewQuestion()"
                        >
                    </base-input>
                    <transition-group name="inLeft" tag="ul">
                        <li v-for="(question, index) in questions" :key="question" class="tweet">
                            <img src="https://www.shareicon.net/data/128x128/2016/09/01/822711_user_512x512.png">
                            {{ question }}
                            <span class="delete">
                                <a href="#" v-on:click.prevent="deleteQuestion(index)">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </a>
                            </span>
                        </li>
                     </transition-group> 
                </div>
                <div class="col-md-6">
                    <base-input label="Que doit le Bot lui répondre"
                        v-model="newValues.newReponse"
                        type="text"
                        placeholder="Ecrire une réponse ici"
                        @keyup.enter.native="addNewReponse()"
                        >
                    </base-input>
                    <transition-group name="inRight" tag="ul">
                        <li v-for="(reponse, index) in reponses" :key="reponse" class="tweet">
                            <img src="https://www.shareicon.net/data/128x128/2016/09/01/822711_user_512x512.png">
                            {{ reponse }}
                            <span class="delete">
                                <a href="#" v-on:click.prevent="deleteReponse(index)">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </a>
                            </span>
                        </li>
                     </transition-group>
                </div>
            </div>

<!-- 
              <base-input label="Type de réponse" >
                <select v-model="FAQ.categorie" class="form-control" >
                    <option v-for="(categorie, index) in categories"
                             :value="categorie" 
                             :key="index" 
                             >{{categorie}}</option>
                </select>
            </base-input> -->

			 
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.newFAQModal = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="addNewFAQ()"
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
		}
	},
	components: {
		Modal,
        BaseInput
	},
	props: [

        "FAQ",
		"modals",
        "addNewFAQ",
        "questions",
        "reponses",
        "newValues",
        "addNewQuestion",
        "addNewReponse",
        "deleteReponse",
        "deleteQuestion"
	],
	computed: {},
	methods:{
	},
	mounted(){
			
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

.inRight-enter-active, .inRight-leave-active {
  transition: opacity .5s;
   transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.inRight-enter, .inRight-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateX(30px);
}

.inLeft-enter-active, .inLeft-leave-active {
  transition: opacity .5s;
   transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.inLeft-enter, .inLeft-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateX(-30px);
}
</style>
