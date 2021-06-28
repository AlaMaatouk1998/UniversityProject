<template>
	<modal :show.sync="modals.newBotModal">
		<template slot="header">
			Créer un nouveau Bot
		</template>
        <template>
            <base-input label="Nom : "
                  v-model="newBot.nom"
                  type="text"
                  placeholder="Nom du Bot">
             </base-input>

            <base-input label="Description : "
                  v-model="newBot.description"
                  type="text"
                  placeholder="Description">
             </base-input>

              <base-input label="Catégorie" >
                <select v-model="newBot.categorie" class="form-control" >
                    <option v-for="(categorie, index) in categories"
                             :value="categorie" 
                             :key="index" 
                             >{{categorie}}</option>
                </select>
            </base-input>

			 
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.newBotModal = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="addNewBot()"
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
		"categories",
		"newBot",
		"modals",
		"addNewBot",
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

</style>
