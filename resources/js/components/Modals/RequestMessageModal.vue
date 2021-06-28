<template>
	<modal :show.sync="modals.requestMessageModal">
		<template slot="header">
			<input v-model="newMessageRequestConfig.title" class="modalTitle"  />
		</template>
        <template>
            <base-input label="Message : "
                  v-model="newMessageRequestConfig.text"
                  type="text"
                  placeholder="Message à envoyer">
             </base-input>
            <base-input label="Type de Validation" >
                <select v-model="newMessageRequestConfig.typeRequest" class="form-control" id="validationType">
                    <option v-for="(type, index) in validationTypes"
                             :value="type" 
                             :key="index" 
                             >{{type}}</option>
                </select>
            </base-input>
            <base-input label="Attribut : "
                  v-model="newMessageRequestConfig.keyRequest"
                  type="text"
                  placeholder="Nom de l'attribut">
             </base-input>
			 <transition name="fade">
				<base-input label="Message de validation : "
					v-show="newMessageRequestConfig.typeRequest != 'text'"
					v-model="newMessageRequestConfig.validationMessage"
					type="text"
					id="1"
					
					placeholder="Message de validation">
				</base-input>
			 </transition>

			 
        </template>
		<template slot="footer">
			<base-button type="secondary" @click="modals.requestMessageModal = false;"
				>Annuler</base-button
			>
			<base-button type="primary" @click="actionButtonRequestMessage()"
				>Enregistrer</base-button
			>
		</template>
	</modal>
</template>
<script>
import draggable from "vuedraggable";
import { Modal, BaseInput } from "../../components/index";
var { Textcomplete, Textarea } = require('textcomplete');


export default {
	data(){
		return{
			attributes:[
				'yes',
				'no',
				'hehe',
				'what',
				'yololo',
				'yeyeye'
			]
		}
	},
	components: {
		Modal,
        draggable,
        BaseInput
	},
	props: [
		"validationTypes",
		"newMessageRequestConfig",
		"modals",
		"addNewOption",
		"updateMessage",
		"actionButtonRequestMessage",
		"storedAttributes"
	],
	computed: {},
	methods:{
		setUpAutoComplete(){
			var attributes = this.storedAttributes;
			console.log(attributes);
			var editor = new Textarea(document.getElementById('1'));
			var textcomplete = new Textcomplete(editor);
			textcomplete.register([{
			match: /(^|\s|{){([a-z0-9+\-\_]*)$/,
			search: function (term, callback) {
				callback(attributes.filter(attr => { 
					return attr.startsWith(term); 
					}));
			},
			replace: function (value) {
				return '$1{{' + value + '}} ';
			}
			}]);
		}
	},
	mounted(){
			
	},
	watch: {
    storedAttributes: function () {
		this.setUpAutoComplete();
    }
  }
};
</script>
<style  scoped>
input{
    min-width :400px;
}
.textcomplete-item > a{
	padding: 6px !important;
	cursor: pointer!important;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
