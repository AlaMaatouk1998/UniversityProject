<template>
	<modal :show.sync="modals.newConversationModal">
		<template slot="header">
			Ajouter une nouvelle Conversation
		</template>
        <template>
            <base-input label="Nom : "
                  v-model="newConversation.nom"
                  type="text"
                  placeholder="Nom de la Conversation">
             </base-input>

            <base-input label="Commentaire : "
                  v-model="newConversation.commentaire"
                  type="text"
                  placeholder="Commentaire...">
             </base-input>

        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.newConversationModal = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="addNewConversation()"
				>Ajouter</base-button
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
		"newConversation",
		"modals",
		"addNewConversation",
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
